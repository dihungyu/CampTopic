<?php
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

if(isset($_POST["submit"])){

    //資料庫連線
    require_once("conn.php");
    //官方通知mail
    $officialEmail = "dihung0921@yahoo.com.tw";

    // 取得活動發起者信箱
    // 使用JOIN語句來避免進行兩個SQL查詢
    // 使用參數化查詢來避免SQL注入攻擊

    $stmt = $conn->prepare("SELECT accounts.accountEmail FROM activities 
                 JOIN accounts ON activities.accountId = accounts.accountId 
                WHERE activities.activityId = ?");
    $stmt->bind_param("s", $activityId); // 將參數綁定到查詢語句中
    $stmt->execute();
    $result = $stmt->get_result(); // 取得查詢結果

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $activityCreatorEmail = $row["accountEmail"]; // 活動發起者信箱
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
        $mail->addAddress($activityCreatorEmail);                    // 收件人郵箱地址
        $mail->addReplyTo($officialEmail, '營在起跑點');        //預設收件人回覆地址
        $mail->Subject = '新的報名通知';
        $mail->Body    = '有人報名了您的活動，請儘速到我們的網站做確認，謝謝！';

        // 發送郵件
        $mail->send();
        echo '郵件已成功發送。';
    } catch (Exception $e) {
        echo "郵件發送失敗：{$mail->ErrorInfo}";
    }
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>報名測試介面</title>
</head>
<body>
    <form action="signupActivity.php?id=<?= $activityId ?>" method="post" id="signupForm">
    <input type="hidden" name="submit" value="signup">
    <button onclick="confirmSignup(event)">報名</button>
</form>

<script>
    function confirmSignup(event) {
        if (confirm('確定要報名嗎？')) {
            document.getElementById('signupForm').submit();
        } else {
            event.preventDefault();
        }
    }
</script>



</body>
</html>