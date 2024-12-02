<?php
session_start();
require 'connect/dbconnect.php';

//echo"<pre>";
//print_r($_SESSION);
//echo"<pre>";

// セッションに保存されたユーザーデータを取得
$username = $_SESSION['User']['username'];
$email = $_SESSION['User']['email'];
$password = $_SESSION['User']['password']; // ハッシュ化前のパスワード
$gender = $_SESSION['User']['gender'];
$skin_type = $_SESSION['skin_type'];
$allergies = $_SESSION['User']['allergies'] ?? null; // アレルギー情報が設定されている場合のみ

//var_dump($username, $email, $password, $gender, $skin_type);

// パスワードをハッシュ化
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// トークンを生成
$token = bin2hex(random_bytes(16));

// 有効期限を設定（1時間後）
$expires_at = date("Y-m-d H:i:s", strtotime('+24 hour'));

// データベースへの挿入
$stmt = $conn->prepare("INSERT INTO email_verifications (test_name, test_email, token, expires_at, test_password, test_skin_type, test_gender)
        VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss",$username,$email,$token,$expires_at,$hashed_password,$skin_type,$gender);
$stmt->execute();

// 認証リンクの生成
$verification_link = "https://aso2201376.boo.jp/Unmeino1geki/PHP/confirm_completed.php?token=" . $token;

// メール送り主のメアド（ロリポップのドメインメールを使用）
$emailfrom = "info@quiet-obi-5971.penne.jp"; // ロリポップで設定したドメインメール
    
// 日本語の送信者名をエンコード
$from_name = "運命の一撃運営チーム";
$encoded_from = mb_encode_mimeheader($from_name) . " <" . $emailfrom . ">";
    
// メールの件名
$subject = "登録用メール";
    
// メールの内容
$mailBody = "新規登録リンク\n次のリンクをクリックして、ユーザー情報を登録してください\n\n$verification_link";

// メールヘッダー
$headers = 'From: ' . $encoded_from . "\r\n" .
           'X-Mailer: PHP/' . phpversion();
// メールを送信
if (mail($email, $subject, $mailBody, $headers)) {
} else {
    echo "メールの送信に失敗しました。";
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

        p{
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>メール送信完了しました</h2>
        <p>こちらのページは閉じていただいて構いません</p>
    </div>
</body>
</html>
