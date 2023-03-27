<?php
$id = $_GET['id'];

include('conn.php');

// Get file names of files to be deleted
$sql_query = "SELECT fileName FROM files WHERE campsiteId = '$id'";
$result = mysqli_query($conn, $sql_query);
$files_to_delete = array();
while ($row = mysqli_fetch_assoc($result)) {
    $files_to_delete[] = $row['fileName'];
}

// Delete data from database
$sql_query1 = "DELETE FROM campsites WHERE campsiteId = '$id'";
mysqli_query($conn, $sql_query1);
$sql_query2 = "DELETE FROM files WHERE campsiteId = '$id'";
mysqli_query($conn, $sql_query2);

// Delete files from upload folder
$upload_dir = "/Applications/XAMPP/xamppfiles/htdocs/upload/";
foreach ($files_to_delete as $file_name) {
    $file_path = $upload_dir . $file_name;
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

header("Location: readCampsite.php");
?>
