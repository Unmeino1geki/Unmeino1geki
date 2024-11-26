<?php
session_start();
require_once 'connect/dbconnect.php';

// データベース接続の確認
if ($conn->connect_error) {
    die("データベース接続エラー: " . $conn->connect_error);
}

// エラーメッセージを表示するための変数を初期化
$usernameError = $passwordError = $confirmPasswordError = $genderError = $emailError = "";
$username = $password = $gender = $email = "";

// POSTリクエストを受け取ったときの処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    // メールアドレスのチェック
    if (empty($_POST["email"])) {
        $emailError = "メールアドレスを記入してください";
        $isValid = false;
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailError = "有効なメールアドレスを入力してください";
        $isValid = false;
    } else {
        $email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
    }
    //重複チェック
    $emailCheckQuery = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($emailCheckQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $emailResult = $stmt->get_result();

    if ($emailResult->num_rows > 0) {   
        $emailError = "このメールアドレスは既に使用されています";
        $isValid = false;
    }

    //重複チェック
    $emailCheckQuery = "SELECT * FROM email_verifications WHERE test_email = ?";
    $stmt = $conn->prepare($emailCheckQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $emailResult = $stmt->get_result();
    
    if ($emailResult->num_rows > 0) {   
        $emailError = "このメールアドレスは既に仮登録に使用されています<br>登録用メールが届いていないか確認してください";
        $isValid = false;
    }

    // ユーザー名のチェック
    if (empty($_POST["username"])) {
        $usernameError = "ユーザー名を記入してください";
        $isValid = false;
    } else {
        $username = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
    }
    //重複チェック
    $usernameCheckQuery = "SELECT * FROM user WHERE name = ?";
    $stmt = $conn->prepare($usernameCheckQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $usernameResult = $stmt->get_result();

    if ($usernameResult->num_rows > 0) {
        $usernameError = "このユーザー名は既に使用されています";
        $isValid = false;
    }

    // パスワードのチェック
    if (empty($_POST["password"])) {
        $passwordError = "パスワードを記入してください";
        $isValid = false;
    } elseif (!preg_match("/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{8,16}$/", $_POST["password"])) {
        $passwordError = "パスワードは英字と数字を含む8文字以上16文字以下にしてください";
        $isValid = false;
    } else {
        $password = htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
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

    // フォームが有効ならセッションに保存し、リダイレクト
    if ($isValid) {
        $_SESSION['User'] = [
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'gender' => $gender,
        ];
        header('Location: touroku_output.php');
        exit(); // リダイレクト後にスクリプトを終了
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
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
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
        
        <label for="email">メールアドレス:</label>
        <input class="inputform" type="email" id="email" name="email" placeholder="test@example.com" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>"><br>
        <span class="error"><?php echo $emailError; ?></span><br><br>

        <label for="username">ユーザー名:</label>
        <input class="inputform" type="text" id="username" name="username" placeholder="真夜中のサーカス" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>"><br>
        <span class="error"><?php echo $usernameError; ?></span><br><br>

        <label for="password">パスワード:</label>
        <div id="fieldPassword">
            <input class="inputform" type="password" id="password" name="password" placeholder="英数字を含む8文字以上16文字以内">
            <span id="buttonEye" class="fa fa-eye" onclick="pushHideButton()"></span>
        </div>
        <span class="error"><?php echo $passwordError; ?></span><br><br>

        <label for="confirm_password">確認用パスワード:</label>
        <div id="fieldPassword">
            <input class="inputform" type="password" id="confirm_password" name="confirm_password" placeholder="上記と同じパスワードを入力してください">
            <span id="confirm_buttonEye" class="fa fa-eye" onclick="pushHideConfirmButton()"></span>
        </div>
        <span class="error"><?php echo $confirmPasswordError; ?></span><br><br>

        <label>性別:</label>
        <div class="gender">
            <label><input type="radio" id="male" name="gender" value="男性" <?php if($gender == '男性') echo 'checked'; ?>> 男性</label>
            <label><input type="radio" id="female" name="gender" value="女性" <?php if($gender == '女性') echo 'checked'; ?>> 女性</label>
            <label><input type="radio" id="other" name="gender" value="ジェンダー" <?php if($gender == 'ジェンダー') echo 'checked'; ?>>ジェンダー</label>
            <label><input type="radio" id="none" name="gender" value="回答しない" <?php if($gender == '回答しない') echo 'checked'; ?>> 回答しない</label>
        </div>
        <span class="error"><?php echo $genderError; ?></span><br><br>

        <input type="submit" value="次へ">
    </form>
</div>

<script language="javascript">
    function pushHideButton() {
        var txtPass = document.getElementById("password");
        var btnEye = document.getElementById("buttonEye");
        if (txtPass.type === "text") {
            txtPass.type = "password";
            btnEye.className = "fa fa-eye";
        } else {
            txtPass.type = "text";
            btnEye.className = "fa fa-eye-slash";
        }
    }
    function pushHideConfirmButton() {
        var txtPass = document.getElementById("confirm_password");
        var btnEye = document.getElementById("confirm_buttonEye");
        if (txtPass.type === "text") {
            txtPass.type = "password";
            btnEye.className = "fa fa-eye";
        } else {
            txtPass.type = "text";
            btnEye.className = "fa fa-eye-slash";
        }
    }
</script>

</body>
</html>
