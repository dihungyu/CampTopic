<?php
require_once '../php/conn.php';
require_once '../php/uuid_generator.php';

session_start();

function format_count($count)
{
  if ($count < 1000) {
    return $count;
  } elseif ($count < 1000000) {
    return round($count / 1000, 1) . 'k';
  } else {
    return round($count / 1000000, 1) . 'm';
  }
}

//判斷是否登入，若有則對變數初始化
if (isset($_COOKIE["accountId"])) {
  $accountId = $_COOKIE["accountId"];
}

$equipmentId = $_GET['equipmentId'];

$sql_equipment = "SELECT * FROM equipments WHERE equipmentId = '$equipmentId'";
$result_equipment = mysqli_query($conn, $sql_equipment);
$row_equipment = mysqli_fetch_assoc($result_equipment);

$accountId = $row_equipment['accountId'];
$equipmentName = $row_equipment['equipmentName'];
$equipmentType = $row_equipment["equipmentType"];
$equipmentName = $row_equipment["equipmentName"];
$equipmentDescription = $row_equipment["equipmentDescription"];
$equipmentPrice = $row_equipment["equipmentPrice"];
$equipmentLikeCount = $row_equipment["equipmentLikeCount"];

$sql_account = "SELECT * FROM accounts WHERE accountId = '$accountId'";
$result_account = mysqli_query($conn, $sql_account);
$row_account = mysqli_fetch_assoc($result_account);

$accountName = $row_account['accountName'];
$accountEmail = $row_account['accountEmail'];
$accountPhoneNumber = $row_account['accountPhoneNumber'];

?>

<html lang="en">

