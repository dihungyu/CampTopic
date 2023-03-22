<?php
include "conn.php";

$id = $_GET['id'];
 
$sql_getDataQuery = "SELECT * FROM campsites WHERE campsiteId = '$id'";

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   
</head>
<body>
<div id="formContainer">
<form action="updateCampsite.php" method="post" enctype="multipart/form-data" name="formAdd" id="formAdd">
    請輸入縣市編號：<input type="text" name="cityId" id="cityId" value="<?php echo $cityId ?>"><br/>
    請輸入營區名稱：<input type="text" name="campsiteName" id="campsiteName" value="<?php echo $campsiteName ?>"><br/>
    請輸入營區地址：<input type="text" name="campsiteAddress" id="campsiteAddress" value="<?php echo $campsiteAddress ?>"><br/>
    <?php
    $sql_query = "SELECT * FROM files WHERE campsiteId = '$id'";
    $result_files = mysqli_query($conn, $sql_query);

    while($row_files = mysqli_fetch_assoc($result_files)) {
        $fileId = $row_files['fileId'];
        $fileName = $row_files['fileName'];
        $isDeleted = $row_files['isDeleted'];
        if ($isDeleted == 0) { // 檢查該圖片是否已標記為已刪除
            echo "<div>
                        <img src='/../upload/$fileName' alt=''>
                        <button type='button' onclick='deleteFile($fileId)'>刪除此圖片</button>
                </div>";
        }
    }
    ?>
    <!-- <div>
        <label for="new_files">新增圖片：</label>
        <input type="file" name="new_files[]" multiple>
    </div> -->
    <input type="hidden" name="action" value="update">
    <input type="submit" name="button" value="修改資料">
</form>
</div>
</body>
</html>

<?php
// 刪除圖片
if (isset($_POST['deleteFileId'])) {
    $deleteFileId = $_POST['deleteFileId'];
    $sql_delete = "UPDATE files SET isDeleted = 1 WHERE fileId = '$deleteFileId'";
    mysqli_query($conn, $sql_delete);
}

if (isset($_POST["action"]) && $_POST["action"] == 'update') {
    

    $newCityId = $_POST['cityId'];
    $newCampsiteName = $_POST['campsiteName'];
    $newCampsiteAddress = $_POST['campsiteAddress'];

    $sql_query1 = "UPDATE campsites SET cityId = '$newCityId', campsiteName = '$newCampsiteName', campsiteAddress = '$newCampsiteAddress' WHERE campsiteId = '$id'";
    mysqli_query($conn,$sql_query1);

    $sql_query2 = "DELETE FROM files WHERE campsiteId = '$id' AND isDeleted = 1";
    mysqli_query($conn, $sql_query2);

    header('Location: readCampsite.php');

    
}
 ?>