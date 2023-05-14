<?php
session_start();

// 連接資料庫
require_once '../conn.php';

if (isset($_POST["equipmentId"])) {
    $equipmentId = $_POST["equipmentId"];

    // Start transaction
    mysqli_begin_transaction($conn);

    $all_successful = true;

    // Get the file names for the current routeId
    $sql_query7 = "SELECT fileName FROM files WHERE equipmentId = ?";
    $stmt7 = mysqli_prepare($conn, $sql_query7);
    mysqli_stmt_bind_param($stmt7, "s", $equipmentId);
    mysqli_stmt_execute($stmt7);
    $result7 = mysqli_stmt_get_result($stmt7);
    $files = [];
    while ($row = mysqli_fetch_assoc($result7)) {
        $files[] = $row;
    }

    // Delete the files from the '../../upload' folder
    foreach ($files as $file) {
        $fileName = $file['fileName'];
        $filePath = '../../upload/' . $fileName;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // Delete the file records from the 'files' table
    $sql_query6 = "DELETE FROM files WHERE equipmentId = ?";
    $stmt6 = mysqli_prepare($conn, $sql_query6);
    mysqli_stmt_bind_param($stmt6, "s", $equipmentId);
    $result6 = mysqli_stmt_execute($stmt6);
    if (!$result6) {
        $all_successful = false;
    }

    // Delete related data from likes table
    $sql_query5 = "DELETE FROM likes WHERE equipmentId = '$equipmentId'";
    $result5 = mysqli_query($conn, $sql_query5);
    if (!$result5) {
        $all_successful = false;
    }

    // Delete related data from collections table
    $sql_query4 = "DELETE FROM collections WHERE equipmentId = '$equipmentId'";
    $result4 = mysqli_query($conn, $sql_query4);
    if (!$result4) {
        $all_successful = false;
    }

    // Delete data from files table
    $sql_query3 = "DELETE FROM files WHERE equipmentId = '$equipmentId'";
    $result3 = mysqli_query($conn, $sql_query3);
    if (!$result3) {
        $all_successful = false;
    }

    // Delete data from database
    $sql_query1 = "DELETE FROM equipments_labels WHERE equipmentId = '$equipmentId'";
    $result1 = mysqli_query($conn, $sql_query1);
    if (!$result1) {
        $all_successful = false;
    }

    $sql_query8 = "DELETE FROM reports WHERE equipmentId = ?";
    $stmt8 = mysqli_prepare($conn, $sql_query8);
    mysqli_stmt_bind_param($stmt8, "s", $equipmentId);
    $result8 = mysqli_stmt_execute($stmt8);
    if (!$result8) {
        $all_successful = false;
    }

    $sql_query2 = "DELETE FROM equipments WHERE equipmentId = '$equipmentId'";
    $result2 = mysqli_query($conn, $sql_query2);
    if (!$result2) {
        $all_successful = false;
    }

    // Check if all queries were successful
    if ($all_successful) {
        // Commit the transaction
        mysqli_commit($conn);
        $_SESSION["system_message"] = "設備已刪除！";
    } else {
        // Rollback the transaction
        mysqli_rollback($conn);
        $_SESSION["system_message"] = "刪除失敗，請重試。";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    header('Location: ../../deluxe-master/property-1.0.0/manage-equip.php');
    exit();
}