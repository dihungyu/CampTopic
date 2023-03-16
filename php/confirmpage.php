<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 載入PHPMailer類別
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/Exception.php';
require '../phpmailer/src/SMTP.php';

if(isset($_GET["status"], $_GET["accountId"], $_GET["activityId"]) && $_GET["status"] == "AGREE"){

    $activityId = $_GET["activityId"];
    $accountId = $_GET["accountId"];

    //資料庫連線
    require_once("conn.php");
    
    //更新報名狀態
    $stmt = $conn->prepare("UPDATE activities_accounts SET signupStatus='AGREE' WHERE activityId = ? AND accountId = ? ");
    $stmt->bind_param("ss", $activityId, $accountId); // 將參數綁定到查詢語句中
    $stmt->execute();


    //官方通知mail
    $officialEmail = "dihung0921@yahoo.com.tw";

    // 取得活動報名者信箱
    // 使用JOIN語句來避免進行兩個SQL查詢
    // 使用參數化查詢來避免SQL注入攻擊

    $stmt = $conn->prepare("SELECT a.accountEmail FROM accounts a 
                 JOIN activities_accounts b ON b.accountId = a.accountId 
                WHERE b.activityId = ? AND b.accountId = ?");
    $stmt->bind_param("ss", $activityId, $accountId); // 將參數綁定到查詢語句中
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
        if (!filter_var($activityApplicantEmail, FILTER_VALIDATE_EMAIL)) {
            echo "無效的郵件地址: " . $activityApplicantEmail;
            exit;
        }
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
elseif(isset($_GET["status"], $_GET["accountId"],$_GET["activityId"]) && $_GET["status"] == "REJECT"){

    $activityId = $_GET["activityId"];
    $accountId = $_GET["accountId"];
    
    //資料庫連線
    require_once("conn.php");
    
    //更新報名狀態
    $stmt = $conn->prepare("UPDATE activities_accounts SET signupStatus='REJECT' WHERE activityId = ? AND accountId = ? ");
    $stmt->bind_param("ss", $activityId, $accountId); // 將參數綁定到查詢語句中
    $stmt->execute();


    //官方通知mail
    $officialEmail = "dihung0921@yahoo.com.tw";

    // 取得活動報名者信箱
    // 使用JOIN語句來避免進行兩個SQL查詢
    // 使用參數化查詢來避免SQL注入攻擊

    $stmt = $conn->prepare("SELECT a.accountEmail FROM accounts a 
                 JOIN activities_accounts b ON b.accountId = a.accountId 
                WHERE b.activityId = ? AND b.accountId = ?");
    $stmt->bind_param("ss", $activityId, $accountId); // 將參數綁定到查詢語句中
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
        if (!filter_var($activityApplicantEmail, FILTER_VALIDATE_EMAIL)) {
            echo "無效的郵件地址: " . $activityApplicantEmail;
            exit;
        }
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