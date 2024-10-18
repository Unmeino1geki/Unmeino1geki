<?php require 'header.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メールアドレスの入力</title>
    <link rel="stylesheet" href="../CSS/email_input.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div id="container">
        <p class="fw-medium">メールアドレスを入力</p>
        <form action="send_email.php" method="POST">
            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" required>
            <input type="submit" value="次へ">
        </form>
    </div>
</body>
</html>
<?php require 'footer.php'; ?>
