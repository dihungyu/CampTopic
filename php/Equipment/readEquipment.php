<?php
require_once '../conn.php';
$sql_query = "SELECT * FROM equipments ORDER BY equipmentId ASC";
$result = mysqli_query($conn, $sql_query);
$total_records = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>設備CRUD測試</title>
</head>

<body>
    <h1 align="center">設備資料總表</h1>
    <p align="center">目前資料筆數：
        <?php echo $total_records; ?>
    </p>
    <p align="center"><a href='createEquipment.php'>新增資料</a></p>

    <table border="1" align="center">
        <tr>
            <th>設備編號</th>
            <th>帳戶編號</th>
            <th>設備圖片</th>
            <th>設備分類</th>
            <th>設備名稱</th>
            <th>設備描述</th>
            <th>設備所在地</th>
            <th>設備價格</th>
            <th>設備標籤</th>
            <th>設備建立日期</th>
            <th>設備更新日期</th>
        </tr>

        <?php
        while ($row_result = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row_result['equipmentId'] . "</td>";
            echo "<td>" . $row_result['accountId'] . "</td>";
            echo "<td>";
            $equipmentId = $row_result['equipmentId'];
            $files_query = "SELECT * FROM files WHERE equipmentId = '$equipmentId'";
            $files_result = mysqli_query($conn, $files_query);
            while ($file_result = mysqli_fetch_assoc($files_result)) {
                $file_path = str_replace('Applications/XAMPP/xamppfiles/htdocs', '../..', $file_result['filePath']);
                echo "<img src='" . $file_path . "' alt=''>";
                echo "<br>"; // 加上換行，方便閱讀
            }
            echo "</td>";
            echo "<td>" . $row_result['equipmentType'] . "</td>";
            echo "<td>" . $row_result['equipmentName'] . "</td>";
            echo "<td>" . $row_result['equipmentDescription'] . "</td>";
            echo "<td>" . $row_result['equipmentLocation'] . "</td>";
            echo "<td>" . $row_result['equipmentPrice'] . "</td>";
            echo "<td>";
            $sql_query_labels = "SELECT equipments_labels.labelId, labels.labelName
            FROM equipments_labels
            JOIN labels ON equipments_labels.labelId = labels.labelId
            WHERE equipments_labels.equipmentId = '$equipmentId'";
            $result_labels = mysqli_query($conn, $sql_query_labels);
            while ($tags_row = mysqli_fetch_assoc($result_labels)) {

                echo $tags_row['labelName'];
                echo "<br>";
            }
            echo "<td>" . $row_result['equipmentCreateDate'] . "</td>";
            echo "<td>" . $row_result['equipmentUpdateDate'] . "</td>";
            echo "<td><a href='updateEquipment.php?equipmentId=" . $row_result['equipmentId'] . "'>修改</a> ";
            echo "<a href='deleteEquipment.php?equipmentId=" . $row_result['equipmentId'] . "'>刪除</a></td>";
            echo "</tr>";
        }
        ?>

    </table>
</body>

</html>