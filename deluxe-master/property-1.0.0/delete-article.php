<?php
session_start();

// 連接資料庫
require_once '../../php/conn.php';
if (isset($_GET["articleId"])) {
    $articleId = $_GET['articleId'];

    // Start transaction
    mysqli_begin_transaction($conn);

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

    // Delete related data from collections table
    $sql_query4 = "DELETE FROM collections WHERE articleId = '$articleId'";
    $result4 = mysqli_query($conn, $sql_query4);

    // Delete data from files table
    $sql_query3 = "DELETE FROM files WHERE articleId = '$articleId'";
    $result3 = mysqli_query($conn, $sql_query3);

    // Delete data from database
    $sql_query1 = "DELETE FROM articles_labels WHERE articleId = '$articleId'";
    $result1 = mysqli_query($conn, $sql_query1);

    $sql_query2 = "DELETE FROM articles WHERE articleId = '$articleId'";
    $result2 = mysqli_query($conn, $sql_query2);

    // Check if all queries were successful
    if ($result1 && $result2 && $result3 && $result4 && $result5) {

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
        $_SESSION["system_message"] = "文章已刪除";
    } else {
        // Rollback the transaction
        mysqli_rollback($conn);
        $_SESSION["system_message"] = "刪除失敗，請重試";
    }

    header("Location: ../all-article.php");
    exit();
}
