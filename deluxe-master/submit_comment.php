<?php
session_start();
require_once '../php/conn.php';
require_once '../php/uuid_generator.php';

if (isset($_POST["type"]) && $_POST["type"] == "article") {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST["action"] == "reply" && isset($_POST["replyId"]) && isset($_POST["articleId"]) && isset($_POST["commentContent"])) {

        // 取得表單資料
        $accountId = $_COOKIE["accountId"];
        $articleId = $_POST["articleId"];
        $replyId = $_POST["replyId"];
        $commentContent = $_POST["commentContent"];

        // 驗證留言內容
        if (empty(trim($commentContent))) {
            $_SESSION["system_message"] = "留言內容不能為空";
            header("Location: article.php?articleId=$articleId");
            exit();
        }

        // 插入留言
        $commentId = uuid_generator();
        $comment_sql = "INSERT INTO comments (commentId, accountId, articleId, replyId, commentContent, commentCreateDate, commentUpdateDate) VALUES ('$commentId', '$accountId', '$articleId', '$replyId', '$commentContent', now(), now() )";
        $comment_result = mysqli_query($conn, $comment_sql);

        // 檢查錯誤
        if (!$comment_result) {
            die("Error: " . mysqli_error($conn));
        }

        // 重定向回文章頁面
        $_SESSION["system_message"] = "留言成功";
        header("Location: article.php?articleId=$articleId");
        exit();
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST["action"] == "comment"  && isset($_POST["articleId"]) && isset($_POST["commentContent"])) {
        // 取得表單資料
        $accountId = $_COOKIE["accountId"];
        $articleId = $_POST["articleId"];
        $commentContent = $_POST["commentContent"];

        // 驗證留言內容
        if (empty(trim($commentContent))) {
            $_SESSION["system_message"] = "留言內容不能為空";
            header("Location: article.php?articleId=$articleId");
            exit();
        }

        // 插入留言
        $commentId = uuid_generator();
        $comment_sql = "INSERT INTO comments (commentId, accountId, articleId, commentContent, commentCreateDate, commentUpdateDate) VALUES ('$commentId', '$accountId', '$articleId', '$commentContent', now(), now() )";
        $comment_result = mysqli_query($conn, $comment_sql);

        // 檢查錯誤
        if (!$comment_result) {
            die("Error: " . mysqli_error($conn));
        }

        // 重定向回文章頁面
        $_SESSION["system_message"] = "留言成功";
        header("Location: article.php?articleId=$articleId");
        exit();
    } else {
        // 非法請求
        header('HTTP/1.1 400 Bad Request');
        exit();
    }
} elseif (isset($_POST["type"]) && $_POST["type"] == "activity") {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST["action"] == "reply" && isset($_POST["replyId"]) && isset($_POST["activityId"]) && isset($_POST["commentContent"])) {

        // 取得表單資料
        $accountId = $_COOKIE["accountId"];
        $activityId = $_POST["activityId"];
        $replyId = $_POST["replyId"];
        $commentContent = $_POST["commentContent"];

        // 驗證留言內容
        if (empty(trim($commentContent))) {
            $_SESSION["system_message"] = "留言內容不能為空";
            header("Location: camper.php?activityId=$activityId");
            exit();
        }

        // 插入留言
        $commentId = uuid_generator();
        $comment_sql = "INSERT INTO comments (commentId, accountId, activityId, replyId, commentContent, commentCreateDate, commentUpdateDate) VALUES ('$commentId', '$accountId', '$activityId', '$replyId', '$commentContent', now(), now() )";
        $comment_result = mysqli_query($conn, $comment_sql);

        // 檢查錯誤
        if (!$comment_result) {
            die("Error: " . mysqli_error($conn));
        }

        // 重定向回文章頁面
        $_SESSION["system_message"] = "留言成功";
        header("Location: camper.php?activityId=$activityId");
        exit();
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST["action"] == "comment"  && isset($_POST["activityId"]) && isset($_POST["commentContent"])) {
        // 取得表單資料
        $accountId = $_COOKIE["accountId"];
        $activityId = $_POST["activityId"];
        $commentContent = $_POST["commentContent"];

        // 驗證留言內容
        if (empty(trim($commentContent))) {
            $_SESSION["system_message"] = "留言內容不能為空";
            header("Location: camper.php?activityId=$activityId");
            exit();
        }

        // 插入留言
        $commentId = uuid_generator();
        $comment_sql = "INSERT INTO comments (commentId, accountId, activityId, commentContent, commentCreateDate, commentUpdateDate) VALUES ('$commentId', '$accountId', '$activityId', '$commentContent', now(), now() )";
        $comment_result = mysqli_query($conn, $comment_sql);

        // 檢查錯誤
        if (!$comment_result) {
            die("Error: " . mysqli_error($conn));
        }

        // 重定向回文章頁面
        $_SESSION["system_message"] = "留言成功";
        header("Location: camper.php?activityId=$activityId");
        exit();
    } else {
        // 非法請求
        header('HTTP/1.1 400 Bad Request');
        exit();
    }
}
