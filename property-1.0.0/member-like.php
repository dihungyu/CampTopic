<?php
session_start();
// $accountId = $_SESSION["accountId"];
// $accountName = $_SESSION["accoutName"];
// $accountEmail = $_SESSION["accoutEmail"];
$accountId = "c995dbc4be4811eda1d4e22a0f5e8454";

require_once("../php/conn.php");



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

  <!-- 引入 Bootstrap 的 CSS 檔案 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" integrity="sha512-6YRlfqlTKP+w6p+UqV3c6fPq7VpgG6+Iprc+OLIj6pw+hSWRZfY6UaV7eXQ/hGxVrUvj3amJ3Thf5Eu5OV5+aw==" crossorigin="anonymous" />


  <style>
    .article-list {
      flex-wrap: wrap;
    }

    .inner {
      width: 100%;
      padding-left: 15px;
      padding-right: 15px;
      display: flex;
      flex-wrap: wrap;
    }

    .card {
      flex: 0 0 calc(33.3333% - 10px);
      margin: 0 10px 10px 0;
    }
  </style>




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
      <a href="index.html"><img class="navbar-brand" src="images/Group 59.png" style="width: 90px; height: auto;"></img></a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
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
            <a class="nav-link dropdown-toggle" href="member.html" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              帳號
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="member.html">會員帳號</a>
              <a class="dropdown-item" href="member-like.html">我的收藏</a>
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
          <h1 class="heading" data-aos="fade-up">收藏清單</h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="index.html">首頁</a></li>
              <li class="breadcrumb-item"><a href="member.html">會員帳號</a></li>
              <li class="breadcrumb-item active text-white-50" aria-current="page">
                我的收藏
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

        <ul class="nav nav-tabs" style="margin-left: 16px; width: 62%; " id="myTab" role="tablist">
          <li class="nav-item" style="margin-right:20px">
            <a class="nav-link land" id="land-tab" data-toggle="tab" href="#land" role="tab" aria-controls="land" aria-selected="true">營地</a>
          </li>
          <li class="nav-item" style="margin-right:20px">
            <a class=" nav-link paper" id="paper-tab" data-toggle="tab" href="#paper" role="tab" aria-controls="paper" aria-selected="true">文章</a>
          </li>
          <li class="nav-item" style="margin-right:20px">
            <a class="nav-link equip" id="equip-tab" data-toggle="tab" href="#equip" role="tab" aria-controls="equip" aria-selected="true">設備</a>
          </li>

        </ul>


      </div>
    </div>

    <div class="tab-content" id="myTabContent">

      <!-- 收藏營區 -->
      <div class="tab-pane fade show active" id="land" role="tabpanel" aria-labelledby="land-tab">
        <div class="section section-properties">
          <div class="container">
            <div class="row">

              <div class="container">
                <div class="row">
                  <div class="col-md-12">
                    <form method="GET" action="" class="mb-4">
                    <div class="input-group " style="display:flex;justify-content: flex-end; margin-bottom: 40px; width: 98%;">
                      <div id="navbar-search-autocomplete" class="form-outline">
                      <input type="search" id="form1" class="form-control" style="height: 40px; border-radius: 35px;"/>
                      </div>&nbsp;
                      <button type="button" class="button-search">
                      <i class="fas fa-search"></i>
                      </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>






              <?php
              // 搜尋關鍵字
              $camp_search_keyword = isset($_GET['camp_search_keyword']) ? trim($_GET['camp_search_keyword']) : '';

              // 先找出該使用者收藏的營地id
              $sql = "SELECT campsiteId FROM collections WHERE accountId='$accountId'";
              $result = $conn->query($sql);

              // 檢查是否有結果，如果有則進行營地查詢
              if ($result && $result->num_rows > 0) {
                // 建立一個空陣列，用於存儲收藏的營地id
                $campsiteIds = array();

                // 循環遍歷所有收藏的營地id，將其存入$campsiteIds陣列中
                while ($row = $result->fetch_assoc()) {
                  $campsiteIds[] = $row['campsiteId'];
                }

                // 將陣列轉換為 SQL 語句中的 IN 條件，並在每個營地 ID 前後添加單引號
                $campsiteIdsStr = implode(',', array_map(function ($id) {
                  return "'$id'";
                }, $campsiteIds));

                // 使用收藏的營地id去查詢相關營地資料的總數
                $camp_keyword_condition = $camp_search_keyword ? "AND campsiteName LIKE '%$camp_search_keyword%'" : "";
                $count_sql = "SELECT COUNT(*) as total FROM campsites WHERE campsiteId IN ($campsiteIdsStr) $camp_keyword_condition";
                $count_result = $conn->query($count_sql);
                $row = $count_result->fetch_assoc();
                $total_rows = $row['total'];
                $total_pages = ceil($total_rows / 9);

                $perPage = 9;
                $camp_current_page = isset($_GET['camp_page']) ? (int)$_GET['camp_page'] : 1;
                $offset = ($camp_current_page - 1) * $perPage;

                // 使用收藏的營地id去查詢相關營地資料
                $sql = "SELECT * FROM campsites WHERE campsiteId IN ($campsiteIdsStr) $camp_keyword_condition LIMIT $offset, $perPage";
                $campsiteResult = $conn->query($sql);


                // 檢查是否有結果，如果有則輸出營地資料
                if ($campsiteResult && $campsiteResult->num_rows > 0) {
                  $cardCounter = 0;
                  while ($campsiteData = $campsiteResult->fetch_assoc()) {
                    if ($cardCounter % 3 == 0) {
                      echo "<article class='col-md-12 article-list' style='display: flex;'>
                      <div class='inner' style='display: flex;'>";
                    }

                    $files_query = "SELECT * FROM files WHERE campsiteId = '$campsiteData[campsiteId]'";
                    $files_result = mysqli_query($conn, $files_query);
                    $image_src = 'images/Rectangle 137.png'; // Default image

                    if ($file_result = mysqli_fetch_assoc($files_result)) {
                      $file_path = str_replace('Applications/XAMPP/xamppfiles/htdocs', '../..', $file_result['filePath']);
                      $image_src = $file_path;
                    }
                    // Card content
                    echo "<div class='card'>
                  <img src='" . $image_src . "' class='card-img-top' alt='...'>
                  <div class='card-body'>
                    <h4>$" . $campsiteData["campsiteLowerLimit"] . "~$" . $campsiteData["campsiteUpperLimit"] . "</h4>
                    <div class='detail'>
                      <h1><a href='single.html'>" . $campsiteData["campsiteName"] . "</a></h1>
                    </div>
                    <p>" . $campsiteData["campsiteAddress"] . "</p>
                    <footer>";
                    echo "<span>";
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

                      echo "<button class='tag-fav'>
              <a href='property-single.html' style='color: #000;'>" . $tags_row['labelName'] . "</a>
          </button>";

                      $printed_tags++;
                    }
                    echo "</span>";
                    echo "</footer>
                  </div>
                </div>";

                    $cardCounter++;

                    if ($cardCounter % 3 == 0) {
                      echo "</div>
                  </article>";
                    }
                  }

                  // Close the last <article> if needed
                  if ($cardCounter % 3 != 0) {
                    echo "</div>
              </article>";
                  }
                }
              }
              ?>

              <div class="row align-items-center py-5">
                <div class="col-lg-3"></div>
                <div class="col-lg-6 text-center">
                  <div class="custom-pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                      <a href="?camp_page=<?= $i ?>#land" <?= ($i == $camp_current_page) ? 'class="active"' : '' ?>><?= $i ?></a>
                    <?php endfor; ?>
                  </div>
                </div>
              </div>





            </div>
          </div>
        </div>
      </div>

      <!-- 收藏文章區 -->
      <div class="tab-pane fade show " id="paper" role="tabpanel" aria-labelledby="paper-tab">
        <div class="container">
          <div class="row">
            <?php


            // 先找出該使用者收藏的文章id
            $sql = "SELECT articleId FROM collections WHERE accountId='$accountId'";
            $result = $conn->query($sql);

            // 檢查是否有結果，如果有則進行營地查詢
            if ($result && $result->num_rows > 0) {
              // 建立一個空陣列，用於存儲收藏的文章id
              $articleIds = array();

              // 循環遍歷所有收藏的文章id，將其存入$articleIds陣列中
              while ($row = $result->fetch_assoc()) {
                $articleIds[] = $row['articleId'];
              }

              // 將陣列轉換為 SQL 語句中的 IN 條件，並在每個文章 ID 前後添加單引號
              $articleIdsStr = implode(',', array_map(function ($id) {
                return "'$id'";
              }, $articleIds));


              // 使用收藏的文章id去查詢相關文章資料的總數
              $article_count_sql = "SELECT COUNT(*) as total FROM articles WHERE articleId IN ($articleIdsStr)";
              $article_count_result = $conn->query($article_count_sql);
              $row = $article_count_result->fetch_assoc();
              $article_total_rows = $row['total'];
              $article_total_pages = ceil($article_total_rows / 9);

              $article_perPage = 9;
              $article_current_page = isset($_GET['article_page']) ? (int)$_GET['article_page'] : 1;
              $article_offset = ($article_current_page - 1) * $article_perPage;

              // 使用收藏的文章id去查詢相關文章資料
              $sql = "SELECT articles.*, accounts.accountName FROM articles
            LEFT JOIN accounts ON articles.accountId = accounts.accountId
            WHERE articleId IN ($articleIdsStr)
            LIMIT $article_offset, $article_perPage";

              $articleResult = $conn->query($sql);


              // 檢查是否有結果，如果有則輸出文章資料
              if ($articleResult && $articleResult->num_rows > 0) {

                $counter = 0;
                while ($articleData = $articleResult->fetch_assoc()) {


                  $files_query = "SELECT * FROM files WHERE articleId = '$articleData[articleId]'";
                  $files_result = mysqli_query($conn, $files_query);
                  $image_src = 'images/news/img15.jpg'; // Default image

                  if ($file_result = mysqli_fetch_assoc($files_result)) {
                    $file_path = str_replace('Applications/XAMPP/xamppfiles/htdocs', '../..', $file_result['filePath']);
                    $image_src = $file_path;
                  }

                  // 使用 strtotime() 將 datetime 轉換為 Unix 時間戳
                  $timestamp = strtotime($articleData["articleCreateDate"]);

                  // 使用 date() 函數將 Unix 時間戳轉換為所需的格式
                  $formatted_date = date('F j, Y', $timestamp);

                  //若文章內容超過30字做限制
                  $content_length = mb_strlen($articleData["articleContent"], 'UTF-8');
                  if ($content_length > 30) {
                    $truncated_content = mb_substr($articleData["articleContent"], 0, 30, 'UTF-8') . '...';
                  } else {
                    $truncated_content = $articleData["articleContent"];
                  }

                  // 在顯示卡片之前查詢留言數
                  $articleId = $articleData["articleId"];
                  $query = "SELECT COUNT(*) as comment_count FROM comments WHERE articleId = '$articleId'";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);
                  $comment_count = $row['comment_count'];

                  // 格式化按讚數
                  $formatted_like_count = format_like_count($articleData["articleLikeCount"]);



                  // Card content
                  echo "<article class='col-md-8 article-list'>
                  <div class='inner'>
                    <figure>
                      <a href='single.html'>
                        <img src='" . $image_src . "'>
                      </a>
                    </figure>
                    <div class='details'>
                      <div class='detail'>
                        <div class='category'>
                          <a href='category.html'>" . $articleData["accountName"] . "</a>
                        </div>
                        <div class='time'>" . $formatted_date . "</div>
                      </div>
                      <h1><a href='single.html'>" . $articleData["articleTitle"] . "</a></h1>
                      <p>
                        " . $truncated_content . "
                      </p>
                      <footer>
                        <p style='white-space: nowrap;'>" . $comment_count . " 則留言</p>
                        <i class='fa-regular fa-heart'></i>
                        <p style='margin-right: 0px;'>" . $formatted_like_count . "</p>
                      </footer>
                    </div>
                  </div>
                </article>";
                  if ($counter <= 1) {
                    $counter++;
                    echo "<div class='col-md-4 sidebar'>
            <aside>
              <div class='aside-body'>
                <figure class='ads'>
                  <a href='single.html'>
                    <img src='images/Group 74.png'>
                  </a>
                  <figcaption>Advertisement</figcaption>
                </figure>
              </div>
            </aside>
          </div>";
                  }
                }
              }
            }
            ?>

            <div class="row align-items-center py-5">
              <div class="col-lg-3"></div>
              <div class="col-lg-6 text-center">
                <div class="custom-pagination">
                  <?php for ($i = 1; $i <= $article_total_pages; $i++) : ?>
                    <a href="?article_page=<?= $i ?>#paper" <?= ($i == $article_current_page) ? 'class="active"' : '' ?>><?= $i ?></a>
                  <?php endfor; ?>
                </div>
              </div>
            </div>



          </div>
        </div>
      </div>

      <div class="tab-pane fade show " id="equip" role="tabpanel" aria-labelledby="equip-tab">
        <div class="container">
          <div class="row">

            <article class="col-md-8 article-list" style="display: flex;">
              <div class="inner" style="display: flex; ">
                <div class="card">
                  <img src="images/M85318677_big.jpeg" class="card-img-top" alt="...">

                  <div class="card-body">
                    <div class="detail">
                      <span class="fa-stack fa-1x" style="margin-right: 5px; ">
                        <i class="fas fa-circle fa-stack-2x" style="color:#EFE9DA; font-size:24px;"></i>
                        <i class="fas fa-stack-1x" style="font-size: 13px;">租</i>
                      </span>
                      <h1><a href="single.html">露營帳篷</a></h1>
                      <h5>$1,000</h5>
                    </div>
                    <p class="card-text">
                      四人帳篷，空間大，租一天1000元，多天可有優惠，以下是帳篷的現況，有興趣者可私訊。</p>
                    <footer style="margin-top:40px">
                      <span>
                        <div class="card-icon-footer">
                          <p>100 留言</p>
                          <p>30 分享</p>
                          <i class="fa-regular fa-eye"></i>
                          <p>1,098</p>
                        </div>
                      </span>
                    </footer>
                  </div>
                </div>
                <div class="card">
                  <img src="images/M85318677_big.jpeg" class="card-img-top" alt="...">

                  <div class="card-body">
                    <div class="detail">
                      <span class="fa-stack fa-1x" style="margin-right: 5px; ">
                        <i class="fas fa-circle fa-stack-2x" style="color:#EFE9DA; font-size:24px;"></i>
                        <i class="fas fa-stack-1x" style="font-size: 13px;">租</i>
                      </span>
                      <h1><a href="single.html">露營帳篷</a></h1>
                      <h5>$1,000</h5>
                    </div>
                    <p class="card-text">
                      四人帳篷，空間大，租一天1000元，多天可有優惠，以下是帳篷的現況，有興趣者可私訊。</p>
                    <footer style="margin-top:40px">
                      <span>
                        <div class="card-icon-footer">
                          <p>100 留言</p>
                          <p>30 分享</p>
                          <i class="fa-regular fa-eye"></i>
                          <p>1,098</p>
                        </div>
                      </span>
                    </footer>
                  </div>
                </div>
              </div>
            </article>


            <div class="col-md-4 sidebar">
              <aside>
                <div class="aside-body">
                  <figure class="ads">
                    <a href="single.html">
                      <img src="images/Group 74.png">
                    </a>
                    <figcaption>Advertisement</figcaption>
                  </figure>
                </div>

              </aside>

            </div>
            <article class="col-md-8 article-list" style="display: flex;">
              <div class="inner" style="display: flex; ">
                <div class="card">
                  <img src="images/M85318677_big.jpeg" class="card-img-top" alt="...">

                  <div class="card-body">
                    <div class="detail">
                      <span class="fa-stack fa-1x" style="margin-right: 5px; ">
                        <i class="fas fa-circle fa-stack-2x" style="color:#8d703b; font-size:24px;"></i>
                        <i class="fas fa-stack-1x fa-inverse" style="font-size: 13px;">徵</i>
                      </span>
                      <h1><a href="single.html">露營帳篷</a></h1>
                      <h5>$1,000</h5>
                    </div>
                    <p class="card-text">
                      四人帳篷，空間大，租一天1000元，多天可有優惠，以下是帳篷的現況，有興趣者可私訊。</p>
                    <footer style="margin-top:40px">
                      <span>
                        <div class="card-icon-footer">
                          <p>100 留言</p>
                          <p>30 分享</p>
                          <i class="fa-regular fa-eye"></i>
                          <p>1,098</p>
                        </div>
                      </span>
                    </footer>
                  </div>
                </div>
                <div class="card">
                  <img src="images/M85318677_big.jpeg" class="card-img-top" alt="...">

                  <div class="card-body">
                    <div class="detail">
                      <span class="fa-stack fa-1x" style="margin-right: 5px;">
                        <i class="fas fa-circle fa-stack-2x" style="color:#ba4040; font-size:24px;"></i>
                        <i class="fas fa-stack-1x fa-inverse" style="font-size: 13px;">售</i>
                      </span>
                      <h1><a href="single.html">露營帳篷</a></h1>
                      <h5>$1,000</h5>
                    </div>
                    <p class="card-text">
                      四人帳篷，空間大，租一天1000元，多天可有優惠，以下是帳篷的現況，有興趣者可私訊。</p>
                    <footer style="margin-top:40px">
                      <span>
                        <div class="card-icon-footer">
                          <p>100 留言</p>
                          <p>30 分享</p>
                          <i class="fa-regular fa-eye"></i>
                          <p>1,098</p>
                        </div>
                      </span>
                    </footer>
                  </div>
                </div>
              </div>
            </article>
          </div>
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
    <!-- 引入 Bootstrap 的 JavaScript 檔案，放在 </body> 前面 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.min.js" integrity="sha512-KsH8Gw+WJ4ZfTw3YqzWmn9pPpxdG+R14gTVjTdwryW8f/WQHm4mZ4z3qf0Wm9vBISlRlSjFVCyTlkWbBBwF0iA==" crossorigin="anonymous" defer></script>

    <script>
      $(document).ready(function() {
        // Check if the URL hash is "#paper", "#land", or "#equip"
        if (window.location.hash === "#paper") {
          // Remove "active" class from other tabs
          $('.nav-link.land').removeClass('active');
          $('.tab-pane#land').removeClass('active');
          $('.nav-link.equip').removeClass('active');
          $('.tab-pane#equip').removeClass('active');

          // Add "active" class to the "文章" tab
          $('.nav-link.paper').addClass('active');
          $('.tab-pane#paper').addClass('active');
        } else if (window.location.hash === "#land") {
          // Remove "active" class from other tabs
          $('.nav-link.paper').removeClass('active');
          $('.tab-pane#paper').removeClass('active');
          $('.nav-link.equip').removeClass('active');
          $('.tab-pane#equip').removeClass('active');

          // Add "active" class to the "營地" tab
          $('.nav-link.land').addClass('active');
          $('.tab-pane#land').addClass('active');
        } else if (window.location.hash === "#equip") {
          // Remove "active" class from other tabs
          $('.nav-link.paper').removeClass('active');
          $('.tab-pane#paper').removeClass('active');
          $('.nav-link.land').removeClass('active');
          $('.tab-pane#land').removeClass('active');

          // Add "active" class to the "設備" tab
          $('.nav-link.equip').addClass('active');
          $('.tab-pane#equip').addClass('active');
        }
      });
    </script>

    <script>
      // 獲取搜尋圖標和搜尋容器元素
      const searchIcon = document.querySelector('.search-icon');
      const searchContainer = document.querySelector('.search-container');

      // 為搜尋圖標添加點擊事件
      searchIcon.addEventListener('click', () => {
        // 切換搜尋容器的顯示狀態
        searchContainer.style.display = searchContainer.style.display === 'none' ? 'flex' : 'none';
      });
    </script>






</body>

</html>