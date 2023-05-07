<?php
session_start();

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../php/conn.php';

$articleId = $_POST["articleId"];
$commentId = $_POST["commentId"];
$updatedContent = $_POST["updatedContent"];

// 验证留言内容
if (empty(trim($updatedContent))) {
    $_SESSION["system_message"] = "留言内容不能为空";
    header("Location: article.php?articleId=$articleId");
    exit();
}

// 更新留言内容
$sql = "UPDATE comments SET commentContent = ?, commentUpdateDate = now() WHERE commentId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $updatedContent, $commentId);


if ($stmt->execute()) {
    $_SESSION["system_message"] = "留言已更新";
    header("Location: article.php?articleId=$articleId");
    exit();
} else {
    $_SESSION["system_message"] = "更新留言失败";
    header("Location: article.php?articleId=$articleId");
    exit();
}

$stmt->close();
$conn->close();
