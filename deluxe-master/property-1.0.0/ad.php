<?php
session_start();


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
      <a href="index.php"><img class="navbar-brand" src="images/Group 59.png" style="width: 90px; height: auto;"></img></a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> 選單
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active"><a href="index.php" class="nav-link">首頁</a></li>
          <li class="nav-item"><a href="camp-information.php" class="nav-link">找小鹿</a></li>
          <li class="nav-item"><a href="../all-article.php" class="nav-link">鹿的分享</a></li>
          <li class="nav-item"><a href="../equipment.php" class="nav-link">鹿的裝備</a></li>
          <li class="nav-item"><a href="ad.php" class="nav-link">廣告方案</a></li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="member.html" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              帳號
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="member.php">會員帳號</a>
              <a class="dropdown-item" href="member-like.php">我的收藏</a>
              <a class="dropdown-item" href="member-record.php">發表記錄</a>
              <a class="dropdown-item" href="myActivityRecord.php">活動紀錄</a>
              <div class="dropdown-divider"></div>
              <?php
              // 檢查是否設置了 accountName 或 accountEmail Cookie
              if (isset($_COOKIE["accountName"]) || isset($_COOKIE["accountEmail"])) {
                echo '<a class="dropdown-item" href="../../logout.php?action=logout">登出</a>';
              }
              // 如果沒有設置 Cookie 則顯示登入選項
              else {
                echo '<a class="dropdown-item" href="../../login.php">登入</a>';
              }
              ?>
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
          <h1 class="heading" data-aos="fade-up">廣告方案</h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="index.php">首頁</a></li>

              <li class="breadcrumb-item active text-white-50" aria-current="page">
                廣告方案
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <div class="container mt-5 mb-5">

    <span style="text-align: center;margin-top: 10px;font-weight: bold;color: #000;">
      <h4 style="font-weight: bold;">廣告方案</h4>
      <p>透過廣告投放、販賣露營商品，有效提高營地的知名度和可信度，吸引更多潛在客戶，帶來更多收益 !</p>
    </span>
  </div>


  <div class="section1 section-properties " style="background-color: #EFE9DA;margin-top: 50px;">
    <div class="container">
      <div class="row ">

        <article class="col-md-12 article-list mt-5 mb-5 " style="display: flex;">
          <div class="col-4">
            <div class="inner" style="display: flex; ">
              <div class="card" style="margin-left: 5px;">
                <img src="images/3.png" class="card-img-top" alt="..." style="margin-bottom: -15px;">
                <div class="card-body">
                  <span style="display: flex;margin-right: 10px;flex-wrap: wrap;flex-direction: column;align-items: center;font-weight: bold;color: #000;">
                    <h4 style="color: #000;font-weight: bold;">時段廣告</h4>
                    <p>
                      &#8226; 一個月為期，選擇您最需要宣傳投放的期間<br>
                      &#8226; 專屬時段，不與其他廣告分攤<br>
                      &#8226; 範圍：首頁、功能頁面橫幅廣告、側邊廣告
                    </p>
                    <button class="btn-new" data-toggle="modal" data-target="#contectus">
                      聯絡我們
                    </button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-4">
            <div class="card">
              <img src="images/4.png" class="card-img-top" alt="..." style="margin-bottom: -15px;">
              <div class="card-body">
                <span style="display: flex;margin-bottom: 10px;margin-right: 10px;flex-wrap: wrap;flex-direction: column;align-items: center;font-weight: bold;color: #000;">
                  <h4 style="color: #000;font-weight: bold;">商品販賣</h4>
                  <p>
                    &#8226; 不限期間，在「鹿的設備」頁面曝光商品<br>
                    &#8226; 針對特定用戶推薦商品，提高購買率
                  </p>
                  <button class="btn-new" style="margin-top: 20px;" data-toggle="modal" data-target="#contectus">
                    聯絡我們
                  </button>
              </div>
            </div>
          </div>

          <div class="col-4">
            <div class="card">
              <img src="images/5.png" class="card-img-top" alt="..." style="margin-bottom: -15px;">
              <div class="card-body">
                <span style="display: flex;margin-bottom: 10px;margin-right: 10px;flex-wrap: wrap;flex-direction: column;align-items: center;font-weight: bold;color: #000;">
                  <h4 style="color: #000;font-weight: bold;">贊助我們</h4>
                  <p>
                  &#8226; 贊助會員制度中「徽章搜集」之獎品<br>
                  &#8226; 提供特殊廣告位置投放<br>
                  &#8226; 下一期間優先選擇時段、位置
                  </p>
                  <button class="btn-new" style="margin-top: 20px;" data-toggle="modal" data-target="#contectus">
                    聯絡我們
                  </button>
              </div>
            </div>
          </div>
        </article>
      </div>
    </div>
  </div>



  <div class="modal fade" id="contectus" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle" style="color: black;">聯絡我們</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i id="close" class="fa-solid fa-circle-xmark" style="color:#a0a0a0;"></i>
          </button>
        </div>
        <div class="modal-body">
          <span class="modal-connect">
            <i class="fa-regular fa-envelope"></i>
            <p>startcamping@gmail.com</p>
          </span>
          <span class="modal-connect">
            <i class="fa-solid fa-phone"></i>
            <p>0911222345</p>
          </span>
          <span class="modal-connect">
            <i class="fa-brands fa-line"></i>
            <p>@startcamping</p>
          </span>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-more" data-dismiss="modal">查看更多</button>
        </div>
      </div>
    </div>
  </div>

  <div class="site-footer" style="margin-top: 0px;">
    <div class="container">
      <div class="row">

        <!-- /.col-lg-4 -->
        <div class="col-lg-5">
          <div class="widget">
            <h3>聯絡資訊</h3>
            <address>StartCamping 營在起跑點！</address>
            <ul class="list-unstyled links">
              <li><a href="tel://11234567890">0911222345</a></li>
              <li><a href="tel://11234567890">@startcamping</a></li>
              <li>
                <a href="mailto:info@mydomain.com">startcamping@gmail.com</a>
              </li>
            </ul>
          </div>
          <!-- /.widget -->
        </div>
        <!-- /.col-lg-4 -->
        <div class="col-lg-5">
          <div class="widget">
            <h3>頁面總覽</h3>
            <ul class="list-unstyled float-start links">
              <li><a href="index.php">首頁</a></li>
              <li><a href="camp-information.php">找小鹿</a></li>
              <li><a href="../all-article.php">鹿的分享</a></li>
              <li><a href="../equipment.php">鹿的裝備</a></li>
              <li><a href="ad.php">廣告方案</a></li>
            </ul>
            <ul class="list-unstyled float-start links">
              <li><a href="member.php">帳號</a></li>
              <li><a href="member.php">會員帳號</a></li>
              <li><a href="member-like.php">我的收藏</a></li>
            </ul>
          </div>
          <!-- /.widget -->
        </div>
        <!-- /.col-lg-4 -->
        <div class="col-lg-2">
          <!-- /.widget -->
        </div>
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
  <script src="js/e-magz.js"></script>

</body>

</html>