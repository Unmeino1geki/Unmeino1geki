<?php
// 出力バッファリングを開始
ob_start();

// データベース接続設定
const SERVER = 'mysql310.phy.lolipop.lan';
const DBNAME = 'LAA1517323-circus';
const USER = 'LAA1517323';
const PASS = 'Pass0128';
$connect = 'mysql:host='. SERVER. ';dbname='. DBNAME. ';charset=utf8';

// MySQL に接続
$conn = new mysqli(SERVER, USER, PASS, DBNAME);

// 接続チェック
if ($conn->connect_error) {
    die("接続に失敗しました: " . $conn->connect_error);
}

// POSTデータを取得
$username = isset($_POST['name']) ? $_POST['name'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;

if (!$username || !$password) {
    header("Location: admin_login-input.php?flag=missing_data");
    exit();
}

// users テーブルでユーザー名から ID とパスワードを確認
$sql = "SELECT id, password FROM user WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_id = $user['id'];

    // パスワード確認
    if ($password == $user['password']) {  // パスワードが一致する場合
        // 管理者テーブルで user_id が管理者か確認
        $sql = "SELECT user_id FROM admin WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // 認証成功
            header("Location: admin_top.php");
            exit();
        } else {
            // 管理者でない場合
            header("Location: admin_login-input.php?flag=not_admin");
            exit();
        }
    } else {
        // パスワードが違う場合
        header("Location: admin_login-input.php?flag=miss");
        exit();
    }
} else {
    // ユーザーが見つからない場合
    header("Location: admin_login-input.php?flag=user_not_found");
    exit();
}
