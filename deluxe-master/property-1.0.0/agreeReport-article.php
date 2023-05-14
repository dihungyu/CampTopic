<?php
session_start();

// 連接資料庫
require_once '../../php/conn.php';
if (isset($_POST["articleId"])) {
    $articleId = $_POST['articleId'];

    // Start transaction
    mysqli_begin_transaction($conn);

    $all_successful = true;

    // Get file names of files to be deleted
    $sql_query = "SELECT fileName FROM files WHERE articleId = '$articleId'";
    $result = mysqli_query($conn, $sql_query);
    $files_to_delete = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $files_to_delete[] = $row['fileName'];
    }

    // Delete related data from likes table
    $sql_query5 = "DELETE FROM likes WHERE articleId = '$articleId'";
    $result5 = mysqli_query($conn, $sql_query5);
    if (!$result5) {
        $all_successful = false;
    }

    // Delete related data from collections table
    $sql_query4 = "DELETE FROM collections WHERE articleId = '$articleId'";
    $result4 = mysqli_query($conn, $sql_query4);
    if (!$result4) {
        $all_successful = false;
    }

    // Delete data from files table
    $sql_query3 = "DELETE FROM files WHERE articleId = '$articleId'";
    $result3 = mysqli_query($conn, $sql_query3);
    if (!$result3) {
        $all_successful = false;
    }

    $sql_query6 = "DELETE FROM comments WHERE articleId = '$articleId'";
    $result6 = mysqli_query($conn, $sql_query6);
    if (!$result6) {
        $all_successful = false;
    }

    $sql_query7 = "DELETE FROM reports WHERE articleId = '$articleId'";
    $result7 = mysqli_query($conn, $sql_query7);
    if (!$result7) {
        $all_successful = false;
    }

    // Delete data from database
    $sql_query1 = "DELETE FROM articles_labels WHERE articleId = '$articleId'";
    $result1 = mysqli_query($conn, $sql_query1);
    if (!$result1) {
        $all_successful = false;
    }

    $sql_query2 = "DELETE FROM articles WHERE articleId = '$articleId'";
    $result2 = mysqli_query($conn, $sql_query2);
    if (!$result2) {
        $all_successful = false;
    }

    // Check if all queries were successful
    if ($all_successful) {

        // Commit the transaction
        mysqli_commit($conn);

        // Delete files from upload folder
        $upload_dir = "../../upload/";
        foreach ($files_to_delete as $file_name) {
            $file_path = $upload_dir . $file_name;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        $_SESSION["system_message"] = "檢舉已通過，並將文章已刪除！";
    } else {
        // Rollback the transaction
        mysqli_rollback($conn);
        $_SESSION["system_message"] = "刪除失敗，請重試。";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    header("Location: manage-article.php");
    exit();
}