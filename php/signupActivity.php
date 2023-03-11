<?php
if(isset($_GET["id"])){
    $activityId = $_GET["id"]; 
}
$activityCreatorEmail = "egroup.intern.ryancho@gmail.com";
$activityApplicantEmail = "dihung0921@yahoo.com.tw";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 載入PHPMailer類別
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/Exception.php';
require '../phpmailer/src/SMTP.php';

if(isset($_POST["submit"])){
    // 建立PHPMailer對象
    $mail = new PHPMailer(true);

    try {
        // 郵件設置
        $mail->isSMTP();                                            // 設置使用SMTP發送郵件
        $mail->Host       = 'smtp.mail.yahoo.com';                       // SMTP服務器地址
        $mail->SMTPAuth   = true;                                   // 啟用SMTP驗證
        $mail->Username   = $activityApplicantEmail;                   // 發送方郵箱地址
        $mail->Password   = 'pdknaazebckinydd';                         // 發送方郵箱密碼
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // SMTP加密方式
        $mail->Port       = 587;                                    // SMTP端口號
        $mail->CharSet = "UTF-8";
        $mail->Encoding = "base64";


        // 收件人、主題、內容設置
        $mail->setFrom('dihung0921@yahoo.com.tw', '測試者');
        $mail->addAddress($activityCreatorEmail);                    // 收件人郵箱地址
        $mail->addReplyTo('dihung0921@yahoo.com.tw', '測試者');        //預設收件人回覆地址
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