<?php
    $id = $_GET['id'];

    include('conn.php');

    $sql_query1 = "DELETE FROM campsites WHERE campsiteId = '$id'";

    mysqli_query($conn,$sql_query1);

    $sql_query2 = "DELETE FROM files WHERE campsiteId = '$id'";

    mysqli_query($conn,$sql_query2);

    header("Location: readCampsite.php");
?>