<?php
include "conn.php";

if (isset($_POST['deleteFileId'])) {
    $deleteFileId = $_POST['deleteFileId'];
    $sql_delete = "UPDATE files SET isDeleted = 1 WHERE fileId = '$deleteFileId'";
    mysqli_query($conn, $sql_delete);
}

$id = $_POST['campsiteId'];
header("Location: updateCampsite.php?id=$id");

?>