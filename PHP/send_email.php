<?php
// dbconnect.phpファイルの内容を使用して接続設定を行う
require_once 'connect/dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    // トークンを生成
    $token = bin2hex(random_bytes(16));

    // 有効期限を設定（1時間後）
    $expires_at = date("Y-m-d H:i:s", strtotime('+1 hour'));
    
    // トークンとメールアドレスをデータベースに保存
    $stmt = $conn->prepare("INSERT INTO email_verifications (test_email, token, expires_at) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $token, $expires_at);
    $stmt->execute();

    // 認証リンクの生成
    $verification_link = "https://quiet-obi-5971.penne.jp/Unmeino1geki/PHP/touroku.php?token=" . $token;

    // メール送り主のメアド（ロリポップのドメインメールを使用）
    $emailfrom = "info@quiet-obi-5971.penne.jp"; // ロリポップで設定したドメインメール

    // 日本語の送信者名をエンコード
    $from_name = "運命の一撃運営チーム";
    $encoded_from = mb_encode_mimeheader($from_name) . " <" . $emailfrom . ">";

    // メールの件名
    $subject = "メールアドレス認証";

    // メールの内容
    $mailBody = "新規登録リンク\n次のリンクをクリックして、ユーザー情報を登録してください\n\n$verification_link";

    // メールヘッダー
    $headers = 'From: ' . $encoded_from . "\r\n" .
               'X-Mailer: PHP/' . phpversion();
    
    // メールを送信
    if (mail($email, $subject, $mailBody, $headers)) {
        echo "メールを送信しました。確認してください。";
    } else {
        echo "メールの送信に失敗しました。";
    }
}
?>

