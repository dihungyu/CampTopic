<?php
session_start();
require_once("conn.php");

// 確認使用者提交的表單中，是否填寫了帳號和密碼欄位
if (isset($_POST["accountEmail"], $_POST["accountPassword"])) {

    // 從 POST 取得填寫的帳號和密碼
    $accountEmail = $_POST["accountEmail"];
    $accountPassword = $_POST["accountPassword"];

    echo $accountEmail;
    echo $accountPassword;

    // 搜尋資料庫中是否有符合帳號的資料
    $stmt = $conn->prepare("SELECT * FROM accounts WHERE accountEmail = ?");
    $stmt->bind_param("s", $accountEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    // 若有符合的資料，則比對密碼是否正確
    if ($row = $result->fetch_assoc()) {
        if (password_verify($accountPassword, $row["accountPassword"])) {

            // 將使用者資料存入 session，並轉址至首頁
            $_SESSION["accountName"] = $row["accountName"];
            $_SESSION["accountEmail"] = $row["accountEmail"];
            $_SESSION["accountPhoneNumber"] = $row["accountPhoneNumber"];
            $_SESSION["accountPassword"] = $row["accountPassword"];
            $_SESSION["accountLevel"] = $row["accountLevel"];
            header("location:../index.html");

        } else {

            // 若密碼不正確，則顯示錯誤訊息，並轉址至登入頁面
            echo "<script>{window.alert('密碼錯誤！請再試一次'); location.href='../LoginPage.html'}</script>";

        }
    } else {

        // 若帳號不存在，則顯示錯誤訊息，並轉址至註冊頁面
        echo "<script>{window.alert('此電子信箱尚未註冊！請先註冊帳號'); location.href='../LoginPage.html'}</script>";

    }
}
?>
