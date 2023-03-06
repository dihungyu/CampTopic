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
    $activityStartDate = $_POST['activityStartDate'];
    $activityEndDate = $_POST['activityEndDate'];

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

    $sql_query = "INSERT INTO activities (activityId, activityTitle, activityDescription, activityStartDate, activityEndDate, activityDeadLineDate, activityIsOpen, activityAttendence) 
    VALUES (REPLACE(uuid(),'-',''), '$activityTitle', '$activityDescription', '$activityStartDate', '$activityEndDate', '$activityDeadLineDate', '$activityIsOpen', 0)";

    mysqli_query($conn, $sql_query);

    header("Location: readActivity.php");
}
?>