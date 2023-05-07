<?php
session_start();

require_once '../php/conn.php';

$articleId = $_GET["articleId"];
$commentId = $_GET["commentId"];

if (!isset($articleId) || !isset($commentId)) {
    $_SESSION["system_message"] = "無法刪除留言，缺少必要的參數";
    header("Location: article.php");
    exit();
}

// 刪除與主留言關聯的子留言
$delete_replies_sql = "DELETE FROM comments WHERE replyId = ?";
$delete_replies_stmt = $conn->prepare($delete_replies_sql);
$delete_replies_stmt->bind_param("s", $commentId);

if (!$delete_replies_stmt->execute()) {
    $_SESSION["system_message"] = "刪除子留言失敗: " . $delete_replies_stmt->error;
    header("Location: article.php?articleId=$articleId");
    exit();
}

$delete_replies_stmt->close();

// 刪除主留言
$sql = "DELETE FROM comments WHERE commentId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $commentId);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        $_SESSION["system_message"] = "留言已刪除";
    } else {
        $_SESSION["system_message"] = "沒有找到要刪除的留言";
    }
    header("Location: article.php?articleId=$articleId");
    exit();
} else {
    $_SESSION["system_message"] = "刪除留言失敗: " . $stmt->error;
    header("Location: article.php?articleId=$articleId");
    exit();
}

$stmt->close();
$conn->close();
