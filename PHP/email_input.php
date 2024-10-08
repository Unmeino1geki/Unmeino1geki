<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メールアドレスの入力</title>
    <link rel="stylesheet" href="../CSS/email_input.css">
</head>
<body>
    <div class="container">
        <h2>メールアドレスを入力</h2>
        <form action="send_email.php" method="POST">
            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" required>
            <input type="submit" value="次へ">
        </form>
    </div>
</body>
</html>
