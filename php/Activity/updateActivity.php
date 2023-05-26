<?php
require_once '../conn.php';

session_start();

$activityId = $_GET['activityId'];

if (isset($_POST["action"]) && $_POST["action"] == 'update') {
    $emptyFields = [];

    if (empty($_POST['campsiteId'])) $emptyFields[] = 'campsiteId';
    if (empty($_POST['activityTitle'])) $emptyFields[] = 'activityTitle';
    if (empty($_POST['activityDescription'])) $emptyFields[] = 'activityDescription';
    if (empty($_POST['activityStartDate'])) $emptyFields[] = 'activityStartDate';
    if (empty($_POST['activityEndDate'])) $emptyFields[] = 'activityEndDate';
    if (empty($_POST['minAttendee'])) $emptyFields[] = 'minAttendee';
    if (empty($_POST['maxAttendee'])) $emptyFields[] = 'maxAttendee';
    if (empty($_POST['leastAttendeeFee'])) $emptyFields[] = 'leastAttendeeFee';
    if (empty($_POST['maxAttendeeFee'])) $emptyFields[] = 'maxAttendeeFee';

    if (!empty($emptyFields)) {
        $_SESSION['system_message'] = '以下欄位不得有空值：' . implode(", ", $emptyFields);
        header('Location: ../../deluxe-master/check.php?activityId=' . $activityId);
        exit;
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
            exit;
        } elseif ($newMinAttendee > $newMaxAttendee) {
            $_SESSION['system_message'] = '最低參加人數要小於最高參加人數！';
            header('Location: ../../deluxe-master/check.php?activityId=' . $activityId);
            exit;
        } elseif ($newLeastAttendeeFee > $newMaxAttendeeFee) {
            $_SESSION['system_message'] = '最低預估費用要小於最高預估費用！';
            header('Location: ../../deluxe-master/check.php?activityId=' . $activityId);
            exit;
        } elseif ($duration > 5) {
            $_SESSION["system_message"] = "活動不得超過五天！";
            header('Location: ../../deluxe-master/check.php?activityId=' . $activityId);
            exit;
        } else {
            $newActivityDeadLineDate = date('Y-m-d', strtotime($newActivityStartDate . "-3 days"));

            $sql_query = "UPDATE activities SET campsiteId = '$newCampsiteId', activityTitle = '$newActivityTitle', activityDescription = '$newActivityDescription',
        activityStartDate = '$newActivityStartDate', activityEndDate = '$newActivityEndDate', activityDeadLineDate = '$newActivityDeadLineDate',
        minAttendee = $newMinAttendee, maxAttendee = $newMaxAttendee, leastAttendeeFee = $newLeastAttendeeFee, maxAttendeeFee = $newMaxAttendeeFee WHERE activityId = '$activityId'";

            mysqli_query($conn, $sql_query);

            $_SESSION['system_message'] = '活動資料更新成功！';
            header('Location: ../../deluxe-master/check.php?activityId=' . $activityId);
            exit;
        }
    }
}
