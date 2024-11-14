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
                    { text: "乾燥肌", type: "dry" },
                    { text: "普通肌", type: "normal" },
                    { text: "混合肌", type: "combination" },
                    { text: "脂性肌", type: "oily" }
                ]
            },
            {
                question: "普段、肌に触れたときの感覚はどのように感じますか？",
                options: [
                    { text: "常にしっとりしている", type: "normal" },
                    { text: "時々乾燥していると感じる", type: "combination" },
                    { text: "ほとんどの場合、乾燥している", type: "dry" },
                    { text: "テカリがちで、触ると脂っぽく感じる", type: "oily" }
                ]
            },
            {
                question: "日常の肌ケアで、どのような悩みを感じることが多いですか？",
                options: [
                    { text: "乾燥によるかさつきや粉ふき", type: "dry" },
                    { text: "テカリや油浮きが気になる", type: "oily" },
                    { text: "肌荒れや赤みが出やすい", type: "combination" },
                    { text: "毛穴の目立ちや黒ずみが気になる", type: "oily" }
                ]
            },
            {
                question: "朝、洗顔後の肌の感覚はどれに近いですか？",
                options: [
                    { text: "すぐに乾燥してつっぱる感じがする", type: "dry" },
                    { text: "少し乾燥するが、すぐに気にならなくなる", type: "combination" },
                    { text: "一日中しっとりしている", type: "normal" },
                    { text: "テカリが気になり、すぐに脂っぽくなる", type: "oily" }
                ]
            },
            {
                question: "季節によって肌の状態が変わると感じますか？",
                options: [
                    { text: "はい、季節ごとに乾燥や脂っぽさが変わる", type: "combination" },
                    { text: "いいえ、あまり変わらない", type: "normal" },
                    { text: "少しだけ変わるが、それほど気にならない", type: "normal" }
                ]
            }
        ];

        let currentQuestion = 0;
        let selectedAnswer = null;
        const skinTypeScores = { dry: 0, normal: 0, combination: 0, oily: 0 };

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
            // 選択肢が選ばれていない場合は、次の質問に進まない
            if (!selectedAnswer) {
                alert("回答を選択してください。");
                return;
            }

            // 選択した肌タイプにポイントを加算
            skinTypeScores[selectedAnswer]++;

            // 最後の質問に達していない場合は次の質問を表示
            if (currentQuestion < questions.length - 1) {
                currentQuestion++;
                showQuestion();
            } else {
                showResult();
            }
        }

        function showResult() {
            // 肌タイプのスコアをもとに最大スコアのタイプを判定
            const skinType = Object.keys(skinTypeScores).reduce((a, b) => skinTypeScores[a] > skinTypeScores[b] ? a : b);
            
            // セッションに肌タイプを保存するために、PHPでの再読み込みなしでデータを送信
            fetch("save_skin_type.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ skin_type: skinType })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // 結果の表示と「登録内容を確認」ボタンの表示
                    const questionContainer = document.getElementById("question-container");
                    questionContainer.innerHTML = `<p class="result-text">肌質診断が完了しました！結果は ${skinType} です。</p>`;

                    const confirmButton = document.createElement("button");
                    confirmButton.textContent = "登録内容を確認";
                    confirmButton.id = "confirm-button";
                    confirmButton.style.marginTop = "20px";
                    confirmButton.style.padding = "10px 20px";
                    confirmButton.style.fontSize = "1em";
                    confirmButton.style.backgroundColor = "#4a90e2";
                    confirmButton.style.color = "white";
                    confirmButton.style.border = "none";
                    confirmButton.style.borderRadius = "5px";
                    confirmButton.style.cursor = "pointer";
                    confirmButton.style.transition = "background-color 0.3s";
                    confirmButton.onclick = () => {
                        window.location.href = "touroku_confirm.php"; // 確認ページに移動
                    };

                    questionContainer.appendChild(confirmButton);
                    document.getElementById("next-button").style.display = "none";
                } else {
                    alert("診断結果の保存に失敗しました。もう一度お試しください。");
                }
            })
            .catch(error => console.error("エラーが発生しました:", error));
        }

        showQuestion();
    </script>
</body>
</html>
