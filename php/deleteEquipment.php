<?php
    $equipmentId = $_GET['equipmentId'];

    include('conn.php');

    $sql_query1 = "DELETE FROM equipments WHERE equipmentId = '$equipmentId'";

    mysqli_query($conn,$sql_query1);

    $sql_query2 = "DELETE FROM files WHERE equipmentId = '$equipmentId'";

    mysqli_query($conn,$sql_query2);

    header("Location: readEquipment.php");
