<?php
session_start();

require_once '../conn.php';

if (isset($_POST["campsiteId"])) {
    $campsiteId = $_POST["campsiteId"];

    $sql_check_activity = "SELECT * FROM activities WHERE campsiteId = ?";
    $stmt_check_activity = mysqli_prepare($conn, $sql_check_activity);
    mysqli_stmt_bind_param($stmt_check_activity, "s", $campsiteId);
    mysqli_stmt_execute($stmt_check_activity);
    $result_check_activity = mysqli_stmt_get_result($stmt_check_activity);
    if (!$result_check_activity) {
        $_SESSION["error_step"] = "Error executing query check activity";
        $all_successful = false;
    }
    if (mysqli_num_rows($result_check_activity) > 0) {
        $_SESSION["system_message"] = "有活動正在使用此營地，無法刪除！";
        header("Location: ../../deluxe-master/property-1.0.0/myCampsite.php");
        exit();
    } else {
        // Start transaction
        mysqli_begin_transaction($conn);

        $all_successful = true;

        // Get the file names for the current routeId
        $sql_query1 = "SELECT fileName FROM files WHERE campsiteId = ?";
        $stmt1 = mysqli_prepare($conn, $sql_query1);
        mysqli_stmt_bind_param($stmt1, "s", $campsiteId);
        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);
        if (!$result1) {
            $_SESSION["error_step"] = "Error executing query 1";
            $all_successful = false;
        }

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
                $_SESSION["error_step"] = "Error executing query 2";
            }
        }

        if ($all_successful) {
            // Delete the file records from the 'campsites_services' table
            $sql_query4 = "DELETE FROM campsites_services WHERE campsiteId = ?";
            $stmt4 = mysqli_prepare($conn, $sql_query4);
            mysqli_stmt_bind_param($stmt4, "s", $campsiteId);
            $result4 = mysqli_stmt_execute($stmt4);
            if (!$result4) {
                $all_successful = false;
                $_SESSION["error_step"] = "Error executing query 4";
            }
        }

        if ($all_successful) {
            // Delete the file records from the 'campsites_labels' table
            $sql_query5 = "DELETE FROM campsites_labels WHERE campsiteId = ?";
            $stmt5 = mysqli_prepare($conn, $sql_query5);
            mysqli_stmt_bind_param($stmt5, "s", $campsiteId);
            $result5 = mysqli_stmt_execute($stmt5);
            if (!$result5) {
                $all_successful = false;
                $_SESSION["error_step"] = "Error executing query 5";
            }
        }

        if ($all_successful) {
            // Delete the file records from the 'collections' table
            $sql_query6 = "DELETE FROM collections WHERE campsiteId = ?";
            $stmt6 = mysqli_prepare($conn, $sql_query6);
            mysqli_stmt_bind_param($stmt6, "s", $campsiteId);
            $result6 = mysqli_stmt_execute($stmt6);
            if (!$result6) {
                $all_successful = false;
                $_SESSION["error_step"] = "Error executing query 6";
            }
        }

        if ($all_successful) {
            // Delete the likes records from the 'likes' table
            $sql_query_likes = "DELETE FROM likes WHERE campsiteId = ?";
            $stmt_likes = mysqli_prepare($conn, $sql_query_likes);
            mysqli_stmt_bind_param($stmt_likes, "s", $campsiteId);
            $result_likes = mysqli_stmt_execute($stmt_likes);
            if (!$result_likes) {
                $all_successful = false;
                $_SESSION["error_step"] = "Error executing query likes: " . mysqli_stmt_error($stmt_likes);
            }
        }

        if ($all_successful) {
            // Delete the record from the 'campsites' table
            $sql_query3 = "DELETE FROM campsites WHERE campsiteId = ?";
            $stmt3 = mysqli_prepare($conn, $sql_query3);
            mysqli_stmt_bind_param($stmt3, "s", $campsiteId);
            $result3 = mysqli_stmt_execute($stmt3);
            if (!$result3) {
                $all_successful = false;
                $_SESSION["error_step"] = "Error executing query 3: " . mysqli_stmt_error($stmt3);
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
            // Rollback the transaction
            mysqli_rollback($conn);
            $_SESSION["system_message"] = "刪除失敗，請重試！";
            header("Location: ../../deluxe-master/property-1.0.0/myCampsite.php");
        }
    }
}