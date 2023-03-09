<?php
// 檔案上傳並顯示基本資料
echo "檔案名稱: " . $_FILES['myfile']['name'] . "<br>";
echo "檔案大小: " . $_FILES['myfile']['size'] . "<br>";
echo "檔案格式: " . $_FILES['myfile']['type'] . "<br>";
echo "暫存名稱: " . $_FILES['myfile']['tmp_name'] . "<br>";
echo "錯誤代碼: " . $_FILES['myfile']['error'] . "<br>";
// 檔案上傳後的偵錯
if($_FILES['myfile']['error'] >0 ) {
switch ($_FILES['myfile']['error'] ) {
case 1:die("檔案大小超出 php.ini:upload_max_filesize 限制 ");
case 2:die("檔案大小超出 MAX_FILE_SIZE 限制");
case 3:die("檔案大小僅被部份上傳");
case 4:die("檔案未被上傳");
}
}
?>