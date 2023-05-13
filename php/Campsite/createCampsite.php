<?php
require_once '../conn.php';
require_once '../uuid_generator.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["action"] === "insert") {
    if (!empty($_COOKIE['accountId']) && !empty($_POST["cityId"]) && !empty($_POST["campsiteName"]) && !empty($_POST["campsiteDescription"]) && !empty($_POST["campsiteAddress"]) && !empty($_POST["campsiteAddressLink"]) && !empty($_POST["campsiteVideoLink"]) && !empty($_POST["campsiteLowerLimit"]) && !empty($_POST["campsiteUpperLimit"])) {
        $cityId = $_POST["cityId"];
        $campsiteName = $_POST["campsiteName"];
        $campsiteDescription = $_POST["campsiteDescription"];
        $campsiteAddress = $_POST["campsiteAddress"];
        $campsiteAddressLink = $_POST["campsiteAddressLink"];
        $campsiteVideoLink = $_POST["campsiteVideoLink"];
        $campsiteLowerLimit = $_POST["campsiteLowerLimit"];
        $campsiteUpperLimit = $_POST["campsiteUpperLimit"];
        $tags = $_POST['tags']; // 取得選擇的標籤值，以陣列的形式傳回
        $services = $_POST['services']; // 取得選擇的服務值，以陣列的形式傳回
        $files = $_FILES['cover'];

        $campsiteId = uuid_generator();

        $sql_query1 = "INSERT INTO campsites (campsiteId, cityId, campsiteName, campsiteDescription, campsiteAddress, campsiteAddressLink, campsiteVideoLink, campsiteLowerLimit, campsiteUpperLimit)
                VALUES ('$campsiteId', '$cityId', '$campsiteName', '$campsiteDescription', '$campsiteAddress','$campsiteAddressLink','$campsiteVideoLink','$campsiteLowerLimit','$campsiteUpperLimit')";
        if (!mysqli_query($conn, $sql_query1)) {
            $_SESSION["system_message"] = "營地新增失敗，請再試一次！";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }


        // 將每個標籤值插入到 campsites_labels 資料表中
        foreach ($tags as $tag) {
            $labelId = uuid_generator();
            $insert_label_sql = "INSERT INTO campsites_labels (campsiteLabelId, campsiteId, labelId) VALUES ('$labelId','$campsiteId', '$tag')";
            if (!mysqli_query($conn, $insert_label_sql)) {
                $_SESSION["system_message"] = "標籤新增失敗，請再試一次！";
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            }
        }

        foreach ($services as $service) {
            $serviceId = uuid_generator();
            $insert_service_sql = "INSERT INTO campsites_services (campsiteServiceId, campsiteId, serviceId) VALUES ('$serviceId','$campsiteId', '$service')";
            if (!mysqli_query($conn, $insert_service_sql)) {
                $_SESSION["system_message"] = "服務項目新增失敗，請再試一次！";
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            }
        }

        // 在這裡調用處理封面圖片的函數
        process_and_save_cover_images($conn, $campsiteId);

        // Process images in the article content and adjust the image paths
        $processedCampsiteDescription = process_and_save_images($campsiteDescription, $conn, $campsiteId);

        // Update the article content with the processed content
        $sql_query_update = "UPDATE campsites SET campsiteDescription = '$processedCampsiteDescription' WHERE campsiteId = '$campsiteId'";
        if (!mysqli_query($conn, $sql_query_update)) {
            $_SESSION["system_message"] = "營地詳細內容更新失敗，請再試一次！";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
        $_SESSION["system_message"] = "營地新增成功！";
        header("Location: ../../deluxe-master/property-1.0.0/manage-land.php");
        exit();
    } else {
        $_SESSION["system_message"] = "營地新增失敗，所有欄位不得為空！";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
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
?>