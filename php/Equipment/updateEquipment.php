<?php

require_once '../conn.php';

$equipmentId = $_GET['equipmentId'];

$sql_getDataQuery = "SELECT * FROM equipments WHERE equipmentId = '$equipmentId'";

$result = mysqli_query($conn, $sql_getDataQuery);

$row_result = mysqli_fetch_assoc($result);

$equipmentId = $row_result['equipmentId'];
$equipmentType = $row_result['equipmentType'];
$equipmentLocation = $row_result['equipmentLocation'];
$equipmentName = $row_result['equipmentName'];
$equipmentDescription = $row_result['equipmentDescription'];
$equipmentPrice = $row_result['equipmentPrice'];

?>
<?php
// 暫時刪除圖片
if (isset($_POST['deleteFileId'])) {
    $deleteFileId = $_POST['deleteFileId'];
    $sql_delete = "UPDATE files SET isDeleted = 1 WHERE fileId = '$deleteFileId'";
    mysqli_query($conn, $sql_delete);
}

if (isset($_POST["action"]) && $_POST["action"] == 'update') {

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $newEquipmentType = $_POST['equipmentType'];
    $newEquipmentName = $_POST['equipmentName'];
    $newEquipmentDescription = $_POST['equipmentDescription'];
    $newEquipmentPrice = $_POST['equipmentPrice'];
    $newEquipmentLocation = $_POST['equipmentLocation'];


    $newtags = $_POST['tags']; // 取得選擇的標籤值，以陣列的形式傳回

    require_once '../conn.php';
    require_once '../uuid_generator.php';
    // 刪除該營地的現有標籤
    $sql_delete = "DELETE FROM equipments_labels WHERE equipmentId = '$equipmentId'";
    mysqli_query($conn, $sql_delete);

    // 插入新的標籤
    foreach ($newtags as $tagId) {
        $equipmentLabelId = uuid_generator();
        $sql_insert = "INSERT INTO equipments_labels (equipmentLabelId, equipmentId, labelId) VALUES ('$equipmentLabelId', '$equipmentId', '$tagId')";
        if (!mysqli_query($conn, $sql_insert)) {
            echo "Error: " . mysqli_error($conn);
        }
    }


    $sql_query1 = "UPDATE equipments SET equipmentLocation = '$newEquipmentLocation', equipmentName = '$newEquipmentName', equipmentDescription='$newEquipmentDescription', equipmentPrice='$newEquipmentPrice', equipmentType='$newEquipmentType' WHERE equipmentId = '$equipmentId'";
    $result1 = mysqli_query($conn, $sql_query1);

    $sql_query2 = "SELECT * FROM files WHERE equipmentId = '$equipmentId' AND isDeleted = 1";
    $result2 = mysqli_query($conn, $sql_query2);

    while ($row = mysqli_fetch_assoc($result2)) {
        $file_path = $row['filePath'];
        unlink($file_path); // 刪除圖片
    }

    $sql_query3 = "DELETE FROM files WHERE equipmentId = '$equipmentId' AND isDeleted = 1";
    $result3 = mysqli_query($conn, $sql_query3);

    if (!$result1 || !$result2 || !$result3) {
        die(mysqli_error($conn));
    }

    if (!empty($_FILES["files"]["name"][0])) {
        require_once '../uuid_generator.php';
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

                    $sql_query4 = "INSERT INTO files (fileId, equipmentId, fileName, fileExtensionName, filePath, fileSize, fileCreateDate, filePathType)
                    VALUES ('$fileId', '$equipmentId', '$fileName', '$fileExtensionName', '$filePath', $fileSize, now(), 'equipment')";

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

    header('Location: readEquipment.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>修改營區資料</title>

</head>

<body>
    <form action="updateEquipment.php?equipmentId=<?php echo $equipmentId ?>" method="post" enctype="multipart/form-data" name="formAdd" id="formAdd">

        設備分類：<select name="equipmentType" id="equipmentType">
            <option value="租" <?php if ($equipmentType == '租') {
                                    echo ' selected';
                                } ?>>租</option>
            <option value="徵" <?php if ($equipmentType == '徵') {
                                    echo ' selected';
                                } ?>>徵</option>
            <option value="賣" <?php if ($equipmentType == '賣') {
                                    echo ' selected';
                                } ?>>賣</option>
        </select>
        <br />
        <?php
        require_once '../conn.php';

        // 先取得目前該資料的縣市名稱
        $currentCityName = '';
        if (!empty($cityId)) {
            $sql_cities = "SELECT cityName FROM cities WHERE cityId = '$equipmentLocation'";
            $result_cities = mysqli_query($conn, $sql_cities);
            if ($row_cities = mysqli_fetch_assoc($result_cities)) {
                $currentCityName = $row_cities['cityName'];
            }
        }

        $sql = "SELECT cityId, cityName FROM cities";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo '設備所在地：<select name="equipmentLocation" id="equipmentLocation">';
            if (!empty($currentCityName)) {
                echo '<option value="' . $cityId . '">' . $currentCityName . '</option>';
            }
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['cityId'] != $cityId) {
                    echo '<option value="' . $row['cityId'] . '">' . $row['cityName'] . '</option>';
                }
            }
            echo '</select><br />';
        } else {
            echo "沒有找到縣市資料。";
        }
        ?>
        設備名稱：<input type="text" name="equipmentName" id="equipmentName" value="<?php echo $equipmentName ?>"><br />
        設備描述：<input type="text" name="equipmentDescription" id="equipmentDescription" value="<?php echo $equipmentDescription ?>"><br />
        設備價格：<input type="text" name="equipmentPrice" id="equipmentPrice" value="<?php echo $equipmentPrice ?>"><br />
        設備標籤：
        <?php
        require_once '../conn.php';

        // 取得所有標籤
        $sql_allLabel = "SELECT labelId, labelName FROM labels WHERE labelType = '設備'";
        $result_allLabel = mysqli_query($conn, $sql_allLabel);
        $allLabels = mysqli_fetch_all($result_allLabel, MYSQLI_ASSOC);

        // 取得該設備的標籤
        $sql_equipmentLabel = "SELECT labelId FROM equipments_labels WHERE equipmentId = '$equipmentId'";
        $result_equipmentLabel = mysqli_query($conn, $sql_equipmentLabel);
        $selectedLabels = array();

        if (mysqli_num_rows($result_equipmentLabel) > 0) {
            while ($row = mysqli_fetch_assoc($result_equipmentLabel)) {
                $selectedLabels[] = $row['labelId'];
            }
        }
        ?>
        請選擇標籤：<br />
        <select id="tags-select" name="tags[]" multiple style="width: 100%;">
            <?php foreach ($allLabels as $row) : ?>
                <?php $selected = (!empty($selectedLabels) && in_array($row['labelId'], $selectedLabels)) ? 'selected' : ''; ?>
                <option value="<?php echo $row['labelId']; ?>" <?php echo $selected; ?>><?php echo $row['labelName']; ?></option>
            <?php endforeach; ?>
        </select>



        請上傳圖片：<input type="file" name="files[]" multiple onchange="previewImage(event)"><br />
        <div id="preview"></div>
        <?php
        $sql_query = "SELECT * FROM files WHERE equipmentId = '$equipmentId'";
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function deleteFile(fileId) {
            if (confirm('確定要刪除此圖片？')) {
                $.post('', {
                    deleteFileId: fileId
                }, function(data) {
                    // Remove image from DOM instead of reloading the page
                    $('#image-' + fileId).remove();
                });
            }
        }

        $('#formAdd').submit(function() {
            $(this).find(':submit').attr('disabled', 'disabled');
            return true;
        }).submit(function() {
            $(this).find(':submit').removeAttr('disabled');
        });

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
</body>

</html>