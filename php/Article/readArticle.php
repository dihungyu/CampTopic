<?php
require_once '../conn.php';
$sql_query = "SELECT * FROM articles ORDER BY articleId ASC";
$result = mysqli_query($conn, $sql_query);
$total_records = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>文章CRUD測試</title>
</head>

<body>
    <h1 align="center">文章資料總表</h1>
    <p align="center">目前資料筆數：
        <?php echo $total_records; ?>
    </p>
    <p align="center"><a href='createArticle.php'>新增資料</a></p>

    <table border="1" align="center">
        <tr>
            <th>文章編號 </th>
            <th>帳戶編號</th>
            <th>文章分類 </th>
            <th>文章圖片</th>
            <th>文章標題 </th>
            <th>文章內容 </th>
            <th>文章建立日期 </th>
            <th>文章更新日期 </th>
            <th>文章收藏次數 </th>
            <th>文章喜愛次數 </th>
            <th>相關操作</th>
        </tr>

        <?php
        while ($row_result = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row_result['articleId'] . "</td>";
            echo "<td>" . $row_result['accountId'] . "</td>";
            echo "<td>";
            $articleId = $row_result['articleId'];
            $files_query = "SELECT * FROM files WHERE articleId = '$articleId'";
            $files_result = mysqli_query($conn, $files_query);
            while ($file_result = mysqli_fetch_assoc($files_result)) {
                $file_path = str_replace('Applications/XAMPP/xamppfiles/htdocs', '../..', $file_result['filePath']);
                echo "<img src='" . $file_path . "' alt=''>";
                echo "<br>"; // 加上換行，方便閱讀
            }
            echo "</td>";
            echo "<td>" . $row_result['articleType'] . "</td>";
            echo "<td>" . $row_result['articleTitle'] . "</td>";
            echo "<td>" . $row_result['articleContent'] . "</td>";
            echo "<td>" . $row_result['articleCreateDate'] . "</td>";
            echo "<td>" . $row_result['articleUpdateDate'] . "</td>";
            echo "<td>" . $row_result['articleCollectCount'] . "</td>";
            echo "<td>" . $row_result['articleLikeCount'] . "</td>";
            echo "<td><a href='updateArticle.php?articleId=" . $row_result['articleId'] . "'>修改</a> ";
            echo "<a href='deleteArticle.php?articleId=" . $row_result['articleId'] . "'>刪除</a></td>";
            echo "</tr>";
        }
        ?>

    </table>
</body>

</html>