<?php
require_once '../conn.php';
require_once '../uuid_generator.php';

$routeId = $_POST['routeId'];
$locations = $_POST['locations'];
$tripIntroductionTitles = $_POST['tripIntroductionTitle'];
$tripIntroductionContents = $_POST['tripIntroductionContent'];
$files = $_FILES['file'];
$tripIntroductionIds = $_POST['tripIntroductionId'];
$fileIds = $_POST['fileId'];

// 更新routes表
$update_routes_query = "UPDATE routes SET locations = '$locations' WHERE routeId = '$routeId'";
mysqli_query($conn, $update_routes_query);

// 更新tripIntroductions表
for ($i = 0; $i < count($tripIntroductionTitles); $i++) {
    $tripIntroductionId = $tripIntroductionIds[$i];
    $tripIntroductionTitle = $tripIntroductionTitles[$i];
    $tripIntroductionContent = $tripIntroductionContents[$i];

    if (!empty($tripIntroductionId)) {
        if (!empty($tripIntroductionTitle) || !empty($tripIntroductionContent)) {
            // 更新現有的資料
            $update_trip_introductions_query = "UPDATE tripIntroductions SET tripIntroductionTitle = '$tripIntroductionTitle', tripIntroductionContent = '$tripIntroductionContent' WHERE routeId = '$routeId' AND tripIntroductionId = '$tripIntroductionId'";
            mysqli_query($conn, $update_trip_introductions_query);
        } else {
            // 刪除空白的資料
            $delete_trip_introductions_query = "DELETE FROM tripIntroductions WHERE routeId = '$routeId' AND tripIntroductionId = '$tripIntroductionId'";
            mysqli_query($conn, $delete_trip_introductions_query);
        }
    } else {
        if (!empty($tripIntroductionTitle) || !empty($tripIntroductionContent)) {
            $tripIntroductionId = uuid_generator();
            // 插入新的資料
            $insert_trip_introductions_query = "INSERT INTO tripIntroductions (tripIntroductionId, routeId, tripIntroductionTitle, tripIntroductionContent) VALUES ('$tripIntroductionId', '$routeId', '$tripIntroductionTitle', '$tripIntroductionContent')";
            mysqli_query($conn, $insert_trip_introductions_query);
        }
    }
}


$upload_directory = '../../upload/';
for ($i = 0; $i < count($files['name']); $i++) {
    $fileId = $fileIds[$i];
    $isNew = isset($_POST['isNew'][$i]) && $_POST['isNew'][$i] == '1';
    if ($files['error'][$i] === 0) {
        $file_name = uuid_generator() . '.' . pathinfo($files['name'][$i], PATHINFO_EXTENSION);
        $file_tmp_name = $files['tmp_name'][$i];
        $file_destination = $upload_directory . $file_name;

        // 取得副檔名
        $file_extension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);

        // 計算檔案大小（KB）
        $file_size = round($files['size'][$i] / 1024);

        if (move_uploaded_file($file_tmp_name, $file_destination)) {
            if ($isNew) {
                $fileId = uuid_generator();
                // 插入新的圖片資訊到資料庫
                $insert_files_query = "INSERT INTO files (fileId, routeId, fileName, fileExtensionName, filePath, fileSize, fileCreateDate, filePathType) VALUES ('$fileId', '$routeId', '$file_name', '$file_extension', '$file_destination', $file_size, now(), 'route')";
                mysqli_query($conn, $insert_files_query);
            } else {
                // 更新檔案資訊
                $update_files_query = "UPDATE files SET fileName = '$file_name', fileExtensionName = '$file_extension', filePath = '$file_destination', fileSize = $file_size, fileUpdateDate = now() WHERE routeId = '$routeId' AND fileId = '$fileId'";
                mysqli_query($conn, $update_files_query);
            }
        }
    }

    // 檢查是否需要刪除圖片
    if (isset($_POST['delete_image']) && in_array($fileId, $_POST['delete_image'])) {
        // 根據 fileId 從資料庫中獲取文件的路徑
        $get_file_name_query = "SELECT fileName FROM files WHERE routeId = '$routeId' AND fileId = '$fileId'";
        $file_name_result = mysqli_query($conn, $get_file_name_query);
        if ($file_name_result) {
            $file_name_row = mysqli_fetch_assoc($file_name_result);
            $file_path = '../../upload/' . $file_name_row['fileName'];

            // 刪除目標資料夾中的文件
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $delete_files_query = "DELETE FROM files WHERE routeId = '$routeId' AND fileId = '$fileId'";
        mysqli_query($conn, $delete_files_query);
    }
}

// 回到原始頁面
header('Location: ../../deluxe-master/check.php');
?>