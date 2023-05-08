<?php
require_once '../conn.php';

session_start();

$activityId = $_GET['activityId'];

if (isset($_POST["action"]) && $_POST["action"] == 'update') {

    if (empty($_POST['campsiteId']) || empty($_POST['activityTitle']) || empty($_POST['activityDescription']) || empty($_POST['activityStartDate']) || empty($_POST['activityEndDate']) || empty($_POST['minAttendee']) || empty($_POST['maxAttendee']) || empty($_POST['leastAttendeeFee']) || empty($_POST['maxAttendeeFee'])) {
        $_SESSION['system_message'] = '欄位不得有空值！';
        header('Location: ../../deluxe-master/check.php?activityId=' . $activityId);
    } else {
        $newCampsiteId = $_POST['campsiteId'];
        $newActivityTitle = $_POST['activityTitle'];
        $newActivityDescription = $_POST['activityDescription'];
        $newActivityStartDate = $_POST['activityStartDate'];
        $newActivityEndDate = $_POST['activityEndDate'];
        $newMinAttendee = intval($_POST['minAttendee']);
        $newMaxAttendee = intval($_POST['maxAttendee']);
        $newLeastAttendeeFee = intval($_POST['leastAttendeeFee']);
        $newMaxAttendeeFee = intval($_POST['maxAttendeeFee']);

        // 計算活動持續的天數
        $duration = (strtotime($newActivityEndDate) - strtotime($newActivityStartDate)) / (60 * 60 * 24);

        if ($newActivityStartDate > $newActivityEndDate) {
            $_SESSION['system_message'] = '活動開始日期要在結束日期之前！';
            header('Location: ../../deluxe-master/check.php?activityId=' . $activityId);
        } elseif ($newMinAttendee > $newMaxAttendee) {
            $_SESSION['system_message'] = '最低參加人數要小於最高參加人數！';
            header('Location: ../../deluxe-master/check.php?activityId=' . $activityId);
        } elseif ($newLeastAttendeeFee > $newMaxAttendeeFee) {
            $_SESSION['system_message'] = '最低預估費用要小於最高預估費用！';
            header('Location: ../../deluxe-master/check.php?activityId=' . $activityId);
        } elseif ($duration > 5) {
            $_SESSION["system_message"] = "活動不得超過五天！";
            header('Location: ../../deluxe-master/check.php?activityId=' . $activityId);
        } else {

            $newActivityDeadLineDate = date('Y-m-d', strtotime($newActivityStartDate . "-3 days"));

            $sql_query = "UPDATE activities SET campsiteId = '$newCampsiteId', activityTitle = '$newActivityTitle', activityDescription = '$newActivityDescription',
        activityStartDate = '$newActivityStartDate', activityEndDate = '$newActivityEndDate', activityDeadLineDate = '$newActivityDeadLineDate',
        minAttendee = $newMinAttendee, maxAttendee = $newMaxAttendee, leastAttendeeFee = $newLeastAttendeeFee, maxAttendeeFee = $newMaxAttendeeFee WHERE activityId = '$activityId'";

            mysqli_query($conn, $sql_query);

            $_SESSION['system_message'] = '活動資料更新成功！';
            header('Location: ../../deluxe-master/check.php?activityId=' . $activityId);
        }
    }
}
?>