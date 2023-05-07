<?php
require_once '../conn.php';
require_once '../uuid_generator.php';

session_start();

// Get the form data
$activityAccountId = uuid_generator();
$activityId = $_POST['activityId'];
$accountId = $_POST['accountId'];
$attendeePhoneNumber = $_POST['attendeePhoneNumber'];
$attendeeEmail = $_POST['attendeeEmail'];
$attendeeRemark = $_POST['attendeeRemark'];

// Check if the user has already signed up for the activity
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

// Prepare the SQL INSERT statement
$sql = "INSERT INTO activities_accounts (activityAccountId, activityId, accountId, attendeePhoneNumber, attendeeEmail, attendeeRemark)
VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

// Bind the parameters
$stmt->bind_param("ssssss", $activityAccountId, $activityId, $accountId, $attendeePhoneNumber, $attendeeEmail, $attendeeRemark);

// Execute the SQL statement
if ($stmt->execute()) {
    // Close the prepared statement and the database connection
    $stmt->close();
    $conn->close();

    $_SESSION['system_message'] = "活動報名成功!";
    // Redirect back to the original page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    // Close the prepared statement and the database connection
    $stmt->close();
    $conn->close();

    // Display an error message
    $_SESSION['system_message'] = "活動報名失敗，請再試一次！";
    header("Location: " . $_SERVER['HTTP_REFERER']);
}
?>