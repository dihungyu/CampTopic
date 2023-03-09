<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>新增營區資料</title>
</head>
<body>
<!--如果要使用上傳檔案的功能，必須要在form加上enctype="multipart/form-data"才能正常上傳檔案-->
<form action="upload.php" method="post" name="formAdd" id="formAdd" enctype="multipart/form-data">
請輸入縣市編號：<input type="text" name="cityId" id="cityId"><br/>
請輸入營區名稱：<input type="text" name="campsiteName" id="campsiteName"><br/>
請輸入營區地址：<input type="text" name="campsiteAddress" id="campsiteAddress"><br/>
請上傳營區圖片：<input type="file" name="file" id="file"><br/>
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

    //檢查是否有上傳檔案
    if (isset($_FILES['file'])) {

        if($_FILES['myfile']['error'] > 0 ) {
            switch ($_FILES['myfile']['error'] ) {
            case 1:die("檔案大小超出 php.ini:upload_max_filesize 限制 ");
            case 2:die("檔案大小超出 MAX_FILE_SIZE 限制");
            case 3:die("檔案大小僅被部份上傳");
            case 4:die("檔案未被上傳");
            }
        } else{
        //設定儲存檔案的路徑
        $upload_dir = '/Applications/XAMPP/xamppfiles/upload';

        //取得檔案資訊
        $file_name = $_FILES['file']['name'];
        $file_type = $_FILES['file']['type'];
        $file_path = $upload_dir . "/" . $file_name;
        $file_size = $_FILES['file']['size'];

        //將檔案儲存至本地資料夾
        move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir . "/" . $file_name);
    


    //資料表查訪指令，請注意 "" , '' 的位置
    //INSERT INTO 就是新建一筆資料進哪個表的哪個欄位
    $sql_query = "INSERT INTO campsites (campsiteId, cityId, campsiteName, campsiteAddress) VALUES (REPLACE(uuid(),'-',''), '$cityId', 
    '$campsiteName','$campsiteAddress')";

    //對資料庫執行查訪的動作
    mysqli_query($conn,$sql_query);

    //導航回首頁
    header("Location: readCampsite.php");
        }
    }
}
?>