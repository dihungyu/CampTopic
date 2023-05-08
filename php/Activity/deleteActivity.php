<?php
// 開啟錯誤報告
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 連接資料庫
require_once '../conn.php';

session_start();

if (isset($_GET["activityId"])) {
    $activityId = $_GET["activityId"];

    // Start transaction
    mysqli_begin_transaction($conn);



    $sql_query4 = "SELECT routeId FROM routes WHERE activityId = '$activityId'";
    $result4 = mysqli_query($conn, $sql_query4);
    $routes = [];
    while ($row = mysqli_fetch_assoc($result4)) {
        $routes[] = $row;
    }
    foreach ($routes as $route) {
        $routeId = $route['routeId'];
        $sql_query5 = "DELETE FROM tripIntroductions WHERE routeId = '$routeId'";
        $result5 = mysqli_query($conn, $sql_query5);
    }

    $sql_query6 = "DELETE FROM routes WHERE activityId = '$activityId'";
    $result6 = mysqli_query($conn, $sql_query6);

    $sql_query2 = "DELETE FROM activities WHERE activityId = '$activityId'";
    $result2 = mysqli_query($conn, $sql_query2);

    // Check if all queries were successful
    if ($result6 && $result2 && $result4 && $result5) {
        // Commit the transaction
        mysqli_commit($conn);
        $_SESSION["system_message"] = "活動已刪除";
    } else {
        // Rollback the transaction
        mysqli_rollback($conn);
        $_SESSION["system_message"] = "刪除失敗，請重試";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    header("Location: ../../deluxe-master/property-1.0.0/camp-information.php");
    exit();
}