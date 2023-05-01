<?php


if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["action"] === "insert") {

    require_once '../conn.php';
    require_once '../uuid_generator.php';

    $equipmentType = $_POST["equipmentType"];
    $equipmentLocation = $_POST["equipmentLocation"];
    $equipmentName = $_POST["equipmentName"];
    $equipmentDescription = $_POST["equipmentDescription"];
    $equipmentPrice = $_POST["equipmentPrice"];
    $tags = $_POST['tags']; // 取得選擇的標籤值，以陣列的形式傳回

    $equipmentId = uuid_generator();
    $accountId = "c995dbc4be4811eda1d4e22a0f5e8454";

    $sql_query1 = "INSERT INTO equipments (equipmentId, accountId, equipmentType, equipmentLocation, equipmentName, equipmentDescription, equipmentCreateDate, equipmentUpdateDate, equipmentPrice)
                VALUES ('$equipmentId', '$accountId', '$equipmentType', '$equipmentLocation', '$equipmentName', '$equipmentDescription', now(), now(), '$equipmentPrice')";

    mysqli_query($conn, $sql_query1);

    // 將每個標籤值插入到 equipments_labels 資料表中
    foreach ($tags as $tag) {
        $labelId = uuid_generator();
        $insert_label_sql = "INSERT INTO equipments_labels (equipmentLabelId, equipmentId, labelId) VALUES ('$labelId','$equipmentId', '$tag')";

        if (!mysqli_query($conn, $insert_label_sql)) {
            echo "Error: " . mysqli_error($conn);
        }
    }


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

                $sql_query2 = "INSERT INTO files (fileId, equipmentId, fileName, fileExtensionName, filePath, fileSize, fileCreateDate, filePathType)
                VALUES ('$fileId', '$equipmentId', '$fileName', '$fileExtensionName', '$filePath', $fileSize, now(), 'equipment')";

                mysqli_query($conn, $sql_query2);
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

    header("Location: readEquipment.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>新增設備資料</title>
    <script>
        function previewImage(event) {
            var preview = document.getElementById('preview');
            preview.innerHTML = '';
            var files = event.target.files;
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();
                reader.onload = function(event) {
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
    <!--如果要使用上傳檔案的功能，必須要在form加上enctype="multipart/form-data"才能正常上傳檔案-->
    <form action="" method="post" name="formAdd" id="formAdd" enctype="multipart/form-data">
        設備分類：<select name="equipmentType" id="equipmentType">
            <option value="租"> 租 </option>
            <option value="徵"> 徵 </option>
            <option value="賣"> 賣 </option>
        </select><br />
        <?php
        require_once '../conn.php';
        $sql = "SELECT cityId, cityName FROM cities";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo '設備所在地：<select name="equipmentLocation" id="equipmentLocation">';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['cityId'] . '">' . $row['cityName'] . '</option>';
            }
            echo '</select><br />';
        } else {
            echo "沒有找到縣市資料。";
        }
        ?>
        設備名稱：<input type="text" name="equipmentName" id="equipmentName"><br />
        設備敘述：<input type="text" name="equipmentDescription" id="equipmentDescription"><br />
        設備價格：<input type="text" name="equipmentPrice" id="equipmentPrice"><br />
        請選擇設備標籤：<br />
        <?php
        require_once '../conn.php';
        $sql = "SELECT labelId, labelName FROM labels WHERE labelType = '設備'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) { // 檢查是否有資料
            echo '<select id="tags-select" name="tags[]" multiple style="width: 100%;">';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['labelId'] . '">' . $row['labelName'] . '</option>';
            }
            echo '</select>';
        }
        ?>
        設備圖片：<input type="file" name="files[]" multiple onchange="previewImage(event)"><br />
        <div id="preview"></div>
        <input type="hidden" name="action" value="insert">
        <input type="submit" name="button" value="新增資料">
        <input type="reset" name="button2" value="重新填寫">
    </form>
</body>

</html>