<?php
require 'connect/dbconnect.php';

// GETパラメータからトークンを取得
$token = $_GET['token'] ?? null;

if (!$token) {
    die("無効なリクエストです。");
}

// トークンをデータベースで検索
$stmt = $conn->prepare("SELECT * FROM email_verifications WHERE token = ? AND expires_at > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("トークンが無効または期限切れです。");
}

// トークンに関連するユーザーデータを取得
$row = $result->fetch_assoc();
$name = $row['test_name'];
$email = $row['test_email'];
$password = $row['test_password'];
$skin_type = $row['test_skin_type'];
$gender = $row['test_gender'];

//var_dump($username, $email, $password, $gender, $skin_type);

// `user`テーブルに挿入
$insert_stmt = $conn->prepare("INSERT INTO user (name, email, password, skin_type, gender, created_at, updated_at) 
                               VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
$insert_stmt->bind_param("sssss", $name, $email, $password, $skin_type, $gender);

if ($insert_stmt->execute()) {
    // `email_verifications`テーブルからトークンを削除
    $delete_stmt = $conn->prepare("DELETE FROM email_verifications WHERE token = ?");
    $delete_stmt->bind_param("s", $token);
    $delete_stmt->execute();

    header("refresh:5;url=login-input.php");
} else {
    echo "登録処理中にエラーが発生しました。";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録内容確認</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>ユーザー登録が完了しました</h2>
        <p>数秒後に自動でログイン画面へ遷移します<br>しばらくお待ちください...</p>
    </div>
</body>
</html>
