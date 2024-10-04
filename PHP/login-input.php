<?php
session_start();
include 'common/db-connect.php';

$errors = []; // エラーメッセージを格納する配列

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['pass'];

    // メールアドレスのバリデーション
    if (empty($email)) {
        $errors['email'] = 'メールアドレスは必須です。';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = '無効なメールアドレス形式です。';
    }

    // パスワードのバリデーション
    if (empty($password)) {
        $errors['pass'] = 'パスワードは必須です。';
    }

    if (count($errors) === 0) {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                $errors['login'] = '入力されたメールアドレスのユーザーは存在しません';
            } elseif (!password_verify($password, $user['password'])) {
                $errors['login'] = 'メールアドレスもしくはパスワードが間違っています。';
            } else {
                $_SESSION['id'] = $user['user_id'];
                header('Location: home.php');
                exit;
            }
        } catch (PDOException $e) {
            $errors['db'] = 'エラーが発生しました: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
</head>
<body>
<div class="flexbox">
    <div class="content">
        <?php foreach ($errors as $error): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endforeach; ?>  
    <h1>ログイン</h1>
        <form action="" method="POST">
            <p>メールアドレス</p><input type="email" name="email">
            <p>パスワード</p><input type="password" name="pass">
            <button type="submit" class="btn">ログイン</button>
        </form>
        <p>アカウントをお持ちでないですか？ <a href=".php">新規登録</a></p>
    </div>
</div>
</body>
</html>


