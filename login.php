<?php
session_start();

if($_POST["FormType"]=="Login"){
	// 確認使用者提交的表單中，是否填寫了帳號和密碼欄位
	if (isset($_POST["accountEmail"], $_POST["accountPassword"])) {

    	// 從 POST 取得填寫的帳號和密碼
    	$accountEmail = $_POST["accountEmail"];
    	$accountPassword = $_POST["accountPassword"];

		//引入資料庫設定
		require_once("php/conn.php");

    	// 搜尋資料庫中是否有符合帳號的資料
    	$stmt = $conn->prepare("SELECT * FROM accounts WHERE accountEmail = ?");
    	$stmt->bind_param("s", $accountEmail);
    	$stmt->execute();
    	$result = $stmt->get_result();

    	// 若有符合的資料，則比對密碼是否正確
    	if ($row = $result->fetch_assoc()) {
        	if (password_verify($accountPassword, $row["accountPassword"])) {

            	// 將使用者資料存入 session，並轉址至首頁
            	$_SESSION["accountName"] = $row["accountName"];
            	$_SESSION["accountEmail"] = $row["accountEmail"];
            	$_SESSION["accountPhoneNumber"] = $row["accountPhoneNumber"];
            	$_SESSION["accountPassword"] = $row["accountPassword"];
            	$_SESSION["accountLevel"] = $row["accountLevel"];
            	header("location:../index.html");
        	} 
			else {
				// 若密碼不正確，則顯示錯誤訊息，並轉址至登入頁面
            	echo "<script>{window.alert('密碼錯誤！請再試一次'); location.href='login.php#login'}</script>";
			}
    	} 
		else {
        	// 若帳號不存在，則顯示錯誤訊息，並轉址至註冊頁面
        	echo "<script>{window.alert('此電子信箱尚未註冊！請先註冊帳號'); location.href='login.php#register'}</script>";
		}
	}
}
elseif($_POST["FormType"]== "Register"){
	//確認前端表單傳送不是空值
	if (isset($_POST["accountName"])&& isset($_POST["accountGender"])&& isset($_POST["accountBirthday"])&& isset($_POST["accountEmail"]) && isset($_POST["accountPhoneNumber"]) && isset($_POST["accountPassword"])) {

    	//變數設定
    	$accountName = $_POST["accountName"];
    	$accountGender = $_POST["accountGender"];
    	$accountBirthday = $_POST["accountBirthday"];
    	$accountEmail = $_POST["accountEmail"];
    	$accountPhoneNumber = $_POST["accountPhoneNumber"];
    	$accountPassword = $_POST["accountPassword"];

    	//加密密碼
    	$hashedPassword = password_hash($accountPassword, PASSWORD_DEFAULT);

    	//引入資料庫設定
    	require_once("php/conn.php");

    	//檢查資料庫內是否已有帳戶
    	$stmt = $conn->prepare("SELECT accountEmail FROM accounts WHERE accountEmail = ?");
    	$stmt->bind_param("s", $accountEmail);
    	$stmt->execute();
    	$result = $stmt->get_result();

    	if (mysqli_num_rows($result) >= 1) {
       		echo "<script>{window.alert('此信箱已被註冊！請換信箱再試一次'); location.href='login.php#register'}</script>";
    	} 
		else {
        	$stmt = $conn->prepare("INSERT INTO accounts(accountId, accountName, accountGender, accountBirthday, accountPassword, accountEmail, accountPhoneNumber) VALUES ( REPLACE(UUID(),'-',''), ?,?,?,?,?,?)");
        	$stmt->bind_param("ssssss", $accountName, $accountGender, $accountBirthday, $hashedPassword, $accountEmail, $accountPhoneNumber);
        	if ($stmt->execute()) {
            echo "<script>{window.alert('註冊成功！'); location.href='login.php#login'}</script>";
        	} 
			else {
            echo "Error: " . $stmt->error;
        	}
    	}
	}
}
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="colorlib">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>營在起跑點</title>

	<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
	<!-- =========CSS======== -->
	<link rel="stylesheet" href="css/linearicons.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/magnific-popup.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<link rel="stylesheet" href="css/nice-select.css">
	<link rel="stylesheet" href="css/animate.min.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/main.css">


</head>

