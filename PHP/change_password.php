<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワード変更</title>
    <link rel="stylesheet" href="../CSS/change_password.css">
</head>
<body>
    <div class="container">
        <h2>パスワード変更</h2>
        <form id="passwordForm">
            <label for="currentPassword">現在のパスワード:</label>
            <input type="password" id="currentPassword" name="currentPassword" required>

            <label for="newPassword">新しいパスワード:</label>
            <input type="password" id="newPassword" name="newPassword" required>

            <label for="confirmPassword">新しいパスワード（確認用）:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>

            <button type="submit">パスワードを変更</button>
        </form>
        <p id="message"></p>
    </div>
    <script src="../JavaScript/change_password.js"></script>
</body>
</html>
