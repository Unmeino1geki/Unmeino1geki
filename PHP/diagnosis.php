<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>肌質診断</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        h1 {
            color: #4a90e2;
            font-size: 2em;
            margin-bottom: 20px;
        }

        #question-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 500px;
            text-align: center;
        }

        #question-text {
            font-size: 1.2em;
            margin-bottom: 15px;
        }

        #answer-options {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .option-button {
            background-color: #e6e6e6;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            font-size: 1em;
        }

        .option-button:hover {
            background-color: #4a90e2;
            color: #fff;
        }

        .selected {
            background-color: #4a90e2;
            color: #fff;
            font-weight: bold;
        }

        #next-button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1em;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #next-button:hover {
            background-color: #357abd;
        }

        .result-text {
            font-size: 1.2em;
            color: #4a90e2;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<?php echo $_SESSION['User']['username']; ?>
    <h1>肌質診断</h1>
    <div id="question-container">
        <p id="question-text"></p>
        <div id="answer-options"></div>
    </div>
    <button id="next-button" onclick="nextQuestion()">次へ</button>

    <script>
        const questions = [
            {
                question: "肌のタイプはどれに当てはまりますか？",
                options: [
                    { text: "乾燥肌", type: "乾燥肌" },
                    { text: "普通肌", type: "普通肌" },
                    { text: "混合肌", type: "混合肌" },
                    { text: "脂性肌", type: "油性肌" }
                ]
            },
            {
                question: "普段、肌に触れたときの感覚はどのように感じますか？",
                options: [
                    { text: "常にしっとりしている", type: "普通肌" },
                    { text: "時々乾燥していると感じる", type: "混合肌" },
                    { text: "ほとんどの場合、乾燥している", type: "乾燥肌" },
                    { text: "テカリがちで、触ると脂っぽく感じる", type: "油性肌" }
                ]
            },
            {
                question: "日常の肌ケアで、どのような悩みを感じることが多いですか？",
                options: [
                    { text: "乾燥によるかさつきや粉ふき", type: "乾燥肌" },
                    { text: "テカリや油浮きが気になる", type: "油性肌" },
                    { text: "肌荒れや赤みが出やすい", type: "混合肌" },
                    { text: "毛穴の目立ちや黒ずみが気になる", type: "油性肌" }
                ]
            },
            {
                question: "朝、洗顔後の肌の感覚はどれに近いですか？",
                options: [
                    { text: "すぐに乾燥してつっぱる感じがする", type: "乾燥肌" },
                    { text: "少し乾燥するが、すぐに気にならなくなる", type: "混合肌" },
                    { text: "一日中しっとりしている", type: "普通肌" },
                    { text: "テカリが気になり、すぐに脂っぽくなる", type: "油性肌" }
                ]
            },
            {
                question: "季節によって肌の状態が変わると感じますか？",
                options: [
                    { text: "はい、季節ごとに乾燥や脂っぽさが変わる", type: "混合肌" },
                    { text: "いいえ、あまり変わらない", type: "普通肌" },
                    { text: "少しだけ変わるが、それほど気にならない", type: "普通肌" }
                ]
            }
        ];

        let currentQuestion = 0;
        let selectedAnswer = null;
        const skinTypeScores = { 乾燥肌: 0, 普通肌: 0, 混合肌: 0, 油性肌: 0 };

        function showQuestion() {
            const questionContainer = document.getElementById('question-text');
            const answerOptions = document.getElementById('answer-options');
            const nextButton = document.getElementById('next-button');

            questionContainer.textContent = questions[currentQuestion].question;
            answerOptions.innerHTML = "";
            selectedAnswer = null;

            questions[currentQuestion].options.forEach((option) => {
                const optionButton = document.createElement("button");
                optionButton.textContent = option.text;
                optionButton.onclick = () => {
                    selectedAnswer = option.type;
                    Array.from(answerOptions.children).forEach(btn => btn.classList.remove('selected'));
                    optionButton.classList.add('selected');
                };
                optionButton.classList.add('option-button');
                answerOptions.appendChild(optionButton);
            });

            nextButton.textContent = (currentQuestion === questions.length - 1) ? "結果を見る" : "次へ";
        }

        function nextQuestion() {
    if (selectedAnswer) {
        // 回答を記録
        skinTypeScores[selectedAnswer]++;

        if (currentQuestion < questions.length - 1) {
            // 次の質問に進む
            currentQuestion++;
            showQuestion();
        } else {
            // 最終結果を計算
            const finalType = Object.keys(skinTypeScores).reduce((a, b) => 
                skinTypeScores[a] > skinTypeScores[b] ? a : b
            );

            // サーバーに送信
            fetch("save_skin_type.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ skin_type: finalType })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('question-container').innerHTML = 
                        `<p class="result-text">診断結果: ${finalType === "乾燥肌" ? "乾燥肌" :
                        finalType === "普通肌" ? "普通肌" :
                        finalType === "混合肌" ? "混合肌" :
                        "脂性肌"}</p>`;

                    // 確認画面に進むボタンを表示
                    const nextButton = document.getElementById('next-button');
                    nextButton.textContent = "確認画面へ";
                    nextButton.onclick = function() {
                        window.location.href = "touroku_confirm.php"; // 確認ページに移動
                    };
                } else {
                    alert("結果の保存に失敗しました。");
                }
            })
            .catch(error => {
                console.error("エラー:", error);
                alert("結果の保存中にエラーが発生しました。");
            });
        }
    } else {
        alert("回答を選択してください。");
    }
}
        // 最初の質問を表示
        showQuestion();
    </script>
</body>
</html>
