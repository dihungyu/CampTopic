<?php
$articleId = $_GET['articleId'];

require_once '../conn.php';

// Get file names of files to be deleted
$sql_query = "SELECT fileName FROM files WHERE articleId = '$articleId'";
$result = mysqli_query($conn, $sql_query);
$files_to_delete = array();
while ($row = mysqli_fetch_assoc($result)) {
    $files_to_delete[] = $row['fileName'];
}

// Delete data from database
$sql_query1 = "DELETE FROM articles_labels WHERE articleId = '$articleId'";
mysqli_query($conn, $sql_query1);
$sql_query2 = "DELETE FROM articles WHERE articleId = '$articleId'";
mysqli_query($conn, $sql_query2);
$sql_query3 = "DELETE FROM files WHERE articleId = '$articleId'";
mysqli_query($conn, $sql_query3);


// Delete files from upload folder
$upload_dir = "/Applications/XAMPP/xamppfiles/htdocs/upload/";
foreach ($files_to_delete as $file_name) {
    $file_path = $upload_dir . $file_name;
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

header("Location: readArticle.php");
