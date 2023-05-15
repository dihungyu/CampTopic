<?php
require_once '../conn.php';
require_once '../uuid_generator.php';

session_start();

if (isset($_POST["action"]) && $_POST["action"] == "update" && isset($_POST['campsiteId']) && isset($_POST['cityId']) && isset($_POST['campsiteName']) && isset($_POST['campsiteDescription']) && isset($_POST['campsiteAddress']) && isset($_POST['campsiteAddressLink']) && isset($_POST['campsiteVideoLink']) && isset($_POST['campsiteLowerLimit']) && isset($_POST['campsiteUpperLimit'])) {

    $campsiteId = $_POST['campsiteId'];
    $newCityId = $_POST['cityId'];
    $newCampsiteName = $_POST['campsiteName'];
    $newCampsiteDescription = $_POST['campsiteDescription'];
    $newCampsiteAddress = $_POST['campsiteAddress'];
    $newCampsiteAddressLink = $_POST['campsiteAddressLink'];
    $newCampsiteVideoLink = $_POST['campsiteVideoLink'];
    $newCampsiteLowerLimit = $_POST['campsiteLowerLimit'];
    $newCampsiteUpperLimit = $_POST['campsiteUpperLimit'];
    $tags = $_POST['tags'];
    $services = $_POST['services'];

    // 刪除該營地的現有標籤
    $sql_delete = "DELETE FROM campsites_labels WHERE campsiteId = '$campsiteId'";
    mysqli_query($conn, $sql_delete);

    // 刪除該營地的現有服務項目
    $sql_delete = "DELETE FROM campsites_services WHERE campsiteId = '$campsiteId'";
    mysqli_query($conn, $sql_delete);

    // 確認是否上傳新圖片
    // 取得舊營地敘述
    $campsite_old_description = "SELECT campsiteDescription FROM campsites WHERE campsiteId = '$campsiteId'";
    $old_description_result = mysqli_query($conn, $campsite_old_description);
    $old_description = mysqli_fetch_assoc($old_description_result);
    $old_description = $old_description['campsiteDescription'];

    if (has_new_images($old_description, $newCampsiteDescription)) { // 刪除該營地敘述的現有檔案
        $sql_query = "SELECT fileName, fileId FROM files WHERE campsiteId = '$campsiteId' AND filePathType='campsite'";
        $result = mysqli_query($conn, $sql_query);
        $files_to_delete = array();
        $file_ids_to_delete = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $files_to_delete[] = $row['fileName'];
            $file_ids_to_delete[] = $row['fileId'];
        }

        // 執行批量刪除操作
        if (!empty($file_ids_to_delete)) {

            // 刪除 files 表中的資料
            foreach ($file_ids_to_delete as $file_id) {
                $sql_delete = "DELETE FROM files WHERE fileId = '$file_id'";
                mysqli_query($conn, $sql_delete);
            }

            // 刪除 upload 目錄中的文件
            $upload_dir = "../../upload/";
            foreach ($files_to_delete as $file_name) {
                $file_path = $upload_dir . $file_name;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
        }
    }

    // 新增新的標籤
    foreach ($tags as $tagId) {
        $campsiteLabelId = uuid_generator();
        $sql_insert = "INSERT INTO campsites_labels (campsiteLabelId, campsiteId, labelId) VALUES ('$campsiteLabelId', '$campsiteId', '$tagId')";
        if (!mysqli_query($conn, $sql_insert)) {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // 新增新的服務項目
    foreach ($services as $serviceId) {
        $campsiteServiceId = uuid_generator();
        $sql_insert = "INSERT INTO campsites_services (campsiteServiceId, campsiteId, serviceId) VALUES ('$campsiteServiceId', '$campsiteId', '$serviceId')";
        if (!mysqli_query($conn, $sql_insert)) {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // 在這裡調用處理封面圖片的函數
    process_and_save_cover_images($conn, $campsiteId);

    // Process images in the campsite description and adjust the image paths
    $processedCampsiteDescription = process_and_save_images($newCampsiteDescription, $conn, $campsiteId);

    // 更新營地資訊
    $sql = "UPDATE campsites SET cityId = ?, campsiteName = ?, campsiteDescription = ?, campsiteAddress = ?, campsiteAddressLink = ?, campsiteVideoLink = ?, campsiteLowerLimit = ?, campsiteUpperLimit = ? WHERE campsiteId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssss",
        $newCityId,
        $newCampsiteName,
        $processedCampsiteDescription,
        $newCampsiteAddress,
        $newCampsiteAddressLink,
        $newCampsiteVideoLink,
        $newCampsiteLowerLimit,
        $newCampsiteUpperLimit,
        $campsiteId
    );
    if ($stmt->execute()) {
        // 更新成功，導回營地列表頁面
        $_SESSION["system_message"] = "營地更新成功!";
        header("Location: /CampTopic/deluxe-master/myCampsiteDetail.php?campsiteId=$campsiteId");
        exit();
    } else {
        // 更新失敗，導回原本的編輯頁面，並顯示錯誤訊息
        // $_SESSION["system_message"] = "營地更新失敗!";
        $_SESSION["system_message"] = $stmt->error;
        header("Location: /CampTopic/deluxe-master/property-1.0.0/myCampsiteUpdate.php?campsiteId=$campsiteId");
        exit();
    }
} elseif (isset($_POST["action"])) {
    // 更新失敗，導回原本的編輯頁面，並顯示錯誤訊息
    $_SESSION["system_message"] = "營地名稱、描述、地址等資料不能為空。";
    header("Location: /CampTopic/deluxe-master/property-1.0.0/myCampsiteUpdate.php?campsiteId=$campsiteId");
}



function process_and_save_images($content, $conn, $campsiteId)
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

            $sql_query3 = "INSERT INTO files (fileId, campsiteId, fileName, fileExtensionName, filePath, fileSize, fileCreateDate, filePathType)
            VALUES ('$fileId', '$campsiteId', '$fileName', '$image_type', '$file_path', $fileSize, now(), 'campsite')";

            if (!mysqli_query($conn, $sql_query3)) {
                echo "Error: " . mysqli_error($conn);
            }
            // Replace the image src attribute with the fileId
            $content = str_replace($image, '../upload/' . $fileName, $content);
        } elseif (substr($image, 0, 10) !== '../upload/') {
            // 如果圖片URL不是以'../upload/'開頭，則將圖片路徑更改為'../upload/檔名'
            $fileName = basename($image);
            $content = str_replace($image, '../upload/' . $fileName, $content);
        }
    }

    return $content;
}

