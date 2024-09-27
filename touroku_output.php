<?php
// POSTリクエストでデータが渡っているか確認
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ユーザー名、パスワード、性別をPOSTから取得、未定義の場合は空文字列を代入
    $username = isset($_POST["username"]) ? $_POST["username"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $gender = isset($_POST["gender"]) ? $_POST["gender"] : "";
} else {
    // POST以外のリクエストでこのページに来た場合はエラーメッセージを表示
    echo "無効なアクセスです。フォームからデータを送信してください。";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録完了</title>
    <link rel="stylesheet" href="css/touroku_output.css">
</head>
<body>
    <h2>登録内容</h2>

    <!-- ユーザー名の表示 -->
    <p>ユーザー名: <?php echo !empty($username) ? htmlspecialchars($username, ENT_QUOTES, 'UTF-8') : "未入力"; ?></p>

    <!-- パスワードの表示 -->
    <p>パスワード: <?php echo !empty($password) ? htmlspecialchars($password, ENT_QUOTES, 'UTF-8') : "未入力"; ?></p>

    <!-- 性別の表示 -->
    <p>性別: 
        <?php 
            if ($gender === "male") {
                echo "男性";
            } elseif ($gender === "female") {
                echo "女性";
            } else {
                echo "未選択";
            }
        ?>
    </p>

    <!-- 戻るボタン -->
    <form action="touroku.php" method="get">
        <button type="submit">戻る</button>
    </form>
</body>
</html>