<?php
$activityId = $_GET['activityId'];

include 'conn.php';

$sql_query = "DELETE FROM activities WHERE activityId = '$activityId'";

mysqli_query($conn, $sql_query);

header("Location: readActivity.php");
?>