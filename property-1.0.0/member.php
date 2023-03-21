<?php
session_start();
// $accountId = $_SESSION["accountId"];
$accountId = "c932dbc4be4811eda1d4e22a0f5e8454";

// 取得會員資料
require_once("../php/conn.php");
$stmt = $conn->prepare("SELECT * FROM `accounts` WHERE `accountId` = ?");
$stmt->bind_param("s", $accountId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) exit('No rows');
if ($row = mysqli_fetch_assoc($result)) {
  $accountId = $row["accountId"];
  $accountName = $row["accountName"];
  $accountGender = $row["accountGender"];
  $accountBirthday = $row["accountBirthday"];
  $accountPassword = $row["accountPassword"];
  $accountEmail = $row["accountEmail"];
  $accountPhoneNumber = $row["accountPhoneNumber"];
}

if (isset($_POST["updateMember"]) && $_POST["updateMember"] == "yes") {
  $accountName = $_POST["accountName"];
  $accountGender = $_POST["accountGender"];
  $accountBirthday = $_POST["accountBirthday"];
  $accountEmail = $_POST["accountEmail"];
  $accountPhoneNumber = $_POST["accountPhoneNumber"];

  $stmt = $conn->prepare("UPDATE accounts SET accountName = ?, accountGender = ?, accountBirthday = ?, accountEmail = ?, accountPhoneNumber = ? WHERE accountId = ?");
  $stmt->bind_param("ssssss", $accountName, $accountGender, $accountBirthday, $accountEmail, $accountPhoneNumber, $accountId);
  $stmt->execute();
  //跳出提示窗，內容為修改成功
  echo "<script>alert('更新成功'); location.href = 'member.php';</script>";
}
?>

