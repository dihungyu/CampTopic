<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 載入PHPMailer類別
require_once 'PHPMailer-master/src/PHPMailer.php';
require_once 'PHPMailer-master/src/Exception.php';
require_once 'PHPMailer-master/src/SMTP.php';

// 載入資料庫連線
require_once 'php/conn.php';


function sendCreatorSomeoneAttend($accountId, $activityId, $conn)
{
    // 官方通知郵箱
    $officialEmail = "dihung0921@yahoo.com.tw";

    // 取得收件人信箱
    $recipient_sql = "SELECT accountName, accountEmail FROM accounts WHERE accountId = '$accountId'";
    $recipient_result = $conn->query($recipient_sql);
    $recipient_row = $recipient_result->fetch_assoc();
    $recipientName = $recipient_row["accountName"];
    $recipientEmail = $recipient_row["accountEmail"];

    // 取得參加活動內容
    $activity_sql = "SELECT a.*, c.campsiteName FROM activities a JOIN campsites c ON a.campsiteId = c.campsiteId WHERE activityId = '$activityId'";
    $activity_result = $conn->query($activity_sql);
    $activity_row = $activity_result->fetch_assoc();
    $activityTitle = $activity_row["activityTitle"];

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
        $mail->addAddress($recipientEmail);                    // 收件人郵箱地址
        $mail->addReplyTo($officialEmail, '營在起跑點');        //預設收件人回覆地址
        $mail->Subject = '新的報名通知';
        $mail->Body = "親愛的 {$recipientName} 您好，

您在營在起跑點創建的活動 {$activityTitle} 有新的報名申請。

請盡快到我們的網站，進行報名申請的審核。在審核過程中，您可以查看報名人的詳細資料，確認其報名資訊的真實性和完整性，並且對報名進行審核。

如有任何疑問或需要我們的協助，請隨時與我們聯繫。我們期待您能夠對報名進行審核，並且在活動中與參加者共度美好時光。

謝謝您的支持和理解，祝您一切順利。

營在起跑點敬上";


        // 發送郵件
        $mail->send();
        echo '郵件已成功發送。';
    } catch (Exception $e) {
        echo "郵件發送失敗：{$mail->ErrorInfo}";
    }
}

function sendAttendeeConfirmSucess($accountId, $activityId, $conn)
{
    // 官方通知郵箱
    $officialEmail = "dihung0921@yahoo.com.tw";

    // 取得收件人信箱
    $recipient_sql = "SELECT a.accountName, b.attendeeEmail FROM accounts a JOIN activities_accounts b ON a.accountId = b.accountId  WHERE a.accountId = '$accountId' AND b.activityId = '$activityId'";
    $recipient_result = $conn->query($recipient_sql);
    $recipient_row = $recipient_result->fetch_assoc();
    $recipientName = $recipient_row["accountName"];
    $recipientEmail = $recipient_row["attendeeEmail"];

    // 取得參加活動內容
    $activity_sql = "SELECT a.*, c.campsiteName FROM activities a JOIN campsites c ON a.campsiteId = c.campsiteId WHERE activityId = '$activityId'";
    $activity_result = $conn->query($activity_sql);
    $activity_row = $activity_result->fetch_assoc();
    $activityTitle = $activity_row["activityTitle"];
    $activityStartDate = $activity_row["activityStartDate"];
    $activityEndDate = $activity_row["activityEndDate"];
    $activityLocation = $activity_row["campsiteName"];


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
        $mail->addAddress($recipientEmail);                    // 收件人郵箱地址
        $mail->addReplyTo($officialEmail, '營在起跑點');        //預設收件人回覆地址
        $mail->Subject = '活動報名成功通知！';
        $mail->Body = "親愛的 {$recipientName} 您好，

感謝您的參加 {$activityTitle} 活動！以下是活動詳細資訊：

活動日期：{$activityStartDate} 至 {$activityEndDate}
活動地點：{$activityLocation}

請務必於報到時間前到達活動地點進行報到，如有任何問題請隨時與我們聯繫。在活動出發前，您還可以隨時登入我們的網站，查看活動的最新詳情和通知。

祝您玩得愉快，期待在活動現場與您相見！

營在起跑點敬上";


        // 發送郵件
        $mail->send();
        echo '郵件已成功發送。';
    } catch (Exception $e) {
        echo "郵件發送失敗：{$mail->ErrorInfo}";
    }
}

function sendAttendeeConfirmReject($accountId, $activityId, $conn)
{
    // 官方通知郵箱
    $officialEmail = "dihung0921@yahoo.com.tw";

    // 取得收件人信箱
    $recipient_sql = "SELECT a.accountName, b.attendeeEmail FROM accounts a JOIN activities_accounts b ON a.accountId = b.accountId  WHERE a.accountId = '$accountId' AND b.activityId = '$activityId'";
    $recipient_result = $conn->query($recipient_sql);
    $recipient_row = $recipient_result->fetch_assoc();
    $recipientName = $recipient_row["accountName"];
    $recipientEmail = $recipient_row["attendeeEmail"];

    // 取得參加活動內容
    $activity_sql = "SELECT a.*, c.campsiteName FROM activities a JOIN campsites c ON a.campsiteId = c.campsiteId WHERE activityId = '$activityId'";
    $activity_result = $conn->query($activity_sql);
    $activity_row = $activity_result->fetch_assoc();
    $activityTitle = $activity_row["activityTitle"];
    $activityStartDate = $activity_row["activityStartDate"];
    $activityEndDate = $activity_row["activityEndDate"];

    // 刪除活動報名紀錄
    $delete_sql = "DELETE FROM activities_accounts WHERE accountId = '$accountId' AND activityId = '$activityId'";
    $conn->query($delete_sql);

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
        $mail->addAddress($recipientEmail);                    // 收件人郵箱地址
        $mail->addReplyTo($officialEmail, '營在起跑點');        //預設收件人回覆地址
        $mail->Subject = '活動報名駁回通知';
        $mail->Body = "親愛的 {$recipientName} 您好，

我們很抱歉地告訴您，您先前報名的活動 

活動名稱： {$activityTitle}
時間： {$activityStartDate} ~ {$activityEndDate} 

目前未能通過審核，故暫時無法參加。以下是一些可能的原因：

- 您的報名資訊不完整或不符合活動發起人的要求
- 活動名額已滿，您未能及時完成報名

如果您對於審核結果有任何疑問或建議，請隨時與我們聯繫。在此期間，您也可以隨時登入我們的網站，查看其他活動的詳情和報名資訊。我們期待未來有機會為您服務。

謝謝您的支持和理解，祝您一切順利。

營在起跑點敬上";


        // 發送郵件
        $mail->send();
        echo '郵件已成功發送。';
    } catch (Exception $e) {
        echo "郵件發送失敗：{$mail->ErrorInfo}";
    }
}
