<?php
// セッションを開始
session_start();

// セッション変数を削除
session_unset();

// セッションを完全に終了
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト</title>
    <link rel="stylesheet" href="../css/logout.css">
</head>
<body>
<div class="logout-container">
  <h1>ご利用ありがとうございます！</h1>
  <p>ログアウトしました。またのご利用をお待ちしております。</p>
  <div class="button-group">
    <a href="login-input.php" class="link">ログインページへ</a>
  </div>
</div>
</body>
</html>
