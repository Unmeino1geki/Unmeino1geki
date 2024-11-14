<?php
session_start();
include 'connect/dbconnect.php';

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
    <style>
        body {
    font-family: 'Lora', serif;
    background-color: #f0f8ff; /* 柔らかい淡い青 */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.content {
    background-color: #ffffff;
    padding: 40px;
    border-radius: 15px; 
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); 
    width: 350px;
    text-align: center;
    border: 1px solid #d0e6f9; 
}

h1 {
    font-size: 26px;
    color: #1e90ff; 
    margin-bottom: 20px;
    font-weight: 600; 
}

input[type="email"], input[type="password"] {
    width: 100%;
    padding: 12px;
    margin: 12px 0;
    border: 1px solid #a0cfee;
    border-radius: 8px; 
    box-sizing: border-box;
    background-color: #f8fbff; 
    transition: border-color 0.3s; 
}

input[type="email"]:focus, input[type="password"]:focus {
    border-color: #1e90ff; 
    outline: none; 
}

.btn {
    background-color: #1e90ff; 
    color: #ffffff;
    padding: 12px 25px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    width: 100%;
    font-size: 18px;
    font-weight: 600;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #187bcd; 
}

p {
    font-size: 14px;
    color: #666666;
}

a {
    color: #1e90ff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

p.error {
    color: #ff4f4f; /* エラーメッセージは赤で強調 */
}

    </style>
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
        <p>アカウントをお持ちでないですか？ <a href="touroku.php">新規登録</a></p>
    </div>
</div>
</body>
</html>


