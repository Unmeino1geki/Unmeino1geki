<?php
require 'connect/dbconnect.php';

// 現在時刻を取得
$current_time = date("Y-m-d H:i:s");

// 有効期限が過ぎたレコードを削除（mysqli使用）
$stmt = $conn->prepare("DELETE FROM email_verifications WHERE expires_at < ?");
if ($stmt === false) {
    // ステートメント準備のエラーをログに記録
    error_log("ステートメントの準備に失敗しました: " . $conn->error);
    exit;
}

// パラメータをバインドして実行
$stmt->bind_param("s", $current_time);
if (!$stmt->execute()) {
    // 実行エラーをログに記録
    error_log("SQL実行エラー: " . $stmt->error);
}

// ステートメントと接続を閉じる
$stmt->close();
$conn->close();
?>
