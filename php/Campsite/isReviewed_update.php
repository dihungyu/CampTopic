<?php
session_start();

require_once '../conn.php';

if (isset($_POST["campsiteId"])) {
    $campsiteId = $_POST["campsiteId"];

    $sql = "UPDATE campsites SET isReviewed = 1 WHERE campsiteId = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $campsiteId);


    // Check if all queries were successful
    if (mysqli_stmt_execute($stmt)) {
        // Commit the transaction
        mysqli_commit($conn);
        $_SESSION["system_message"] = "營地已上架！";
        header("Location: ../../deluxe-master/property-1.0.0/manage-land.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
        // Rollback the transaction
        mysqli_rollback($conn);
        $_SESSION["system_message"] = "更新失敗，請重試！";
        header("Location: ../../deluxe-master/property-1.0.0/manage-land.php");
    }
}
