<?php
require_once '../conn.php';

session_start();

if (isset($_POST["equipmentId"])) {
    $equipmentId = $_POST["equipmentId"];

    $all_successful = true;

    $sql = "UPDATE equipments SET isReviewed = 1 WHERE equipmentId = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $equipmentId);
    if (!mysqli_stmt_execute($stmt)) {
        $all_successful = false;
    }

    $sql_delete_report = "DELETE FROM reports WHERE equipmentId = ?";
    $stmt_delete_report = mysqli_prepare($conn, $sql_delete_report);
    mysqli_stmt_bind_param($stmt_delete_report, "s", $equipmentId);
    if (!mysqli_stmt_execute($stmt_delete_report)) {
        $all_successful = false;
    }

    if ($all_successful) {
        $_SESSION["system_message"] = "已駁回該設備的檢舉！";
        header('Location: ../../deluxe-master/property-1.0.0/manage-equip.php');
    } else {
        $_SESSION["system_message"] = "更新失敗，請重試！";
        header('Location: ' . $_SERVER['HTTP_REFERER']);

    }

} else {
    $_SESSION["system_message"] = "更新失敗，請重試！";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>