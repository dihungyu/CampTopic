<?php
function get_profileImg_src($accountId, $conn)
{
    $pic_sql = "SELECT `filePath` FROM `files` WHERE `accountId` = '$accountId' ORDER BY `fileCreateDate` DESC LIMIT 1";
    $pic_result = mysqli_query($conn, $pic_sql);

    if ($pic_row = mysqli_fetch_assoc($pic_result)) {
        $img_src = $pic_row["filePath"];
    } else {
        $img_src = "../../upload/profileDefault.jpeg";
    }

    return $img_src;
}


function get_img_src($fileType, $fileTypeId, $defaultImg, $conn)
{
    $files_query = "SELECT * FROM files WHERE '$fileType' = '$fileTypeId'";
    $files_result = mysqli_query($conn, $files_query);
    $image_src = $defaultImg; // Default image

    if ($file_result = mysqli_fetch_assoc($files_result)) {
        $file_path = str_replace('Applications/XAMPP/xamppfiles/htdocs', '../..', $file_result['filePath']);
        $image_src = $file_path;
    }

    return $image_src;
}
