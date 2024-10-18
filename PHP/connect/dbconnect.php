<?php
    // データベース接続設定
    const SERVER = 'mysql310.phy.lolipop.lan';
    const DBNAME = 'LAA1517323-circus';
    const USER = 'LAA1517323';
    const PASS = 'Pass0128';
    $connect = 'mysql:host='. SERVER. ';dbname='. DBNAME. ';charset=utf8';

    // MySQL に接続
    $conn = new mysqli(SERVER, USER, PASS, DBNAME);

    // 接続チェック
    if ($conn->connect_error) {
        die("接続に失敗しました: " . $conn->connect_error);
    }
?>