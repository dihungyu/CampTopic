<?php
    session_start();
    require_once("conn.php");

    if(isset($_POST["accountName"]) && isset($_POST["accountEmail"]) && isset($_POST["accountPhoneNumber"]) && isset($_POST["accountPassword"])){
        $accountName=$_POST["accountName"];
        $accountEmail=$_POST["accountEmail"];
        $accountPhoneNumber=$_POST["accountPhoneNumber"];
        $accountPassword=$_POST["accountPassword"];

        $result = $conn->query("select accountEmail from `accounts` where accountEmail='$accountEmail'");

    if(mysqli_num_rows($result) >= 1){
    
    echo "<script>{window.alert('此信箱已被註冊！'); location.href='register.php'}</script>";
    }
     else{
        $result2 = $conn->query("insert into accounts(accountName,accountEmail,accountPhoneNumber,accountPassword,level) values ('$accountName','$accountEmail','$accountPhoneNumber','$accountPassword','user')");
        if($result2){
            echo "<script>{window.alert('註冊成功！'); location.href='login.php'}</script>";
        }
     }
}