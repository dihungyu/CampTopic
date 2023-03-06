<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>新增營區資料</title>
</head>
<body>
<form action="" method="post" name="formAdd" id="formAdd">
請輸入縣市編號：<input type="text" name="cityId" id="cityId"><br/>
請輸入營區名稱：<input type="text" name="campsiteName" id="campsiteName"><br/>
請輸入營區地址：<input type="text" name="campsiteAddress" id="campsiteAddress"><br/>
<input type="hidden" name="action" value="insert">
<input type="submit" name="button" value="新增資料">
<input type="reset" name="button2" value="重新填寫">
</form>
</body>
</html>

<?php
//先檢查請求來源是否是我們上面創建的form
if (isset($_POST["action"])&&($_POST["action"] == "insert")) {

    //引入檔，負責連結資料庫
    include("conn.php");

    //取得請求過來的資料
    $cityId = $_POST["cityId"];
    $campsiteName = $_POST['campsiteName'];
    $campsiteAddress = $_POST['campsiteAddress'];

    //資料表查訪指令，請注意 "" , '' 的位置
    //INSERT INTO 就是新建一筆資料進哪個表的哪個欄位
    $sql_query = "INSERT INTO campsites (campsiteId, cityId, campsiteName, campsiteAddress) VALUES (REPLACE(uuid(),'-',''), '$cityId', 
'$campsiteName','$campsiteAddress')";

    //對資料庫執行查訪的動作
    mysqli_query($conn,$sql_query);

    //導航回首頁
    header("Location: readCampsite.php");
}
?>