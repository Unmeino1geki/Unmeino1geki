<?php
require 'connect/dbconnect.php';

// GETパラメータからトークンを取得
$token = $_GET['token'] ?? null;

if (!$token) {
    die("無効なリクエストです。");
}

// トークンをデータベースで検索
$stmt = $conn->prepare("SELECT * FROM email_verifications WHERE token = ? AND expires_at > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("トークンが無効または期限切れです。");
}

// トークンに関連するユーザーデータを取得
$row = $result->fetch_assoc();
$name = $row['test_name'];
$email = $row['test_email'];
$password = $row['test_password'];
$skin_type = $row['test_skin_type'];
$gender = $row['test_gender'];

//var_dump($username, $email, $password, $gender, $skin_type);

// `user`テーブルに挿入
$insert_stmt = $conn->prepare("INSERT INTO user (name, email, password, skin_type, gender, created_at, updated_at) 
                               VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
$insert_stmt->bind_param("sssss", $name, $email, $password, $skin_type, $gender);

if ($insert_stmt->execute()) {
    // `email_verifications`テーブルからトークンを削除
    $delete_stmt = $conn->prepare("DELETE FROM email_verifications WHERE token = ?");
    $delete_stmt->bind_param("s", $token);
    $delete_stmt->execute();

    header("refresh:5;url=https://quiet-obi-5971.penne.jp/Unmeino1geki/PHP/login.php");
    echo "登録が完了しました。";
} else {
    echo "登録処理中にエラーが発生しました。";
}
?>
