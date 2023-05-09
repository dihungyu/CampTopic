<?php
// 開啟錯誤報告
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../conn.php';
require_once '../uuid_generator.php';
require_once '../processFile_equip.php';
require_once '../get_img_src.php';

session_start();

if (isset($_POST["action"]) && $_POST["action"] == "update" && isset($_POST["equipmentType"]) && isset($_POST["equipmentLocation"]) && isset($_POST["equipmentName"]) && isset($_POST["equipmentDescription"]) && isset($_POST["equipmentPrice"])) {

    $equipmentId = $_POST['equipmentId'];
    $equipmentType = $_POST["equipmentType"];
    $equipmentLocation = $_POST["equipmentLocation"];
    $equipmentName = $_POST["equipmentName"];
    $equipmentDescription = $_POST["equipmentDescription"];
    $equipmentPrice = $_POST["equipmentPrice"];
    $tags = $_POST['tags']; // 取得選擇的標籤值，以陣列的形式傳回

    // 刪除該文章的現有標籤
    $sql_delete = "DELETE FROM equipments_labels WHERE equipmentId = '$equipmentId'";
    mysqli_query($conn, $sql_delete);

    // 刪除該文章的現有檔案
    $sql_query = "SELECT fileName, fileId FROM files WHERE equipmentId = '$equipmentId'";
    $result = mysqli_query($conn, $sql_query);
    $files_to_delete = array();
    $file_ids_to_delete = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $files_to_delete[] = $row['fileName'];
        $file_ids_to_delete[] = $row['fileId'];
    }

    // 執行批量刪除操作
    if (isset($file_ids_to_delete)) {

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


    // 新增新的檔案
    $equipmentDescription = process_and_save_images($equipmentDescription, $conn, $equipmentId);

    // Update the article content with the processed content
    $sql_query_update = "UPDATE equipments SET equipmentDescription = '$equipmentDescription' WHERE equipmentId = '$equipmentId'";
    mysqli_query($conn, $sql_query_update);


    // 插入新的標籤
    foreach ($tags as $tagId) {
        $equipmentLabelId = uuid_generator();
        $sql_insert = "INSERT INTO equipments_labels (equipmentLabelId, equipmentId, labelId) VALUES ('$equipmentLabelId', '$equipmentId', '$tagId')";
        if (!mysqli_query($conn, $sql_insert)) {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // 更新文章
    $sql = "UPDATE equipments SET equipmentType = ?, equipmentLocation = ?, equipmentName = ?, equipmentPrice = ? WHERE equipmentId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $equipmentType, $equipmentLocation, $equipmentName, $equipmentPrice, $equipmentId);

    if ($stmt->execute()) {
        // 更新成功，導回文章列表頁面
        $_SESSION["system_message"] = "文章更新成功!";
        header("Location: ../../deluxe-master/equip-single.php?equipmentId=$equipmentId");
        exit();
    } else {
        // 更新失敗，導回原本的編輯頁面，並顯示錯誤訊息
        // $_SESSION["system_message"] = "文章更新失敗!";
        $_SESSION["system_message"] = $stmt->error;
        header("Location: ../../deluxe-master/property-1.0.0/edit-equip.php?equipmentId=$equipmentId");
        exit();
    }
} elseif (isset($_POST["action"])) {
    // 更新失敗，導回原本的編輯頁面，並顯示錯誤訊息
    $_SESSION["system_message"] = "設備內容不能為空。";
    header("Location: ../../deluxe-master/property-1.0.0/edit-equip.php?equipmentId=$equipmentId");
}
?>