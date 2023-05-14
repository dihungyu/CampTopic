<?php
session_start();
//判斷是否登入
if (!isset($_COOKIE["accountId"])) {
  $_SESSION["system_message"] = "請先登入或註冊成為會員!";
  header("Location: ../all-article.php");
  exit;
}
require_once '../../php/conn.php';
require_once '../../php/get_img_src.php';

$accountId = $_COOKIE["accountId"];
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
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="author" content="Untree.co" />
  <link rel="shortcut icon" href="images/Frame 5.png" />

  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap5" />
  <title>
    Start Camping &mdash; 一起展開露營冒險！
  </title>


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


  <!-- 引入Bootstrap CSS -->
  <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" /> -->

  <!-- 引入Summernote CSS -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet" />

  <!-- select2 -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->

  <!-- choices.js -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">


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
          <h1 class="heading" data-aos="fade-up">文章管理</h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
              <li class="breadcrumb-item"><a href="../all-article.php">鹿的分享</a></li>
              <li class="breadcrumb-item active text-white-50" aria-current="page">
                文章管理
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



    <?php
    // 取得使用者頭像
    $image_src = get_profileImg_src($accountId, $conn);

    ?>
    <div class="section section-properties">
      <div class="container">
        <div class="row">
          <span style="margin-left: 80px; margin-bottom: 20px;" class="mt-2 mb-4">
            <img src="<?php echo $image_src; ?>" alt="Image description" style="border-radius: 50%; width: 40px; height:40px;">
            <label style="font-size: 14px; margin-bottom: 0px;margin-left: 20px; font-weight: 600; ">
              <?php echo $_COOKIE["accountName"]; ?>
            </label>
          </span>



        </div>
        </span>
        <span style="display:flex; justify-content:center;margin-left:20px">
          <form id="article-form" action="save-article.php" method="post" enctype="multipart/form-data">

            <span style="display:flex;align-items: flex-end;flex-wrap: wrap;margin-bottom: 16px;margin-top: 16px;">
              <input type="text" name="articleTitle" placeholder="文章標題" class="articletitle">
            </span>

            <select id="tags-select" name="tags[]" multiple style="width: 100%;">
              <!-- 你的選項將在這裡生成，就像在你原始的程式碼中一樣 -->
              <?php
              $sql = "SELECT labelId, labelName FROM labels WHERE labelType = '文章'";
              $result = mysqli_query($conn, $sql);

              if (mysqli_num_rows($result) > 0) { // 檢查是否有資料
                while ($row = mysqli_fetch_assoc($result)) {
                  echo '<option value="' . $row['labelId'] . '">' . $row['labelName'] . '</option>';
                }
              }
              ?>

            </select>

            <textarea id="summernote-editor" name="articleContent" placeholder="開始撰寫貼文..." rows="20" class="articletext"></textarea>
        </span>
        <span>
        </span>

        <span style="display:flex;justify-content: flex-end;margin-right: 10px;">
          <input type="hidden" name="accountId" value="<?php echo $_COOKIE["accountId"] ?>">
          <input type="hidden" name="action" value="insert">
          <a href="../all-article.php"><button class="btn-new1" style="margin-right:10px">取消</button></a>
          <button class="btn-new" type="submit">分享</button>

        </span>
        </form>






      </div>
    </div>
  </div>

  <br><br>


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
  <script src="js/uploadphoto.js"></script>
  <!-- 引入jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <!-- 引入Bootstrap JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

  <!-- 引入Summernote JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/lang/summernote-zh-TW.min.js"></script>

  <!-- Select2 JavaScript -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

  <!-- 引入Choices JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#summernote-editor').summernote({

        // 設置編輯器的語言為繁體中文
        lang: 'zh-TW',
        height: 500, // 設置編輯器的高度
        minHeight: null, // 設置編輯器的最小高度
        maxHeight: null, // 設置編輯器的最大高度
        focus: true, // 設置自動聚焦到編輯器
        placeholder: '請輸入內容', // 設置placeholder

      });
    });
  </script>


  <script>
    $(document).ready(function() {
      $('#summernote-editor').summernote({
        callbacks: {
          onImageUpload: function(files) {
            var maxSize = 2 * 1024 * 1024; // 限制檔案大小為 2 MB
            if (files[0].size > maxSize) {
              alert('檔案大小不能超過 2 MB');
              return;
            }
            var formData = new FormData();
            formData.append('file', files[0]);

            $.ajax({
              url: '../../php/upload_image.php',
              method: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              success: function(response) {
                $('#summernote-editor').summernote('insertImage', response.imageUrl);
              },
              error: function(error) {
                console.error('圖片上傳失敗', error);
              }
            });
          }
        }
      });
    });
  </script>


  <!-- <script>
    $(document).ready(function() {
      $('#tags-select').select2({
        placeholder: '請選擇標籤'
      });
    });
  </script> -->

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const choices = new Choices('#tags-select', {
        removeItemButton: true,
        searchEnabled: false,
        placeholderValue: '請選擇標籤...',
        searchPlaceholderValue: '搜尋標籤',
        maxItemCount: 5
      });
    });
  </script>



</body>

</html>