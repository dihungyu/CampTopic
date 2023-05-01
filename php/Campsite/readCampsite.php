<?php
require_once '../conn.php';
$sql_query = "SELECT * FROM campsites ORDER BY CAST(campsiteId AS SIGNED) ASC";
$result = mysqli_query($conn, $sql_query);
$total_records = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>營區CRUD測試</title>
</head>

<body>
    <h1 align="center">營區資料總表</h1>
    <p align="center">目前資料筆數：
        <?php echo $total_records; ?>
    </p>
    <p align="center"><a href='createCampsite.php'>新增資料</a></p>

    <table border="1" align="center">
        <tr>
            <th>營區編號</th>
            <th>營區圖片</th>
            <th>縣市編號</th>
            <th>營區名稱</th>
            <th>營區介紹</th>
            <th>營區地址</th>
            <th>營區地址地圖連結</th>
            <th>營區介紹影片連結</th>
            <th>營區更新日期</th>
            <th>營區收藏次數</th>
            <th>營區喜愛次數</th>
            <th>營區價格下限</th>
            <th>營區價格上限</th>
            <th>營區相關標籤</th>
            <th>相關操作</th>
        </tr>

        <?php
        while ($row_result = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row_result['campsiteId'] . "</td>";
            echo "<td>";
            $campsiteId = $row_result['campsiteId'];
            $files_query = "SELECT * FROM files WHERE campsiteId = '$campsiteId'";
            $files_result = mysqli_query($conn, $files_query);
            while ($file_result = mysqli_fetch_assoc($files_result)) {
                $file_path = str_replace('Applications/XAMPP/xamppfiles/htdocs', '../..', $file_result['filePath']);
                echo "<img src='" . $file_path . "' alt=''>";
                echo "<br>"; // 加上換行，方便閱讀
            }
            echo "</td>";
            echo "<td>" . $row_result['cityId'] . "</td>";
            echo "<td>" . $row_result['campsiteName'] . "</td>";
            echo "<td>" . $row_result['campsiteDescription'] . "</td>";
            echo "<td>" . $row_result['campsiteAddress'] . "</td>";
            echo "<td>" . $row_result['campsiteAddressLink'] . "</td>";
            echo "<td>" . $row_result['campsiteVideoLink'] . "</td>";
            echo "<td>" . $row_result['campsiteUpdateDate'] . "</td>";
            echo "<td>" . $row_result['campsiteCollectCount'] . "</td>";
            echo "<td>" . $row_result['campsiteLikeCount'] . "</td>";
            echo "<td>" . $row_result['campsiteLowerLimit'] . "</td>";
            echo "<td>" . $row_result['campsiteUpperLimit'] . "</td>";
            echo "<td>";
            $sql_query_labels = "SELECT campsites_labels.labelId, labels.labelName
            FROM campsites_labels
            JOIN labels ON campsites_labels.labelId = labels.labelId
            WHERE campsites_labels.campsiteId = '$campsiteId'";
            $result_labels = mysqli_query($conn, $sql_query_labels);
            while ($tags_row = mysqli_fetch_assoc($result_labels)) {

                echo $tags_row['labelName'];
                echo "<br>";
            }
            echo "</td>"; //此處需改為放相關標籤
            echo "<td><a href='updateCampsite.php?campsiteId=" . $row_result['campsiteId'] . "'>修改</a> ";
            echo "<a href='deleteCampsite.php?campsiteId=" . $row_result['campsiteId'] . "'>刪除</a></td>";
            echo "</tr>";
        }
        ?>

    </table>
</body>

</html>