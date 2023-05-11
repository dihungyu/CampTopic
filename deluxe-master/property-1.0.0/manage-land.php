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

  <script>
    function hideMessage() {
      document.getElementById("message").style.opacity = "0";
      setTimeout(function () {
        document.getElementById("message").style.display = "none";
      }, 500);
    }
    setTimeout(hideMessage, 3000);
  </script>

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
          <li class="nav-item "><a href="index.php" class="nav-link">首頁</a></li>
          <li class="nav-item"><a href="rooms.html" class="nav-link">找小鹿</a></li>
          <li class="nav-item"><a href="../all-article.php" class="nav-link">鹿的分享</a></li>
          <li class="nav-item"><a href="../equipment.php" class="nav-link">鹿的裝備</a></li>
          <li class="nav-item"><a href="blog.html" class="nav-link">廣告方案</a></li>

          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="member.php" id="navbarDropdown" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              帳號
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="member.php">會員帳號</a>
              <a class="dropdown-item" href="member-like.php">我的收藏</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="../../logout.php?action=logout">登出</a>
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
          <h1 class="heading" data-aos="fade-up">營地管理</h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
              <li class="breadcrumb-item"><a href="member.php">帳號</a></li>
              <li class="breadcrumb-item active text-white-50" aria-current="page"> 營地管理
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

        <div class="input-group " style="display:flex;justify-content: flex-end; margin-bottom: 40px; width: 98%;">
          <div id="navbar-search-autocomplete" class="form-outline">
            <input type="search" id="form1" name="camp_search_keyword" class="form-control"
              style="height: 40px; border-radius: 35px;" placeholder="搜尋營地名稱..." />
          </div>&nbsp;
          <button type="submit" class="button-search">
            <i class="fas fa-search"></i>
          </button>
        </div>
        <span class="span-adj" style="justify-content: flex-end;">
          <a href="add-land.html">
            <button class="btn-new" style=" margin-right: 20px; margin-bottom: 0px;">
              新增
            </button></a>
        </span>
      </div>
    </div>

    <div class="section section-properties">
      <div class="container">
        <div class="row">
          <article class="col-md-12 article-list" style="display: flex;">
            <div class="card">
              <img src="images/Rectangle 137.png" class="card-img-top" alt="...">
              <div class="card-body">
                <span class="span-adj" style="justify-content: space-between;">
                  <h4><span>$1,291起</span></h4>
                  <button type="button" class="btn-icon">
                    <i class="fa-regular fa-bookmark"></i>
                  </button>
                </span>
                <div>
                  <h5 class='city d-block mb-3 mt-3'>北得拉曼露營區</h5></a>
                  <span class="d-block mb-4 text-black-50">新竹縣尖石鄉水田部落</span>
                  <div class="card-icon-footer">
                    <div class="tagcloud">
                      <a href="property-single.html">雲海</a>
                      <a href="property-single.html">櫻花</a>
                      <a href="property-single.html">森林</a>
                    </div>
                    <span style="display: flex; align-items: center;">
                      <i class="fa-regular fa-heart"></i>
                      <p style="margin-top:0px">1,098</p>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <img src="images/Rectangle 137.png" class="card-img-top" alt="...">
              <div class="card-body">
                <span class="span-adj" style="justify-content: space-between;">
                  <h4><span>$1,291起</span></h4>
                  <button type="button" class="btn-icon">
                    <i class="fa-regular fa-bookmark"></i>
                  </button>
                </span>
                <div>
                  <h5 class='city d-block mb-3 mt-3'>北得拉曼露營區</h5></a>
                  <span class="d-block mb-4 text-black-50">新竹縣尖石鄉水田部落</span>
                  <div class="card-icon-footer">
                    <div class="tagcloud">
                      <a href="property-single.html">雲海</a>
                      <a href="property-single.html">櫻花</a>
                      <a href="property-single.html">森林</a>
                    </div>
                    <span style="display: flex; align-items: center;">
                      <i class="fa-regular fa-heart"></i>
                      <p style="margin-top:0px">1,098</p>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <img src="images/Rectangle 137.png" class="card-img-top" alt="...">
              <div class="card-body">
                <span class="span-adj" style="justify-content: space-between;">
                  <h4><span>$1,291起</span></h4>
                  <button type="button" class="btn-icon">
                    <i class="fa-regular fa-bookmark"></i>
                  </button>
                </span>
                <div>
                  <h5 class='city d-block mb-3 mt-3'>北得拉曼露營區</h5></a>
                  <span class="d-block mb-4 text-black-50">新竹縣尖石鄉水田部落</span>
                  <div class="card-icon-footer">
                    <div class="tagcloud">
                      <a href="property-single.html">雲海</a>
                      <a href="property-single.html">櫻花</a>
                      <a href="property-single.html">森林</a>
                    </div>
                    <span style="display: flex; align-items: center;">
                      <i class="fa-regular fa-heart"></i>
                      <p style="margin-top:0px">1,098</p>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </article>

          <article class="col-md-12 article-list" style="display: flex;">
            <div class="card">
              <img src="images/Rectangle 137.png" class="card-img-top" alt="...">
              <div class="card-body">
                <span class="span-adj" style="justify-content: space-between;">
                  <h4><span>$1,291起</span></h4>
                  <button type="button" class="btn-icon">
                    <i class="fa-regular fa-bookmark"></i>
                  </button>
                </span>
                <div>
                  <h5 class='city d-block mb-3 mt-3'>北得拉曼露營區</h5></a>
                  <span class="d-block mb-4 text-black-50">新竹縣尖石鄉水田部落</span>
                  <div class="card-icon-footer">
                    <div class="tagcloud">
                      <a href="property-single.html">雲海</a>
                      <a href="property-single.html">櫻花</a>
                      <a href="property-single.html">森林</a>
                    </div>
                    <span style="display: flex; align-items: center;">
                      <i class="fa-regular fa-heart"></i>
                      <p style="margin-top:0px">1,098</p>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <img src="images/Rectangle 137.png" class="card-img-top" alt="...">
              <div class="card-body">
                <span class="span-adj" style="justify-content: space-between;">
                  <h4><span>$1,291起</span></h4>
                  <button type="button" class="btn-icon">
                    <i class="fa-regular fa-bookmark"></i>
                  </button>
                </span>
                <div>
                  <h5 class='city d-block mb-3 mt-3'>北得拉曼露營區</h5></a>
                  <span class="d-block mb-4 text-black-50">新竹縣尖石鄉水田部落</span>
                  <div class="card-icon-footer">
                    <div class="tagcloud">
                      <a href="property-single.html">雲海</a>
                      <a href="property-single.html">櫻花</a>
                      <a href="property-single.html">森林</a>
                    </div>
                    <span style="display: flex; align-items: center;">
                      <i class="fa-regular fa-heart"></i>
                      <p style="margin-top:0px">1,098</p>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <img src="images/Rectangle 137.png" class="card-img-top" alt="...">
              <div class="card-body">
                <span class="span-adj" style="justify-content: space-between;">
                  <h4><span>$1,291起</span></h4>
                  <button type="button" class="btn-icon">
                    <i class="fa-regular fa-bookmark"></i>
                  </button>
                </span>
                <div>
                  <h5 class='city d-block mb-3 mt-3'>北得拉曼露營區</h5></a>
                  <span class="d-block mb-4 text-black-50">新竹縣尖石鄉水田部落</span>
                  <div class="card-icon-footer">
                    <div class="tagcloud">
                      <a href="property-single.html">雲海</a>
                      <a href="property-single.html">櫻花</a>
                      <a href="property-single.html">森林</a>
                    </div>
                    <span style="display: flex; align-items: center;">
                      <i class="fa-regular fa-heart"></i>
                      <p style="margin-top:0px">1,098</p>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </article>

          <article class="col-md-12 article-list" style="display: flex;">
            <div class="card">
              <img src="images/Rectangle 137.png" class="card-img-top" alt="...">
              <div class="card-body">
                <span class="span-adj" style="justify-content: space-between;">
                  <h4><span>$1,291起</span></h4>
                  <button type="button" class="btn-icon">
                    <i class="fa-regular fa-bookmark"></i>
                  </button>
                </span>
                <div>
                  <h5 class='city d-block mb-3 mt-3'>北得拉曼露營區</h5></a>
                  <span class="d-block mb-4 text-black-50">新竹縣尖石鄉水田部落</span>
                  <div class="card-icon-footer">
                    <div class="tagcloud">
                      <a href="property-single.html">雲海</a>
                      <a href="property-single.html">櫻花</a>
                      <a href="property-single.html">森林</a>
                    </div>
                    <span style="display: flex; align-items: center;">
                      <i class="fa-regular fa-heart"></i>
                      <p style="margin-top:0px">1,098</p>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <img src="images/Rectangle 137.png" class="card-img-top" alt="...">
              <div class="card-body">
                <span class="span-adj" style="justify-content: space-between;">
                  <h4><span>$1,291起</span></h4>
                  <button type="button" class="btn-icon">
                    <i class="fa-regular fa-bookmark"></i>
                  </button>
                </span>
                <div>
                  <h5 class='city d-block mb-3 mt-3'>北得拉曼露營區</h5></a>
                  <span class="d-block mb-4 text-black-50">新竹縣尖石鄉水田部落</span>
                  <div class="card-icon-footer">
                    <div class="tagcloud">
                      <a href="property-single.html">雲海</a>
                      <a href="property-single.html">櫻花</a>
                      <a href="property-single.html">森林</a>
                    </div>
                    <span style="display: flex; align-items: center;">
                      <i class="fa-regular fa-heart"></i>
                      <p style="margin-top:0px">1,098</p>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <img src="images/Rectangle 137.png" class="card-img-top" alt="...">
              <div class="card-body">
                <span class="span-adj" style="justify-content: space-between;">
                  <h4><span>$1,291起</span></h4>
                  <button type="button" class="btn-icon">
                    <i class="fa-regular fa-bookmark"></i>
                  </button>
                </span>
                <div>
                  <h5 class='city d-block mb-3 mt-3'>北得拉曼露營區</h5></a>
                  <span class="d-block mb-4 text-black-50">新竹縣尖石鄉水田部落</span>
                  <div class="card-icon-footer">
                    <div class="tagcloud">
                      <a href="property-single.html">雲海</a>
                      <a href="property-single.html">櫻花</a>
                      <a href="property-single.html">森林</a>
                    </div>
                    <span style="display: flex; align-items: center;">
                      <i class="fa-regular fa-heart"></i>
                      <p style="margin-top:0px">1,098</p>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </article>
        </div>
      </div>
    </div>
    <div class="row align-items-center py-5">
      <div class="col-lg-3"></div>
      <div class="col-lg-6 text-center">
        <div class="custom-pagination">
          <a href="#">1</a>
          <a href="#" class="active">2</a>
          <a href="#">3</a>
          <a href="#">4</a>
          <a href="#">5</a>
        </div>
      </div>
    </div>
  </div>

  <div class="site-footer">
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
              <li><a href="camp-information.html">找小鹿</a></li>
              <li><a href="../all-article.html">鹿的分享</a></li>
              <li><a href="../equipment.html">鹿的裝備</a></li>
              <li><a href="#">廣告方案</a></li>
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



</body>

</html>