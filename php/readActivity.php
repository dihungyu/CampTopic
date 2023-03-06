<?php
   include("conn.php");

   // 更新 activityIsOpen 的值
   $update_query = "UPDATE activities SET activityIsOpen = CASE WHEN activityStartDate <= NOW() AND NOW() <= activityEndDate THEN 1 ELSE 0 END";
   mysqli_query($conn, $update_query);

   // 取得所有資料
   $sql_query = "SELECT * FROM activities ORDER BY activityId ASC";
   $result = mysqli_query($conn,$sql_query);
   $total_records = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>活動資料CRUD測試</title>
</head>
<body>
<h1 align = "center">活動資料總表</h1>
<p align= "center">目前資料筆數：<?php echo $total_records;?></p>
<p align= "center"><a href='createActivity.php'>新增資料</a></p>

<table border="1" align = "center">
    <tr>
        <th>活動編號</th>
        <th>活動建立者帳戶編號</th>
        <th>路線編號</th>
        <th>活動名稱</th>
        <th>活動介紹</th>
        <th>活動開始日期</th>
        <th>活動結束日期</th>
        <th>活動報名截止日期</th>
        <th>活動是否開啟</th>
        <th>活動出席人數</th>
        <th>相關操作</th>
    </tr>
<?php

while($row_result = mysqli_fetch_assoc($result)) {

    // 取出更新後的 activityIsOpen 值
    $activity_is_open = ($row_result['activityIsOpen'] == 1) ? "是" : "否";

    // 印出資料
    echo "<tr>";
    echo "<td>".$row_result['activityId']."</td>";
    echo "<td>".$row_result['accountId']."</td>";
    echo "<td>".$row_result['routeId']."</td>";
    echo "<td>".$row_result['activityTitle']."</td>";
    echo "<td>".$row_result['activityDescription']."</td>";
    echo "<td>".$row_result['activityStartDate']."</td>";
    echo "<td>".$row_result['activityEndDate']."</td>";
    echo "<td>".$row_result['activityDeadLineDate']."</td>";
    echo "<td>".$activity_is_open."</td>";
    echo "<td>".$row_result['activityAttendence']."</td>";
    echo "<td><a href='updateActivity.php?id=".$row_result['activityId']."'>修改</a> ";
    echo "<a href='deleteActivity.php?id=".$row_result['activityId']."'>刪除</a></td>";
    echo "</tr>";
}
?>
</table>
</body>
</html>