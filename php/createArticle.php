<?php
session_start();
//引入資料庫設定，開啟連線
require_once("conn.php");

if(isset($_SESSION["accountId"], $_POST["articleTitle"], $_POST["articleContent"], $_POST["articleType"])){
    //變數設定
    $accountId = $_SESSION["accountId"];
    $articleTitle = $_POST["articleTitle"];
    $articleContent = $_POST["articleContent"];
    $articleType = $_POST["articleType"];

    //執行sql
    $stmt = $conn->prepare("INSERT INTO articles(articleId, accountId, articleTitle, articleContent, articleCreateDate, articleUpdateDate, articleType) VALUES (REPLACE(UUID(),'-',''), ?, ?, ?, CURDATE(), CURDATE(), ?)");
    $stmt->bind_param("ssss", $accountId, $articleTitle, $articleContent, $articleType);
    if ($stmt->execute()) {
            echo "<script>{window.alert('新增成功！'); location.href='../index.html'}</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

    
}
?>