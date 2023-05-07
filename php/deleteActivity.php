<?php
    $id = $_GET['id'];

    include ('conn.php');

    $sql_query = "DELETE FROM activities WHERE activityId = '$id'";

    mysqli_query($conn,$sql_query);

    header("Location: readActivity.php");
?>