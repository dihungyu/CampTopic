<?php
include "conn.php";

$articleId = $_GET['articleId'];

$sql_getDataQuery = "SELECT * FROM articles WHERE articleId = '$articleId'";

$result = mysqli_query($conn, $sql_getDataQuery);

$row_result = mysqli_fetch_assoc($result);

$articleId = $row_result['articleId'];
$articleType = $row_result['articleType'];
$articleTitle = $row_result['articleTitle'];
$articleContent = $row_result['articleContent'];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>修改營區資料</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function deleteFile(fileId) {
            if (confirm('確定要刪除此圖片？')) {
                $.post('', {
                    deleteFileId: fileId
                }, function (data) {
                    // Remove image from DOM instead of reloading the page
                    $('#image-' + fileId).remove();
                });
            }
        }

        $('#formAdd').submit(function () {
            $(this).find(':submit').attr('disabled', 'disabled');
            return true;
        }).submit(function () {
            $(this).find(':submit').removeAttr('disabled');
        });

        function previewImage(event) {
            var preview = document.getElementById('preview');
            preview.innerHTML = '';
            var files = event.target.files;
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();
                reader.onload = function (event) {
                    var img = document.createElement('img');
                    img.src = event.target.result;
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</head>

<body>
    <form action="updateArticle.php?articleId=<?php echo $articleId ?>" method="post" enctype="multipart/form-data"
        name="formAdd" id="formAdd">
        文章分類：<select name="articleType" id="articleType" value="<?php echo $articleType ?>">
            <option value="心得"> 心得 </option>
            <option value="討論"> 討論 </option>
            <option value="問答"> 問答 </option>
        </select><br />
        文章標題：<input type="text" name="articleTitle" id="articleTitle" value="<?php echo $articleTitle ?>"><br />
        文章內容：<input type="text" name="articleContent" id="articleContent" value="<?php echo $articleContent ?>"><br />
        請上傳文章圖片：<input type="file" name="files[]" multiple onchange="previewImage(event)"><br />
        <div id="preview"></div>
        <?php
        $sql_query = "SELECT * FROM files WHERE articleId = '$articleId'";
        $result_files = mysqli_query($conn, $sql_query);

        while ($row_files = mysqli_fetch_assoc($result_files)) {
            $fileId = $row_files['fileId'];
            $fileName = $row_files['fileName'];
            $isDeleted = $row_files['isDeleted'];
            $file_path = $row_files['filePath'];
            if ($isDeleted == 0) { // 檢查該圖片是否已標記為已刪除
                echo "<div id='image-$fileId'>
                    <img src='/../upload/$fileName' alt=''>
                    <button type='button' onclick='deleteFile(\"$fileId\")'>刪除此圖片</button>
                </div>";
            }
        }
        ?>
        <input type="hidden" name="action" value="update">
        <input type="submit" name="button" value="修改資料">
    </form>
</body>

</html>

<?php
// 暫時刪除圖片
if (isset($_POST['deleteFileId'])) {
    $deleteFileId = $_POST['deleteFileId'];
    $sql_delete = "UPDATE files SET isDeleted = 1 WHERE fileId = '$deleteFileId'";
    mysqli_query($conn, $sql_delete);
}

if (isset($_POST["action"]) && $_POST["action"] == 'update') {
    $newArticleType = $_POST['articleType'];
    $newArticleTitle = $_POST['articleTitle'];
    $newArticleContent = $_POST['articleContent'];

    $sql_query1 = "UPDATE articles SET articleType = '$newArticleType', articleTitle = '$newArticleTitle', articleContent = '$newArticleContent', articleUpdateDate = now() WHERE articleId = '$articleId'";
    $result1 = mysqli_query($conn, $sql_query1);

    $sql_query2 = "SELECT * FROM files WHERE articleId = '$articleId' AND isDeleted = 1";
    $result2 = mysqli_query($conn, $sql_query2);

    while ($row = mysqli_fetch_assoc($result2)) {
        $file_path = $row['filePath'];
        unlink($file_path); // 刪除圖片
    }

    $sql_query3 = "DELETE FROM files WHERE articleId = '$articleId' AND isDeleted = 1";
    $result3 = mysqli_query($conn, $sql_query3);

    if (!$result1 || !$result2 || !$result3) {
        die(mysqli_error($conn));
    }

    if (!empty($_FILES["files"]["name"][0])) {
        include "uuid_generator.php";
        // loop through all uploaded files
        foreach ($_FILES["files"]["name"] as $key => $name) {

            // check if file was uploaded successfully
            if ($_FILES["files"]["error"][$key] === UPLOAD_ERR_OK) {

                // check if file is an image
                $allowed_types = [IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF];
                $detected_type = exif_imagetype($_FILES["files"]["tmp_name"][$key]);

                if (in_array($detected_type, $allowed_types)) {
                    $fileId = uuid_generator();
                    $upload_dir = "/Applications/XAMPP/xamppfiles/htdocs/upload/";
                    $fileName = $_FILES["files"]["name"][$key];
                    $filePath = $upload_dir . $fileName;
                    $fileExtensionName = pathinfo($_FILES["files"]["name"][$key], PATHINFO_EXTENSION);
                    $fileSize = round($_FILES["files"]["size"][$key] / 1024, 2); //KB

                    move_uploaded_file($_FILES["files"]["tmp_name"][$key], $filePath);

                    $sql_query4 = "INSERT INTO files (fileId, articleId, fileName, fileExtensionName, filePath, fileSize, fileCreateDate, filePathType)
                    VALUES ('$fileId', '$articleId', '$fileName', '$fileExtensionName', '$filePath', $fileSize, now(), 'article')";

                    $result4 = mysqli_query($conn, $sql_query4);

                    if (!$result4) {
                        die(mysqli_error($conn));
                    }
                } else {
                    echo "檔案 $name 必須為圖片格式！<br>";
                }
            } else if ($_FILES["files"]["error"][$key] !== UPLOAD_ERR_NO_FILE) {
                $error_messages = [
                    UPLOAD_ERR_INI_SIZE => "檔案大小超出 php.ini:upload_max_filesize 限制",
                    UPLOAD_ERR_FORM_SIZE => "檔案大小超出 MAX_FILE_SIZE 限制",
                    UPLOAD_ERR_PARTIAL => "檔案大小僅被部份上傳",
                    UPLOAD_ERR_NO_TMP_DIR => "找不到暫存資料夾",
                    UPLOAD_ERR_CANT_WRITE => "檔案寫入失敗",
                    UPLOAD_ERR_EXTENSION => "上傳檔案被中斷",
                ];
                $error_code = $_FILES["files"]["error"][$key];

                echo "檔案 $name 上傳失敗：" . $error_messages[$error_code] . "<br>";
            }
        }
    }

    header('Location: readArticle.php');
    exit();
}
?>