<?php
$activityId = $_GET['activityId'];

session_start();

require_once '../conn.php';

$sql_query = "DELETE FROM activities WHERE activityId = '$activityId'";

mysqli_query($conn, $sql_query);

$_SESSION['system_message'] = '活動資料成功！';
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>