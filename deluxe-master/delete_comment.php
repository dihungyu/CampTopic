<?php
session_start();

require_once '../php/conn.php';

if (!isset($_GET["type"]) || !isset($_GET["id"]) || !isset($_GET["commentId"])) {
    $_SESSION["system_message"] = "無法刪除留言，缺少必要的參數";
    header("Location: index.php");
    exit();
}

$type = $_GET["type"]; // 取得留言類型：article 或 activity
$id = $_GET["id"]; // 取得文章或活動的 ID
$commentId = $_GET["commentId"]; // 取得留言的 ID

// 開始事務
$conn->begin_transaction();

try {
    if ($type == "article") {
        // 刪除與主留言關聯的子留言（文章留言）
        $delete_replies_sql = "DELETE FROM comments WHERE replyId = ? AND articleId = ?";
        $delete_replies_stmt = $conn->prepare($delete_replies_sql);
        $delete_replies_stmt->bind_param("ss", $commentId, $id);
        $delete_replies_stmt->execute();
        $delete_replies_stmt->close();

        // 刪除主留言（文章留言）
        $sql = "DELETE FROM comments WHERE commentId = ? AND articleId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $commentId, $id);
        $stmt->execute();
    } elseif ($type == "activity") {
        // 刪除與主留言關聯的子留言（活動留言）
        $delete_replies_sql = "DELETE FROM comments WHERE replyId = ? AND activityId = ?";
        $delete_replies_stmt = $conn->prepare($delete_replies_sql);
        $delete_replies_stmt->bind_param("ss", $commentId, $id);
        $delete_replies_stmt->execute();
        $delete_replies_stmt->close();

        // 刪除主留言（活動留言）
        $sql = "DELETE FROM comments WHERE commentId = ? AND activityId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $commentId, $id);
        $stmt->execute();
    }

    if ($stmt->affected_rows > 0) {
        $_SESSION["system_message"] = "留言已刪除";
    } else {
        $_SESSION["system_message"] = "沒有找到要刪除的留言";
    }

    $stmt->close();

    // 提交事務
    $conn->commit();
} catch (Exception $e) {
    // 發生錯誤時回滾事務
    $conn->rollback();
    $_SESSION["system_message"] = "刪除留言失敗: " . $e->getMessage();
}

$conn->close();
if (isset($_GET["level"]) && $_GET["level"] == "check") {
    header("Location: check.php?activityId=$id");
    exit();
} elseif ($type == "article") {
    header("Location: article.php?articleId=$id");
} elseif ($type == "activity") {
    header("Location: camper.php?activityId=$id");
} else {
    // 若留言類型不正確，導向預設頁面
    header("Location: index.php");
}
exit();
