<?php
session_start();

require_once '../conn.php';

if (isset($_GET["activityId"])) {
    $activityId = $_GET["activityId"];

    // Start transaction
    mysqli_begin_transaction($conn);

    $sql_query1 = "SELECT routeId FROM routes WHERE activityId = ?";
    $stmt1 = mysqli_prepare($conn, $sql_query1);
    mysqli_stmt_bind_param($stmt1, "s", $activityId);
    mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);
    $routes = [];
    while ($row = mysqli_fetch_assoc($result1)) {
        $routes[] = $row;
    }

    $all_successful = true;

    foreach ($routes as $route) {
        $routeId = $route['routeId'];
        $sql_query2 = "DELETE FROM tripIntroductions WHERE routeId = ?";
        $stmt2 = mysqli_prepare($conn, $sql_query2);
        mysqli_stmt_bind_param($stmt2, "s", $routeId);
        $result2 = mysqli_stmt_execute($stmt2);
        if (!$result2) {
            $_SESSION["system_message"] = "Error deleting trip introductions: " . mysqli_error($conn);
            $all_successful = false;
            break;
        }

        // Get the file names for the current routeId
        $sql_query5 = "SELECT fileName FROM files WHERE routeId = ?";
        $stmt5 = mysqli_prepare($conn, $sql_query5);
        mysqli_stmt_bind_param($stmt5, "s", $routeId);
        mysqli_stmt_execute($stmt5);
        $result5 = mysqli_stmt_get_result($stmt5);
        $files = [];
        while ($row = mysqli_fetch_assoc($result5)) {
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
        $sql_query6 = "DELETE FROM files WHERE routeId = ?";
        $stmt6 = mysqli_prepare($conn, $sql_query6);
        mysqli_stmt_bind_param($stmt6, "s", $routeId);
        $result6 = mysqli_stmt_execute($stmt6);
        if (!$result6) {
            $_SESSION["system_message"] = "Error deleting file records: " . mysqli_error($conn);
            $all_successful = false;
            break;
        }
    }

    if ($all_successful) {
        $sql_query3 = "DELETE FROM routes WHERE activityId = ?";
        $stmt3 = mysqli_prepare($conn, $sql_query3);
        mysqli_stmt_bind_param($stmt3, "s", $activityId);
        $result3 = mysqli_stmt_execute($stmt3);

        if (!$result3) {
            $_SESSION["system_message"] = "Error deleting routes: " . mysqli_error($conn);
            $all_successful = false;
        }
    }

    if ($all_successful) {
        $sql_query7 = "DELETE FROM comments WHERE activityId = ?";
        $stmt7 = mysqli_prepare($conn, $sql_query7);
        mysqli_stmt_bind_param($stmt7, "s", $activityId);
        $result7 = mysqli_stmt_execute($stmt7);

        if (!$result7) {
            $_SESSION["system_message"] = "Error deleting comments: " . mysqli_error($conn);
            $all_successful = false;
        }
    }

    if ($all_successful) {
        // Delete from the activities_accounts table first
        $sql_query8 = "DELETE FROM activities_accounts WHERE activityId = ?";
        $stmt8 = mysqli_prepare($conn, $sql_query8);
        mysqli_stmt_bind_param($stmt8, "s", $activityId);
        $result8 = mysqli_stmt_execute($stmt8);

        if (!$result8) {
            $_SESSION["system_message"] = "Error deleting records from activities_accounts: " . mysqli_error($conn);
            $all_successful = false;
        }
    }

    if ($all_successful) {
        $sql_query4 = "DELETE FROM activities WHERE activityId = ?";
        $stmt4 = mysqli_prepare($conn, $sql_query4);
        mysqli_stmt_bind_param($stmt4, "s", $activityId);
        $result4 = mysqli_stmt_execute($stmt4);

        if (!$result4) {
            $_SESSION["system_message"] = "Error deleting activities: " . mysqli_error($conn);
            $all_successful = false;
        }
    }


    // Check if all queries were successful
    if ($all_successful) {
        // Commit the transaction
        mysqli_commit($conn);
        $_SESSION["system_message"] = "活動已刪除";
        header("Location: ../../deluxe-master/property-1.0.0/camp-information.php");
        exit();
    } else {
        // Rollback the transaction
        mysqli_rollback($conn);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
