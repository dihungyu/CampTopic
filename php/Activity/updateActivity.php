<?php
require_once '../conn.php';

if (isset($_POST["action"]) && $_POST["action"] == 'update') {

    if (empty($_POST['campsiteId']) || empty($_POST['activityTitle']) || empty($_POST['activityDescription']) || empty($_POST['activityStartDate']) || empty($_POST['activityEndDate']) || empty($_POST['minAttendee']) || empty($_POST['maxAttendee']) || empty($_POST['leastAttendeeFee']) || empty($_POST['maxAttendeeFee'])) {
        echo "<script>
                alert('欄位不得為空值！');
                window.location.href = '../../deluxe-master/check.php';
              </script>";
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

        if ($newActivityStartDate > $newActivityEndDate) {
            echo "<script>alert('活動開始日期要在結束日期之前！')</script>";
        } elseif ($newMinAttendee > $newMaxAttendee) {
            echo "<script>alert('最低參加人數要小於最高參加人數！')</script>";
        } elseif ($newLeastAttendeeFee > $newMaxAttendeeFee) {
            echo "<script>alert('最低預估費用要小於最高預估費用！')</script>";
        } else {

            $newActivityDeadLineDate = date('Y-m-d', strtotime($newActivityStartDate . "-3 days"));

            $sql_query = "UPDATE activities SET campsiteId = '$newCampsiteId', activityTitle = '$newActivityTitle', activityDescription = '$newActivityDescription',
        activityStartDate = '$newActivityStartDate', activityEndDate = '$newActivityEndDate', activityDeadLineDate = '$newActivityDeadLineDate',
        minAttendee = $newMinAttendee, maxAttendee = $newMaxAttendee, leastAttendeeFee = $newLeastAttendeeFee, maxAttendeeFee = $newMaxAttendeeFee WHERE activityId = '$activityId'";

            mysqli_query($conn, $sql_query);

            header('Location: ../../deluxe-master/check.php');
        }
    }
}
?>