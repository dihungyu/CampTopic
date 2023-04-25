<?php
// 開啟錯誤報告
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$campsiteId = $_GET['campsiteId'];

require_once '../conn.php';

// Get file names of files to be deleted
$sql_query = "SELECT fileName FROM files WHERE campsiteId = '$campsiteId'";
$result = mysqli_query($conn, $sql_query);
$files_to_delete = array();
while ($row = mysqli_fetch_assoc($result)) {
    $files_to_delete[] = $row['fileName'];
}

// Delete data from database
$sql_query2 = "DELETE FROM files WHERE campsiteId = '$campsiteId'";
mysqli_query($conn, $sql_query2);
$sql_query1 = "DELETE FROM campsites WHERE campsiteId = '$campsiteId'";
mysqli_query($conn, $sql_query1);

// Delete files from upload folder
$upload_dir = __DIR__ . '/../../upload/';
foreach ($files_to_delete as $fileName) { // 修改變量名 $file_name 為 $fileName
    $file_path = $upload_dir . $fileName; // 修改變量名 $filePath 為 $file_path 並使用 $upload_dir
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

header("Location: readCampsite.php");
?>