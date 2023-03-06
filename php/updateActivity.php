<?php
    include "conn.php";

    $id = $_GET['id'];
    
    $sql_getDataQuery = "SELECT * FROM activities WHERE activityId = '$id'";

    $result = mysqli_query($conn, $sql_getDataQuery);

    $row_result = mysqli_fetch_assoc($result);
    $activityId = $row_result['activityId'];
    $activityTitle = $row_result['activityTitle'];
    $activityDescription = $row_result['activityDescription'];
    $activityStartDate = $row_result['activityStartDate'];
    $activityEndDate = $row_result['activityEndDate'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>新增活動資料</title>
</head>
<body>
<form action="" method="post" name="formAdd" id="formAdd">
請輸入活動名稱：<input type="text" name="activityTitle" id="activityTitle" value=" <?php echo $activityTitle ?>"><br/>
請輸入活動介紹：<input type="text" name="activityDescription" id="activityDescription" value=" <?php echo $activityDescription ?>"><br/>
請輸入活動開始日期：<input type="date" name="activityStartDate" id="activityStartDate" value=" <?php echo $activityStartDate ?>"><br/>
請輸入活動結束日期：<input type="date" name="activityEndDate" id="activityEndDate" value=" <?php echo $activityEndDate ?>"><br/>
<input type="hidden" name="action" value="update">
<input type="submit" name="button" value="修改資料">
</form>
</body>
</html>

<?php
 if (isset($_POST["action"]) && $_POST["action"] == 'update') {

     $newActivityTitle = $_POST['activityTitle'];
     $newActivityDescription = $_POST['activityDescription'];
     $newActivityStartDate = $_POST['activityStartDate'];
     $newActivityEndDate = $_POST['activityEndDate'];

     $newActivityDeadLineDate = date('Y-m-d', strtotime($newActivityStartDate . "-3 days"));

     $sql_query = "UPDATE activities SET activityTitle = '$newActivityTitle', activityDescription = '$newActivityDescription', activityStartDate = '$newActivityStartDate', activityEndDate = '$newActivityEndDate', activityDeadLineDate = '$newActivityDeadLineDate' WHERE activityId = '$id'";

     mysqli_query($conn,$sql_query);

     header('Location: readActivity.php');
 }
 ?>