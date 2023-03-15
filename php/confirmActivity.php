<?php
//-----------------------活動發起人審核功能-------------------------

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 載入PHPMailer類別
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/Exception.php';
require '../phpmailer/src/SMTP.php';

//Logic section
if(isset($_GET["id"])){
    $activityId = $_GET["id"]; 
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
    <table border="1" align = "center">
    <tr>
        <th>報名者編號</th>
        <th>報名者名稱</th>
        <th>性別</th>
        <th>生日</th>
        <th>相關操作</th>
    </tr>
    <?php
    //查詢有哪些報名者報名該活動，且審核狀態為Processing
    $stmt = $conn->prepare("SELECT a.accountId, a.accountName, a.accountGender, a.accountBirthday FROM accounts a JOIN activities_accounts b ON a.accountId = b.accountId WHERE b.signupStatus = 'PROCESSING' AND b.activityId = ?");
    $stmt->bind_param("s", $activityId); // 將參數綁定到查詢語句中
    $stmt->execute();
    $result = $stmt->get_result(); // 取得查詢結果

    while($row = mysqli_fetch_assoc($result)) {
        // 印出資料
        echo "<tr>";
        echo "<td>".$row['accountId']."</td>";
        echo "<td>".$row['accountName']."</td>";
        echo "<td>".$row['accountGender']."</td>";
        echo "<td>".$row['accountBirthday']."</td>";
        echo "<td><a href='confirmActivity.php?accountId=".$row['accountId']."&status=AGREE'>同意</a> ";
        echo "<a href='confirmActivity.php?accountId=".$row['accountId']."&status=REJECT'>拒絕</a></td>'";
        echo "</tr>";
    }

    if(isset($_GET["status"], $_GET["accountId"]) && $_GET["status"] == "AGREE"){

    //資料庫連線
    require_once("conn.php");
    
    //更新報名狀態
    $stmt = $conn->prepare("UPDATE activities_accounts SET signupStatus='AGREE' WHERE activityId = ? AND accountId = ? ");
    $stmt->bind_param("ss", $activityId, $_GET["accountId"]); // 將參數綁定到查詢語句中
    $stmt->execute();


    //官方通知mail
    $officialEmail = "dihung0921@yahoo.com.tw";

    // 取得活動報名者信箱
    // 使用JOIN語句來避免進行兩個SQL查詢
    // 使用參數化查詢來避免SQL注入攻擊

    $stmt = $conn->prepare("SELECT a.accountEmail FROM accounts a 
                 JOIN activities_accounts b ON b.accountId = a.accountId 
                WHERE b.activityId = ?");
    $stmt->bind_param("s", $activityId); // 將參數綁定到查詢語句中
    $stmt->execute();
    $result = $stmt->get_result(); // 取得查詢結果

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $activityApplicantEmail = $row["accountEmail"]; // 活動發起者信箱
    } 
    else {
    // 找不到符合條件的資料
    http_response_code(404);
    }

    // 建立PHPMailer對象
    $mail = new PHPMailer(true);

    try {
        // 郵件設置
        $mail->isSMTP();                                            // 設置使用SMTP發送郵件
        $mail->Host       = 'smtp.mail.yahoo.com';                       // SMTP服務器地址
        $mail->SMTPAuth   = true;                                   // 啟用SMTP驗證
        $mail->Username   = $officialEmail;                   // 發送方郵箱地址
        $mail->Password   = 'pdknaazebckinydd';                         // 發送方郵箱密碼
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // SMTP加密方式
        $mail->Port       = 587;                                    // SMTP端口號
        $mail->CharSet = "UTF-8";
        $mail->Encoding = "base64";


        // 收件人、主題、內容設置
        $mail->setFrom($officialEmail, '營在起跑點');
        $mail->addAddress($activityApplicantEmail);                    // 收件人郵箱地址
        $mail->addReplyTo($officialEmail, '營在起跑點');        //預設收件人回覆地址
        $mail->Subject = '報名成功通知';
        $mail->Body    = '您報名的活動已通過審核，請儘速到我們的網站做確認，謝謝！';

        // 發送郵件
        $mail->send();
        echo '郵件已成功發送。';
    } catch (Exception $e) {
        echo "郵件發送失敗：{$mail->ErrorInfo}";
    }
}
else{

    //資料庫連線
    require_once("conn.php");
    
    //更新報名狀態
    $stmt = $conn->prepare("UPDATE activities_accounts SET signupStatus='REJECT' WHERE activityId = ? AND accountId = ? ");
    $stmt->bind_param("ss", $activityId, $_GET["accountId"]); // 將參數綁定到查詢語句中
    $stmt->execute();


    //官方通知mail
    $officialEmail = "dihung0921@yahoo.com.tw";

    // 取得活動報名者信箱
    // 使用JOIN語句來避免進行兩個SQL查詢
    // 使用參數化查詢來避免SQL注入攻擊

    $stmt = $conn->prepare("SELECT a.accountEmail FROM accounts a 
                 JOIN activities_accounts b ON b.accountId = a.accountId 
                WHERE b.activityId = ?");
    $stmt->bind_param("s", $activityId); // 將參數綁定到查詢語句中
    $stmt->execute();
    $result = $stmt->get_result(); // 取得查詢結果

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $activityApplicantEmail = $row["accountEmail"]; // 活動發起者信箱
    } 
    else {
    // 找不到符合條件的資料
    http_response_code(404);
    }

    // 建立PHPMailer對象
    $mail = new PHPMailer(true);

    try {
        // 郵件設置
        $mail->isSMTP();                                            // 設置使用SMTP發送郵件
        $mail->Host       = 'smtp.mail.yahoo.com';                       // SMTP服務器地址
        $mail->SMTPAuth   = true;                                   // 啟用SMTP驗證
        $mail->Username   = $officialEmail;                   // 發送方郵箱地址
        $mail->Password   = 'pdknaazebckinydd';                         // 發送方郵箱密碼
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // SMTP加密方式
        $mail->Port       = 587;                                    // SMTP端口號
        $mail->CharSet = "UTF-8";
        $mail->Encoding = "base64";


        // 收件人、主題、內容設置
        $mail->setFrom($officialEmail, '營在起跑點');
        $mail->addAddress($activityApplicantEmail);                    // 收件人郵箱地址
        $mail->addReplyTo($officialEmail, '營在起跑點');        //預設收件人回覆地址
        $mail->Subject = '報名駁回通知';
        $mail->Body    = '您報名的活動經審核未通過，請儘速到我們的網站做確認，謝謝！';

        // 發送郵件
        $mail->send();
        echo '郵件已成功發送。';
    } catch (Exception $e) {
        echo "郵件發送失敗：{$mail->ErrorInfo}";
    }

}
    ?>
    </table>

</body>
</html>