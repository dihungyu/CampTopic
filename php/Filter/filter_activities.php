<?php
require_once "../conn.php";

$labelIds = isset($_POST['labelIds']) ? json_decode($_POST['labelIds']) : null;
$accountId = $_POST['accountId'];

function get_img_src($accountId, $conn)
{
    $pic_sql = "SELECT `filePath` FROM `files` WHERE `accountId` = '$accountId' ORDER BY `fileCreateDate` DESC LIMIT 1";
    $pic_result = mysqli_query($conn, $pic_sql);

    if ($pic_row = mysqli_fetch_assoc($pic_result)) {
        $img_src = $pic_row["filePath"];
        $img_src = str_replace("../", "", $img_src);
        $img_src = "../" . $img_src;
    } else {
        $img_src = "../../upload/profileDefault.jpeg";
    }

    return $img_src;
}

if ($labelIds != null) {
    // 根據所選標籤從資料庫獲取符合條件的營地
    $sql_campsiteIds = "SELECT DISTINCT campsiteId FROM campsites_labels WHERE labelId IN ('" . implode("','", $labelIds) . "')";
    $result_campsiteIds = mysqli_query($conn, $sql_campsiteIds);
    $campsiteIds = [];

    while ($row_campsiteId = mysqli_fetch_assoc($result_campsiteIds)) {
        $campsiteIds[] = $row_campsiteId['campsiteId'];
    }

    // 使用查詢結果中的 campsiteId 查詢 activities 資料表
    $sql_activities = "SELECT * FROM activities LEFT JOIN accounts ON activities.accountId = accounts.accountId LEFT JOIN campsites ON activities.campsiteId = campsites.campsiteId WHERE activities.campsiteId IN ('" . implode("','", $campsiteIds) . "') AND activities.accountId != '$accountId'";
} else {
    $sql_activities = "SELECT * FROM activities LEFT JOIN accounts ON activities.accountId = accounts.accountId LEFT JOIN campsites ON activities.campsiteId = campsites.campsiteId WHERE activities.accountId != '$accountId'";
}
$result_activities = mysqli_query($conn, $sql_activities);
$activities = [];

while ($row_activities = mysqli_fetch_assoc($result_activities)) {
    $accountId = $row_activities['accountId'];
    $img_src = get_img_src($accountId, $conn);
    if ($img_src == '') {
        $img_src = '../../upload/profileDefault.jpeg';
    }
    $row_activities['img_src'] = $img_src;
    $activities[] = $row_activities;
}

// 將篩選後的營地返回給前端
echo json_encode($activities);