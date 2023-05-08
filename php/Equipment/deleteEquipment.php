<?php
$equipmentId = $_GET['equipmentId'];

session_start();
require_once '../conn.php';

// Get file names of files to be deleted
$sql_query = "SELECT fileName FROM files WHERE equipmentId = '$equipmentId'";
$result = mysqli_query($conn, $sql_query);
$files_to_delete = array();
while ($row = mysqli_fetch_assoc($result)) {
    $files_to_delete[] = $row['fileName'];
}

// Delete related data from collections table
$sql_query4 = "DELETE FROM collections WHERE equipmentId = '$equipmentId'";
if (!mysqli_query($conn, $sql_query4)) {
    echo "Error: " . mysqli_error($conn);
}

// Delete data from files table
$sql_query3 = "DELETE FROM files WHERE equipmentId = '$equipmentId'";
if (!mysqli_query($conn, $sql_query3)) {
    echo "Error: " . mysqli_error($conn);
}

// Delete data from database
$sql_query1 = "DELETE FROM equipments_labels WHERE equipmentId = '$equipmentId'";
if (!mysqli_query($conn, $sql_query1)) {
    echo "Error: " . mysqli_error($conn);
}
$sql_query2 = "DELETE FROM equipments WHERE equipmentId = '$equipmentId'";
if (!mysqli_query($conn, $sql_query2)) {
    echo "Error: " . mysqli_error($conn);
}

// Delete files from upload folder
$upload_dir = "../../upload/";
foreach ($files_to_delete as $file_name) {
    $file_path = $upload_dir . $file_name;
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

$_SESSION['system_message'] = '設備刪除成功！';
header("Location: readEquipment.php");