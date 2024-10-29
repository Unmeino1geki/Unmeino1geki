<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>削除画面</title>
    <style>
        body {
            background-color: #000033; /* 青黒い背景 */
            color: white; /* 全体の文字色を白に */
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        #username-all {
            font-size: 50px; /* 文字サイズを大きく調整 */
            margin-top: -5px; /* 上部余白を調整 */
            margin-bottom: 10px; /* 下部余白を縮小 */
            background-color: #00c2ff82; /* 背景色 */
            color: white; /* 文字の色を白に */
            padding-left: 70px; /* 左側の余白 */
            padding-right: 70px; /* 右側の余白 */
            display: inline-block; /* コンテンツに合わせた背景サイズ */
        }

        #login-all {
            margin-top: 30px; /* 上部の間隔を調整 */
        }

        button {
    background-color: rgba(0, 123, 255, 0.5); /* 半透明青 */
    color: #ADD8E6; /* 水色の文字 */
    border: none;
    padding: 15px 40px; /* サイズ統一 */
    margin: 0 20px; /* 横の間隔 */
    font-size: 24px; /* 統一された文字サイズ */
    cursor: pointer;
    padding-top: 5px;
    padding-bottom: 5px;
    padding-right: 60px;
    padding-left: 60px;    
    transition: background-color 0.3s, transform 0.2s; /* スムーズな変化 */
}

button:hover {
    background-color: rgba(0, 123, 255, 0.7); /* ホバー時の濃い青 */
    transform: scale(1.01); /* 少し拡大 */
    box-shadow: 0 0 15px 5px #ADD8E6; /* 発光効果 */
}
.small-text {
    font-size: 12px; /* 小さな文字サイズ */
    color: #ADD8E6; /* 水色 */
    display: block; /* ブロック要素にしてボタンの下に配置 */
}


        .a {
            font-size: 16px; /* 一回り大きく */
            margin-top: 30px; /* 上部の間隔を縮小 */
        }

        .aa {
            font-size: 13px; /* 一回り大きく */
            margin-top: -10px; /* 間隔をさらに小さく */
        }
        .aaa {
            font-size: 14px; /* 一回り大きく */
            margin-top: -5px; /* 間隔をさらに小さく */
        }


        .yes-button.no-button{
    
        }
    </style>
</head>
<body>

    <!-- ロゴの表示 -->
    <img src="../IMG/なるみ.png" alt="SAKUJYO ロゴ" style="max-width: 200px; margin-bottom: 30px;"> <!-- ロゴも大きく -->

    <p class="a">
        SAKUJYOを起動させるためには、以下の質問に答える必要があります。
    </p>
    <p class="aa">
        In order to start SAKUJYO, you need to answer the following questions.
    </p>

    <!-- 削除確認フォーム -->
    <form action="admin_login-output.php" method="post">
        <div id="username-all">
            アカウントケシマスカ？
        </div>
        <p class="aaa">Do you have an account poppy?</p>

        <div id="login-all">
    <button type="submit" id="yes-button">YES<span class="small-text">はい</span></button>

    <button type="button" id="no-button" onclick="history.back();">NO<span class="small-text">いいえ</span></button>
</div>

    </form>

</body>
</html>
