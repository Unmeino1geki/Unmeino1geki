<?php require 'header.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メールアドレスの入力</title>
    <link rel="stylesheet" href="../CSS/email_input.css">
    <link rel="stylesheet" href="../Java/email_input.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body class="bg-secondary-subtle">


        <!-- ここにスクリーンのコンテンツを挿入 -->
<ul class="screens">
            <li id="screen0" class="screen screen0">
                <a class="next-arrow" href="#screen1">
                    <div id="title">
                        <p class="fs-4 fw-medium mx-auto">メールアドレス認証</p>
                    </div>
                    <p id="confirm-text" class="Bold text mx-auto">本人確認のため、メールアドレスの認証をお願いします</p>
                    <form action="send_email.php" method="POST">
                        <div id="form-box"> 
                            <label for="email" id="email-label">メールアドレス</label><br>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div id="submit-button">
                            <input class="rounded-2 justify-content-center" type="submit" value="認証メールを送る">
                        </div>
                    </form>
                </a>
            </li>
    <div id="container">
    </div>
</body>
</html>
<?php require 'footer.php'; ?>
