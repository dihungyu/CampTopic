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
</head>
<body>
<form action="" method="post" name="formAdd" id="formAdd">
    請輸入縣市編號：<input type="text" name="cityId" id="cityId" value="<?php echo $cityId ?>"><br/>
    請輸入營區名稱：<input type="text" name="campsiteName" id="campsiteName" value="<?php echo $campsiteName ?>"><br/>
    請輸入營區地址：<input type="text" name="campsiteAddress" id="campsiteAddress" value="<?php echo $campsiteAddress ?>"><br/>
    <?php
    $sql_query = "SELECT * FROM files WHERE campsiteId = '$id'";
    $result_files = mysqli_query($conn, $sql_query);

    while($row_files = mysqli_fetch_assoc($result_files)) {
        $fileId = $row_files['fileId'];
        $fileName = $row_files['fileName'];
        $isDeleted == 0;
        if ($isDeleted == 0) { // 檢查該圖片是否已標記為已刪除
            echo "<div>
                <img src='/../upload/$fileName' alt=''>
                <form method='post'>
                    <input type='hidden' name='delete_file' value='$fileId'>
                    <input type='submit' name='delete' value='刪除此圖片'>
                </form>
            </div>";
        }
    }
?>
    <div>
        <label for="new_files">新增圖片：</label>
        <input type="file" name="new_files[]" multiple>
    </div>
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

    $sql_query = "UPDATE campsites SET cityId = '$newCityId', campsiteName = '$newCampsiteName', campsiteAddress = '$newCampsiteAddress' WHERE campsiteId = '$id'";

    mysqli_query($conn,$sql_query);
    header('Location: readCampsite.php');

    // 刪除圖片
    if (isset($_POST['delete_file'])) {
        $isDeleted = 1;
        $delete_file = $_POST['delete_file'];
        
        $sql_delete = "DELETE FROM files WHERE fileId = '$delete_file'";
        mysqli_query($conn, $sql_delete);
    }

    // 上傳新的圖片
    if (isset($_FILES['new_files'])) {
        foreach ($_FILES["new_files"]["name"] as $key => $name) {

            // check if file was uploaded successfully
            if ($_FILES["new_files"]["error"][$key] === UPLOAD_ERR_OK) {
        
                // check if file is an image
                $allowed_types = [IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF];
                $detected_type = exif_imagetype($_FILES["new_files"]["tmp_name"][$key]);
        
                if (in_array($detected_type, $allowed_types)) {
                    $fileId = uuid_generator();
                    $upload_dir = "/Applications/XAMPP/xamppfiles/htdocs/upload/";
                    $fileName = $_FILES["new_files"]["name"][$key];
                    $filePath = $upload_dir . $fileName;
                    $fileExtensionName = pathinfo($_FILES["new_files"]["name"][$key], PATHINFO_EXTENSION);
                    $fileSize = round($_FILES["new_files"]["size"][$key] / 1024, 2); //KB
        
                    move_uploaded_file($_FILES["new_files"]["tmp_name"][$key], $filePath);
        
                    $sql_query2 = "INSERT INTO files (fileId, campsiteId, fileName, fileExtensionName, filePath, fileSize, fileCreateDate, filePathType) 
                    VALUES ('$fileId', '$id', '$fileName', '$fileExtensionName', '$filePath', $fileSize, now(), 'campsite')";
        
                    mysqli_query($conn, $sql_query2);
        
                } else {
                    echo "檔案 $name 必須為圖片格式！<br>";
                }
            } else if ($_FILES["new_files"]["error"][$key] !== UPLOAD_ERR_NO_FILE) {
                $error_messages = [
                    UPLOAD_ERR_INI_SIZE => "檔案大小超出 php.ini:upload_max_filesize 限制",
                    UPLOAD_ERR_FORM_SIZE => "檔案大小超出 MAX_FILE_SIZE 限制",
                    UPLOAD_ERR_PARTIAL => "檔案大小僅被部份上傳",
                    UPLOAD_ERR_NO_TMP_DIR => "找不到暫存資料夾",
                    UPLOAD_ERR_CANT_WRITE => "檔案寫入失敗",
                    UPLOAD_ERR_EXTENSION => "上傳檔案被中斷",
                ];
                $error_code = $_FILES["new_files"]["error"][$key];
        
                echo "檔案 $name 上傳失敗：" . $error_messages[$error_code] . "<br>";
            }
    }
}
}
 ?>