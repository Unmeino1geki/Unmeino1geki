<?php
session_start();

// エラーメッセージを表示するための変数を初期化
$usernameError = $passwordError = $genderError = "";
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
    } else {
        $password = htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');
    }

    // 性別のチェック
    if (empty($_POST["gender"])) {
        $genderError = "性別を選択してください";
        $isValid = false;
    } else {
        $gender = htmlspecialchars($_POST["gender"], ENT_QUOTES, 'UTF-8');
    }

    // フォームが有効ならtouroku_output.phpにデータを送信
    if ($isValid) {
        echo "<form id='redirectForm' action='touroku_output.php' method='post'>";
        echo "<input type='hidden' name='username' value='" . $username . "'>";
        echo "<input type='hidden' name='password' value='" . $password . "'>";
        echo "<input type='hidden' name='gender' value='" . $gender . "'>";
        echo "</form>";
        echo "<script>document.getElementById('redirectForm').submit();</script>";
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
