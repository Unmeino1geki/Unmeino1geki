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

    if ($stmt->execute()) {
        // 認証リンクの生成
        $verification_link = "https://quiet-obi-5971.penne.jp/Unmeino1geki/PHP/touroku.php?token=" . urlencode($token);

        // メール送り主のメアド（ロリポップのドメインメールを使用）
        $emailfrom = "info@quiet-obi-5971.penne.jp";

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
            // トークンをURLに含めて次のページへリダイレクト
            header("Location: nextpage.php?token=" . urlencode($token));
            exit();
        } else {
            echo "メールの送信に失敗しました。";
        }
    } else {
        echo "トークンの保存に失敗しました。";
    }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
    <link rel="stylesheet" href="../CSS/touroku.css">
    <style>
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>新規登録</h2>

    <!-- 新規登録フォーム -->
    <form action="touroku.php" method="post">
        <label for="username">ユーザー名:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>"><br>
        <span class="error"><?php echo $usernameError; ?></span><br><br>

        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password"><br>
        <span class="error"><?php echo $passwordError; ?></span><br><br>

        <label for="confirm_password">確認用パスワード:</label>
        <input type="password" id="confirm_password" name="confirm_password"><br>
        <span class="error"><?php echo $confirmPasswordError; ?></span><br><br>

        <label>性別:</label>
        <div class="gender">
            <label><input type="radio" id="male" name="gender" value="male" <?php if($gender == 'male') echo 'checked'; ?>> 男性</label>
            <label><input type="radio" id="female" name="gender" value="female" <?php if($gender == 'female') echo 'checked'; ?>> 女性</label>
            <label><input type="radio" id="other" name="gender" value="other" <?php if($gender == 'other') echo 'checked'; ?>> その他</label>
            <label><input type="radio" id="none" name="gender" value="none" <?php if($gender == 'none') echo 'checked'; ?>> 回答しない</label>
        </div>
        <span class="error"><?php echo $genderError; ?></span><br><br>

        <input type="submit" value="次へ">
    </form>
</div>
</body>
</html>
