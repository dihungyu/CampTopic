<?php
$articleId = $_GET['articleId'];

include('conn.php');

$sql_query1 = "DELETE FROM articles WHERE articleId = '$articleId'";

mysqli_query($conn, $sql_query1);

$sql_query2 = "DELETE FROM files WHERE articleId = '$articleId'";

mysqli_query($conn, $sql_query2);

header("Location: readArticle.php");
