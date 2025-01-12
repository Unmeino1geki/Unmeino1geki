<?php
// 必要な設定・共通処理をインクルード
require_once 'connect/dbconnect.php'; // DB接続情報などの設定を格納
session_start();

// セッションチェック（ログインしているか確認）
if (!isset($_SESSION['user_id'])) {
    echo "ログインが必要です。";
    exit();
}

// DB接続
try {
    // DB接続情報を確認して接続
    $pdo = new PDO('mysql:host=' . SERVER . ';dbname=' . DBNAME . ';charset=utf8', USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "データベース接続エラー: " . $e->getMessage();
    exit();
}

// ユーザーID（セッションから取得）
$userId = $_SESSION['user_id'];

// 名前・性別の更新処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['gender'])) {
        $name = $_POST['name'];
        $gender = $_POST['gender'];

        try {
            // 名前と性別を更新するクエリ
            $stmt = $pdo->prepare('UPDATE user SET name = :name, gender = :gender WHERE id = :id');
            $stmt->execute([
                ':name' => $name,
                ':gender' => $gender,
                ':id' => $userId
            ]);

            // 更新後、プロフィールページにリダイレクト
            header('Location: profile.php');
            exit();
        } catch (PDOException $e) {
            echo "データベース更新エラー: " . $e->getMessage();
        }
    }
}

// アレルギー情報の更新処理（そのまま）
if (isset($_POST['allergy'])) {
    $allergy = $_POST['allergy'];

    try {
        $stmt = $pdo->prepare('UPDATE user SET allergies = :allergies WHERE id = :id');
        $stmt->execute([
            ':allergies' => $allergy,
            ':id' => $userId
        ]);
        header("Location: profile.php");
        exit();
    } catch (PDOException $e) {
        echo "データベース接続エラー: " . $e->getMessage();
    }
}
?>
