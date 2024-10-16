<?php
const SERVER = 'mysql310.phy.lolipop.lan';
const DBNAME = 'LAA1517323-circus';
const USER = 'LAA1517323';
const PASS = 'Pass0128';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // アレルギー情報の取得
    $allergy = $_POST['allergy'] ?? '';

    // データベース接続処理
    try {
        $pdo = new PDO('mysql:host='. SERVER. ';dbname='. DBNAME. ';charset=utf8', USER, PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // アレルギー情報を更新するクエリ
        $stmt = $pdo->prepare('UPDATE user SET allergies = :allergies WHERE id = :id');
        $stmt->execute([
            ':allergies' => $allergy,
            ':id' => 14 // ユーザーIDは例として14を使用
        ]);

        // 保存成功後、profile.phpにリダイレクト
        header("Location: profile.php");
        exit;

    } catch (PDOException $e) {
        // エラー発生時はエラーメッセージを表示
        echo "データベース接続エラー: " . $e->getMessage();
    }
}
?>