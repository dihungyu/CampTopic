<?php
session_start();
//若點擊登出按鈕
if (isset($_GET["action"]) && $_GET["action"] == "logout") {
    // 清除 Cookie
    setcookie("accountId", "", time() - 3600, "/");
    setcookie("accountName", "", time() - 3600, "/");
    setcookie("accountEmail", "", time() - 3600, "/");
    setcookie("accountPhoneNumber", "", time() - 3600, "/");
    setcookie("accountLevel", "", time() - 3600, "/");

    // 清除 Session
    session_unset();
    session_destroy();

    // 轉址至登入頁面
    $_SESSION["system_message"] = "登出成功！";
    header("Location: /CampTopic/deluxe-master/property-1.0.0/index.php");
    exit;
}
