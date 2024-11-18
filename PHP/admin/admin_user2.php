<?php
// データベース接続 (PDO を使用)
require_once 'connect/dbconnect.php';
try {
    $pdo = new PDO('mysql:host='. SERVER. ';dbname='. DBNAME. ';charset=utf8', USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // POSTリクエストで送信されたユーザーIDの削除処理
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
        $userId = (int)$_POST['user_id'];
        
        // トランザクション開始
        $pdo->beginTransaction();

        // 1. まず admin テーブルの関連データを削除
        $stmt = $pdo->prepare("DELETE FROM admin WHERE user_id = ?");
        $stmt->execute([$userId]);

        // まず関連する favorite テーブルのデータを削除
        $stmt = $pdo->prepare("DELETE FROM favorite WHERE user_id = ?");
        $stmt->execute([$userId]);
        
        // 次に user テーブルのデータを削除
        $stmt = $pdo->prepare("DELETE FROM user WHERE id = ?");
        $stmt->execute([$userId]);
        
        // コミットしてトランザクションを終了
        $pdo->commit();

        // 削除が成功したら admin_user2.php にリダイレクト
        header("Location: admin_user1.php");
        exit;  // リダイレクト後のコード実行を防止
    }

} catch (PDOException $e) {
    // エラーがあったらロールバック
    $pdo->rollBack();
    echo "データベースエラー: " . $e->getMessage();
    exit;
}
?>
