<?php
session_start();

// エラーメッセージを表示するための変数を初期化
$usernameError = $passwordError = $confirmPasswordError = $genderError = "";
$username = $password = $gender = "";

// POSTリクエストを受け取ったときの処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    // ユーザー名のチェック
    if (empty($_POST["username"])) {
        $usernameError = "ユーザー名を記入してください";
        $isValid = false;
    } else {
        $username = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
    }

    // パスワードのチェック
    if (empty($_POST["password"])) {
        $passwordError = "パスワードを記入してください";
        $isValid = false;
    } elseif (!preg_match("/^[a-zA-Z0-9]{8,16}$/", $_POST["password"])) {
        $passwordError = "パスワードは半角英数字で8文字以上16文字以下にしてください";
        $isValid = false;
    } else {
        $password = htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');
    }

    // 確認用パスワードのチェック
    if (empty($_POST["confirm_password"])) {
        $confirmPasswordError = "確認用パスワードを入力してください";
        $isValid = false;
    } elseif ($_POST["password"] !== $_POST["confirm_password"]) {
        $confirmPasswordError = "パスワードが一致しません";
        $isValid = false;
    }

    // 性別のチェック
    if (empty($_POST["gender"])) {
        $genderError = "性別を選択してください";
        $isValid = false;
    } else {
        $gender = htmlspecialchars($_POST["gender"], ENT_QUOTES, 'UTF-8');
    }

    // メールアドレスのセッション保存
    $_SESSION['User']['email'] = $_SESSION['User']['email'] ?? '';

    // フォームが有効ならセッションに保存
    if ($isValid) {
        $_SESSION['User']['username'] = $username;
        $_SESSION['User']['password'] = $password;
        $_SESSION['User']['gender'] = $gender;

        // touroku-output.phpにリダイレクト
        header('Location: touroku_output.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
    <link rel="stylesheet" href="../CSS/touroku.css">
    <style>
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>新規登録</h2>

    <!-- 新規登録フォーム -->
    <form action="touroku.php" method="post">
        <label for="username">ユーザー名:</label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>"><br>
        <span class="error"><?php echo $usernameError; ?></span><br><br>

        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password"><br>
        <span class="error"><?php echo $passwordError; ?></span><br><br>

        <label for="confirm_password">確認用パスワード:</label>
        <input type="password" id="confirm_password" name="confirm_password"><br>
        <span class="error"><?php echo $confirmPasswordError; ?></span><br><br>

        <label>性別:</label>
        <div class="gender">
            <label><input type="radio" id="male" name="gender" value="male" <?php if($gender == 'male') echo 'checked'; ?>> 男性</label>
            <label><input type="radio" id="female" name="gender" value="female" <?php if($gender == 'female') echo 'checked'; ?>> 女性</label>
            <label><input type="radio" id="other" name="gender" value="other" <?php if($gender == 'other') echo 'checked'; ?>> ジェンダー</label>
            <label><input type="radio" id="none" name="gender" value="none" <?php if($gender == 'none') echo 'checked'; ?>> なし</label>
        </div>
        <span class="error"><?php echo $genderError; ?></span><br><br>

        <input type="submit" value="次へ">
    </form>
</div>
</body>
</html>
