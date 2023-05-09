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
        $tags = $_POST['tags']; // 取得選擇的標籤值，以陣列的形式傳回

        $equipmentId = uuid_generator();
        $sql_query1 = "INSERT INTO equipments (equipmentId, accountId, equipmentType, equipmentLocation, equipmentName, equipmentDescription, equipmentCreateDate, equipmentUpdateDate, equipmentPrice)
                VALUES ('$equipmentId', '$accountId', '$equipmentType', '$equipmentLocation', '$equipmentName', '$equipmentDescription', now(), now(), '$equipmentPrice')";

        mysqli_query($conn, $sql_query1);

        // 將每個標籤值插入到 equipments_labels 資料表中
        foreach ($tags as $tag) {
            $labelId = uuid_generator();
            $insert_label_sql = "INSERT INTO equipments_labels (equipmentLabelId, equipmentId, labelId) VALUES ('$labelId','$equipmentId', '$tag')";

            if (!mysqli_query($conn, $insert_label_sql)) {
                $_SESSION['system_message'] = '新增標籤失敗，請再試一次！';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }

        // Process images in the article content and adjust the image paths
        $processedEquipmentDescription = process_and_save_images($equipmentDescription, $conn, $equipmentId);

        // Update the article content with the processed content
        $sql_query_update = "UPDATE equipments SET equipmentDescription = '$processedEquipmentDescription' WHERE equipmentId = '$equipmentId'";

        if (!mysqli_query($conn, $sql_query_update)) {
            $_SESSION["system_message"] = "設備新增失敗，請再試一次！";
            header("Location: ../all-article.php");
            exit();
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

function process_and_save_images($content, $conn, $equipmentId)
{
    // 匹配文章內容中的圖片URL
    preg_match_all('/src="([^"]+)"/i', $content, $matches);

    $images = $matches[1];

    foreach ($images as $image) {
        if (substr($image, 0, 5) === 'data:') {
            // Process data URLs
            $fileId = uuid_generator();
            $upload_dir = "../../upload/";
            $image_parts = explode(";base64,", $image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            // Save the decoded image to the uploads directory
            $fileName = $fileId . '.' . $image_type;
            $file_path = $upload_dir . $fileName;
            file_put_contents($file_path, $image_base64);

            $fileSize = round(filesize($file_path) / 1024, 2); //KB

            $sql_query2 = "INSERT INTO files (fileId, equipmentId, fileName, fileExtensionName, filePath, fileSize, fileCreateDate, filePathType)
            VALUES ('$fileId', '$equipmentId', '$fileName', '$image_type', '$file_path', $fileSize, now(), 'eqiupment')";

            if (!mysqli_query($conn, $sql_query2)) {
                echo "Error: " . mysqli_error($conn);
            }
            // Replace the image src attribute with the fileId
            $content = str_replace($image, '../upload/' . $fileName, $content);
        }
    }

    return $content;
}