<head>
  <title>Start Camping &mdash; 一起展開露營冒險！</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="images/Frame 5.png" />

  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i" rel="stylesheet">

  <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
  <link rel="stylesheet" href="css/animate.css">

  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">

  <link rel="stylesheet" href="css/aos.css">

  <link rel="stylesheet" href="css/ionicons.min.css">

  <link rel="stylesheet" href="css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="css/jquery.timepicker.css">


  <link rel="stylesheet" href="css/flaticon.css">
  <link rel="stylesheet" href="css/icomoon.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="fonts/icomoon/style.css" />
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css" />

  <link rel="stylesheet" href="css/tiny-slider.css" />
  <link rel="stylesheet" href="css/aos.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="https://kit.fontawesome.com/d02d7e1ecb.css" crossorigin="anonymous">

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
              <a class="dropdown-item" href="member.html">管理員帳號</a>
              <a class="dropdown-item" href="member-like.html">營地管理</a>
              <a class="dropdown-item" href="member-like.html">文章管理</a>
              <a class="dropdown-item" href="member-like.html">設備管理</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">登出</a>
            </div>
          </li>

        </ul>
      </div>
    </div>
  </nav>
  <!-- END nav -->
  <div class="hero page-inner overlay" style="background-image: url('images/Rectangle\ 134.png')">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-9 text-center mt-5">
          <h1 class="heading" data-aos="fade-up">設備詳細資訊</h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="index.html">首頁</a></li>
              <li class="breadcrumb-item"><a href="member.html">鹿的裝備</a></li>
              <li class="breadcrumb-item active text-white-50" aria-current="page">
                設備詳細資訊
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>


  <section class="ftco-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="row">
            <div class="col-md-11 ftco-animate">
              <div class="single-slider owl-carousel">
                <div class="item">
                  <div class="room-img" style="background-image: url(images/Rectangle\ 222.png);"></div>
                </div>
              </div>
            </div>
            <div class="col-md-11 room-single mt-4 mb-5 ftco-animate">
              <div class="detail" style="display: flex; align-items: center;">
                <span class="fa-stack fa-1x" style="margin-right: 5px; ">
                  <i class="fas fa-circle fa-stack-2x" style="color:#EFE9DA; font-size:30px;"></i>
                  <i class="fas fa-stack-1x" style="font-size: 13px;">
                    <?php echo $equipmentType ?>
                  </i>
                </span>
                <h1><a href="single.html">
                    <?php echo $equipmentName ?>
                  </a></h1>
                <h5>$
                  <?php echo $equipmentPrice ?>
                </h5>
              </div>
              <br>
              <p>
                <?php echo $equipmentDescription ?>
              </p>
              <div class="col-md-7 room-single mt-2 mb-2 ftco-animate" style="margin-bottom: -100px;">
                <h6 style="margin-top: 56px">設備與服務</h6>
                <div class="d-md-flex mt-4 mb-4">
                  <ul class="list">
                    <li>
                      <span style="display: flex; align-items: center;">
                        <i class="fa-regular fa-user fa-xl"></i>
                        <p style="margin-bottom: 0px; box-sizing: content-box;width: 60px;">聯絡人</p>
                        <p style="margin-bottom: 0px; margin-left: 10px;">
                          <?php echo $accountName ?>
                        </p>
                      </span>
                    </li>
                    <li>
                      <span style="display: flex; align-items: center; ">
                        <i class="fa-regular fa-envelope fa-lg"></i>
                        <p style="margin-bottom: 0px; box-sizing: content-box;width: 60px;">信箱</p>
                        <p style="margin-bottom: 0px; margin-left: 10px;">
                          <?php echo $accountEmail ?>
                        </p>
                      </span>
                    </li>

                    <li>
                      <span style="display: flex; align-items: center;">
                        <i class="fa-solid fa-phone fa-lg"></i>
                        <p style="margin-bottom: 0px; box-sizing: content-box;width: 60px;">電話</p>
                        <p style="margin-bottom: 0px; margin-left: 10px;">
                          <?php echo $accountPhoneNumber ?>
                        </p>
                      </span>
                    </li>
                  </ul>
                </div>
              </div>

            </div>
            <div class="col-md-11 room-single ftco-animate mb-5 mt-3">
              <div class="row">
                <div class="col-sm col-md-6 ftco-animate">
                  <div class="room">
                    <a class="img img-2 d-flex justify-content-center align-items-center"
                      style="background-image: url(images/Rectangle\ 223.png);">

                    </a>

                  </div>
                </div>
                <div class="col-sm col-md-6 ftco-animate">
                  <div class="room">
                    <a class="img img-2 d-flex justify-content-center align-items-center"
                      style="background-image: url(images/Rectangle\ 224.png);">

                    </a>
                  </div>
                </div>
              </div>
            </div>

          </div>


        </div> <!-- .col-md-8 -->
        <div class="col-lg-4 sidebar ftco-animate">
          <div class="categories">
            <h4 style="margin-bottom: 16px">類別</h4>
            <?php
            $sql_all = "SELECT COUNT(*) FROM equipments";
            $result_all = mysqli_query($conn, $sql_all);
            $row_all = mysqli_fetch_assoc($result_all);
            $count_all = $row_all['COUNT(*)'];

            $sql_rent = "SELECT COUNT(*) FROM equipments WHERE equipmentType = '租'";
            $result_rent = mysqli_query($conn, $sql_rent);
            $row_rent = mysqli_fetch_assoc($result_rent);
            $count_rent = $row_rent['COUNT(*)'];

            $sql_request = "SELECT COUNT(*) FROM equipments WHERE equipmentType = '徵'";
            $result_request = mysqli_query($conn, $sql_request);
            $row_request = mysqli_fetch_assoc($result_request);
            $count_request = $row_request['COUNT(*)'];

            $sql_sell = "SELECT COUNT(*) FROM equipments WHERE equipmentType = '賣'";
            $result_sell = mysqli_query($conn, $sql_sell);
            $row_sell = mysqli_fetch_assoc($result_sell);
            $count_sell = $row_sell['COUNT(*)'];
            ?>
            <li><a href="equipment.php">全部<span>(
                  <?php echo $count_all ?>)
                </span></a></li>
            <li><a href="equipment_rent.php">租<span>(
                  <?php echo $count_rent ?>)
                </span></a></li>
            <li><a href="equipment_request.php">徵<span>(
                  <?php echo $count_request ?>)
                </span></a></li>
            <li><a href="equipment_sell.php">賣<span>(
                  <?php echo $count_sell ?>)
                </span></a></li>
          </div>

          <div class="sidebar-box ftco-animate">
            <h3>熱門設備標籤</h3>
            <div class="tagcloud">
              <?php
              $sql_labels = "SELECT * FROM labels WHERE labelType = '設備'";
              $result_labels = mysqli_query($conn, $sql_labels);
              $labels = [];
              while ($row_labels = mysqli_fetch_assoc($result_labels)) {
                $labels[] = $row_labels;
              }
              foreach ($labels as $label) {
                echo "<a href='#' class=tag-cloud-link'>" . $label['labelName'] . "</a>";
              }
              ?>
            </div>
          </div>


        </div>

      </div>
    </div>
  </section> <!-- .section -->

  <div class="ad-img">
    <img src="images/Group 147.png">
  </div>
  <section class="ftco-section">
    <div class="container">
      <div class="row" style="display: flex;justify-content: center;">
        <div class="col-md-12 ftco-animate">
          <h5>相關設備</h5>
          <article class="col-md-12 mt-5 article-list">
            <div class="inner" style="display: flex; justify-content: center">
              <?php
              // 取出已被收藏的設備
              $equip_collect_sql = "SELECT `equipmentId` FROM `collections` WHERE `accountId` = '$accountId'";
              $equip_collect_result = mysqli_query($conn, $equip_collect_sql);

              // 將查詢結果轉換為包含已收藏設備ID的陣列
              $collectedEquips = array();
              while ($row = mysqli_fetch_assoc($equip_collect_result)) {
                $collectedEquips[] = $row['equipmentId'];
              }

              // 取出已被按讚的設備
              $equip_like_sql = "SELECT `equipmentId` FROM `likes` WHERE `accountId` = '$accountId'";
              $equip_like_result = mysqli_query($conn, $equip_like_sql);

              // 將查詢結果轉換為包含已按讚設備ID的陣列
              $likedEquips = array();
              while ($row = mysqli_fetch_assoc($equip_like_result)) {
                $likedEquips[] = $row['equipmentId'];
              }

              $sql_recommand_equipment = "SELECT * FROM equipments WHERE equipmentType = '$equipmentType' AND equipmentId != '$equipmentId' ORDER BY RAND() LIMIT 3";
              $result_recommand_equipment = mysqli_query($conn, $sql_recommand_equipment);
              $recommand_equipments = [];
              while ($row_recommand_equipment = mysqli_fetch_assoc($result_recommand_equipment)) {
                $recommand_equipments[] = $row_recommand_equipment;
              }
              foreach ($recommand_equipments as $recommand_equipment) {
                // 檢查當前設備是否已收藏
                $isEquipCollected = in_array($recommand_equipment["equipmentId"], $collectedEquips);

                // 檢查當前設備是否已按讚
                $isEquipLiked = in_array($recommand_equipment["equipmentId"], $likedEquips);

                $recommand_equipmentId = $recommand_equipment['equipmentId'];
                $recommand_equipmentName = $recommand_equipment['equipmentName'];
                $recommand_equipmentType = $recommand_equipment['equipmentType'];
                $recommand_equipmentPrice = $recommand_equipment['equipmentPrice'];
                $recommand_equipmentDescription = $recommand_equipment['equipmentDescription'];
                $recommand_equipmentLikeCount = $recommand_equipment['equipmentLikeCount'];
                echo '<div class="card-eq" style=" margin-right: 25px;">';
                echo '<img src="images/M85318677_big.jpeg" class="card-img-top" alt="...">';
                echo '<div class="card-body-eq">';

                echo '<div class="detail" style="flex-wrap: wrap">';

                echo '<span class="fa-stack fa-1x" style="margin-right: 5px;">';

                echo '<i class="fas fa-circle fa-stack-2x" style="color:#EFE9DA; font-size:24px;"></i>';

                echo '<i class="fas fa-stack-1x" style="font-size: 13px;">' . $recommand_equipmentType . '</i>';
                echo '</span>';
                echo '<a href="equip-single.php?equipmentId=' . $recommand_equipmentId . '">';
                echo '<h5 style="width: 135px;">' . $recommand_equipmentName . '</h5>';
                echo '</a>';
                echo '<span class="span-adj">';
                echo '<h4 style="margin-left: 24px;">$' . format_count($equipmentPrice) . '</h4>';
                echo "<form action='equipment.php' method='post' style='margin-bottom: 0px;'>";
                echo "<input type='hidden' name='" . ($isEquipCollected ? "collectEquipDel" : "collectEquipAdd") . "' value='" . $recommand_equipmentId . "'>";
                echo "<button type='submit' class='btn-icon'>";
                echo "<i class='" . ($isEquipCollected ? "fas" : "fa-regular") . " fa-bookmark' " . "></i>";
                echo "</button>";
                echo "</form>";
                echo '</span>';
                echo '</div>';
                echo '<p class="card-text-eq">';
                echo '' . $recommand_equipmentDescription . '</p>';
                echo '<footer style="margin-top:40px">';
                echo '<span>';
                echo '<div class="card-icon-footer">';
                echo '<div class="tagcloud">';
                $sql_query_labels = "SELECT equipments_labels.labelId, labels.labelName
                      FROM equipments_labels
                      JOIN labels ON equipments_labels.labelId = labels.labelId
                      WHERE equipments_labels.equipmentId = '$recommand_equipmentId'";
                $result_labels = mysqli_query($conn, $sql_query_labels);

                $printed_tags = 0;
                while ($tags_row = mysqli_fetch_assoc($result_labels)) {
                  if ($printed_tags >= 3) {
                    break;
                  }

                  echo "<a href='#'>" . $tags_row['labelName'] . "</a>";

                  $printed_tags++;
                }
                echo '</div>';
                echo '<span style="display: flex; align-items: center;">';
                echo '<form action="equipment.php" method="post" style="margin-bottom: 0px;">';
                echo '<input type="hidden" name="' . ($isEquipLiked ? "likeEquipDel" : "likeEquipAdd") . '" value="' . $recommand_equipmentId . '">';
                echo '<button type="submit" class="btn-icon">';
                echo '<i class="' . ($isEquipLiked ? "fas" : "fa-regular") . ' fa-heart" . "></i>';
                echo '</button>';
                echo '</form>';
                echo '<p>' . format_count($recommand_equipmentLikeCount) . '</p>';
                echo '</span>';
                echo '</div>';

                echo '</span>';

                echo '</footer>';
                echo '</div>';
                echo '</div>';
              }
              ?>
          </article>
        </div>
      </div>
    </div>
  </section>


  <div class="site-footer" style="clear: both;">
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



    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
          stroke="#F96D00" />
      </svg></div>


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
</body>

</html>