<?php
   session_start();
   require_once("conn.php");

    if(isset($_POST["email"]) && isset($_POST["password"])){
       $email = $_POST["email"];
       $password = $_POST["password"];
       $rs=$conn->query("select * from `member` where email ='$email'");
      
    if($row = mysqli_fetch_array($rs)){
        if($row["password"] == $_POST["password"]){
           $_SESSION["member_name"] = $row["name"];
           $_SESSION["member_email"] = $row["email"];
           $_SESSION["member_phone"] = $row["phone"];
           $_SESSION["member_password"] = $row["password"];
           $_SESSION["level"] = $row["level"];
           header("location:index.php");
        }

        else{
        echo "<script>{window.alert('密碼錯誤！請再試一次'); location.href='login.php'}</script>";
        }
    }
   else{
    echo "<script>{window.alert('此電子信箱尚未註冊！請先註冊帳號'); location.href='register.php'}</script>";
   }
}
?>