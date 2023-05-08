<?php
header('Content-Type: application/json');

// 連接資料庫
require_once '../../php/conn.php';

if (isset($_GET['articleId'])) {

    $articleId = $_GET['articleId'];

    // 取得文章內容
    $sql = "SELECT * FROM articles WHERE articleId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $articleId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // 將文章內容作為 JSON 物件回傳
        echo json_encode(array(
            'articleTitle' => $row['articleTitle'],
            'articleContent' => $row['articleContent']
        ));
    } else {
        echo json_encode(array('error' => '無法獲取文章內容。'));
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(array('error' => '無效的文章ID。'));
}
