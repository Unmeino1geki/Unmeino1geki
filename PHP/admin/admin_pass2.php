<?php
// データベース接続 (PDO を使用)
const SERVER = 'mysql310.phy.lolipop.lan';
const DBNAME = 'LAA1517323-circus';
const USER = 'LAA1517323';
const PASS = 'Pass0128';


try {
    $pdo = new PDO('mysql:host='. SERVER . ';dbname='. DBNAME . ';charset=utf8', USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // POSTリクエストで送信されたユーザーデータの更新処理
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['adminname'], $_POST['password'])) {
        $userId = (int)$_POST['user_id'];
        $newUsername = trim($_POST['adminname']);
        $newPassword = trim($_POST['password']);
    
    
        // パスワードのバリデーション（例: 8文字以上）
        if (strlen($newPassword) < 8) {
            echo "パスワードは8文字以上でなければなりません。";
            exit;
        }

        // トランザクション開始
        $pdo->beginTransaction();

        // 1. user テーブルのユーザーネームを更新
        $stmt = $pdo->prepare("UPDATE user SET name = ? WHERE id = ?");
        $stmt->execute([$newUsername, $userId]);

        // 2. パスワードをハッシュ化して更新
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE user SET password = ? WHERE id = ?");
        $stmt->execute([$hashedPassword, $userId]);
        
        // コミットしてトランザクションを終了
        $pdo->commit();

        // 更新が成功したら admin_pass1.php にリダイレクト
        header("Location: admin_pass1.php");
        exit;  // リダイレクト後のコード実行を防止
    }

} catch (PDOException $e) {
    // エラーがあったらロールバック
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "データベースエラー: " . $e->getMessage();
    exit;
}
?>

