<?php
$activityId = $_GET['activityId'];

require_once '../conn.php';

$sql_query = "DELETE FROM activities WHERE activityId = '$activityId'";

mysqli_query($conn, $sql_query);

header("Location: readActivity.php");
?>