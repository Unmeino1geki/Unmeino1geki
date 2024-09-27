<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name=”viewport” content=”width=device-width, initial-scale=1.0″>
    <title>管理者ログイン画面</title>
    <link rel="stylesheet" href="../../CSS/admin/admin-login.css">
</head>
<body>
<?php
        if(isset($_GET['flag']) && $_GET['flag'] == 'miss'){
            echo '<script>alert("認証に失敗しました。");</script>';
        }else if(isset($_GET['flag']) && $_GET['flag'] == 'fail'){
            echo '<script>alert("エラーが発生しました。");</script>';
        }
    ?>
    <!-- Login Form Container -->

        <!--<form action="admin_login-output.php" method="post">-->
        <form action="admin_top.php" method="post">
            <div id="username-all">
                ユーザー名<br><input type="text" id="adminname" name="adminname" placeholder="ADMIN NAME" required>
            </div>
            <div id="password-all">
                パスワード<br><input type="password" id="password" name="password" placeholder="PASSWORD" required>
            </div>
            
            <div id="login-all">
            <button type="submit" id="login-button">ログイン</button>
            </div><br>
      </form>

</body>
</html>