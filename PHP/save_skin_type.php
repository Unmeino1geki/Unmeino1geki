<?php
session_start();

// JSONデータを取得
$data = json_decode(file_get_contents("php://input"), true);

// データが正しく受け取られているか確認
if (isset($data['skin_type'])) {
    $_SESSION['skin_type'] = $data['skin_type'];
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>