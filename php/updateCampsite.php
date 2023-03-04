<?php
 include "conn.php";

 $id = $_GET['id'];
 
 //請注意，這邊因為 $userID 本身是 integer，所以可以不用加 ''
 $sql_getDataQuery = "SELECT * FROM campsites WHERE campsiteId = $id";

 $result = mysqli_query($conn, $sql_getDataQuery);

 $row_result = mysqli_fetch_assoc($result);
 $campsiteId = $row_result['campsiteId'];
 $cityId = $row_result['cityId'];
 $campsiteName = $row_result['campsiteName'];
 $campsiteAddress = $row_result['campsiteAddress'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>修改營區資料</title>
</head>
<body>
<form action="" method="post" name="formAdd" id="formAdd">
    請輸入縣市編號：<input type="text" name="cityId" id="cityId" value="<?php echo $cityId ?>"><br/>
    請輸入營區名稱：<input type="text" name="campsiteName" id="campsiteName" value="<?php echo $campsiteName ?>"><br/>
    請輸入營區地址：<input type="text" name="campsiteAddress" id="campsiteAddress" value="<?php echo $campsiteAddress ?>"><br/>
    <input type="hidden" name="action" value="update">
    <input type="submit" name="button" value="修改資料">
</form>
</body>
</html>

<?php
 if (isset($_POST["action"]) && $_POST["action"] == 'update') {

     $newCityId = $_POST['cityId'];
     $newCampsiteName = $_POST['campsiteName'];
     $newCampsiteAddress = $_POST['campsiteAddress'];

     $sql_query = "UPDATE campsites SET cityId = '$newCityId', campsiteName = '$newCampsiteName', campsiteAddress = '$newCampsiteAddress' WHERE campsiteId = $id";

     mysqli_query($conn,$sql_query);

     header('Location: readCampsite.php');
 }
 ?>