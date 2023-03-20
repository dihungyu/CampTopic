<?php
$server_name = "localhost";
$username = "root";
$password = "";
$db_name = "camp_topic";
$port = "3307";
$conn = new mysqli($server_name, $username, $password, $db_name, $port);
// conn 為 connection 的簡寫，第一個參數是 server 名稱，第二個是帳號，第三個是密碼，第四個是 database
if ($conn->connect_error) { // 物件存取屬性是用 -> 來表示
  die('資料庫連線錯誤:' . $conn->connect_error);
}
//連線完要加上下面這兩行，編碼跟時區比較不會有問題
$conn->query('SET NAMES UTF8'); // 設定編碼
$conn->query('SET time_zone = "+8:00"'); // 設定台灣時間
