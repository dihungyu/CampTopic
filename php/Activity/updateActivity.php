<?php
include "conn.php";

$activityId = $_GET['activityId'];

$sql_getDataQuery = "SELECT * FROM activities WHERE activityId = '$activityId'";

$result = mysqli_query($conn, $sql_getDataQuery);

$row_result = mysqli_fetch_assoc($result);
$activityId = $row_result['activityId'];
$activityTitle = $row_result['activityTitle'];
$activityDescription = $row_result['activityDescription'];
$activityStartDate = $row_result['activityStartDate'];
$activityEndDate = $row_result['activityEndDate'];
$minAttendee = $row_result['minAttendee'];
$maxAttendee = $row_result['maxAttendee'];
$leastAttendeeFee = $row_result['leastAttendeeFee'];
$maxAttendeeFee = $row_result['maxAttendeeFee'];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>更新活動資料</title>
</head>

<body>
    <form action="updateActivity.php?activityId=<? echo $activityId ?>" method="post" name="formAdd" id="formAdd">
        請輸入活動名稱：<input type="text" name="activityTitle" id="activityTitle" value="<?php echo $activityTitle ?>"><br />
        請輸入活動介紹：<input type="text" name="activityDescription" id="activityDescription"
            value="<?php echo $activityDescription ?>"><br />
        請輸入活動開始日期：<input type="date" name="activityStartDate" id="activityStartDate"
            value="<?php echo $activityStartDate ?>"><br />
        請輸入活動結束日期：<input type="date" name="activityEndDate" id="activityEndDate"
            value="<?php echo $activityEndDate ?>"><br />
        請輸入最低參加人數：<input type="text" name="minAttendee" id="minAttendee" value="<?php echo $minAttendee ?>"><br />
        請輸入最高參加人數：<input type="text" name="maxAttendee" id="maxAttendee" value="<?php echo $maxAttendee ?>"><br />
        請輸入預估參加費用：<input type="text" name="leastAttendeeFee" id="leastAttendeeFee"
            value="<?php echo $leastAttendeeFee ?>"><br />
        請輸入最高預估參加費用：<input type="text" name="maxAttendeeFee" id="maxAttendeeFee"
            value="<?php echo $maxAttendeeFee ?>"><br />
        <input type="hidden" name="action" value="update">
        <input type="submit" name="button" value="修改資料">
    </form>
</body>

</html>

<?php
if (isset($_POST["action"]) && $_POST["action"] == 'update') {

    if (empty($_POST['activityTitle']) || empty($_POST['activityDescription']) || empty($_POST['activityStartDate']) || empty($_POST['activityEndDate']) || empty($_POST['minAttendee']) || empty($_POST['maxAttendee']) || empty($_POST['leastAttendeeFee']) || empty($_POST['maxAttendeeFee'])) {
        echo "<script>alert('欄位不得為空值！')</script>";
    } else {

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

            $sql_query = "UPDATE activities SET activityTitle = '$newActivityTitle', activityDescription = '$newActivityDescription',
        activityStartDate = '$newActivityStartDate', activityEndDate = '$newActivityEndDate', activityDeadLineDate = '$newActivityDeadLineDate',
        minAttendee = $newMinAttendee, maxAttendee = $newMaxAttendee, leastAttendeeFee = $newLeastAttendeeFee, maxAttendeeFee = $newMaxAttendeeFee WHERE activityId = '$id'";

            mysqli_query($conn, $sql_query);

            header('Location: readActivity.php');
        }
    }
}
?>