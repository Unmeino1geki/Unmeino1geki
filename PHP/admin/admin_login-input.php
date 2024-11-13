<?php
// フラグの取得
$flag = isset($_GET['flag']) ? $_GET['flag'] : null;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ログイン画面</title>
    <link rel="stylesheet" href="../../CSS/admin/admin-login.css">
</head>
<body>
    <div id="err" style="display: none;">
    <button id="close-btn">✘</button>
        <!-- エラーメッセージの表示 -->
        <?php if ($flag == 'missing_data'): ?>
            <h1>入力欄にユーザー名とパスワードを記入してください。</h1>
        <?php elseif ($flag == 'user_not_found'): ?>
            <h1>ユーザーが見つかりません。</h1>
        <?php elseif ($flag == 'not_admin'): ?>
            <h1>そのユーザーは管理者ではありません。</h1>
        <?php elseif ($flag == 'miss'): ?>
            <h1>ユーザー名またはパスワードが間違っています。</h1>
        <?php endif; ?>
    </div>


    
    <!-- ログインフォーム -->
    <form action="admin_login-output.php" method="post">
        <div id="username-all">
            ユーザー名<br><input type="text" id="adminname" name="name" placeholder="ADMIN NAME" required>

        </div>
        <div id="password-all">
            パスワード<br><input type="password" id="password" name="password" placeholder="PASSWORD" required>
        </div>
        <div id="login-all">
            <button type="submit" id="login-button">ログイン</button>
        </div><br>
    </form>

    <script>
        // エラーメッセージがある場合に表示
        <?php if ($flag): ?>
            document.getElementById('err').style.display = 'flex';
        <?php endif; ?>

        // ✘ボタンのクリックイベント
        document.getElementById('close-btn').onclick = function() {
            document.getElementById('err').style.display = 'none';
        };
    </script>

</body>
</html>
