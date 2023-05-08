<?php
require_once '../conn.php';
require_once '../uuid_generator.php';

session_start();

if (isset($_POST["action"]) && $_POST["action"] == "update" && isset($_POST['equipmentId']) && isset($_POST['equipmentName']) && isset($_POST['equipmentDescription']) && isset($_POST['equipmentPrice']) && isset($_POST['equipmentLocation']) && isset($_POST['equipmentType'])) {

    $equipmentId = $_POST['equipmentId'];
    $equipmentName = $_POST['equipmentName'];
    $equipmentDescription = $_POST['equipmentDescription'];
    $equipmentPrice = $_POST['equipmentPrice'];
    $equipmentLocation = $_POST['equipmentLocation'];
    $equipmentType = $_POST['equipmentType'];
    $tags = $_POST['tags'];

    // 刪除該設備的現有標籤
    $sql_delete = "DELETE FROM articles_labels WHERE equipmentId = '$equipmentId'";
    mysqli_query($conn, $sql_delete);

    // 插入新的標籤
    foreach ($tags as $tagId) {
        $equipmentLabelId = uuid_generator();
        $sql_insert = "INSERT INTO equipments_labels (equipmentLabelId, equipmentId, labelId) VALUES ('$equipmentLabelId', '$equipmentId', '$tagId')";
        if (!mysqli_query($conn, $sql_insert)) {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // 更新設備
    $sql = "UPDATE equipments SET equipmentName = ?, equipmentDescription = ?, equipmentPrice = ?, equipmentLocation = ?, equipmentType = ? WHERE equipmentId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $equipmentName, $equipmentDescription, $equipmentPrice, $equipmentLocation, $equipmentType, $equipmentId);

    if ($stmt->execute()) {
        // 更新成功，導回設備列表頁面
        $_SESSION["system_message"] = "設備更新成功!";
        header("Location: ../../deluxe-master/equip-single.php?equipmentId=$equipmentId");
        exit();
    } else {
        // 更新失敗，導回原本的編輯頁面，並顯示錯誤訊息
        $_SESSION["system_message"] = $stmt->error;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
} elseif (isset($_POST["action"])) {
    // 更新失敗，導回原本的編輯頁面，並顯示錯誤訊息
    $_SESSION["system_message"] = "所有欄位都不得為空。";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
