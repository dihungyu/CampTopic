<?php
require_once '../conn.php';

// 啟動會話
session_start();

if (isset($_POST['approvalStatus'])) {
    $approvalStatus = json_decode($_POST['approvalStatus'], true);
    $success = true;

    foreach ($approvalStatus as $accountId => $status) {
        // 根據您的資料表結構，請在此處更新資料表的isApproved欄位
        if ($status == 'accepted') {
            // 將isApproved更新為1（已接受）
            $sql_update_approval = "UPDATE activities_accounts SET isApproved = 1 WHERE accountId = '$accountId'";
        } elseif ($status == 'rejected') {
            // 將isApproved更新為2（已拒絕）
            $sql_update_approval = "UPDATE activities_accounts SET isApproved = 2 WHERE accountId = '$accountId'";
        }
        if (mysqli_query($conn, $sql_update_approval)) {
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
?>