<?php
require_once '../../php/conn.php';

session_start();

if (isset($_POST["articleId"])) {
    $articleId = $_POST["articleId"];

    $all_successful = true;

    $sql = "UPDATE articles SET isReviewed = 1 WHERE articleId = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $articleId);
    if (!mysqli_stmt_execute($stmt)) {
        $all_successful = false;
    }

    $sql_delete_report = "DELETE FROM reports WHERE articleId = ?";
    $stmt_delete_report = mysqli_prepare($conn, $sql_delete_report);
    mysqli_stmt_bind_param($stmt_delete_report, "s", $articleId);
    if (!mysqli_stmt_execute($stmt_delete_report)) {
        $all_successful = false;
    }

    if ($all_successful) {
        $_SESSION["system_message"] = "已駁回該文章的檢舉！";
        header('Location: ../../deluxe-master/property-1.0.0/manage-equip.php');
    } else {
        $_SESSION["system_message"] = "更新失敗，請重試！";
        header('Location: ' . $_SERVER['HTTP_REFERER']);

    }

} else {
    $_SESSION["system_message"] = "更新失敗，請重試！";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>