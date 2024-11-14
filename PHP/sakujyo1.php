<?php
session_start(); // セッションを再開して保持

// セッションからユーザーIDを取得
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // セッションがない場合はログインページにリダイレクト
    header("Location: login-input.php");
    exit;
}

const SERVER = 'mysql310.phy.lolipop.lan';
const DBNAME = 'LAA1517323-circus';
const USER = 'LAA1517323';
const PASS = 'Pass0128';

try {
    // データベースに接続
    $pdo = new PDO('mysql:host='. SERVER. ';dbname='. DBNAME. ';charset=utf8', USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ユーザー情報を削除するSQL
    $stmt = $pdo->prepare('DELETE FROM user WHERE id = :id');
    $stmt->execute([':id' => $user_id]);

    // 削除が完了したらセッションを破棄
    session_unset();
    session_destroy();

    // 削除完了後、ログインページにリダイレクトし、完了メッセージを表示
    header("Location:sakujyo2.php?deleted=1");
    exit;

} catch (PDOException $e) {
    echo "データベースエラー: " . $e->getMessage();
}
?>
