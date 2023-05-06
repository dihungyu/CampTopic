<?php
session_start();
require_once '../../php/conn.php';
require_once '../../php/uuid_generator.php';

if (isset($_POST['submit'])) {
    $accountId = $_COOKIE['accountId'];
    $fileId = uuid_generator();
    // 定義目標資料夾路徑
    $target_dir = "../../upload/";
    // 取得原始檔案名稱
    $originalFileName = pathinfo($_FILES["avatar"]["name"], PATHINFO_FILENAME);
    // 取得檔案類型，轉換為小寫
    $imageFileType = strtolower(pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION));
    // 為檔案生成唯一標識符，例如：用戶ID + 當前時間戳 + UUID
    $uniqueIdentifier = $accountId . '_' . time() . '_' . uuid_generator();
    // 使用新的檔案名稱替換原始檔案名稱
    $newFileName = $uniqueIdentifier . '.' . $imageFileType;
    // 更新目標檔案路徑
    $target_file = $target_dir . $newFileName;

    // 檢查檔案是否為圖片
    $check = getimagesize($_FILES["avatar"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;

        $_SESSION["system_message"] = "檔案不是圖片。";
        header("Location: member.php");
        exit;
    }

    // 檢查檔案大小 (5MB max)
    if ($_FILES["avatar"]["size"] > 5000000) {
        $uploadOk = 0;

        $_SESSION["system_message"] = "檔案太大。";
        header("Location: member.php");
        exit;
    }

    // 允許的檔案格式
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        $uploadOk = 0;

        $_SESSION["system_message"] = "只允許 JPG, JPEG, PNG 和 GIF 檔案格式。";
        header("Location: member.php");
        exit;
    }

    // 如果 $uploadOk 為 0，表示發生錯誤
    if ($uploadOk == 0) {
        $_SESSION["system_message"] = "抱歉，檔案上傳失敗。";
        header("Location: member.php");
        exit;
    } else { // 否則嘗試上傳檔案
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            // 計算檔案路徑
            $filePath = $target_dir . $newFileName;
            // 取得檔案大小
            $fileSize = $_FILES["avatar"]["size"];
            // 將檔案資訊寫入資料庫
            $sql_query2 = "INSERT INTO files (fileId, accountId, fileName, fileExtensionName, filePath, fileSize, fileCreateDate, fileUpdateDate, filePathType)
VALUES ('$fileId', '$accountId', '$originalFileName', '$imageFileType', '$filePath', $fileSize, now(), now(),'profilePicture')";
            mysqli_query($conn, $sql_query2);
            $_SESSION["system_message"] = "更新成功！";
            header("Location: member.php");
            exit;
        } else {
            $_SESSION["system_message"] = "抱歉，檔案上傳失敗。";
            header("Location: member.php");
            exit;
        }
    }
}
