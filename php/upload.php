<html>
<body>
<form action="" method="post" enctype="multipart/form-data">
    選擇檔案:<input type="file" name="myfile" id="myfile"><br />
    <input type="submit" name="submit" value="上傳檔案">

</form>
</body>
</html>


<?php
if ($_FILES["myfile"]["error"] > 0){
    echo "Error: " . $_FILES["myfile"]["error"];

}else{

    echo "檔案名稱: " . $_FILES["myfile"]["name"]."<br/>";
    echo "檔案類型: " . $_FILES["myfile"]["type"]."<br/>";
    echo "檔案大小: " . ($_FILES["myfile"]["size"] / 1024)." Kb<br />";
    echo "暫存名稱: " . $_FILES["myfile"]["tmp_name"]."<br/>";
    
    if (file_exists("/Applications/XAMPP/xamppfiles/htdocs/upload/".$_FILES["myfile"]["name"])){
    echo "檔案已經存在，請勿重覆上傳相同檔案";

    } else{
        
        $target_path = "/Applications/XAMPP/xamppfiles/htdocs/upload/".$_FILES["myfile"]["name"];

        if(move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {  
        echo "檔案：". $_FILES['myfile']['name'] . " 上傳成功!";

        } else{
            echo "檔案上傳失敗，請再試一次!";

        }
    }
}

?>
