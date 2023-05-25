<?php
require_once '../../php/conn.php';
require_once '../../php/get_img_src.php';

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
          <li class="nav-item  active"><a href="index-manage.php" class="nav-link">首頁</a></li>
          <li class="nav-item"><a href="manage-article.php" class="nav-link">文章管理</a></li>
          <li class="nav-item"><a href="manage-equip.php" class="nav-link">設備管理</a></li>
          <li class="nav-item"><a href="manage-land.php" class="nav-link">營地管理</a></li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="member.php" id="navbarDropdown" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              帳號
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="member.php">會員帳號</a>
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
          <h1 class="heading" data-aos="fade-up">文章管理</h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="index.html">首頁</a></li>
              <li class="breadcrumb-item"><a href="member.html">管理員帳號</a></li>
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
    <div class="container" style="max-width: 1260px;">
      <div class="row mb-6 align-items-center" style="margin-top: 20px; margin-bottom: 40px;">
        <div class="col-8">
          <ul class="nav nav-tabs" style="margin-left: 16px;" id="myTab" role="tablist">
            <li class="nav-item" style="margin-right:20px">
              <a class="nav-link isReviewed" id="isReviewed-tab" data-toggle="tab" href="#isReviewed" role="tab"
                aria-controls="isReviewed" aria-selected="true">已上架</a>
            </li>
            <li class="nav-item" style="margin-right:20px">
              <a class="nav-link unReviewed" id="unReviewed-tab" data-toggle="tab" href="#unReviewed" role="tab"
                aria-controls="unReviewed" aria-selected="true">待審核</a>
            </li>
          </ul>
        </div>
        <div class="col-4">
          <div class="input-group " style="display:flex;justify-content: flex-end; margin-bottom: 40px; width: 98%;">
            <div id="navbar-search-autocomplete" class="form-outline">
              <input type="search" id="form1" name="article_search_keyword" class="form-control"
                style="height: 40px; border-radius: 35px;" placeholder="搜尋文章名稱..." />
            </div>&nbsp;
            <button type="submit" class="button-search">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show" id="isReviewed" role="tabpanel" aria-labelledby="isReviewed-tab">
      <div class="container" style="max-width: 1260px;">
        <div class="row">
          <?php
          $records_per_page = 4;
          $current_page = isset($_GET['reviewedPage']) ? $_GET['reviewedPage'] : 1;
          $offset = ($current_page - 1) * $records_per_page;

          $sql_isReviewed_articles = "SELECT articles.*, accounts.accountName FROM articles
          LEFT JOIN accounts ON articles.accountId = accounts.accountId WHERE isReviewed = 1 LIMIT $records_per_page OFFSET $offset";
          $result_isReviewed_articles = mysqli_query($conn, $sql_isReviewed_articles);
          $isReviewed_articles = [];
          if (mysqli_num_rows($result_isReviewed_articles) > 0) {
            while ($row = mysqli_fetch_assoc($result_isReviewed_articles)) {
              $isReviewed_articles[] = $row;
            }
          }

          $sql_total_articles = "SELECT COUNT(*) as total FROM articles WHERE isReviewed = 1";
          $result_total_articles = mysqli_query($conn, $sql_total_articles);
          $total_articles = mysqli_fetch_assoc($result_total_articles)['total'];
          $total_pages = ceil($total_articles / $records_per_page);

          foreach ($isReviewed_articles as $isReviewed_article) {
            $isReviewed_image_src = get_first_image_src($isReviewed_article["articleContent"]);
            if ($isReviewed_image_src == "") {
              $isReviewed_image_src = "images/news/img15.jpg";
            } else {
              $isReviewed_image_src = '../' . $isReviewed_image_src;
            }

            // 使用 strtotime() 將 datetime 轉換為 Unix 時間戳
            $isReviewed_timestamp = strtotime($isReviewed_article["articleCreateDate"]);
            // 使用 date() 函數將 Unix 時間戳轉換為所需的格式
            $isReviewed_formatted_date = date('F j, Y', $isReviewed_timestamp);

            //若文章內容超過30字做限制
            $isReviewed_content_length = mb_strlen(strip_tags($isReviewed_article["articleContent"]), 'UTF-8');
            if ($isReviewed_content_length > 30) {
              $isReviewed_content = mb_substr(strip_tags($isReviewed_article["articleContent"]), 0, 80, 'UTF-8') . '...'; // 截斷文章內容
            } else {
              $isReviewed_content = strip_tags($isReviewed_article["articleContent"]);
            }

            echo '<article class="col-md-12 article-list">';
            echo '  <div class="inner isReviewed-card">';
            echo '    <figure>';
            echo '  <a href="../article-manage.php?articleId=' . $isReviewed_article['articleId'] . '">';
            echo '        <img src="' . $isReviewed_image_src . '">';
            echo '      </a>';
            echo '    </figure>';
            echo '    <div class="details">';
            echo '      <div class="detail" style="justify-content: space-between;">';
            echo '        <span style="display: flex;">';
            echo '          <div class="category">';
            echo '            <a href="#">' . $isReviewed_article['accountName'] . '</a>';
            echo '          </div>';
            echo '          <div class="time">' . $isReviewed_formatted_date . '</div>';
            echo '        </span>';
            echo '      </div>';
            echo '  <a href="../article-manage.php?articleId=' . $isReviewed_article['articleId'] . '">';
            echo '      <h1 class="city">' . $isReviewed_article['articleTitle'] . '</h1>';
            echo '  </a>';
            echo '      <p>' . $isReviewed_content . '</p>';
            echo '      <footer style="display: flex;align-items: center; justify-content: space-between;">';
            echo '        <span style="display: flex;align-items: center;">';
            $isReviewed_commentCount = "SELECT COUNT(*) as total FROM comments WHERE articleId = '" . $isReviewed_article["articleId"] . "'";
            $result_isReviewed_commentCount = mysqli_query($conn, $isReviewed_commentCount);
            $row_isReviewed_commentCount = mysqli_fetch_assoc($result_isReviewed_commentCount);
            $isReviewed_comment_total = $row_isReviewed_commentCount['total'];
            echo '          <p>' . $isReviewed_comment_total . ' 留言</p>';
            echo '        </span>';
            echo '        <span style="display: flex; align-items: center; margin-right: 80px;">';
            echo '          <i class="fa-regular fa-heart"></i>';
            echo '          <p style="margin-right: 0px;">' . format_count($isReviewed_article["articleLikeCount"]) . '</p>';
            echo '        </span>';
            echo '      </footer>';
            echo '    </div>';
            echo '  </div>';
            echo '</article>';
          }
          ?>
        </div>
        <div class="row align-items-center py-5">
          <div class="col-lg-3"></div>
          <div class="col-lg-6 text-center">
            <div class="custom-pagination">
              <?php
              for ($i = 1; $i <= $total_pages; $i++) {
                $active_class = ($i == $current_page) ? 'class="active"' : '';
                echo "<a href=\"?reviewedPage=$i&tab=isReviewed\" $active_class>$i</a>";
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="tab-pane fade" id="unReviewed" role="tabpanel" aria-labelledby="unReviewed-tab">
      <div class="container" style="max-width: 1260px;">
        <div class="row">
          <?php
          $recordsPerPage = 6;
          $currentPage = isset($_GET['unReviewedPage']) ? $_GET['unReviewedPage'] : 1;
          $offSet = ($currentPage - 1) * $recordsPerPage;

          $sql_unReviewed_articles = "SELECT articles.*, accounts.accountName FROM articles
            LEFT JOIN accounts ON articles.accountId = accounts.accountId WHERE isReviewed = 0 LIMIT $records_per_page OFFSET $offset";
          $result_unReviewed_articles = mysqli_query($conn, $sql_unReviewed_articles);
          $unReviewed_articles = [];
          if (mysqli_num_rows($result_unReviewed_articles) > 0) {
            while ($row = mysqli_fetch_assoc($result_unReviewed_articles)) {
              $unReviewed_articles[] = $row;
            }
          }

          $sql_total_unReviewed_articles = "SELECT COUNT(*) as total FROM articles WHERE isReviewed = 0";
          $result_total_unReviewed_articles = mysqli_query($conn, $sql_total_unReviewed_articles);
          $total_unReviewed_articles = mysqli_fetch_assoc($result_total_unReviewed_articles)['total'];
          $total_unReviewed_pages = ceil($total_unReviewed_articles / $recordsPerPage);

          foreach ($unReviewed_articles as $unReviewed_article) {
            $unReviewed_image_src = get_first_image_src($unReviewed_article["articleContent"]);
            if ($unReviewed_image_src == "") {
              $unReviewed_image_src = "images/news/img15.jpg";
            } else {
              $unReviewed_image_src = '../' . $unReviewed_image_src;
            }

            // 使用 strtotime() 將 datetime 轉換為 Unix 時間戳
            $unReviewed_timestamp = strtotime($unReviewed_article["articleCreateDate"]);
            // 使用 date() 函數將 Unix 時間戳轉換為所需的格式
            $unReviewed_formatted_date = date('F j, Y', $unReviewed_timestamp);

            //若文章內容超過30字做限制
            $unReviewed_content_length = mb_strlen(strip_tags($unReviewed_article["articleContent"]), 'UTF-8');
            if ($unReviewed_content_length > 30) {
              $unReviewed_content = mb_substr(strip_tags($unReviewed_article["articleContent"]), 0, 80, 'UTF-8') . '...'; // 截斷文章內容
            } else {
              $unReviewed_content = strip_tags($unReviewed_article["articleContent"]);
            }

            echo '<article class="col-md-12 article-list">';
            echo '  <div class="inner unReviewed-card">';
            echo '    <figure>';
            echo '  <a href="../article-manage.php?articleId=' . $unReviewed_article['articleId'] . '">';
            echo '        <img src="' . $unReviewed_image_src . '">';
            echo '      </a>';
            echo '    </figure>';
            echo '    <div class="details">';
            echo '      <div class="detail" style="justify-content: space-between;">';
            echo '        <span style="display: flex;">';
            echo '          <div class="category">';
            echo '            <a href="#">' . $unReviewed_article["accountName"] . '</a>';
            echo '          </div>';
            echo '          <div class="time">' . $unReviewed_formatted_date . '</div>';
            echo '        </span>';
            echo '      </div>';
            echo '  <a href="../article-manage.php?articleId=' . $unReviewed_article['articleId'] . '">';
            echo '      <h1 class="city">' . $unReviewed_article["articleTitle"] . '</h1>';
            echo '  </a>';
            echo '      <p>' . $unReviewed_content . '</p>';
            echo '      <footer style="display: flex;align-items: center; justify-content: space-between;">';
            echo '        <span style="display: flex;align-items: center;">';
            $unReviewed_commentCount = "SELECT COUNT(*) as total FROM comments WHERE articleId = '" . $unReviewed_article["articleId"] . "'";
            $result_unReviewed_commentCount = mysqli_query($conn, $unReviewed_commentCount);
            $row_unReviewed_commentCount = mysqli_fetch_assoc($result_unReviewed_commentCount);
            $unReviewed_comment_total = $row_unReviewed_commentCount['total'];
            echo '          <p>' . $unReviewed_comment_total . ' 留言</p>';
            echo '        </span>';
            echo '<span style="display: flex; justify-content: flex-end; align-items: center;">';
            echo '          <i class="fa-regular fa-heart" style="margin-left: 5px;"></i>';
            echo '          <p style="margin-right: 0px; margin-left: 5px;">' . format_count($unReviewed_article["articleLikeCount"]) . '</p>';
            echo '            <i class="fas fa-flag" style="font-weight: 500; color: #000; margin-left: 5px;"></i>';
            $sql_report_count = "SELECT COUNT(*) AS reportCount FROM reports WHERE articleId = '" . $unReviewed_article["articleId"] . "'";
            $result_report_count = mysqli_query($conn, $sql_report_count);
            $row_report_count = mysqli_fetch_assoc($result_report_count);
            echo '            <p style="margin-right: 0px; margin-left: 5px;">' . format_count($row_report_count["reportCount"]) . '</p>';
            echo '        </span>';
            echo '      </footer>';
            echo '    </div>';
            echo '  </div>';
            echo '</article>';
          }
          ?>
        </div>
        <div class="row align-items-center py-5">
          <div class="col-lg-3"></div>
          <div class="col-lg-6 text-center">
            <div class="custom-pagination">
              <?php
              for ($k = 1; $k <= $total_unReviewed_pages; $k++) {
                $activeClass = ($k == $currentPage) ? 'class="active"' : '';
                echo "<a href=\"?unReviewedPage=$k&tab=unReviewed\" $activeClass>$k</a>";
              }
              ?>
            </div>
          </div>
        </div>
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

  <script>
    $(document).ready(function () {
      function showTab(tab) {
        if (tab === 'isReviewed') {
          $('#isReviewed-tab').addClass('active');
          $('#unReviewed-tab').removeClass('active');
          $('#isReviewed').addClass('show active');
          $('#unReviewed').removeClass('show active');
          window.location.hash = 'isReviewed';
        } else if (tab === 'unReviewed') {
          $('#unReviewed-tab').addClass('active');
          $('#isReviewed-tab').removeClass('active');
          $('#unReviewed').addClass('show active');
          $('#isReviewed').removeClass('show active');
          window.location.hash = 'unReviewed';
        }
      }

      // 當 "已上架" tab 被點擊時的觸發事件
      $('#isReviewed-tab').on('click', function () {
        showTab('isReviewed');
      });

      // 當 "待審核" tab 被點擊時的觸發事件
      $('#unReviewed-tab').on('click', function () {
        showTab('unReviewed');
      });

      // 根據網址的 hash 來初始顯示的分頁內容
      var currentHash = window.location.hash.slice(1);

      // 獲取URL中的tab參數
      var urlParams = new URLSearchParams(window.location.search);
      var tabParam = urlParams.get('tab');

      if (tabParam === 'unReviewed') {
        showTab('unReviewed');
      } else if (tabParam === 'isReviewed') {
        showTab('isReviewed');
      } else if (currentHash === 'unReviewed') {
        showTab('unReviewed');
      } else {
        showTab('isReviewed');
      }

      // 搜索功能
      $('#form1').on('input', function () {
        let searchKeyword = $(this).val().toLowerCase();
        let activeTab = $('.nav-link.active').hasClass('isReviewed') ? 'isReviewed' : 'unReviewed';
        let targetCards = activeTab === 'isReviewed' ? '.isReviewed-card' : '.unReviewed-card';

        $(targetCards).each(function () {
          let articleName = $(this).find('.city').text().toLowerCase();
          if (articleName.indexOf(searchKeyword) !== -1) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });
      });

    });
  </script>



</body>

</html>