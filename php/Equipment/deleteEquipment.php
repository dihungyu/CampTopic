<?php
session_start();

// 連接資料庫
require_once '../../php/conn.php';

if (isset($_GET["equipmentId"])) {
    $equipmentId = $_GET['equipmentId'];

    // Start transaction
    mysqli_begin_transaction($conn);

    // Delete related data from likes table
    $sql_query5 = "DELETE FROM likes WHERE equipmentId = '$equipmentId'";
    $result5 = mysqli_query($conn, $sql_query5);

    // Delete related data from collections table
    $sql_query4 = "DELETE FROM collections WHERE equipmentId = '$equipmentId'";
    $result4 = mysqli_query($conn, $sql_query4);

    // Delete data from files table
    $sql_query3 = "DELETE FROM files WHERE equipmentId = '$equipmentId'";
    $result3 = mysqli_query($conn, $sql_query3);

    // Delete data from database
    $sql_query1 = "DELETE FROM equipments_labels WHERE equipmentId = '$equipmentId'";
    $result1 = mysqli_query($conn, $sql_query1);

    $sql_query2 = "DELETE FROM equipments WHERE equipmentId = '$equipmentId'";
    $result2 = mysqli_query($conn, $sql_query2);

    // Check if all queries were successful
    if ($result1 && $result2 && $result3 && $result4 && $result5) {
        // Commit the transaction
        mysqli_commit($conn);
        $_SESSION["system_message"] = "設備已刪除";
    } else {
        // Rollback the transaction
        mysqli_rollback($conn);
        $_SESSION["system_message"] = "刪除失敗，請重試";
    }

    header("Location: ../../deluxe-master/equipment.php");
    exit();
}