function process_and_save_cover_images($conn, $campsiteId)
{
    // loop through all uploaded files
    foreach ($_FILES["cover"]["name"] as $key => $name) {
        // check if file was uploaded successfully
        if ($_FILES["cover"]["error"][$key] === UPLOAD_ERR_OK) {
            // check if file is an image
            $allowed_types = [IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF];
            $detected_type = exif_imagetype($_FILES["cover"]["tmp_name"][$key]);
            if (in_array($detected_type, $allowed_types)) {
                $coverId = uuid_generator();
                $uploadDir = "../../upload/";
                $coverExtensionName = pathinfo($_FILES["cover"]["name"][$key], PATHINFO_EXTENSION);
                $coverName = $coverId . '.' . $coverExtensionName;
                $coverPath = $uploadDir . $coverName;
                $coverSize = round($_FILES["cover"]["size"][$key] / 1024, 2); //KB
                move_uploaded_file($_FILES["cover"]["tmp_name"][$key], $coverPath);
                $sql_query2 = "INSERT INTO files (fileId, campsiteId, fileName, fileExtensionName, filePath, fileSize, fileCreateDate, filePathType)
    VALUES ('$coverId', '$campsiteId', '$coverName', '$coverExtensionName', '$coverPath', $coverSize, now(), 'campsiteCover')";
                if (!mysqli_query($conn, $sql_query2)) {
                    $_SESSION["system_message"] = "營地封面新增失敗，請再試一次！";
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    exit();
                }
            } else {
                echo "檔案 $name 必須為圖片格式！<br>";
            }
        } else if ($_FILES["cover"]["error"][$key] !== UPLOAD_ERR_NO_FILE) {
            $error_messages = [
                UPLOAD_ERR_INI_SIZE => "檔案大小超出 php.ini:upload_max_filesize 限制",
                UPLOAD_ERR_FORM_SIZE => "檔案大小超出 MAX_FILE_SIZE 限制",
                UPLOAD_ERR_PARTIAL => "檔案大小僅被部份上傳",
                UPLOAD_ERR_NO_TMP_DIR => "找不到暫存資料夾",
                UPLOAD_ERR_CANT_WRITE => "檔案寫入失敗",
                UPLOAD_ERR_EXTENSION => "上傳檔案被中斷",
            ];
            $error_code = $_FILES["cover"]["error"][$key];
            echo "檔案 $name 上傳失敗：" . $error_messages[$error_code] . "<br>";
        }
    }
}

function has_new_images($old_content, $new_content)
{
    // 將圖片路徑統一為相對於資料庫裡的路徑
    $old_content = str_replace('../upload/', '../upload/', $old_content);
    $new_content = str_replace('../../upload/', '../upload/', $new_content);

    preg_match_all('/src="([^"]+)"/i', $old_content, $old_matches);
    preg_match_all('/src="([^"]+)"/i', $new_content, $new_matches);

    $old_images = array_map('trim', $old_matches[1]);
    $new_images = array_map('trim', $new_matches[1]);

    // 將圖片網址轉換為小寫，以忽略大小寫差異
    $old_images_lower = array_map('strtolower', $old_images);
    $new_images_lower = array_map('strtolower', $new_images);

    $added_images = array_diff($new_images_lower, $old_images_lower);
    $removed_images = array_diff($old_images_lower, $new_images_lower);

    return !empty($added_images) || !empty($removed_images);
}
