<?php
require 'connect/dbconnect.php';
    // 現在時刻を取得
    $current_time = date("Y-m-d H:i:s");

    // 有効期限が過ぎたレコードを削除（mysqli使用）
    $stmt = $conn->prepare("DELETE FROM email_verifications WHERE expires_at < ?");
    $stmt->bind_param("s", $current_time);
    $stmt->execute();
    $stmt->close();

    // 接続を閉じる
    $conn->close();
?>
