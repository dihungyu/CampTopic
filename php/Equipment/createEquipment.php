<?php
session_start();
require_once '../conn.php';
require_once '../uuid_generator.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_COOKIE['accountId']) && !empty($_POST["equipmentType"]) && !empty($_POST["equipmentLocation"]) && !empty($_POST["equipmentName"]) && !empty($_POST["equipmentDescription"]) && !empty($_POST["equipmentPrice"])) {


        $accountId = $_COOKIE['accountId'];
        $equipmentType = $_POST["equipmentType"];
        $equipmentLocation = $_POST["equipmentLocation"];
        $equipmentName = $_POST["equipmentName"];
        $equipmentDescription = $_POST["equipmentDescription"];
        $equipmentPrice = $_POST["equipmentPrice"];
        // $tags = $_POST['tags']; // 取得選擇的標籤值，以陣列的形式傳回

        $equipmentId = uuid_generator();
        $sql_query1 = "INSERT INTO equipments (equipmentId, accountId, equipmentType, equipmentLocation, equipmentName, equipmentDescription, equipmentCreateDate, equipmentUpdateDate, equipmentPrice)
                VALUES ('$equipmentId', '$accountId', '$equipmentType', '$equipmentLocation', '$equipmentName', '$equipmentDescription', now(), now(), '$equipmentPrice')";

        mysqli_query($conn, $sql_query1);

        // 將每個標籤值插入到 equipments_labels 資料表中
        // foreach ($tags as $tag) {
        //     $labelId = uuid_generator();
        //     $insert_label_sql = "INSERT INTO equipments_labels (equipmentLabelId, equipmentId, labelId) VALUES ('$labelId','$equipmentId', '$tag')";

        //     if (!mysqli_query($conn, $insert_label_sql)) {
        //         echo "Error: " . mysqli_error($conn);
        //     }
        // }


        // loop through all uploaded files
        foreach ($_FILES["files"]["name"] as $key => $name) {

            // check if file was uploaded successfully
            if ($_FILES["files"]["error"][$key] === UPLOAD_ERR_OK) {

                // check if file is an image
                $allowed_types = [IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF];
                $detected_type = exif_imagetype($_FILES["files"]["tmp_name"][$key]);

                if (in_array($detected_type, $allowed_types)) {
                    $fileId = uuid_generator();
                    $upload_dir = "../../upload/";
                    $fileName = $_FILES["files"]["name"][$key];
                    $filePath = $upload_dir . $fileName;
                    $fileExtensionName = pathinfo($_FILES["files"]["name"][$key], PATHINFO_EXTENSION);
                    $fileSize = round($_FILES["files"]["size"][$key] / 1024, 2); //KB

                    move_uploaded_file($_FILES["files"]["tmp_name"][$key], $filePath);

                    $sql_query2 = "INSERT INTO files (fileId, equipmentId, fileName, fileExtensionName, filePath, fileSize, fileCreateDate, filePathType)
                VALUES ('$fileId', '$equipmentId', '$fileName', '$fileExtensionName', '$filePath', $fileSize, now(), 'equipment')";

                    mysqli_query($conn, $sql_query2);
                } else {
                    echo "檔案 $name 必須為圖片格式！<br>";
                }
            } else if ($_FILES["files"]["error"][$key] !== UPLOAD_ERR_NO_FILE) {
                $error_messages = [
                    UPLOAD_ERR_INI_SIZE => "檔案大小超出 php.ini:upload_max_filesize 限制",
                    UPLOAD_ERR_FORM_SIZE => "檔案大小超出 MAX_FILE_SIZE 限制",
                    UPLOAD_ERR_PARTIAL => "檔案大小僅被部份上傳",
                    UPLOAD_ERR_NO_TMP_DIR => "找不到暫存資料夾",
                    UPLOAD_ERR_CANT_WRITE => "檔案寫入失敗",
                    UPLOAD_ERR_EXTENSION => "上傳檔案被中斷",
                ];
                $error_code = $_FILES["files"]["error"][$key];

                echo "檔案 $name 上傳失敗：" . $error_messages[$error_code] . "<br>";
            }
        }

        $_SESSION['system_message'] = '新增設備成功！';
        header('Location: ../../deluxe-master/equip-single.php?equipmentId=' . $equipmentId . '');
        exit();
    } else {
        $_SESSION['system_message'] = '新增設備失敗，注意所有欄位都不得為空！';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>