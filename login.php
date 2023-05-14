<?php
session_start();


// 若已經登入則轉址至首頁
if ($_POST["FormType"] == "Login") {
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

				// 將使用者資訊存入 Cookie，並轉址至首頁
				setcookie("accountId", $row["accountId"], time() + 3600 * 24 * 30, "/");
				setcookie("accountName", $row["accountName"], time() + 3600 * 24 * 30, "/");
				setcookie("accountEmail", $row["accountEmail"], time() + 3600 * 24 * 30, "/");
				setcookie("accountPhoneNumber", $row["accountPhoneNumber"], time() + 3600 * 24 * 30, "/");
				setcookie("accountType", $row["accountType"], time() + 3600 * 24 * 30, "/");

				// 將敏感的使用者資訊存入 Session
				$_SESSION["accountPassword"] = $row["accountPassword"];

				// 儲存登出成功的訊息到 Session 中
				$_SESSION["system_message"] = "歡迎回來！";

				// 轉址至登入頁面
				if ($_COOKIE["accountType"] == "ADMIN") {
					header("Location: /CampTopic/deluxe-master/property-1.0.0/index-manage.php");
					exit;
				} elseif ($_COOKIE["accountType"] == "USER" || $_COOKIE["accountType"] == "BUSINESS") {
					header("Location: /CampTopic/deluxe-master/property-1.0.0/index.php");
					exit;
				}


				// echo "<script>{window.alert('登入成功！'); location.href='/CampTopic/deluxe-master/property-1.0.0/index.php'}</script>";
			} else {
				// 儲存登入失敗的訊息到 Session 中
				$_SESSION["system_message"] = "密碼錯誤！";

				// 轉址至登入頁面
				header("Location: login.php");
				exit;

				// 若密碼不正確，則顯示錯誤訊息，並轉址至登入頁
				// echo "<script>{window.alert('密碼錯誤！請再試一次'); location.href='login.php'}</script>";
			}
		} else {
			// 儲存登入失敗的訊息到 Session 中
			$_SESSION["system_message"] = "此電子信箱尚未註冊！請先註冊帳號";

			// 轉址至登入頁面
			header("Location: register.php");
			exit;

			// 若帳號不存在，則顯示錯誤訊息，並轉址至註冊頁面
			// echo "<script>{window.alert('此電子信箱尚未註冊！請先註冊帳號'); location.href='register.php'}</script>";
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
	<link rel="shortcut icon" href="img/Frame 5.png">
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
	<!-- 系統訊息 -->
	<?php if (isset($_SESSION["system_message"])): ?>
		<div id="message" class="alert alert-success"
			style="position: fixed; top: 10%; left: 50%; transform: translate(-50%, -50%); z-index: 1000; padding: 15px 30px; border-radius: 5px; font-weight: 500; transition: opacity 0.5s;">
			<?php echo $_SESSION["system_message"]; ?>
		</div>
		<?php unset($_SESSION["system_message"]); ?>
	<?php endif; ?>

	<section class="banner-area relative">
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<div class="row fullscreen align-items-center justify-content-between">
				<div class="col-lg-5 col-md-6 banner-left">
					<h5 class="text-white" style="font-family: Arial Black, sans-serif;">Start Camping</h5>
					<h1 class="text-white" style="font-size: 40px;"><a
							href="../CampTopic/deluxe-master/property-1.0.0/index.php"
							style=" color: #f1f1f1f1;">營在起跑點</a></h1>
					<p class="text-white" style="font-size: 14px;">
						邀請你一同進入露營的世界，快速開始一趟冒險旅程，多處地點一覽，不怕踩雷，讓你能夠「營」在起跑點！☺ ☺ ☺
					</p>

				</div>
				<div class="col-lg-5 col-md-10 banner-right">

					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab" ">
							<form class=" form-wrap" method="post" action="login.php" style="padding: 40px 35px; ">
							<h4 style="text-align: center; margin-left: 12px; margin-bottom: 24px; ">歡迎回來！</h4>
							<input type="hidden" name="FormType" value="Login">

							<input type="email" class="form-control"
								style="margin-bottom:10px; border-radius: 25px; background-color:#f1f1f1f1; padding: 0.675rem 1.75rem; "
								name="accountEmail" placeholder="電子信箱" onfocus="this.placeholder = ''"
								onblur="this.placeholder = '電子信箱 '" required>

							<input type="password" class="form-control" name="accountPassword"
								style="margin-bottom:5px; border-radius: 25px;background-color:#f1f1f1f1; padding: 0.675rem 1.75rem;"
								placeholder="密碼" onfocus="this.placeholder = ''" onblur="this.placeholder = '密碼'"
								required>
							<button class="primary-btn" :hover
								style=" width:220px;  margin-top: 20px; margin-right: 5px; ">登入</button>
							<a class="secondary-btn-l" :hover style=" width:140px;" href="register.php">尚未註冊？</a>

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
			function hideMessage() {
				document.getElementById("message").style.opacity = "0";
				setTimeout(function () {
					document.getElementById("message").style.display = "none";
				}, 500);
			}

			setTimeout(hideMessage, 3000);
		</script>
</body>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>

<script src="https://cdn.bootcss.com/moment.js/2.18.1/moment-with-locales.min.js"></script>

<script src="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

</html>