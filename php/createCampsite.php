<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>新增營區資料</title>
</head>
<body>
<!--如果要使用上傳檔案的功能，必須要在form加上enctype="multipart/form-data"才能正常上傳檔案-->
<form action="" method="post" name="formAdd" id="formAdd" enctype="multipart/form-data">
請輸入縣市編號：<input type="text" name="cityId" id="cityId"><br/>
請輸入營區名稱：<input type="text" name="campsiteName" id="campsiteName"><br/>
請輸入營區地址：<input type="text" name="campsiteAddress" id="campsiteAddress"><br/>
請上傳營區圖片：<input type="file" name="file" id="file"><br/>
<input type="hidden" name="action" value="insert">
<input type="submit" name="button" value="新增資料">
<input type="reset" name="button2" value="重新填寫">
</form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["action"] === "insert") {

    require_once("conn.php");

    $cityId = $_POST["cityId"];
    $campsiteName = $_POST["campsiteName"];
    $campsiteAddress = $_POST["campsiteAddress"];

    if (isset($_FILES["file"]) && $_FILES["file"]["error"] === UPLOAD_ERR_OK) {
        $allowed_types = [IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF];
        $detected_type = exif_imagetype($_FILES["file"]["tmp_name"]);

        if (in_array($detected_type, $allowed_types)) {
            $upload_dir = "/Applications/XAMPP/xamppfiles/htdocs/upload/";
            $fileName = $_FILES["file"]["name"];
            $filePath = $upload_dir . $fileName;
            $fileExtensionName = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
            $fileSize = round($_FILES["file"]["size"] / 1024, 2); //KB

            move_uploaded_file($_FILES["file"]["tmp_name"], $filePath);

            $sql_query1 = "INSERT INTO campsites (campsiteId, cityId, campsiteName, campsiteAddress) 
                          VALUES (REPLACE(uuid(),'-',''), '$cityId', '$campsiteName', '$campsiteAddress')";

            $sql_query2 = "INSERT INTO files (fileId, fileName, fileExtensionName, filePath, fileSize, fileCreateDate, filePathType) 
            VALUES (REPLACE(uuid(),'-',''), '$fileName', '$fileExtensionName', '$filePath', $fileSize, now(), 'campsite')";

            mysqli_query($conn, $sql_query1);
            mysqli_query($conn, $sql_query2);

            header("Location: readCampsite.php");
            exit();
        } else {
            echo "上傳的檔案必須為圖片格式！";
        }
    } else if (isset($_FILES["file"]) && $_FILES["file"]["error"] !== UPLOAD_ERR_NO_FILE) {
        $error_messages = [
            UPLOAD_ERR_INI_SIZE => "檔案大小超出 php.ini:upload_max_filesize 限制",
            UPLOAD_ERR_FORM_SIZE => "檔案大小超出 MAX_FILE_SIZE 限制",
            UPLOAD_ERR_PARTIAL => "檔案大小僅被部份上傳",
            UPLOAD_ERR_NO_TMP_DIR => "找不到暫存資料夾",
            UPLOAD_ERR_CANT_WRITE => "檔案寫入失敗",
            UPLOAD_ERR_EXTENSION => "上傳檔案被中斷",
        ];
        $error_code = $_FILES["file"]["error"];

        echo $error_messages[$error_code];
    }
}
?>