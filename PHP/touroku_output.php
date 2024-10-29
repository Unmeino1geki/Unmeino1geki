<?php
session_start();

// セッションに保存したユーザー情報があるか確認
if (!isset($_SESSION['User'])) {
    header("Location: touroku.php");
    exit();
}

// データベースに保存したい場合の処理（例：必要ならDBに接続してINSERT文を実行）

// `diagnosis.php`にリダイレクト
header("Location: diagnosis.php");
exit();
?>
