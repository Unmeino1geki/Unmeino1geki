<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メールアドレス変更確認</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        p {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .email-info {
            font-weight: bold;
            margin-bottom: 10px;
        }
        input[type="button"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="button"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>メールアドレス変更確認</h2>
        <p>以下の内容でメールアドレスを変更します。よろしいですか？</p>

        <div class="email-info">
            <p>現在のメールアドレス: <span id="nowEmail"></span></p>
            <p>新しいメールアドレス: <span id="newEmail"></span></p>
        </div>

        <input type="button" value="変更を確定する" onclick="confirmChange()">
        <input type="button" value="戻る" onclick="goBack()">
    </div>
<script src="../JavaScript/confirm_email.js"></script>
</body>
</html>
