<?php
require_once '../conn.php';
require_once '../../sendMail.php';

// 啟動會話
session_start();

if (isset($_POST['approvalStatus']) && isset($_POST['activityId'])) {
    $approvalStatus = json_decode($_POST['approvalStatus'], true);
    $activityId = $_POST['activityId'];
    $success = true;

    foreach ($approvalStatus as $accountId => $status) {
        // 根據您的資料表結構，請在此處更新資料表的isApproved欄位
        if ($status == 'accepted') {
            // 將isApproved更新為1（已接受）
            $sql_update_approval = "UPDATE activities_accounts SET isApproved = 1 WHERE accountId = '$accountId'";
            $exeResult = 1;
        } elseif ($status == 'rejected') {
            // 將isApproved更新為2（已拒絕）
            $sql_update_approval = "UPDATE activities_accounts SET isApproved = 2 WHERE accountId = '$accountId'";
            $exeResult = 2;
        }
        if (mysqli_query($conn, $sql_update_approval)) {
            if ($exeResult == 1) {
                // 審核通過，寄送通知信給使用者
                sendAttendeeConfirmSucess($accountId, $activityId, $conn);
            } elseif ($exeResult == 2) {
                // 審核不通過，寄送通知信給使用者
                sendAttendeeConfirmReject($accountId, $activityId, $conn);
            }
            // 資料更新成功
        } else {
            // 資料更新失敗
            $success = false;
        }
    }
    if ($success == true) {

        $_SESSION['system_message'] = '審核結果已更新！';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['system_message'] = '審核結果更新失敗！';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}