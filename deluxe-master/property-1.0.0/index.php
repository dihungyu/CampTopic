<?php
session_start();
require_once '../../php/conn.php';
require_once '../../php/uuid_generator.php';
require_once '../../php/get_img_src.php';

//讚數格式化函式
function format_like_count($count)
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



//收藏營地
if (isset($_POST["collectCampAdd"])) {
  if (!isset($_COOKIE["accountId"])) {
    $_SESSION["system_message"] = "請先登入會員，才能進行收藏喔!";
    header("Location: index.php");
    exit; // 確保重新導向後停止執行後續代碼
  }
  $campsiteId = $_POST["collectCampAdd"];
  $accountId = $_COOKIE["accountId"];
  $collectionId = uuid_generator();
  $sql = "INSERT INTO `collections` (`collectionId`,`accountId`, `campsiteId`) VALUES ('$collectionId','$accountId', '$campsiteId')";
  $sql2 = "UPDATE `campsites` SET `campsiteCollectCount` = `campsiteCollectCount` + 1 WHERE `campsiteId` = '$campsiteId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result) {
    $_SESSION["system_message"] = "已加入收藏!";
    header("Location: index.php");
    exit; // 確保重新導向後停止執行後續代碼
  }
}

//移除收藏營地
if (isset($_POST["collectCampDel"])) {

  $campsiteId = $_POST["collectCampDel"];
  $accountId = $_COOKIE["accountId"];
  $sql = "DELETE FROM `collections` WHERE `accountId` = '$accountId' AND `campsiteId` = '$campsiteId'";
  $sql2 = "UPDATE `campsites` SET `campsiteCollectCount` = `campsiteCollectCount` - 1 WHERE `campsiteId` = '$campsiteId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result) {
    $_SESSION["system_message"] = "已取消收藏!";
    header("Location: index.php");
    exit; // 確保重新導向後停止執行後續代碼
  }
}

//收藏設備
if (isset($_POST["collectEquipAdd"])) {
  if (!isset($_COOKIE["accountId"])) {
    $_SESSION["system_message"] = "請先登入會員，才能進行收藏喔!";
    header("Location: index.php");
    exit; // 確保重新導向後停止執行後續代碼
  }
  $equipmentId = $_POST["collectEquipAdd"];
  $accountId = $_COOKIE["accountId"];
  $collectionId = uuid_generator();
  $sql = "INSERT INTO `collections` (`collectionId`,`accountId`, `equipmentId`) VALUES ('$collectionId','$accountId', '$equipmentId')";
  $sql2 = "UPDATE `equipments` SET `equipmentCollectCount` = `equipmentCollectCount` + 1 WHERE `equipmentId` = '$equipmentId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result) {
    $_SESSION["system_message"] = "已加入收藏!";
    header("Location: index.php");
    exit; // 確保重新導向後停止執行後續代碼
  }
}

//移除收藏設備
if (isset($_POST["collectEquipDel"])) {

  $equipmentId = $_POST["collectEquipDel"];
  $accountId = $_COOKIE["accountId"];
  $sql = "DELETE FROM `collections` WHERE `accountId` = '$accountId' AND `equipmentId` = '$equipmentId'";
  $sql2 = "UPDATE `equipments` SET `equipmentCollectCount` = `equipmentCollectCount` - 1 WHERE `equipmentId` = '$equipmentId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result) {
    $_SESSION["system_message"] = "已取消收藏!";
    header("Location: index.php");
    exit; // 確保重新導向後停止執行後續代碼
  }
}

// 按讚營區
if (isset($_POST["likeCampAdd"])) {

  if (!isset($_COOKIE["accountId"])) {
    $_SESSION["system_message"] = "請先登入會員，才能進行按讚喔!";
    header("Location: index.php");
    exit; // 確保重新導向後停止執行後續代碼
  }
  $campsiteId = $_POST["likeCampAdd"];
  $accountId = $_COOKIE["accountId"];
  $likeId = uuid_generator();
  $sql = "INSERT INTO `likes` (`likeId`, `accountId`, `campsiteId`) VALUES ('$likeId', '$accountId', '$campsiteId')";
  $sql2 = "UPDATE `campsites` SET `campsiteLikeCount` = `campsiteLikeCount` + 1 WHERE `campsiteId` = '$campsiteId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result) {
    $_SESSION["system_message"] = "已按讚!";
    header("Location: index.php");
    exit; // 確保重新導向後停止執行後續代碼
  }
}

