<?php
session_start();
require_once("conn.php");

if (isset($_POST["accountEmail"]) && isset($_POST["accountPassword"])) {

    $accountEmail = $_POST["accountEmail"];
    $accountPasswordword = $_POST["accountPassword"];
    $result = $conn->query("select * from `accounts` where accountEmail ='$accountEmail'");

    if ($row = mysqli_fetch_array($result)) {
        if ($row["accountPassword"] == $_POST["accountPassword"]) {
            $_SESSION["accountName"] = $row["accountName"];
            $_SESSION["accountEmail"] = $row["accountEmail"];
            $_SESSION["accountPhoneNumber"] = $row["accountPhoneNumber"];
            $_SESSION["accountPassword"] = $row["accountPassword"];
            $_SESSION["accountLevel"] = $row["accountLevel"];
            header("location:index.php");
        } else {
            echo "<script>{window.alert('密碼錯誤！請再試一次'); location.href='login.php'}</script>";
        }
    } else {
        echo "<script>{window.alert('此電子信箱尚未註冊！請先註冊帳號'); location.href='register.php'}</script>";
    }
}
?>