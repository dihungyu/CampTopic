<?php
session_start();

require_once '../conn.php';

if (isset($_GET["campsiteId"])) {
    $campsiteId = $_GET["campsiteId"];

    // Start transaction
    mysqli_begin_transaction($conn);

    $all_successful = true;

    // Get the file names for the current routeId
    $sql_query1 = "SELECT fileName FROM files WHERE campsiteId = ?";
    $stmt1 = mysqli_prepare($conn, $sql_query1);
    mysqli_stmt_bind_param($stmt1, "s", $campsiteId);
    mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);
    $files = [];
    while ($row = mysqli_fetch_assoc($result1)) {
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

    if ($all_successful) {
        // Delete the file records from the 'files' table
        $sql_query2 = "DELETE FROM files WHERE campsiteId = ?";
        $stmt2 = mysqli_prepare($conn, $sql_query2);
        mysqli_stmt_bind_param($stmt2, "s", $campsiteId);
        $result2 = mysqli_stmt_execute($stmt2);
        if (!$result2) {
            $all_successful = false;
        }
    }

    if ($all_successful) {
        // Delete the file records from the 'files' table
        $sql_query4 = "DELETE FROM campsites_services WHERE campsiteId = ?";
        $stmt4 = mysqli_prepare($conn, $sql_query4);
        mysqli_stmt_bind_param($stmt4, "s", $campsiteId);
        $result4 = mysqli_stmt_execute($stmt4);
        if (!$result4) {
            $all_successful = false;
        }
    }

    if ($all_successful) {
        // Delete the file records from the 'files' table
        $sql_query5 = "DELETE FROM campsites_labels WHERE campsiteId = ?";
        $stmt5 = mysqli_prepare($conn, $sql_query5);
        mysqli_stmt_bind_param($stmt5, "s", $campsiteId);
        $result5 = mysqli_stmt_execute($stmt5);
        if (!$result5) {
            $all_successful = false;
        }
    }

    if ($all_successful) {
        // Delete the file records from the 'files' table
        $sql_query6 = "DELETE FROM collections WHERE campsiteId = ?";
        $stmt6 = mysqli_prepare($conn, $sql_query6);
        mysqli_stmt_bind_param($stmt6, "s", $campsiteId);
        $result6 = mysqli_stmt_execute($stmt6);
        if (!$result6) {
            $all_successful = false;
        }
    }

    if ($all_successful) {
        $sql_query3 = "DELETE FROM campsites WHERE campsiteId = ?";
        $stmt3 = mysqli_prepare($conn, $sql_query3);
        mysqli_stmt_bind_param($stmt3, "s", $campsiteId);
        $result3 = mysqli_stmt_execute($stmt3);

        if (!$result3) {
            $all_successful = false;
        }
    }

    // Check if all queries were successful
    if ($all_successful) {
        // Commit the transaction
        mysqli_commit($conn);
        $_SESSION["system_message"] = "營地已刪除！";
        header("Location: ../../deluxe-master/property-1.0.0/myCampsite.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
        // Rollback the transaction
        mysqli_rollback($conn);
        $_SESSION["system_message"] = "刪除失敗，請重試！";
        header("Location: ../../deluxe-master/property-1.0.0/myCampsite.php");
    }
}
