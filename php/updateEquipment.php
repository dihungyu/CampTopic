<?php
include "conn.php";

$equipmentId = $_GET['equipmentId'];

$sql_getDataQuery = "SELECT * FROM equipments WHERE equipmentId = '$equipmentId'";

$result = mysqli_query($conn, $sql_getDataQuery);

$row_result = mysqli_fetch_assoc($result);

$equipmentType = $row_result['equipmentType'];
$equipmentLocation = $row_result['equipmentLocation'];
$equipmentName = $row_result['equipmentName'];
$equipmentDescription = $row_result['equipmentDescription'];

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>修改營區資料</title>
</head>

<body>
    <form action="updateEquipment.php" method="post" name="formAdd" id="formAdd">
        設備分類：<select name="equipmentType" id="equipmentType">
            <option value="地墊" <?php if ($equipmentType == "地墊") {
                                    echo "selected";
                                } ?>> 地墊 </option>
            <option value="帳篷" <?php if ($equipmentType == "帳篷") {
                                    echo "selected";
                                } ?>> 帳篷 </option>
        </select><br />
        請選擇設備地址：<input type="text" name="equipmentLocation" id="equipmentLocation" value="<?php echo $equipmentLocation ?>"><br />
        請輸入設備名稱：<input type="text" name="equipmentName" id="equipmentName" value="<?php echo $equipmentName ?>"><br />
        請輸入設備敘述：<input type="text" name="equipmentDescription" id="equipmentDescription" value="<?php echo $equipmentDescription ?>"><br />
        <?php
        $sql_query = "SELECT * FROM files WHERE equipmentId = '$equipmentId'";
        $result_files = mysqli_query($conn, $sql_query);

        while ($row_files = mysqli_fetch_assoc($result_files)) {
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

                    $sql_query2 = "INSERT INTO files (fileId, equipmentId, fileName, fileExtensionName, filePath, fileSize, fileCreateDate, filePathType) 
                    VALUES ('$fileId', '$equipmentId', '$fileName', '$fileExtensionName', '$filePath', $fileSize, now(), 'equipment')";

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

    $newEquipmentType = $_POST["equipmentType"];
    $newEquipmentLocation = $_POST["equipmentLocation"];
    $newEquipmentName = $_POST["equipmentName"];
    $newEquipmentDescription = $_POST["equipmentDescription"];

    $sql_query = "UPDATE equipments SET equipmentType = '$newEquipmentType', equipmentLocation = '$newEquipmentLocation', equipmentName = '$newEquipmentName', equipmentDescription = '$newEquipmentDescription' WHERE equipmentId = '$equipmentId'";

    mysqli_query($conn, $sql_query);
    if (mysqli_affected_rows($conn) > 0) {
        // 成功修改資料，重新導向到 readEquipment.php 頁面
        header('Location: readEquipment.php');
    } else {
        // 修改資料失敗，顯示錯誤訊息給使用者
        echo "修改資料失敗";
    }
}
?>