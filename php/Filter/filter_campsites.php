<?php
require_once "../conn.php";

function format_count($count)
{
    if ($count < 1000) {
        return $count;
    } elseif ($count < 1000000) {
        return round($count / 1000, 1) . 'k';
    } else {
        return round($count / 1000000, 1) . 'm';
    }
}

$labelIds = isset($_POST['labelIds']) ? json_decode($_POST['labelIds']) : null;
$accountId = $_POST['accountId'];

if ($labelIds != null) {
    $sql_campsiteIds = "SELECT DISTINCT campsiteId FROM campsites_labels WHERE labelId IN ('" . implode("','", $labelIds) . "')";
    $result_campsiteIds = mysqli_query($conn, $sql_campsiteIds);
    $campsiteIds = [];

    while ($row_campsiteId = mysqli_fetch_assoc($result_campsiteIds)) {
        $campsiteIds[] = $row_campsiteId['campsiteId'];
    }

    $sql_campsites = "SELECT * FROM campsites LEFT JOIN accounts ON campsites.accountId = accounts.accountId WHERE isReviewed = 1 AND campsites.campsiteId IN ('" . implode("','", $campsiteIds) . "') AND campsites.accountId != '$accountId'";
} else {
    $sql_campsites = "SELECT * FROM campsites LEFT JOIN accounts ON campsites.accountId = accounts.accountId WHERE isReviewed = 1 AND campsites.accountId != '$accountId'";
}

$result_campsites = mysqli_query($conn, $sql_campsites);
$campsites = [];

$camp_collect_sql = "SELECT `campsiteId` FROM `collections` WHERE `accountId` = '$accountId'";
$camp_collect_result = mysqli_query($conn, $camp_collect_sql);
$collectedCamps = array();
while ($row = mysqli_fetch_assoc($camp_collect_result)) {
    $collectedCamps[] = $row['campsiteId'];
}

$camp_like_sql = "SELECT `campsiteId` FROM `likes` WHERE `accountId` = '$accountId'";
$camp_like_result = mysqli_query($conn, $camp_like_sql);
$likedCamps = array();
while ($row = mysqli_fetch_assoc($camp_like_result)) {
    $likedCamps[] = $row['campsiteId'];
}

while ($campsiteData = mysqli_fetch_assoc($result_campsites)) {
    //若文章內容超過30字做限制
    $content_length = mb_strlen(strip_tags($campsiteData["campsiteDescription"]), 'UTF-8');
    if ($content_length > 30) {
        $isReviewed_content = mb_substr(strip_tags($campsiteData["campsiteDescription"]), 0, 80, 'UTF-8') . '...'; // 截斷文章內容
    } else {
        $isReviewed_content = strip_tags($campsiteData["campsiteDescription"]);
    }

    $isCampCollected = in_array($campsiteData["campsiteId"], $collectedCamps);
    $isCampLiked = in_array($campsiteData["campsiteId"], $likedCamps);

    $files_query = "SELECT filePath FROM files WHERE campsiteId = '" . $campsiteData['campsiteId'] . "' AND filePathType = 'campsiteCover' ORDER BY fileCreateDate DESC LIMIT 1";
    $files_result = mysqli_query($conn, $files_query);
    if ($file_row = mysqli_fetch_assoc($files_result)) {
        $cover_src = $file_row["filePath"];
    } else {
        $cover_src = "images/Rectangle 137.png";
    }


    $sql_query_labels = "SELECT campsites_labels.labelId, labels.labelName
                          FROM campsites_labels
                          JOIN labels ON campsites_labels.labelId = labels.labelId
                          WHERE campsites_labels.campsiteId = '" . $campsiteData['campsiteId'] . "'";
    $result_labels = mysqli_query($conn, $sql_query_labels);
    $tags = [];
    while ($tags_row = mysqli_fetch_assoc($result_labels)) {
        $tags[] = $tags_row['labelName'];
    }

    $campsites[] = [
        'campsiteId' => $campsiteData['campsiteId'],
        'campsiteName' => $campsiteData['campsiteName'],

        'campsiteDescription' => $isReviewed_content,
        'campsiteLowerLimit' => number_format($campsiteData['campsiteLowerLimit']),
        'campsiteLikeCount' => format_count($campsiteData['campsiteLikeCount']),
        'img_src' => $cover_src,
        'isCampCollected' => $isCampCollected,
        'isCampLiked' => format_count($isCampLiked),
        'tags' => $tags
    ];
}

echo json_encode($campsites);