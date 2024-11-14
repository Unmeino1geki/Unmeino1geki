<?php
// セッションを開始
session_start();

// ユーザーがログインしているか確認
if (!isset($_SESSION['user_id'])) {
    // 未ログインの場合はログインページにリダイレクト
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <title>change_email</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="all">
        <h2>メールアドレス変更</h2>
        <form action="./complete_email" method="post">
        <label for="now_email">現在のメールアドレス</label>
        <input type="email" id="now_email" name="now_email" required palceholder="現在のメールアドレスを入力">

        <label for="new_email">新しいメールアドレス</label>
        <input type="email" id="new_email" name="new_email" required palceholder="新しいメールアドレスを入力">

        <label for="confirm_new_email">新しいメールアドレス(確認用)</label>
        <input type="email" id="confirm_new_email" name="confirm_new_email" required palceholder="新しいメールアドレスを再入力">

        <input type="submit" value="変更">
        </form>
    </div>

    <script src="../JavaScript/change_email.js"></script>
</body>
</html>