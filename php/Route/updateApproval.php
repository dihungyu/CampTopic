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
    $alert_message = $success ? '審核成功' : '資料更新失敗';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting...</title>
    <script>
        // 顯示提示訊息
        alert('<?php echo $alert_message; ?>');

        // 跳轉到 check.php 頁面
        window.location.href = '../../deluxe-master/check.php';
    </script>
</head>

<body>
</body>

</html>