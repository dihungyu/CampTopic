<?php
session_start();

require_once '../conn.php';
require_once '../uuid_generator.php';

if (isset($_POST["action"]) && ($_POST["action"] == "insert")) {

    $activityId = uuid_generator();
    $campsiteId = $_POST["campsiteId"];
    $accountId = $_POST["accountId"];
    $activityTitle = $_POST["activityTitle"];
    $activityDescription = $_POST['activityDescription'];
    $activityStartDate = $_POST['activityStartDate'];
    $activityEndDate = $_POST['activityEndDate'];
    $minAttendee = intval($_POST['minAttendee']);
    $maxAttendee = intval($_POST['maxAttendee']);
    $leastAttendeeFee = intval($_POST['leastAttendeeFee']);
    $maxAttendeeFee = intval($_POST['maxAttendeeFee']);

    // 計算活動持續的天數
    $duration = (strtotime($activityEndDate) - strtotime($activityStartDate)) / (60 * 60 * 24);

    // 檢查是否已經存在相同日期範圍內的活動
    $check_duplicate_query = "SELECT * FROM activities WHERE accountId = '$accountId' AND (
        ('$activityStartDate' BETWEEN activityStartDate AND activityEndDate) OR
        ('$activityEndDate' BETWEEN activityStartDate AND activityEndDate) OR
        (activityStartDate BETWEEN '$activityStartDate' AND '$activityEndDate') OR
        (activityEndDate BETWEEN '$activityStartDate' AND '$activityEndDate')
    )";
    $result = mysqli_query($conn, $check_duplicate_query);

    if ($activityStartDate > $activityEndDate) {
        $_SESSION["system_message"] = "活動開始日期要小於活動結束日期！";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } elseif ($minAttendee > $maxAttendee) {
        $_SESSION["system_message"] = "最低參加人數要小於最高參加人數！";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } elseif ($leastAttendeeFee > $maxAttendeeFee) {
        $_SESSION["system_message"] = "最低參加費用要小於最高參加費用！";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } elseif (mysqli_num_rows($result) > 0) {
        $_SESSION["system_message"] = "您已經在該日期間創建過活動！";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } elseif ($duration > 5) {
        $_SESSION["system_message"] = "活動不得超過五天！";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        // 將活動結束日期往前移動三天，設定成報名截止日期
        $activityDeadLineDate = date('Y-m-d', strtotime($activityStartDate . "-3 days"));

        // 獲取當前系統時間
        $currentTime = date('Y-m-d H:i:s');

        // 判斷當前時間是否在活動開始和結束時間之間
        if ($currentTime >= $activityStartDate && $currentTime <= $activityEndDate) {
            $activityIsOpen = 1;
        } else {
            $activityIsOpen = 0;
        }

        $sql_query = "INSERT INTO activities (activityId, campsiteId, accountId, activityTitle, activityDescription, activityStartDate, activityEndDate, activityDeadLineDate, activityIsOpen, minAttendee, maxAttendee, activityAttendence, leastAttendeeFee, maxAttendeeFee)
            VALUES ('$activityId', '$campsiteId', '$accountId', '$activityTitle', '$activityDescription', '$activityStartDate', '$activityEndDate', '$activityDeadLineDate', '$activityIsOpen', $minAttendee, $maxAttendee, 0, $leastAttendeeFee, $maxAttendeeFee)";

        mysqli_query($conn, $sql_query);

        $_SESSION["system_message"] = "活動新增成功！";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}
?>