<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../conn.php';
require_once '../uuid_generator.php';
require_once '../../sendMail.php';

session_start();

// 取得表單資料
$activityAccountId = uuid_generator();
$activityId = $_POST['activityId'];
$accountId = $_POST['accountId']; // 這個是報名者的accountId
$attendeePhoneNumber = $_POST['attendeePhoneNumber'];
$attendeeEmail = $_POST['attendeeEmail'];
$attendeeRemark = $_POST['attendeeRemark'];

// 檢查使用者是否已報名該活動
$checkSql = "SELECT * FROM activities_accounts WHERE activityId = ? AND accountId = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("ss", $activityId, $accountId);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    $_SESSION['system_message'] = "您已經報名過囉，請耐心等待審核！";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

// 取得活動發起者accountId
$creatorAccountId_sql = "SELECT accountId FROM activities WHERE activityId = ?";
$creatorAccountId_stmt = $conn->prepare($creatorAccountId_sql);
$creatorAccountId_stmt->bind_param("s", $activityId);
$creatorAccountId_stmt->execute();
$creatorAccountId_result = $creatorAccountId_stmt->get_result();

if ($creatorAccountId_result->num_rows > 0) {
    $creatorAccountId_row = $creatorAccountId_result->fetch_assoc();
    $creatorAccountId = $creatorAccountId_row['accountId'];
}

// 準備SQL INSERT語句
$sql = "INSERT INTO activities_accounts (activityAccountId, activityId, accountId, attendeePhoneNumber, attendeeEmail, attendeeRemark)
VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// 綁定參數
$stmt->bind_param("ssssss", $activityAccountId, $activityId, $accountId, $attendeePhoneNumber, $attendeeEmail, $attendeeRemark);

// 執行SQL語句
if ($stmt->execute()) {

    // 寄出通知信給活動發起人
    sendCreatorSomeoneAttend($creatorAccountId, $activityId, $conn);

    // 關閉預備語句和資料庫連接
    $stmt->close();
    $conn->close();

    $_SESSION['system_message'] = "活動報名成功!";
    // 重定向回原始頁面
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    // 關閉預備語句和資料庫連接
    $stmt->close();
    $conn->close();

    // 顯示錯誤訊息
    $_SESSION['system_message'] = "活動報名失敗，請再試一次！";
    header("Location: " . $_SERVER['HTTP_REFERER']);
}
