<?php
session_start();
require_once 'connect/dbconnect.php';

// データベース接続の確認
if ($conn->connect_error) {
    die("データベース接続エラー: " . $conn->connect_error);
}

// トークンをURLパラメータから取得し、サニタイズ
$token = isset($_GET['token']) ? htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8') : '';
$email = '';  // 初期化

// トークンの確認メッセージ
echo "取得したトークン: " . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . "<br>";

// トークンに対応するメールアドレスをデータベースから取得
$stmt = $conn->prepare("SELECT test_email FROM email_verifications WHERE token = ?");
if (!$stmt) {
    die("クエリ準備エラー: " . $conn->error);
}

$stmt->bind_param("s", $token);

// クエリの実行とエラーチェック
if (!$stmt->execute()) {
    die("クエリエラー: " . $stmt->error);
}

$result = $stmt->get_result();

// クエリ結果の確認
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row['test_email'];
    echo "取得したメールアドレス: " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "<br>";
} else {
    echo "メールアドレスが見つかりませんでした。トークンが無効または期限切れの可能性があります。<br>";
   exit(); // メールアドレスが見つからなかった場合はここで処理を終了
}

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
            'username' => $username,
            'password' => $hashedPassword,
            'gender' => $gender,
            'email' => $email,
        ];
        header('Location: touroku_output.php?token=' . urlencode($token));
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
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>"><br>
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
            <label><input type="radio" id="other" name="gender" value="other" <?php if($gender == 'other') echo 'checked'; ?>> その他</label>
            <label><input type="radio" id="none" name="gender" value="none" <?php if($gender == 'none') echo 'checked'; ?>> 回答しない</label>
        </div>
        <span class="error"><?php echo $genderError; ?></span><br><br>

        <input type="submit" value="次へ">
    </form>
</div>
</body>
</html>
