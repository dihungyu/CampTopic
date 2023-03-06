<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>新增活動資料</title>
</head>
<body>
<form action="" method="post" name="formAdd" id="formAdd">
請輸入活動名稱：<input type="text" name="activityTitle" id="activityTitle"><br/>
請輸入活動介紹：<input type="text" name="activityDescription" id="activityDescription"><br/>
請輸入活動開始日期：<input type="date" name="activityStartDate" id="activityStartDate"><br/>
請輸入活動結束日期：<input type="date" name="activityEndDate" id="activityEndDate"><br/>
<input type="hidden" name="action" value="insert">
<input type="submit" name="button" value="新增資料">
<input type="reset" name="button2" value="重新填寫">
</form>
</body>
</html>

<?php
if (isset($_POST["action"]) && ($_POST["action"] == "insert")) {

    include("conn.php");

    $activityTitle = $_POST["activityTitle"];
    $activityDescription = $_POST['activityDescription'];

    // 取得使用者輸入的開始日期
    $activityStartDate = new DateTime($_POST['activityStartDate']);
    // 往前移動三天
    $activityDeadLineDate = $activityStartDate->sub(new DateInterval('P3D'))->format('Y-m-d');

    // 取得使用者輸入的結束日期
    $activityEndDate = new DateTime($_POST['activityEndDate']);

    $sql_query = "INSERT INTO activities (activityId, activityTitle, activityDescription, activityStartDate, activityEndDate, activityDeadLineDate, activityIsOpen, activityAttendence) 
    VALUES (UUID(), '$activityTitle', '$activityDescription','$activityStartDate->format(\'Y-m-d\')','$activityEndDate->format(\'Y-m-d\')','$activityDeadLineDate', 1, 0)";

    mysqli_query($conn, $sql_query);

    header("Location: readActivity.php");
}
?>