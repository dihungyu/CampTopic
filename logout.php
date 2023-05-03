<?php
if (isset($_GET["action"]) && $_GET["action"] == "logout") {
    // 清除 Cookie
    setcookie("accountName", "", time() - 3600, "/");
    setcookie("accountEmail", "", time() - 3600, "/");
    setcookie("accountPhoneNumber", "", time() - 3600, "/");
    setcookie("accountLevel", "", time() - 3600, "/");

    // 清除 Session 中的訊息
    session_start();
    unset($_SESSION["system_message"]);

    // 儲存登出成功的訊息到 Session 中
    $_SESSION["system_message"] = "登出成功！";

    // 轉址至登入頁面
    header("Location: /CampTopic/deluxe-master/property-1.0.0/index.php");
    exit;
}