// 取消讚營區
if (isset($_POST["likeCampDel"])) {

  $campsiteId = $_POST["likeCampDel"];
  $accountId = $_COOKIE["accountId"];
  $sql = "DELETE FROM `likes` WHERE `accountId` = '$accountId' AND `campsiteId` = '$campsiteId'";
  $sql2 = "UPDATE `campsites` SET `campsiteLikeCount` = `campsiteLikeCount` - 1 WHERE `campsiteId` = '$campsiteId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result) {
    $_SESSION["system_message"] = "已取消讚!";
    header("Location: index.php");
    exit; // 確保重新導向後停止執行後續代碼
  }
}

// 按讚設備
if (isset($_POST["likeEquipAdd"])) {

  if (!isset($_COOKIE["accountId"])) {
    $_SESSION["system_message"] = "請先登入會員，才能進行按讚喔!";
    header("Location: index.php");
    exit; // 確保重新導向後停止執行後續代碼
  }

  $equipmentId = $_POST["likeEquipAdd"];
  $accountId = $_COOKIE["accountId"];
  $likeId = uuid_generator();
  $sql = "INSERT INTO `likes` (`likeId`, `accountId`, `equipmentId`) VALUES ('$likeId', '$accountId', '$equipmentId')";
  $sql2 = "UPDATE `equipments` SET `equipmentLikeCount` = `equipmentLikeCount` + 1 WHERE `equipmentId` = '$equipmentId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result) {
    $_SESSION["system_message"] = "已按讚!";
    header("Location: index.php");
    exit; // 確保重新導向後停止執行後續代碼
  }
}

