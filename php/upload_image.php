<?php
require_once '../../php/conn.php';
require_once '../../php/uuid_generator.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_FILES["file"]["error"] === UPLOAD_ERR_OK) {
        $allowed_types = [IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF];
        $detected_type = exif_imagetype($_FILES["file"]["tmp_name"]);

        if (in_array($detected_type, $allowed_types)) {
            $fileId = uuid_generator();
            $upload_dir = "../upload/";
            $fileName = $_FILES["file"]["name"];
            $filePath = $upload_dir . $fileName;
            $fileExtensionName = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
            $fileSize = round($_FILES["file"]["size"] / 1024, 2); //KB

            move_uploaded_file($_FILES["file"]["tmp_name"], $filePath);

            // You can save the file information to the database if you want
            // $sql_query = "INSERT INTO files (fileId, fileName, fileExtensionName, filePath, fileSize, fileCreateDate)
            // VALUES ('$fileId', '$fileName', '$fileExtensionName', '$filePath', $fileSize, now())";
            // mysqli_query($conn, $sql_query);

            echo json_encode(array("url" => $filePath));
        } else {
            echo "檔案必須為圖片格式！";
        }
    } else {
        echo "檔案上傳失敗！";
    }
}
