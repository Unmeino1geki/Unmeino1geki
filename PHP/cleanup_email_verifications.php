<?php
require 'connect/dbconnect.php';

// 現在時刻を取得
$current_time = date("Y-m-d H:i:s");

// 有効期限が過ぎたレコードを削除
$stmt = $pdo->prepare("DELETE FROM email_verifications WHERE expires_at < :current_time");
$stmt->bindParam(':current_time', $current_time);
$stmt->execute();

?>