<body>
	
	<section class="banner-area relative" >
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<div class="row fullscreen align-items-center justify-content-between">
				<div class="col-lg-5 col-md-6 banner-left">
					<h5 class="text-white" style="font-family: Arial Black, sans-serif;">Start Camping</h5>
					<h1 class="text-white" style="font-size: 40px;">營在起跑點</h1>
					<p class="text-white" style="font-size: 14px;">
					邀請你一同進入露營的世界，快速開始一趟冒險旅程，多處地點一覽，不怕踩雷，讓你能夠「營」在起跑點！☺ ☺ ☺
					</p>

				</div>
				<div class="col-lg-5 col-md-10 banner-right">
					
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
							<form class="form-wrap" method="post" action="login.php" style="padding: 40px 35px;">
							<h4 style="text-align: center; margin-left: 12px; margin-bottom: 24px; color: ">歡迎回來！</h4>
								<input type="hidden" name="FormType" value="Login" >
								
								<input type="email" class="form-control" style="margin-bottom:10px; border-radius: 25px; background-color:#f1f1f1f1; padding: 0.675rem 1.75rem; " name="accountEmail" placeholder="電子信箱"
									onfocus="this.placeholder = ''" onblur="this.placeholder = '電子信箱 '" required>

								<input type="password" class="form-control" name="accountPassword" style="margin-bottom:5px; border-radius: 25px;background-color:#f1f1f1f1; padding: 0.675rem 1.75rem;" placeholder="密碼"
									onfocus="this.placeholder = ''" onblur="this.placeholder = '密碼'" required>
								<button class="primary-btn text-uppercase"
								style="background-color: #EFE9DA; color: black; border-radius: 25px; width:225px;  margin-top: 20px;  margin-right: 5px;">登入</button>

								<button class="primary-btn text-uppercase"
								style="background-color: #fff; border-radius: 25px; width:140px; border: solid; border-color: #EFE9DA;" ><a href="register.php" style="color: #808080; font-weight: 400;" >尚未註冊？</a></button>
							
							</form>
						</div>
						
						<div class="tab-pane fade" id="register"  role="tabpanel" aria-labelledby="register-tab">
							<form class="form-wrap" method="post" action="login.php" onsubmit="return checkPassword()" >
							<h4 style="text-align: center; margin-left: 12px; margin-bottom: 24px; color: ">加入我們！</h4>
								<input type="hidden" name="FormType" value="Register">
								

								<input type="text" class="form-control" style="margin-bottom:10px; border-radius: 25px; background-color:#f1f1f1f1; padding: 0.675rem 1.75rem; name="accountName" placeholder="名稱"
									onfocus="this.placeholder = ''" onblur="this.placeholder = '名稱'" required>
								

								<input type="email" class="form-control Email" style="margin-bottom:10px; border-radius: 25px; background-color:#f1f1f1f1; padding: 0.675rem 1.75rem; name="accountEmail" placeholder="電子信箱"
									onfocus="this.placeholder = ''" onblur="this.placeholder = '電子信箱 '" required>
								<input type="tel" class="form-control phone" style="margin-bottom:10px; border-radius: 25px; background-color:#f1f1f1f1; padding: 0.675rem 1.75rem;
									name="accountPhoneNumber" placeholder="電話" onfocus="this.placeholder = ''"
									onblur="this.placeholder = '電話'" required>
							<input type="date"  class="form-control " name="accountBirthday" id="birthday" style="width:200px; margin-bottom:10px; border-radius: 25px; background-color:#f1f1f1f1; padding: 0.675rem 1.75rem;" required>
							<div class="form-check form-check-inline" style=" position:relative;  left: 110px; top: -40px;">
							<input class="form-check-input" type="radio" name="accountGender" value="Female" style="text-align: left;" required>
							<label class="form-check-label"  for="Female">女性</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input class="form-check-input" type="radio"name="accountGender" value="Male" required>
							<label  class="form-check-label" for="Male">男性</label></div>
							<hr>
							<input type="password" class="form-control " style="margin-bottom:10px; border-radius: 25px; background-color:#f1f1f1f1; padding: 0.675rem 1.75rem;
									name="accountPassword" placeholder="密碼" onfocus="this.placeholder = ''"
									onblur="this.placeholder = '密碼'" id="accountPassword" required>
								<input type="password" class="form-control " style="margin-bottom:10px; border-radius: 25px; background-color:#f1f1f1f1; padding: 0.675rem 1.75rem;
									name="checkPassword" placeholder="再次確認密碼 " onfocus="this.placeholder = ''"
									onblur="this.placeholder = '再次確認密碼'" id="checkPassword">
								<button class="primary-btn text-uppercase"
								style="background-color: #EFE9DA; color: black; border-radius: 25px; width:380px;  position:relative;  top: 15px" id="registerButton">註冊</button>
							</form>
						</div>

					</div>
				</div>
			</div>
		</div>


		<!-- End footer Area -->

		<script src="js/vendor/jquery-2.2.4.min.js"></script>
		<script src="js/popper.min.js"></script>
		<script src="js/vendor/bootstrap.min.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
		<script src="js/jquery-ui.js"></script>
		<script src="js/easing.min.js"></script>
		<script src="js/hoverIntent.js"></script>
		<script src="js/superfish.min.js"></script>
		<script src="js/jquery.ajaxchimp.min.js"></script>
		<script src="js/jquery.magnific-popup.min.js"></script>
		<script src="js/jquery.nice-select.min.js"></script>
		<script src="js/owl.carousel.min.js"></script>
		<script src="js/mail-script.js"></script>
		<script src="js/main.js"></script>
		<script>
			// 取得當前日期再減去 18 年的日期，並將其設置為生日欄位的最大可選日期
			var today = new Date();
			var maxBirthday = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
			document.getElementById("birthday").setAttribute("max", maxBirthday.toISOString().slice(0, 10));
		</script>
		<script>
			function checkPassword() {
				var password1 = document.getElementById("accountPassword").value;
				var password2 = document.getElementById("checkPassword").value;
				if (password1 != password2) {
					alert("兩次輸入的密碼不一致，請重新輸入！");
					return false;
				}
				return true;
			}

			document.getElementById("registerButton").addEventListener("click", function(event){
				if (!checkPassword()) {
					event.preventDefault();
				}
			});
		</script>
</body>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>

<script src="https://cdn.bootcss.com/moment.js/2.18.1/moment-with-locales.min.js"></script>

<script src="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

</html>