<!-- /*
* Template Name: Property
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="author" content="Untree.co" />
  <link rel="shortcut icon" href="favicon.png" />

  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap5" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="fonts/icomoon/style.css" />
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css" />

  <link rel="stylesheet" href="css/tiny-slider.css" />
  <link rel="stylesheet" href="css/aos.css" />
  <link rel="stylesheet" href="css/style.css" />

  <title>
    Starting Camping &mdash; 開啟你的露營冒險！
  </title>

  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i" rel="stylesheet">

  <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
  <link rel="stylesheet" href="css/animate.css">

  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">

  <link rel="stylesheet" href="css/ionicons.min.css">

  <link rel="stylesheet" href="css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="css/jquery.timepicker.css">
  <link rel="stylesheet" href="css/icomoon.css">
  <link rel="stylesheet" href="https://kit.fontawesome.com/d02d7e1ecb.css" crossorigin="anonymous">

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a href="index.html"><img class="navbar-brand" src="images/Group 59.png" style="width: 90px; height: auto;"></img></a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> 選單
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item "><a href="index.html" class="nav-link">首頁</a></li>
          <li class="nav-item"><a href="rooms.html" class="nav-link">Rooms</a></li>
          <li class="nav-item"><a href="restaurant.html" class="nav-link">Restaurant</a></li>
          <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
          <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>

          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle " href="member.html" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              帳號
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="member.html">會員帳號</a>
              <a class="dropdown-item" href="member-like.html">我的收藏</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="file:///Applications/XAMPP/xamppfiles/htdocs/CampTopic/login.html">登出</a>
            </div>
          </li>

        </ul>
      </div>
    </div>
  </nav>
  <div class="hero page-inner overlay" style="background-image: url('images/Rectangle\ 136.png')">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-9 text-center mt-5">
          <h1 class="heading" data-aos="fade-up">會員資料</h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="index.html">首頁</a></li>
              <li class="breadcrumb-item active text-white-50" aria-current="page">
                會員資料
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <div class="section">
    <div class="container">
      <div class="row">
        <div class="col-md-5 mb-3">
          <div class="card" style="width: 300px;margin: 50px;border:none;">
            <div class="card-body">
              <div class="d-flex flex-column align-items-center text-center">
                <img src="img/crayon.png" alt="Admin" class="rounded-circle" width="110">
                <div class='mt-3'>
                  <h5><?php echo $accountName; ?></h5>
                </div>
                <div class="btn btn-primary-tag">露營新手</div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 mb-3">
          <form action="member.php" method="post">
            <input type="hidden" name="updateMember" value="yes">
            <div class="column">

              <span style="width: 400px;
              flex-wrap: wrap;
              font-size: 16px;
              font-weight: bolder;
              margin-left: 4px;
              align-items: center;
              ">
                <i class="fa-solid fa-pencil" style="margin-right: 16px; margin-bottom: 48px;"></i>編輯會員資料</span>

              <span style="display: flex;
                width: 400px;
                align-items: center;
                flex-wrap: wrap;
                font-size: 15px;
                font-weight: 400px;
                margin-bottom: 48px;
                ">
                姓名

                <input type="text" name="accountName" class="form-control" style="font-size: 14px; margin-left: 32px; height: 42px;" placeholder="請輸入名字" value="<?php echo $accountName; ?>" required />

              </span>

              <span style="display: flex;
                width: 400px;
                flex-wrap: wrap;
                font-size: 15px;
                font-weight: 400px;
                margin-bottom: 48px;
                align-items: center;">
                電話
                <input type="tel" name="accountPhoneNumber" class="form-control" style="font-size: 14px; margin-left: 32px; height: 42px;" placeholder="請輸入電話" value="<?php echo $accountPhoneNumber; ?>" required />

              </span>

              <span style="display: flex;
                width: 400px;
                flex-wrap: wrap;
                font-size: 15px;
                font-weight: 400px;
                margin-bottom: 48px;
                align-items: center;">
                信箱

                <input type="email" name="accountEmail" class="form-control" style="font-size: 14px; margin-left: 32px; height: 42px;" placeholder="請輸入電子郵件" value="<?php echo $accountEmail; ?>" required />

              </span>

              <span style="display: flex;
                width: 400px;
                flex-wrap: wrap;
                font-size: 15px;
                font-weight: 400px;
                margin-bottom: 48px;
                align-items: center;">
                生日

                <input type="date" name="accountBirthday" id="birthday" class="form-control" style="font-size: 14px; margin-left: 32px; height: 42px;" placeholder="請選擇日期" value="<?php echo $accountBirthday; ?>" required>
              </span>

              <span style="display: flex;
                width: 400px;
                flex-wrap: wrap;
                font-size: 15px;
                font-weight: 400px;
                margin-bottom: 48px;
                align-items: center;">
                性別

                <input type="radio" name="accountGender" value="Female" style=" margin-left: 32px; margin-right: 8px;" <?php if ($accountGender == "Female") {
                                                                                                                          echo "checked";
                                                                                                                        } ?> required>
                <label for="Female" style="font-weight: bold;font-size:16px;">女</label>
                <input type="radio" name="accountGender" value="Male" style=" margin-left: 32px; margin-right: 8px;" <?php if ($accountGender == "Male") {
                                                                                                                        echo "checked";
                                                                                                                      } ?> required>
                <label for=" Male" style="font-weight: bold;font-size:16px;">男</label>
              </span>

              <hr width="100%" size="3" style="margin-top: 20px; margin-bottom: 52px;">

              <span style="display: flex;
                width:400px;
                flex-wrap: wrap;
                font-size: 15px;
                font-weight: 400px;
                align-items: center;
                margin-bottom: 56px;">
                密碼

                <a href="password.php" style="margin-left: 32px;">設定新的密碼</a>
              </span>

              <div class="col-10 mb-3" style="margin-left: 32px;">

                <span style="display: flex;
                width:400px;
                flex-wrap: wrap;
                font-size: 12px;
                margin-left:400px;
                align-items: center;">
                  <input type="reset" value="取消" class="btn btn-secondary" 
                  style="margin-right: 12px;color: #000;background-color: #f1f1f1;">
                  <input type="submit" value="確認修改" class="btn btn-primary">
              </div></span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- /.untree_co-section -->

  <div class="site-footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="widget">
            <h3>Contact</h3>
            <address>43 Raymouth Rd. Baltemoer, London 3910</address>
            <ul class="list-unstyled links">
              <li><a href="tel://11234567890">+1(123)-456-7890</a></li>
              <li><a href="tel://11234567890">+1(123)-456-7890</a></li>
              <li>
                <a href="mailto:info@mydomain.com">info@mydomain.com</a>
              </li>
            </ul>
          </div>
          <!-- /.widget -->
        </div>
        <!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <div class="widget">
            <h3>Sources</h3>
            <ul class="list-unstyled float-start links">
              <li><a href="#">About us</a></li>
              <li><a href="#">Services</a></li>
              <li><a href="#">Vision</a></li>
              <li><a href="#">Mission</a></li>
              <li><a href="#">Terms</a></li>
              <li><a href="#">Privacy</a></li>
            </ul>
            <ul class="list-unstyled float-start links">
              <li><a href="#">Partners</a></li>
              <li><a href="#">Business</a></li>
              <li><a href="#">Careers</a></li>
              <li><a href="#">Blog</a></li>
              <li><a href="#">FAQ</a></li>
              <li><a href="#">Creative</a></li>
            </ul>
          </div>
          <!-- /.widget -->
        </div>
        <!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <div class="widget">
            <h3>Links</h3>
            <ul class="list-unstyled links">
              <li><a href="#">Our Vision</a></li>
              <li><a href="#">About us</a></li>
              <li><a href="#">Contact us</a></li>
            </ul>

            <ul class="list-unstyled social">
              <li>
                <a href="#"><span class="icon-instagram"></span></a>
              </li>
              <li>
                <a href="#"><span class="icon-twitter"></span></a>
              </li>
              <li>
                <a href="#"><span class="icon-facebook"></span></a>
              </li>
              <li>
                <a href="#"><span class="icon-linkedin"></span></a>
              </li>
              <li>
                <a href="#"><span class="icon-pinterest"></span></a>
              </li>
              <li>
                <a href="#"><span class="icon-dribbble"></span></a>
              </li>
            </ul>
          </div>
          <!-- /.widget -->
        </div>
        <!-- /.col-lg-4 -->
      </div>
      <!-- /.row -->

      <div class="row mt-5">
        <div class="col-12 text-center">
          <!-- 
              **==========
              NOTE: 
              Please don't remove this copyright link unless you buy the license here https://untree.co/license/  
              **==========
            -->

          <p>
            Copyright &copy;
            <script>
              document.write(new Date().getFullYear());
            </script>
            . All Rights Reserved. &mdash; Designed with love by
            <a href="https://untree.co">Untree.co</a>
            <!-- License information: https://untree.co/license/ -->
          </p>
          <div>
            Distributed by
            <a href="https://themewagon.com/" target="_blank">themewagon</a>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container -->
  </div>
  <!-- /.site-footer -->

  <!-- Preloader -->
  <div id="overlayer"></div>
  <div class="loader">
    <div class="spinner-border" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/tiny-slider.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/navbar.js"></script>
  <script src="js/counter.js"></script>
  <script src="js/custom.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
  <script src="https://kit.fontawesome.com/d02d7e1ecb.js" crossorigin="anonymous"></script>
  <script>
    $(function() {
      // 取得當前日期再減去 18 年的日期，並將其設置為生日欄位的最大可選日期
      var today = new Date();
      var maxBirthday = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
      $("#birthday").attr("max", maxBirthday.toISOString().slice(0, 10));

      // 初始化日期選擇器
      $("#birthday").datepicker({
        language: 'zh-TW', // 設置語言為繁體中文
        autoclose: true, // 選擇日期後自動關閉
        clearBtn: false, // 清除按鈕
        format: "yyyy-mm-dd", // 日期格式
        beforeShowDay: function(date) {
          var selectable = true;
          var cssClass = '';
          var tooltip = '';

          // 判斷日期是否小於18年前的日期，如是，則不可選
          if (date >= maxBirthday) {
            selectable = false;
            cssClass = 'disabled';
            tooltip = '必須年滿18歲才能註冊';
          }

          return {
            enabled: selectable, // 是否可選
            classes: cssClass, // 當前日期的樣式
            tooltip: tooltip, // 滑鼠提示內容
            content: date.getDate() // 當前日期單元格顯示的內容
          }
        }
      });
    });
  </script>


</body>

</html>