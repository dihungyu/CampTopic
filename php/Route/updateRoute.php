<?php

require_once '../conn.php';
require_once '../uuid_generator.php';

session_start();

$activityId = $_POST['activityId'];
$routeId = $_POST['routeId'];
$locations = $_POST['locations'];
$tripIntroductionTitles = $_POST['tripIntroductionTitle'];
$tripIntroductionContents = $_POST['tripIntroductionContent'];
$files = $_FILES['file'];
$tripIntroductionIds = $_POST['tripIntroductionId'];
$fileIds = $_POST['fileId'];
$dayNumber = $_POST['dayNumber'];

$error_occurred = false;

// 檢查routeId是否存在於routes表
$check_route_query = "SELECT * FROM routes WHERE routeId = '$routeId'";
$result = mysqli_query($conn, $check_route_query);
if (mysqli_num_rows($result) == 0) {
    // 如果routeId不存在，插入一條新記錄
    $insert_route_query = "INSERT INTO routes (routeId, activityId, dayNumber, locations) VALUES ('$routeId', '$activityId', $dayNumber, '$locations')";
    $insert_route_result = mysqli_query($conn, $insert_route_query);
    if (!$insert_route_result) {
        $error_occurred = true;
    }
} else {
    // 更新routes表
    $update_routes_query = "UPDATE routes SET locations = '$locations' WHERE routeId = '$routeId'";
    $update_routes_result = mysqli_query($conn, $update_routes_query);
    if (!$update_routes_result) {
        $error_occurred = true;
    }
}

// 更新tripIntroductions表
for ($i = 0; $i < count($tripIntroductionTitles); $i++) {
    $tripIntroductionId = $tripIntroductionIds[$i];
    $tripIntroductionTitle = $tripIntroductionTitles[$i];
    $tripIntroductionContent = $tripIntroductionContents[$i];

    if (!empty($tripIntroductionId)) {
        if (!empty($tripIntroductionTitle) || !empty($tripIntroductionContent)) {
            // 更新現有的資料
            $update_trip_introductions_query = "UPDATE tripIntroductions SET tripIntroductionTitle = '$tripIntroductionTitle', tripIntroductionContent = '$tripIntroductionContent' WHERE routeId = '$routeId' AND tripIntroductionId = '$tripIntroductionId'";
            $update_trip_introductions_result = mysqli_query($conn, $update_trip_introductions_query);
            if (!$update_trip_introductions_result) {
                $error_occurred = true;
            }
        } else {
            // 刪除空白的資料
            $delete_trip_introductions_query = "DELETE FROM tripIntroductions WHERE routeId = '$routeId' AND tripIntroductionId = '$tripIntroductionId'";
            $delete_trip_introductions_result = mysqli_query($conn, $delete_trip_introductions_query);
            if (!$delete_trip_introductions_result) {
                $error_occurred = true;
            }
        }
    } else {
        if (!empty($tripIntroductionTitle) || !empty($tripIntroductionContent)) {
            $tripIntroductionId = uuid_generator();
            // 插入新的資料
            $insert_trip_introductions_query = "INSERT INTO tripIntroductions (tripIntroductionId, routeId, tripIntroductionTitle, tripIntroductionContent) VALUES ('$tripIntroductionId', '$routeId', '$tripIntroductionTitle', '$tripIntroductionContent')";
            $insert_trip_introductions_result = mysqli_query($conn, $insert_trip_introductions_query);
            if (!$insert_trip_introductions_result) {
                $error_occurred = true;
            }
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
                $insert_files_result = mysqli_query($conn, $insert_files_query);
                if (!$insert_files_result) {
                    $error_occurred = true;
                }
            } else {
                // 更新檔案資訊
                $update_files_query = "UPDATE files SET fileName = '$file_name', fileExtensionName = '$file_extension', filePath = '$file_destination', fileSize = $file_size, fileUpdateDate = now() WHERE routeId = '$routeId' AND fileId = '$fileId'";
                $update_files_result = mysqli_query($conn, $update_files_query);
                if (!$update_files_result) {
                    $error_occurred = true;
                }
            }
        } else {
            $error_occurred = true;
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
        $delete_files_result = mysqli_query($conn, $delete_files_query);
        if (!$delete_files_result) {
            $error_occurred = true;
        }
    }
}

// 回到原始頁面
if ($error_occurred) {
    $_SESSION['system_message'] = '行程更新失敗，請再試一次！';
} else {
    $_SESSION['system_message'] = '行程更新成功！';
}
header('Location: ../../deluxe-master/check.php?activityId=' . $activityId . '');
?>