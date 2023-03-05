<?php
session_start();

//確認前端表單傳送不是空值
if (isset($_POST["accountName"]) && isset($_POST["accountEmail"]) && isset($_POST["accountPhoneNumber"]) && isset($_POST["accountPassword"])) {

    //變數設定
    $accountName = $_POST["accountName"];
    $accountEmail = $_POST["accountEmail"];
    $accountPhoneNumber = $_POST["accountPhoneNumber"];
    $accountPassword = $_POST["accountPassword"];

    //加密密碼
    $hashedPassword = password_hash($accountPassword, PASSWORD_DEFAULT);

    //引入資料庫設定
    require_once("conn.php");

    //檢查資料庫內是否已有帳戶
    $stmt = $conn->prepare("SELECT accountEmail FROM accounts WHERE accountEmail = ?");
    $stmt->bind_param("s", $accountEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) >= 1) {
        echo "<script>{window.alert('此信箱已被註冊！'); location.href='../Register.html'}</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO accounts(accountId, accountName, accountPassword, accountEmail, accountPhoneNumber) VALUES ( UUID(), ?,?,?,?)");
        $stmt->bind_param("ssss", $accountName, $hashedPassword, $accountEmail, $accountPhoneNumber);
        if ($stmt->execute()) {
            echo "<script>{window.alert('註冊成功！'); location.href='../LoginPage.html'}</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>