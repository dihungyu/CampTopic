<?php
session_start();
require_once '../php/conn.php';
require_once '../php/uuid_generator.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 獲取表單數據
    $reportReason = isset($_POST['reportReason']) ? $_POST['reportReason'] : '';
    $reportDescription = isset($_POST['reportDescription']) ? $_POST['reportDescription'] : '';
    $articleId = isset($_POST['articleId']) ? $_POST['articleId'] : 0;
    $reporterId = $_COOKIE["accountId"]; // 從 Cookie 獲取舉報者 ID
    $reportId = uuid_generator(); // 生成舉報 ID

    // 數據驗證
    $errors = array();

    if (empty($reportReason)) {
        $errors[] = '舉報原因字段為空';
    }

    if (empty($reportDescription)) {
        $errors[] = '詳細描述字段為空';
    }

    if ($articleId == 0) {
        $errors[] = '文章ID字段為空或無效';
    }

    if (!empty($errors)) {
        // 返回錯誤信息
        $error_message = '表單數據不完整: ' . implode(', ', $errors);
        echo json_encode(['status' => 'error', 'message' => $error_message, 'articleId' => $articleId]);
        exit;
    }

    // 檢查是否已經举報過該文章
    $sql_check = "SELECT COUNT(*) FROM reports WHERE articleId = '$articleId' AND accountId = '$reporterId'";
    $sql_check_result = mysqli_query($conn, $sql_check);

    if ($sql_check_result) {
        $count = mysqli_fetch_row($sql_check_result)[0];

        if ($count > 0) {
            // 已經举報過該文章，返回錯誤信息
            echo json_encode(['status' => 'error', 'message' => '您已經對該文章進行過舉報，請耐心等待審核', 'articleId' => $articleId]);
            exit;
        }
    } else {
        // 查詢出錯，返回錯誤信息
        echo json_encode(['status' => 'error', 'message' => '查詢數據庫時發生錯誤', 'articleId' => $articleId]);
        exit;
    }

    // 準備 SQL 語句
    $sql = "INSERT INTO reports (reportId, accountId, articleId, reportReason, reportDescription) VALUES ('$reportId', '$reporterId', '$articleId', '$reportReason', '$reportDescription')";
    $sql_result = mysqli_query($conn, $sql);

    // 檢查錯誤
    if (!$sql_result) {
        // 返回錯誤信息
        echo json_encode(['status' => 'error', 'message' => '數據庫操作失敗：' . mysqli_error($conn), 'articleId' => $articleId]);
        exit;
    }

    // 返回成功信息
    echo json_encode([
        'status' => 'success', 'message' => '舉報已提交', 'articleId' => $articleId
    ]);
}
