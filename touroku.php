<?php
// エラーメッセージを表示するための変数を初期化
$usernameError = $passwordError = "";
$username = $password = "";

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

    // フォームが有効ならtouroku_output.phpにデータを送信
    if ($isValid) {
        // データをPOSTで送信する
        echo "<form id='redirectForm' action='touroku_output.php' method='post'>";
        echo "<input type='hidden' name='username' value='" . $username . "'>";
        echo "<input type='hidden' name='password' value='" . $password . "'>";
        echo "<input type='hidden' name='gender' value='" . htmlspecialchars($_POST["gender"], ENT_QUOTES, 'UTF-8') . "'>";
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
    <link rel="stylesheet" href="css/touroku.css">
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
            <label><input type="radio" id="male" name="gender" value="male"> 男性</label>
            <label><input type="radio" id="female" name="gender" value="female"> 女性</label>
        </div>

        <input type="submit" value="新規登録">
    </form>
</div>
</body>
</html>