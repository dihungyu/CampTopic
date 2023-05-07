<?php
require_once '../../php/conn.php';
//判斷是否登入，若有則對變數初始化
if (isset($_COOKIE["accountId"])) {
  $accountId = $_COOKIE["accountId"];
}

if (!isset($_COOKIE["accountId"])) {
  $_SESSION["system_message"] = "請先登入會員，才能上傳設備喔!";
  header('Location: ' . $_SERVER['HTTP_REFERER']);
  exit; // 確保重新導向後停止執行後續代碼
}

$sql_account = "SELECT * FROM accounts WHERE accountId = '$accountId'";
$result_account = mysqli_query($conn, $sql_account);
$row_account = mysqli_fetch_assoc($result_account);
$accountName = $row_account['accountName'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="author" content="Untree.co" />
  <link rel="shortcut icon" href="images/Frame 5.png" />

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
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  <title>
    Start Camping &mdash; 一起展開露營冒險！
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

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a href="index.html"><img class="navbar-brand" src="images/Group 59.png"
          style="width: 90px; height: auto;"></img></a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
        aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> 選單
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item "><a href="index.html" class="nav-link">首頁</a></li>
          <li class="nav-item"><a href="rooms.html" class="nav-link">找小鹿</a></li>
          <li class="nav-item"><a href="restaurant.html" class="nav-link">鹿的分享</a></li>
          <li class="nav-item"><a href="about.html" class="nav-link">鹿的裝備</a></li>
          <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>

          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="member.html" id="navbarDropdown" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              帳號
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="member.html">會員帳號</a>
              <a class="dropdown-item" href="member-like.html">我的收藏</a>
              <a class="dropdown-item" href="">文章管理</a>
              <a class="dropdown-item" href="manage-equip.html">設備管理</a>
              <a class="dropdown-item" href="manage-land.html">營地管理</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">登出</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="hero page-inner overlay" style="background-image: url('images/Rectangle\ 134.png')">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-9 text-center mt-5">
          <h1 class="heading" data-aos="fade-up">設備管理</h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="index.html">首頁</a></li>
              <li class="breadcrumb-item"><a href="member.html">會員帳號</a></li>
              <li class="breadcrumb-item active text-white-50" aria-current="page">
                設備管理
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <div class="section">
    <div class="container" style="max-width: 1260px">
      <div class="row mb-6 align-items-center" style="margin-top: 20px; margin-bottom: 40px;">
      </div>
    </div>

    <div class="section section-properties">
      <div class="container">
        <div class="row">
          <span style="margin-left: 105px;margin-bottom: 20px;margin-bottom: 25px; margin-top: -65px;">
            <img src="images/person_4.jpg" alt="Image description" style="border-radius: 50%; width: 5%;">
            <label style="font-size: 14px; margin-bottom: 0px;margin-left: 20px; font-weight: 600; ">
              <?php echo $accountName ?>
            </label>
          </span>
          <br>
          <span
            style="display:flex;align-items: center;justify-content:flex-start;margin-left: 100px;margin-top: -15px;">
            <button class="btn-new2">
              <a class="tag-filter" href="#">櫻花
                <i class="fa-solid fa-circle-xmark" style="margin-left: 15px;margin-right: -10px;"></i>
              </a>
            </button>
            <button class="btn-new2">
              <a class="tag-filter" href="#">櫻花
                <i class="fa-solid fa-circle-xmark" style="margin-left: 15px;margin-right: -10px;"></i>
              </a>
            </button>
            <button class="btn-new2">
              <a class="tag-filter" href="#">櫻花
                <i class="fa-solid fa-circle-xmark" style="margin-left: 15px;margin-right: -10px;"></i>
              </a>
            </button>
            <button class="btn-new2">
              <a class="tag-filter" href="#">櫻花
                <i class="fa-solid fa-circle-xmark" style="margin-left: 15px;margin-right: -10px;"></i>
              </a>
            </button>
            <button type="button" class="btn-new2" data-toggle="modal" data-target="#exampleModalCenter">
              <a class="tag-filter" href="#">新增標籤</a>
            </button>
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
              aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="width:450px;height:200px;">
                  <div class="modal-body">
                    <span style="display: flex;">
                      <h4 style="font-weight: bold;margin-top: 5px;margin-left: 10px;">新增標籤</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i id="close" class="fa-solid fa-circle-xmark"
                          style="color:#a0a0a0;margin-left: 275px;margin-top: -5px;"></i>
                      </button>
                    </span>
                  </div>

                  <input type="text" value="標籤名稱"
                    style="background-color: #F0F0F0; border-style: none; color:#9D9D9D; width: 350px; height: 40px; border-radius: 30px;padding: 20px;margin-left: 50px;margin-bottom: 75px;">
          </span>
          <button class="btn-new" style=" margin-left: 340px;margin-top: -55px;margin-right: 25px;">
            <a href="add-equip.html" style="color: #fff;">確認</a></button>

        </div>
      </div>
    </div>
  </div>
  </span>

  <span style="display:flex;align-items: flex-end;flex-wrap: wrap;margin-bottom: 17px;margin-top: 17px;">
    <input type="text" value="設備名稱"
      style="background-color: #F0F0F0; border-style: none; color:#9D9D9D; width: 350px; height: 40px; border-radius: 30px;padding: 20px;margin-left: 100px;">
    <input type="text" value="租/徵/賣"
      style="background-color: #F0F0F0; border-style: none; color:#9D9D9D; width: 140px; height: 40px; border-radius: 30px;padding: 20px;margin-left: 8px;">
    <input type="text" value="價錢"
      style="background-color: #F0F0F0; border-style: none; color:#9D9D9D; width: 140px; height: 40px; border-radius: 30px;padding: 20px;margin-left: 8px;">
  </span>

  <textarea rows="6"
    style="background-color: #F0F0F0; border-style: none; color:#9D9D9D; width: 1030px; border-radius: 10px;padding: 20px;margin-left: 100px;margin-bottom: 20px;">詳細介紹</textarea>
  <br>


  <br>
  <span>
    <form method="post" enctype="multipart/form-data" style="margin-left: 100px;">
      <div>
        <input type="file" id="image_uploads" name="image_uploads" accept=".jpg, .jpeg, .png"
          style="position:absolute;height:200px;width:330px;opacity: 0;">
      </div>
      <div class="preview"
        style="float:left;background-color: #F0F0F0;height:200px;width:330px;text-align:center;border-radius: 20px;">
        <i class="icon-cloud_upload" style="font-size:50px;color:#acacac;"></i>
        <p style="line-height: 100px;color:#797979;">上傳圖片</p>
      </div>
    </form>
    <form method="post" enctype="multipart/form-data" style="margin-left: 100px;">
      <div>
        <input type="file" id="image_uploads" name="image_uploads" accept=".jpg, .jpeg, .png"
          style="position:absolute;height:200px;width:330px;opacity: 0;">
      </div>
      <div class="preview"
        style="float:left;background-color: #F0F0F0;height:200px;width:330px;text-align:center;border-radius: 20px;margin-left: 20px;">
        <i class="icon-cloud_upload" style="font-size:50px;color:#acacac;"></i>
        <p style="line-height: 100px;color:#797979;">上傳圖片</p>
      </div>
    </form>
    <form method="post" enctype="multipart/form-data" style="margin-left: 100px;">
      <div>
        <input type="file" id="image_uploads" name="image_uploads" accept=".jpg, .jpeg, .png"
          style="position:absolute;height:200px;width:330px;opacity: 0;">
      </div>
      <div class="preview"
        style="float:left;background-color: #F0F0F0;height:200px;width:330px;text-align:center;border-radius: 20px;margin-left: 20px;">
        <i class="icon-cloud_upload" style="font-size:50px;color:#acacac;"></i>
        <p style="line-height: 100px;color: #797979;;">上傳圖片</p>
      </div>
    </form>
  </span>


  <span style="margin-left: 990px;margin-top: 20px;">
    <button class="btn-new1">取消</button>
    <button class="btn-new"><a href="manage-land.html" style="color: #fff;">新增</a></button>
  </span>






  </div>
  </div>
  </div>

  <br><br>


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
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>

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
  <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
  <script src="https://kit.fontawesome.com/d02d7e1ecb.js" crossorigin="anonymous"></script>
  <script src="js/e-magz.js"></script>
  <script src="js/uploadphoto.js"></script>




</body>

</html>