// 取消讚設備
if (isset($_POST["likeEquipDel"])) {

  $equipmentId = $_POST["likeEquipDel"];
  $accountId = $_COOKIE["accountId"];
  $sql = "DELETE FROM `likes` WHERE `accountId` = '$accountId' AND `equipmentId` = '$equipmentId'";
  $sql2 = "UPDATE `equipments` SET `equipmentLikeCount` = `equipmentLikeCount` - 1 WHERE `equipmentId` = '$equipmentId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result) {
    $_SESSION["system_message"] = "已取消讚!";
    header("Location: index.php");
    exit; // 確保重新導向後停止執行後續代碼
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
  <link rel="shortcut icon" href="images/Frame 5.png" />

  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap5" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://kit.fontawesome.com/d02d7e1ecb.css">

  <link rel="stylesheet" href="fonts/icomoon/style.css" />
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css" />

  <link rel="stylesheet" href="css/tiny-slider.css" />
  <link rel="stylesheet" href="css/aos.css" />

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
  <link rel="stylesheet" href="css/style.css" />



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
      <a href="index.php"><img class="navbar-brand" src="images/Group 59.png"
          style="width: 90px; height: auto;"></img></a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
        aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
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
            <a class="nav-link dropdown-toggle" href="member.html" id="navbarDropdown" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              帳號
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="member.php">會員帳號</a>
              <a class="dropdown-item" href="member-like.php">我的收藏</a>
              <a class="dropdown-item" href="member-record.php">我的紀錄</a>
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

  <div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
      <div class="site-mobile-menu-close">
        <span class="icofont-close js-menu-toggle"></span>
      </div>
    </div>
    <div class="site-mobile-menu-body"></div>
  </div>


  <div class="hero">
    <div class="hero-slide">
      <div class="img overlay" style="background-image: url('images/Rectangle\ 134.png')"></div>
      <div class="img overlay" style="background-image: url('images/Rectangle\ 135.png')"></div>
      <div class="img overlay" style="background-image: url('images/Rectangle\ 136.png')"></div>
    </div>
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-9 text-center">
          <h1 class="heading" data-aos="fade-up">
            Start Camping！<br>營在起跑點
          </h1>
        </div>
      </div>
    </div>
  </div>


  <section class="features-1">
    <div class="container">
      <div class="row">
        <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
          <div class="box-feature">
            <span class="flaticon-member">
              <i class="fa-solid fa-tent"></i></span>
            <h3 class="mb-3 mt-3">露營地</h3>
            <p>
              眾多營地不知從何下手？<br>透過標籤篩選，幫你找出心目中理想的營地！
            </p>
            <p><a href="index.php" class="learn-more">Learn More</a></p>
          </div>
        </div>
        <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="500">
          <div class="box-feature">
            <span class="flaticon-member"><i class="fa-solid fa-people-roof"></i></span>
            <h3 class="mb-3 mt-3">找營友</h3>
            <p>
              找不到夥伴一起露營？<br>
              「找小鹿」功能帶你找到志同道合的營友一同露營冒險！
            </p>
            <p><a href="camp-information.php" class="learn-more">Learn More</a></p>
          </div>
        </div>
        <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
          <div class="box-feature">
            <span class="flaticon-member"><i class="fa-solid fa-fire-burner"></i></span>
            <h3 class="mb-3 mt-3">出租裝備</h3>
            <p>
              有閒置或多餘的裝備不用好浪費？<br>
              「鹿的裝備」讓你的裝備能被妥善運用！
            </p>
            <p><a href="../equipment.php" class="learn-more">Learn More</a></p>
          </div>
        </div>
        <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="600">
          <div class="box-feature">
            <span class="flaticon-member"><i class="fa-regular fa-newspaper"></i></span>
            <h3 class="mb-3 mt-3">文章分享</h3>
            <p>
              透過文章分享，輕鬆地將露營心得、照片和建議分享給其他露營愛好者，也能從中發掘更多露營靈感！
            </p>
            <p><a href="../all-article.php" class="learn-more">Learn More</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="section">
    <div class="container">
      <div class="row mb-5 align-items-center">
        <div class="col-lg-6">
          <h3 class="text-primary heading">
            推薦營地
          </h3>
        </div>
        <!-- <div class="col-lg-6 text-lg-end">
          <p>
            <a href="#" target="_blank" class="btn btn-primary text-white py-3 px-4">查看所有營地</a>
          </p>
        </div> -->
      </div>
      <div class="row">
        <div class="col-12">
          <div class="property-slider-wrap">
            <div class="property-slider">

              <?php

              //取出營地按讚數前10名的營地
              $sql = "SELECT * FROM `campsites` ORDER BY `campsiteLikeCount` DESC LIMIT 10";
              $campsiteResult = mysqli_query($conn, $sql);

              // 取出已被收藏的營地
              $camp_collect_sql = "SELECT `campsiteId` FROM `collections` WHERE `accountId` = '$accountId'";
              $camp_collect_result = mysqli_query($conn, $camp_collect_sql);

              // 將查詢結果轉換為包含已收藏營地ID的陣列
              $collectedCamps = array();
              while ($row = mysqli_fetch_assoc($camp_collect_result)) {
                $collectedCamps[] = $row['campsiteId'];
              }

              // 取出已被按讚的營地
              $camp_like_sql = "SELECT `campsiteId` FROM `likes` WHERE `accountId` = '$accountId'";
              $camp_like_result = mysqli_query($conn, $camp_like_sql);

              // 將查詢結果轉換為包含已按讚營地ID的陣列
              $likedCamps = array();
              while ($row = mysqli_fetch_assoc($camp_like_result)) {
                $likedCamps[] = $row['campsiteId'];
              }

              if ($campsiteResult && $campsiteResult->num_rows > 0) {
                while ($campsiteData = mysqli_fetch_assoc($campsiteResult)) {

                  // 檢查當前營區是否已收藏
                  $isCampCollected = in_array($campsiteData["campsiteId"], $collectedCamps);

                  // 檢查當前營區是否已按讚
                  $isCampLiked = in_array($campsiteData["campsiteId"], $likedCamps);




                  $files_query = "SELECT * FROM files WHERE campsiteId = '$campsiteData[campsiteId]'";
                  $files_result = mysqli_query($conn, $files_query);
                  $image_src = 'images/Rectangle 332.png'; // Default image
              
                  if ($file_result = mysqli_fetch_assoc($files_result)) {
                    $file_path = str_replace('Applications/XAMPP/xamppfiles/htdocs', '../..', $file_result['filePath']);
                    $image_src = $file_path;
                  }

                  //格式化按讚數
                  $campsitelikeCount = format_like_count($campsiteData["campsiteLikeCount"]);



                  echo "<div class='property-item'>
                <img src='" . $image_src . "' alt='Image' class='img-fluid' style='width: 412px; height: 412px;' />

                <div class='property-content'>
                  <span class='span-adj' style='justify-content: space-between;'>
                    <div class='price mb-2'><span>$" . number_format($campsiteData["campsiteLowerLimit"]) . "起</span></div>
                    <form action='index.php' method='post'>
                    <input type='hidden' name='" . ($isCampCollected ? "collectCampDel" : "collectCampAdd") . "' value='" . $campsiteData["campsiteId"] . "'>
                    <button type='submit' class='btn-icon'>";
                  echo "<i class='" . ($isCampCollected ? "fas" : "fa-regular") . " fa-bookmark' " . "></i>";

                  $campsiteId = $campsiteData["campsiteId"];
                  echo "</button>
                    </form>
                  </span>
                  <div>
                    <a href='../camp-single.php?campsiteId=$campsiteId' class='img'>
                      <span class='city d-block mb-3 mt-3'>" . $campsiteData["campsiteName"] . "</span></a>
                    <span class='d-block mb-4 text-black-50'>" . $campsiteData["campsiteAddress"] . "</span>";

                  echo "<div class='card-icon-footer'>
                        <div class='tagcloud'>";
                  $sql_query_labels = "SELECT campsites_labels.labelId, labels.labelName
                      FROM campsites_labels
                      JOIN labels ON campsites_labels.labelId = labels.labelId
                      WHERE campsites_labels.campsiteId = '$campsiteData[campsiteId]'";
                  $result_labels = mysqli_query($conn, $sql_query_labels);

                  $printed_tags = 0;
                  while ($tags_row = mysqli_fetch_assoc($result_labels)) {
                    if ($printed_tags >= 3) {
                      break;
                    }

                    echo "<a href='#'>" . $tags_row['labelName'] . "</a>";

                    $printed_tags++;
                  }

                  echo
                    "</div>
                        <span style='display: flex; align-items: center;'>
                        <form action='index.php' method='post'>
                    <input type='hidden' name='" . ($isCampLiked ? "likeCampDel" : "likeCampAdd") . "' value='" . $campsiteData["campsiteId"] . "'>
                    <button type='submit' class='btn-icon'>";
                  echo "<i class='" . ($isCampLiked ? "fas" : "fa-regular") . " fa-heart' " . "></i>";


                  echo "</button>
                    </form>
                          <p style='margin-top:0px'>" . $campsitelikeCount . "</p>
                        </span>
                      </div>
                  </div>
                </div>
              </div>";
                }
              }

              ?>


              <!-- .item -->
              <div class="property-item">
                <img src="images/Rectangle 332.png" alt="Image" class="img-fluid"
                  style="style='width: 412px; height: 412px;'" />


                <div class="property-content">
                  <span class="span-adj" style="justify-content: space-between;">
                    <div class="price mb-2"><span>$1,291起</span></div>
                    <button type="button" class="btn-icon">
                      <i class="fa-regular fa-bookmark"></i>
                    </button>
                  </span>
                  <div>
                    <a href="property-single.html" class="img">
                      <span class="city d-block mb-3 mt-3">北得拉曼露營區</span></a>
                    <span class="d-block mb-4 text-black-50">新竹縣尖石鄉水田部落</span>
                    <div class="card-icon-footer">
                      <div class="tagcloud">
                        <a href="property-single.html">雲海</a>
                        <a href="property-single.html">櫻花</a>
                        <a href="property-single.html">森林</a>
                      </div>
                      <span style="display: flex; align-items: center;">
                        <i class="fa-regular fa-heart"></i>
                        <p style='margin-top:0px'>1,098</p>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- .item end -->




              <!-- 分頁導航 -->
            </div>
            <div id="property-nav" class="controls" tabindex="0" aria-label="Carousel Navigation">
              <span class="prev" data-controls="prev" aria-controls="property" tabindex="-1">Prev</span>
              <span class="next" data-controls="next" aria-controls="property" tabindex="-1">Next</span>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section">
    <div class="container">
      <div class="row mb-5 align-items-center">
        <div class="col-lg-6">
          <h3 class="font-weight-bold text-primary heading">
            推薦設備
          </h3>
        </div>
        <div class="col-lg-6 text-lg-end">
          <p>
            <a href="../equipment.html" target="_blank" class="btn btn-primary text-white py-3 px-4">查看所有設備</a>
          </p>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="row">
            <div class="col-lg-4"></div>
          </div>
          <div class="testimonial-slider-wrap">
            <div class="testimonial-slider">


              <?php
              //取出按讚數前10名的設備
              $sql = "SELECT * FROM `equipments` ORDER BY `equipmentLikeCount` DESC LIMIT 10";
              $equipmentResult = mysqli_query($conn, $sql);

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


              if ($equipmentResult && $equipmentResult->num_rows > 0) {
                while ($equipmentData = mysqli_fetch_assoc($equipmentResult)) {

                  // 檢查當前設備是否已收藏
                  $isEquipCollected = in_array($equipmentData["equipmentId"], $collectedEquips);

                  // 檢查當前設備是否已按讚
                  $isEquipLiked = in_array($equipmentData["equipmentId"], $likedEquips);




                  $files_query = "SELECT * FROM files WHERE equipmentId = '$equipmentData[equipmentId]'";
                  $files_result = mysqli_query($conn, $files_query);
                  $image_src = 'images/image 3.png'; // Default image
              
                  if ($file_result = mysqli_fetch_assoc($files_result)) {
                    $file_path = str_replace('Applications/XAMPP/xamppfiles/htdocs', '../..', $file_result['filePath']);
                    $image_src = $file_path;
                  }

                  //格式化按讚數
                  $equipmentlikeCount = format_like_count($equipmentData["equipmentLikeCount"]);

                  echo "<div class='property-item'>
                  <a href='#' class='img'>
                    <img src='" . $image_src . "' alt='Image' class='img-fluid' style='width: 398px; height: 400px;' />
                  </a>
                  <div class='property-content'>
                    <div style='display: flex; justify-content: space-between;'>
                    <span style='display: flex; align-items: center;'>";
                  if ($equipmentData["equipmentType"] === "租") {
                    echo '<span class="fa-stack fa-1x" style="margin-right: 10px; ">';
                    echo '<i class="fas fa-circle fa-stack-2x" style="color:#EFE9DA;"></i>';
                    echo '<i class="fas fa-stack-1x" style="font-size: 13px;">租</i>';
                    echo '</span>';
                  } else if ($equipmentData["equipmentType"] === "徵") {
                    echo '<span class="fa-stack fa-1x" style="margin-right: 10px; ">';
                    echo '<i class="fas fa-circle fa-stack-2x" style="color:#8d703b;"></i>';
                    echo '<i class="fas fa-stack-1x fa-inverse" style="font-size: 13px;">徵</i>';
                    echo '</span>';
                  } else if ($equipmentData["equipmentType"] === "賣") {
                    echo '<span class="fa-stack fa-1x" style="margin-right: 10px; ">';
                    echo '<i class="fas fa-circle fa-stack-2x" style="color:#ba4040; "></i>';
                    echo '<i class="fas fa-stack-1x fa-inverse" style="font-size: 13px;">售</i>';
                    echo '</span>';
                  }
                  echo "<div class='city d-block'>" . $equipmentData["equipmentName"] . "</div>
                  </span>
                  <span class='span-adj'>
                    <div class='price mb-1'><span>$" . number_format($equipmentData["equipmentPrice"]) . "</span></div>
                      <form action='index.php' method='post'>
                        <input type='hidden' name='" . ($isEquipCollected ? "collectEquipDel" : "collectEquipAdd") . "' value='" . $equipmentData["equipmentId"] . "'>
                        <button type='submit' class='btn-icon'>";
                  echo "<i class='" . ($isEquipCollected ? "fas" : "fa-regular") . " fa-bookmark' " . "></i>";
                  echo "</button>
                      </form>
                  </span>
                </div>
              <div>
            <span class='d-block mb-4 mt-3 text-black-50'>
              " . $equipmentData["equipmentDescription"] . "</span>
            <footer style='margin-top:40px'>
              <div class='card-icon-footer'>
                <div class='tagcloud'>";
                  $sql_query_labels = "SELECT equipments_labels.labelId, labels.labelName
                      FROM equipments_labels
                      JOIN labels ON equipments_labels.labelId = labels.labelId
                      WHERE equipments_labels.equipmentId = '$equipmentData[equipmentId]'";
                  $result_labels = mysqli_query($conn, $sql_query_labels);

                  $printed_tags = 0;
                  while ($tags_row = mysqli_fetch_assoc($result_labels)) {
                    if ($printed_tags >= 3) {
                      break;
                    }

                    echo "<a href='#'>" . $tags_row['labelName'] . "</a>";

                    $printed_tags++;
                  }
                  echo "</div>
                <span style='display: flex; align-items: center;'>
                <form action='index.php' method='post'>
                  <input type='hidden' name='" . ($isEquipLiked ? "likeEquipDel" : "likeEquipAdd") . "' value='" . $equipmentData["equipmentId"] . "'>
                  <button type='submit' class='btn-icon'>";
                  echo "<i class='" . ($isEquipLiked ? "fas" : "fa-regular") . " fa-heart' " . "></i>";
                  echo "</button>
                </form>
                  <p style='margin-top:0px'>" . $equipmentlikeCount . "</p>
                </span>
              </div>
            </footer>
          </div>
        </div>
      </div>";
                }
              }

              ?>
              <div class="property-item">
                <a href="property-single.html" class="img">
                  <img src="images/image 3.png" alt="Image" class="img-fluid" style='width: 398px; height: 400px;' />
                </a>
                <div class="property-content">
                  <div style="display: flex; justify-content: space-between;">
                    <span style="display: flex; align-items: center;">
                      <span class="fa-stack fa-1x" style="margin-right: 5px; ">
                        <i class="fas fa-circle fa-stack-2x" style="color:#EFE9DA; font-size:24px;"></i>
                        <i class="fas fa-stack-1x" style="font-size: 13px;">租</i>
                      </span>
                      <div class="city d-block">露營帳篷</div>
                    </span>
                    <span class="span-adj">
                      <div class="price mb-1"><span>$1,291</span></div>
                      <button type="button" class="btn-icon">
                        <i class="fa-regular fa-bookmark"></i>
                      </button>
                    </span>
                  </div>
                  <div>
                    <span class="d-block mb-4 mt-3 text-black-50">
                      四人帳篷，空間大，租一天1000元，多天可有優惠，以下是帳篷的現況，有興趣者可私訊。</span>

                    <footer style="margin-top:40px">
                      <div class="card-icon-footer">
                        <div class="tagcloud">
                          <a href="property-single.html">家庭帳</a>
                          <a href="property-single.html">家庭帳</a>
                          <a href="property-single.html">帳篷</a>
                        </div>
                        <span style="display: flex; align-items: center;">
                          <i class="fa-regular fa-heart"></i>
                          <p style='margin-top:0px'>1,098</p>
                        </span>
                      </div>
                    </footer>
                  </div>
                </div>
              </div>


              <!-- 分頁導航 -->
            </div>
            <div id="testimonial-nav" class="controls" tabindex="0" aria-label="Carousel Navigation">
              <span class="prev" data-controls="prev" aria-controls="property" tabindex="-1">Prev</span>
              <span class="next" data-controls="next" aria-controls="property" tabindex="-1">Next</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section section-4 bg-light" style="padding-bottom: 0rem;">
    <div class="container">
      <div class="row justify-content-center text-center mb-5">
        <div class="col-lg-5">
          <h3 class="font-weight-bold heading text-primary mb-4">
            熱門文章推薦
          </h3>
          <p class="text-black-50">
            推薦給你時下最熱門的文章，讓你不錯過任何發燒話題！
          </p>
        </div>
      </div>
      <div class="row justify-content-between mb-5">
        <div class="col-lg-7 mb-5 mb-lg-0 order-lg-2">
          <div class="img-about dots">
            <img src="images/Rectangle 135.png" alt="Image" class="img-fluid" />
          </div>
        </div>
        <div class="col-lg-4 mt-4">

          <?php
          // 提取articles資料表裡articleLikeCount排名前五的熱門文章
          $sql = "SELECT * FROM `articles` ORDER BY `articleLikeCount` DESC LIMIT 5";
          $articleResult = mysqli_query($conn, $sql);

          // 如果有資料的話，就把資料放進$articleData裡面
          if ($articleResult && $articleResult->num_rows > 0) {
            while ($articleData = mysqli_fetch_assoc($articleResult)) {

              $articleId = $articleData["articleId"];
              $articleCreator = $articleData["accountId"];
              $articleContent = $articleData["articleContent"];

              // 使用 strtotime() 將 datetime 轉換為 Unix 時間戳
              $timestamp = strtotime($articleData["articleCreateDate"]);

              // 使用 date() 函數將 Unix 時間戳轉換為所需的格式
              $formatted_date = date('F j, Y', $timestamp);

              $files_query = "SELECT * FROM files WHERE articleId = '$articleId'";
              $files_result = mysqli_query($conn, $files_query);
              $image_src = 'images/image 3.png'; // Default image
          
              // 取得文章創作者名稱
              $author_query = "SELECT accountName FROM accounts WHERE accountId = '$articleCreator'";
              $author_result = mysqli_query($conn, $author_query);
              $author_name = mysqli_fetch_assoc($author_result)['accountName'];

              // 取得文章圖片
              // $image_src = get_first_image_src($articleContent);
              // $image_src = "../" . $image_src;
              // if (!$image_src) {
                $image_src = 'images/1.jpg';
              // }

              //取得文章留言數
              $comment_query = "SELECT COUNT(*) as comment_count FROM comments WHERE articleId = '$articleId'";
              $comment_result = mysqli_query($conn, $comment_query);
              $comment_row = mysqli_fetch_assoc($comment_result);
              $comment_count = $comment_row['comment_count'];

              echo "<div class='d-flex feature-h'>
            <div class='block-21 mb-4 d-flex'>
              <a class='blog-img mr-4' style='background-image: url(" . $image_src . ");'></a>
              <div class='text'>";
              echo "<div>";
              echo "<h3 class='heading'><a href='../article.php?articleId=" . $articleId . "'>";
              if (strlen($articleData["articleTitle"]) > 25) {
                echo wordwrap($articleData["articleTitle"], 25, "<br>");
              } else {
                echo $articleData["articleTitle"];
              }
              echo "</a></h3>";
              echo "<div class='meta'>
                  <div><a href='../article.php?articleId=" . $articleId . "'><span class='icon-calendar'></span> " . $formatted_date . "</a></div>
                  <div><a href='../article.php?articleId=" . $articleId . "'><span class='icon-person'></span> " . $author_name . "</a></div>
                  <div><a href='../article.php?articleId=" . $articleId . "'><span class='icon-chat'></span> " . $comment_count . "</a></div>
                </div>";
              echo "</div>";
              echo "</div>
            </div>
          </div>";
            }
          }



          ?>


        </div>
      </div>

      <div class="section">
        <div class="row justify-content-center footer-cta" data-aos="fade-up">
          <div class="col-lg-7 mx-auto text-center mb-3">
            <h3 class="mb-4">訂閱廣告方案，提高你的營地/商品曝光率！</h3>
            <p>
              <a href="#" target="_blank" class="btn btn-primary text-white py-3 px-4">訂閱說明</a>
            </p>
          </div>
          <!-- /.col-lg-7 -->
        </div>
        <!-- /.row -->
      </div>

      <div class="section section-5 bg-light mb-0">
        <div class="container">
          <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-6 mb-3 mt-3">
              <h3 class="font-weight-bold heading text-primary mb-4">
                各式廣告方案
              </h3>
              <p class="text-black-50">
                透過我們的廣告投放、販賣露營商品，有效提高的營地知名度和可信度，<br>吸引更多潛在客戶，帶來更多收益！
              </p>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0">
              <div class="h-100 person">
                <div class="circle">
                  <i class="fa-regular fa-clock"></i>
                </div>
                <div class="person-contents">
                  <h2 class="mb-4"><a href="#">時段選擇</a></h2>
                  <p>
                    選擇您所偏好的投放廣告時段，擁有完整屬於您的宣傳時間，
                    不與其他業者分攤。選擇時段進行廣告投放，也可以讓廣告投放更有針對性，降低無效廣告投放的浪費，從而節省廣告預算
                  </p>

                  <button class="btn-ad" data-toggle="modal" data-target="#contectus">聯絡我們</button>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0">
              <div class="h-100 person">
                <div class="circle">
                  <i class="fa-solid fa-chart-line"></i>
                </div>
                <div class="person-contents">
                  <h2 class="mb-4"><a href="#">提升曝光率</a></h2>
                  <p>
                    此平台「贏在起跑點」專為露營愛好者群打造，，您可以精準地傳達您的訊息，吸引更多熱愛野外露營的客戶。
                  </p>
                  <button class="btn-ad" data-toggle="modal" data-target="#contectus">聯絡我們</button>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0">
              <div class="h-100 person">
                <div class="circle">
                  <i class="fa-solid fa-box-open"></i>
                </div>
                <div class="person-contents">
                  <h2 class="mb-4"><a href="#">商品販賣</a></h2>
                  <p>透過「設備出租」幫助您刊登露營商品，精準地將商品陳列在露營愛好者前，以此提升商品曝光率與成交次數
                  </p>
                  <button class="btn-ad" data-toggle="modal" data-target="#contectus">聯絡我們</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px;">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle" style="color: black;">天景露營區</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa-solid fa-heart" style="color:#a0a0a0"></i>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-6" style="padding-bottom: 15px;">
                  <img src="images/Rectangle 325.png" style="width: 100%;height: 320px; border-radius: 4px;">
                </div>
                <div class="col-6" style="padding: 20px;margin-top: 20px;">
                  <span class="modal-index">
                    <i class="fa-solid fa-location-dot"></i>新竹縣五峰鄉花園村10鄰天湖205號</span>
                  <span class="modal-index">
                    <i class="fa-solid fa-mountain"></i>海拔1100公尺</span>
                  <span class="modal-index">
                    <i class="fa-solid fa-signs-post"></i>公休日:星期五</span>
                  <span class="modal-index">
                    <i class="fa-solid fa-phone"></i>0987-347-774</span>
                  <span class="modal-index">
                    <i class="fa-solid fa-globe"></i>尚無官網</span>

                  <div class="tagcloud" style="margin-top: 40px;margin-bottom: 20px;">
                    <a href="">草地</a>
                    <a href="">夜景</a>
                    <a href="">櫻花</a>
                  </div>
                  <div class="modal-more">
                    <a href="../camp-single.php"><button class="btn-more">查看更多</button></a>
                  </div>
                </div>
              </div>

              <div class="modal-index-footer" style="align-items: flex-start;">
                <h6 style="margin-bottom: 0px;">其他營地推薦</h6>
              </div>
              <div style="display: flex;">
                <span class="modal-index-footerimg">
                  <a href=""><img src="images/Rectangle 326.png" alt="" /></a>
                  <p>北埔星月天空露營區</p>
                </span>
                <span class="modal-index-footerimg">
                  <a href=""><img src="images/Rectangle 327.png" alt="" /></a>
                  <p>天方夜譚</p>
                </span>
                <span class="modal-index-footerimg">
                  <a href=""><img src="images/Rectangle 329.png" alt="" /></a>
                  <p>司馬庫斯舊部落營地</p>
                </span>
                <span class="modal-index-footerimg">
                  <a href=""><img src="images/Rectangle 328.png" alt="" /></a>
                  <p>松野農園露營區</p>
                </span>

              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="contectus" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
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
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
      <script src="https://kit.fontawesome.com/d02d7e1ecb.js"></script>

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

</html>