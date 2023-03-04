<?php
    $id = $_GET['id'];

    include('conn.php');

    $sql_query = "DELETE FROM campsites WHERE campsiteId = $id";

    mysqli_query($conn,$sql_query);

    header("Location: readCampsite.php");
?>