<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>管理画面</title>
    <link rel="stylesheet" href="../../CSS/admin/admin-top.css">
</head>
<body>

<div class="button-container">
    <button type="submit" class="user" onclick="location.href='admin_user1.php'">
        ユーザー管理
    </button>
    <button type="submit" class="rebyu" onclick="location.href='admin_rebyu1.php'">
        レビュー管理
    </button>
    <button type="button" class="pass" onclick="location.href='admin_pass1.php'">
        パスワード管理
    </button>
</div>

<!-- ログアウトボタンを別のコンテナに移動 -->
<div class="logout-container">
    <button type="button" class="out" onclick="location.href='top.php'">
        ログアウト
    </button>
</div>

<script src="../JavaScript/hamburger.js"></script>

<style>
html,body {
  overflow-y: hidden;
} 
</style>
</body>
</html>
