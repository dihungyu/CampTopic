<?php
session_start();
// $accountId = $_SESSION["accountId"];
// $accountName = $_SESSION["accountName"];
// $accountEmail = $_SESSION["accountEmail"];
// $accountPhoneNumber = $_SESSION["accountPhoneNumber"];
$accountId = "c932dbc4be4811eda1d4e22a0f5e8454";
$accountName = "dihung";
$accountEmail = "dihung921@gmail.com";
$accountPhoneNumber = "0978546921";

if (isset($_POST["submit"])) {
  $oldPassword = $_POST["oldPassword"];
  $newPassword = $_POST["newPassword"];


  require_once("../php/conn.php");
  $stmt = $conn->prepare("SELECT accountPassword FROM accounts WHERE accountId = ?");
  $stmt->bind_param("s", $accountId);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    //檢查舊密碼是否與資料庫相同
    if (password_verify($oldPassword, $row["accountPassword"])) {

      //加密新密碼
      $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
      //更新密碼
      $stmt = $conn->prepare("UPDATE accounts SET accountPassword = ? WHERE accountId = ?");
      $stmt->bind_param("ss", $hashedPassword, $accountId);
      $stmt->execute();
      if ($stmt->affected_rows > 0) {
        echo "<script>alert('密碼更新成功'); location.href = 'member.php';</script>";
      } else {
        echo "<script>alert('密碼更新失敗，請再試一次'); location.href = 'password.php';</script>";
      }
    } else {
      echo "<script>alert('舊密碼錯誤'); location.href = 'password.php';</script>";
    }
  }
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
    Property &mdash; Free Bootstrap 5 Website Template by Untree.co
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
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item "><a href="index.html" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="rooms.html" class="nav-link">Rooms</a></li>
          <li class="nav-item"><a href="restaurant.html" class="nav-link">Restaurant</a></li>
          <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
          <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>

          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle " href="member.html" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Account
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
  <div class="hero page-inner overlay" style="background-image: url('images/hero_bg_1.jpg')">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-9 text-center mt-5">
          <h1 class="heading" data-aos="fade-up">會員資料</h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="index.html">Home</a></li>
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
    <div class="container" style="height:450px">
      <div class="col-md-4 mb-3">
        <div class="card" style="width: 350px;margin: 50px;">
          <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
              <img src="img/crayon.png" alt="Admin" class="rounded-circle" width="110">
              <div class='mt-3'>
                <h3><?php echo $accountName; ?></h3>
              </div>
              <input class="btn btn-primary" style="transform: translate(-1% , 30%);width:90px;height:30px;border:0;background-color:#EFE9DA;color:#000;border-radius:20px;font-size: 13px;padding: 5px;display: hidden;" type="submit" value="露營新手">
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4 mb-5 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
          <div class="contact-info">
            <div class="address mt-2">
            </div>

            <div class="open-hours mt-4">
              </p>
            </div>
          </div>

        </div>

        <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
          <form action="password.php" method="post" onsubmit="return checkPassword()">
            <input type="hidden" name="updatePassword" value="yes">
            <div class="column" style="position:absolute;height: 500px;top:-270px;left:200px;right: 0px;padding: 20px;">
              <h4 style="margin-left: 150px;font-weight: bolder;letter-spacing: 3px;"><i class="fa-solid fa-pencil" style="margin-right: 10px;margin-bottom: 20px;"></i>編輯密碼</h4>
              <i class="fa-solid fa-key" style="display: flex;
                    transform: translate(50%, 100%);
                    flex-wrap: wrap;
                    font-size: 15px
                    font-weight: bold;
                    width: 50px;">
              </i>

              <div class="col-6 mb-3" style="margin-left: 50px;margin-top: -5px;">
                <input type="password" name="oldPassword" class="form-control" style="font-size: 14px;
                    border-top-style: none;
                    border-left-style:none;
                    border-right-style:none;
                    border-bottom-style:solid; 
                    border-color: #f1f1f1;
                    margin-bottom: 20px;
                    letter-spacing: 1px;
                    " placeholder="舊密碼" required />
              </div>
              <i class="fa-solid fa-key" style="display: flex;
                    transform: translate(50%, 100%);
                    flex-wrap: wrap;
                    font-size: 15px;
                    font-weight: bold;
                    width: 50px;">
              </i>

              <div class="col-6 mb-2" style="margin-left: 50px;margin-top: -5px;">
                <input type="password" name="newPassword" id="newPassword" class="form-control" style="font-size: 14px;
                    border-top-style: none;
                    border-left-style:none;
                    border-right-style:none;
                    border-bottom-style:solid; 
                    border-color: #f1f1f1;
                    margin-bottom: 20px;
                    letter-spacing: 1px;
                    " placeholder="新密碼 (至少八個字元)" required />
              </div>
              <i class="fa-solid fa-key" style="display: flex;
                    transform: translate(50%, 100%);
                    flex-wrap: wrap;
                    font-size: 15px;
                    font-weight: bold;
                    width: 50px;">
              </i>

              <div class="col-6 mb-3" style="margin-left: 50px;margin-top: -5px;">
                <input type="password" name="checkNewPassword" id="checkNewPassword" class="form-control" style="font-size: 14px;
                    border-top-style: none;
                    border-left-style:none;
                    border-right-style:none;
                    border-bottom-style:solid; 
                    border-color: #f1f1f1;
                    letter-spacing: 1px;
                    " placeholder="確認新密碼" required />
              </div>
              <input class="btn-primary" style="position: relative;
                    transform: translate( 7%, 50%);
                    width:350px;height: 35px;px;border:0;
                    font-size: 14px;font-weight:bold;
                    border-radius: 20px;
                    background-color: #f1f1f1;color: #000;
                    letter-spacing: 1ex;display: hidden;" name="submit" type="submit" value="更新" id="submitButton" />
            </div>

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
    function checkPassword() {
      var password1 = document.getElementById("newPassword").value;
      var password2 = document.getElementById("checkNewPassword").value;
      if (password1 != password2) {
        alert("確認新密碼不一致，請重新輸入！");
        return false;
      }
      return true;
    }

    document.getElementById("submitButton").addEventListener("click", function(event) {
      if (!checkPassword()) {
        event.preventDefault();
      }
    });
  </script>
</body>



</body>

</html>