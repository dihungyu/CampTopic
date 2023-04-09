<?php
//-----------------------活動發起人審核功能-------------------------

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 載入PHPMailer類別
require '../../phpmailer/src/PHPMailer.php';
require '../../phpmailer/src/Exception.php';
require '../../phpmailer/src/SMTP.php';

//Logic section
if (isset($_GET["activityId"])) {
    $activityId = $_GET["activityId"];
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>審核參加者介面</title>
</head>

<body>
    <table border="1" align="center">
        <tr>
            <th>報名者編號</th>
            <th>報名者名稱</th>
            <th>性別</th>
            <th>生日</th>
            <th>相關操作</th>
        </tr>
        <?php
        require_once '../conn.php';
        //查詢有哪些報名者報名該活動，且審核狀態為Processing
        $stmt = $conn->prepare("SELECT a.accountId, a.accountName, a.accountGender, a.accountBirthday FROM accounts a JOIN activities_accounts b ON a.accountId = b.accountId WHERE b.signupStatus = 'PROCESSING' AND b.activityId = ?");
        $stmt->bind_param("s", $activityId); // 將參數綁定到查詢語句中
        $stmt->execute();
        $result = $stmt->get_result(); // 取得查詢結果
        
        while ($row = mysqli_fetch_assoc($result)) {
            // 印出資料
            echo "<tr>";
            echo "<td>" . $row['accountId'] . "</td>";
            echo "<td>" . $row['accountName'] . "</td>";
            echo "<td>" . $row['accountGender'] . "</td>";
            echo "<td>" . $row['accountBirthday'] . "</td>";
            echo "<td><a href='confirmpage.php?activityId=" . $activityId . "&accountId=" . $row['accountId'] . "&status=AGREE'>同意</a> ";
            echo "<a href='confirmpage.php?activityId=" . $activityId . "&accountId=" . $row['accountId'] . "&status=REJECT'>拒絕</a></td>";
            echo "</tr>";
        }


        ?>
    </table>

</body>

</html>