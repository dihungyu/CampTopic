<?php
session_start();
require_once '../php/conn.php';
require_once '../php/uuid_generator.php';

$articleId = $_GET['articleId'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="property-1.0.0/images/Group 75.png" />
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
  <link rel="stylesheet" href="property-1.0.0/css/icomoon.css">

  <style>
    #article-content .article-img {
      max-width: 100%;
      height: auto;
    }
  </style>
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
          <li class="nav-item "><a href="property-1.0.0/index.php" class="nav-link">首頁</a></li>
          <li class="nav-item"><a href="rooms.html" class="nav-link">找小鹿</a></li>
          <li class="nav-item"><a href="all-article.php" class="nav-link">鹿的分享</a></li>
          <li class="nav-item"><a href="equipment.php" class="nav-link">鹿的設備</a></li>
          <li class="nav-item"><a href="blog.html" class="nav-link">廣告方案</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="property-1.0.0/member.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              帳號
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="property-1.0.0/member.php">會員帳號</a>
              <a class="dropdown-item" href="property-1.0.0/member-like.php">我的收藏</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="../login.php">登出</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- END nav -->

  <div class="hero page-inner overlay" style="background-image: url('images/Rectangle\ 56.jpg'); 
      height:70vh;
      min-height: 300px;">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-12 text-center mt-5">
          <h1 class="heading" data-aos="fade-up">文章分享
          </h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="index.html">首頁</a></li>
              <li class="breadcrumb-item"><a href="index.html">鹿的分享</a></li>
              <li class="breadcrumb-item active text-white-50" aria-current="page">
                文章分享
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>



  <?php
  //取得文章資料
  $main_article_sql = "SELECT articles.*, accounts.accountName FROM articles JOIN accounts ON articles.accountId = accounts.accountId WHERE articleId = '$articleId'";
  $main_article_result = mysqli_query($conn, $main_article_sql);
  $main_article_row = mysqli_fetch_assoc($main_article_result);
  ?>
  <section class="ftco-section ftco-degree-bg">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 ftco-animate order-md-last">
          <span class="img-name">
            <img src="images/person_4.jpg" alt="Image description" style="border-radius: 50%; width: 5%; margin-right: 16px;">
            <label style="font-size: 16px; margin-bottom: 0px; "><?php echo $main_article_row["accountName"]; ?></label>
          </span>

          <h2 class="mb-4"><?php echo $main_article_row["articleTitle"]; ?></h2>
          <div id="article-content">
            <?php echo $main_article_row["articleContent"]; ?>
          </div>

          <!-- 此文章相關標籤 -->
          <div class="tag-widget post-tag-container mb-5 mt-5">
            <div class="tagcloud">
              <?php
              // 查詢文章相關的標籤
              $article_label_query = "SELECT articles_labels.labelId, labels.labelName FROM articles_labels JOIN labels ON articles_labels.labelId = labels.labelId WHERE articles_labels.articleId = '$articleId'";

              $article_label_result = mysqli_query($conn, $article_label_query);

              // 檢查錯誤
              if (!$article_label_result) {
                echo "Error: " . mysqli_error($conn);
              }

              $printed_article_tags = 0;
              while ($article_tags_row = mysqli_fetch_assoc($article_label_result)) {
                echo "<a href='#' class='tag-cloud-link'>" . $article_tags_row["labelName"] . "</a>";
              }
              ?>
            </div>
          </div>

          <div class="pt-5 mt-5">
            <h3 class="mb-5">6 留言</h3>
            <ul class="comment-list">
              <li class="comment">
                <div class="vcard bio">
                  <img src="images/person_1.jpg" alt="Image placeholder">
                </div>
                <div class="comment-body">
                  <h3>John Doe</h3>
                  <div class="meta">Decmener 7, 2018 at 2:21pm</div>
                  <p>露營的地方是怎麼挑選的？有什麼推薦的地方嗎？</p>
                  <span class="img-name">
                    <img src="images/person_4.jpg" alt="Image description" style="border-radius: 50%; width: 5%; margin-right: 16px;">
                    <label style="font-size: 16px; margin-bottom: 0px; ">yizzzzz</label>
                    <input value="回覆" type="search" id="form1" class="article-comment" />
                  </span>
                </div>
              </li>

              <li class="comment">
                <div class="vcard bio">
                  <img src="images/person_1.jpg" alt="Image placeholder">
                </div>
                <div class="comment-body">
                  <h3>John Doe</h3>
                  <div class="meta">Decmener 7, 2018 at 2:21pm</div>
                  <p>起來你的露營裝備都很齊全，可以分享一下你帶了哪些東西嗎？</p>

                  <span class="img-name">
                    <img src="images/person_4.jpg" alt="Image description" style="border-radius: 50%; width: 5%; margin-right: 16px;">
                    <label style="font-size: 16px; margin-bottom: 0px; ">yizzzzz</label>
                    <input value="回覆" type="search" id="form1" class="article-comment" />
                  </span>
                </div>

                <ul class="children">
                  <li class="comment">
                    <div class="vcard bio">
                      <img src="images/person_1.jpg" alt="Image placeholder">
                    </div>
                    <div class="comment-body">
                      <h3>John Doe</h3>
                      <div class="meta">Decmener 7, 2018 at 2:21pm</div>
                      <p>我也是個露營愛好者，我最喜歡的是在晚上看到滿天星星的畫面！</p>
                      <span class="img-name">
                        <img src="images/person_4.jpg" alt="Image description" style="border-radius: 50%; width: 5%; margin-right: 16px;">
                        <label style="font-size: 16px; margin-bottom: 0px; ">yizzzzz</label>
                        <input value="回覆" type="search" id="form1" class="article-comment" />
                      </span>
                    </div>

                  </li>
                </ul>
              </li>


            </ul>
            <!-- END comment-list -->

          </div>

        </div> <!-- .col-md-8 -->
        <div class="col-lg-4 sidebar ftco-animate">

          <div class="sidebar-box ftco-animate mt-5">
            <h3>熱門標籤</h3>
            <div class="tagcloud">
              <?php
              //根據資料庫裡文章類別的標籤出現次數來選擇出現次數最多的前五個標籤
              $label_query = "SELECT labels.labelName, COUNT(articles_labels.labelId) AS labelCount FROM articles_labels JOIN labels ON articles_labels.labelId = labels.labelId GROUP BY articles_labels.labelId ORDER BY labelCount DESC LIMIT 5";
              $label_result = mysqli_query($conn, $label_query);

              // 檢查錯誤
              if (!$label_result) {
                echo "Error: " . mysqli_error($conn);
              }

              while ($label_row = mysqli_fetch_assoc($label_result)) {
                echo "<a href='#' class='tag-cloud-link'>" . $label_row["labelName"] . "</a>";
              }
              ?>
            </div>
          </div>

          <div class="sidebar-box ftco-animate">
            <h3>推薦文章</h3>

            <?php
            // Top 3 熱門文章
            $top3_article_sql = "SELECT articles.*, accounts.accountName FROM articles JOIN accounts ON articles.accountId = accounts.accountId ORDER BY articleLikeCount DESC LIMIT 3";
            $top3_article_result = mysqli_query($conn, $top3_article_sql);

            if ($top3_article_result && mysqli_num_rows($top3_article_result) > 0) {
              while ($top3_article_row = mysqli_fetch_assoc($top3_article_result)) {
                $articleId = $top3_article_row["articleId"];

                $files_query = "SELECT * FROM files WHERE articleId = '$articleId'";
                $files_result = mysqli_query($conn, $files_query);
                $image_src = '../property-1.0.0/images/Rectangle\ 135.png'; // Default image

                if ($file_result = mysqli_fetch_assoc($files_result)) {
                  $file_path = str_replace('Applications/XAMPP/xamppfiles/htdocs', '../..', $file_result['filePath']);
                  $image_src = $file_path;
                }

                // 使用 strtotime() 將 datetime 轉換為 Unix 時間戳
                $timestamp = strtotime($top234_article_row["articleCreateDate"]);

                // 使用 date() 函數將 Unix 時間戳轉換為所需的格式
                $formatted_date = date('F j, Y', $timestamp);

                // 在顯示卡片之前查詢留言數
                $query = "SELECT COUNT(*) as comment_count FROM comments WHERE articleId = '$articleId'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $comment_count = $row['comment_count'];

                echo "<div class='block-21 mb-4 d-flex'>
              <a class='blog-img mr-4' style='background-image: url(" . $image_src . ");'></a>
              <div class='text'>
                <h3 class='heading'><a href='article.php?articleId=" . $articleId . "'>" . $top3_article_row["articleTitle"] . "</a></h3>
                <div class='meta'>
                  <div><a href='article.php?articleId=" . $articleId . "'><span class='icon-calendar'></span> " . $formatted_date . "</a></div>
                  <div><a href='article.php?articleId=" . $articleId . "'><span class='icon-person'></span> " . $top3_article_row["accountName"] . "</a></div>
                  <div><a href='article.php?articleId=" . $articleId . "'><span class='icon-chat'></span> " . $comment_count . "</a></div>
                </div>
              </div>
            </div>";
              }
            }
            ?>




          </div>
        </div>
      </div>
    </div>
  </section> <!-- .section -->


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
              <li><a href="property1.0.0/index.php">首頁</a></li>
              <li><a href="#">找小鹿</a></li>
              <li><a href="#">鹿的分享</a></li>
              <li><a href="#">鹿的裝備</a></li>
              <li><a href="#">廣告方案</a></li>
            </ul>
            <ul class="list-unstyled float-start links">
              <li><a href="property1.0.0/member.php">帳號</a></li>
              <li><a href="property1.0.0/member.php">會員帳號</a></li>
              <li><a href="property1.0.0/member-like.php">我的收藏</a></li>
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





    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
    <script src="js/google-map.js"></script>
    <script src="js/main.js"></script>
    <script src="https://kit.fontawesome.com/d02d7e1ecb.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#article-content img').addClass('article-img');
      });
    </script>

</body>

</html>