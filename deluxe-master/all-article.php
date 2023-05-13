<?php
// 開啟錯誤報告
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once "../php/conn.php";
require_once "../php/uuid_generator.php";
require_once "../php/get_img_src.php";
session_start();

//判斷是否登入，若有則對變數初始化
if (isset($_COOKIE["accountId"])) {
  $accountId = $_COOKIE["accountId"];
}

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

function getArticles($conn, $labelId = null, $article_search_keyword = '', $article_page = 1)
{
  $conditions = array();

  if ($article_search_keyword) {
    $conditions[] = "articleTitle LIKE '%$article_search_keyword%'";
  }

  $whereClause = count($conditions) > 0 ? 'WHERE ' . implode(' AND ', $conditions) : '';

  // 如果提供了$labelId，则使用INNER JOIN连接articles_labels表
  if ($labelId) {
    $joinClause = "INNER JOIN articles_labels ON articles.articleId = articles_labels.articleId AND articles_labels.labelId = '$labelId'";
  } else {
    $joinClause = "";
  }

  $article_count_sql = "SELECT COUNT(*) as total FROM articles $joinClause $whereClause";
  $article_count_result = $conn->query($article_count_sql);
  $row = $article_count_result->fetch_assoc();
  $article_total_rows = $row['total'];
  $article_total_pages = ceil($article_total_rows / 4);

  $article_perPage = 4;
  $article_offset = ($article_page - 1) * $article_perPage;

  $sql_articles = "SELECT articles.*, accounts.accountName FROM articles JOIN accounts ON articles.accountId = accounts.accountId $joinClause $whereClause ORDER BY articles.articleCreateDate DESC, articles.articleLikeCount DESC LIMIT $article_perPage OFFSET $article_offset";
  $result_articles = mysqli_query($conn, $sql_articles);
  if (!$result_articles) {
    die("Error in SQL query: " . mysqli_error($conn));
  }


  $articles = array();
  if (mysqli_num_rows($result_articles) > 0) {
    while ($row_articles = mysqli_fetch_assoc($result_articles)) {
      $articles[] = $row_articles;
    }
  }

  return array(
    'articles' => $articles,
    'total_pages' => $article_total_pages,
    'current_page' => $article_page,
  );
}




//收藏文章
if (isset($_POST["collectArticleAdd"])) {
  if (!isset($_COOKIE["accountId"])) {
    $_SESSION["system_message"] = "請先登入會員，才能進行收藏喔!";
    header("Location: all-article.php");
    exit; // 確保重新導向後停止執行後續代碼
  }
  $articleId = $_POST["collectArticleAdd"];
  $accountId = $_COOKIE["accountId"];
  $collectionId = uuid_generator();
  $sql = "INSERT INTO `collections` (`collectionId`,`accountId`, `articleId`) VALUES ('$collectionId','$accountId', '$articleId')";
  $sql2 = "UPDATE `articles` SET `articleCollectCount` = `articleCollectCount` + 1 WHERE `articleId` = '$articleId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result && $result2) {

    $_SESSION["system_message"] = "已加入收藏!";
    header("Location: all-article.php");
    exit; // 確保重新導向後停止執行後續代碼
  } else {
    $_SESSION["system_message"] = "收藏失敗!";
    header("Location: all-article.php");
    exit; // 確保重新導向後停止執行後續代碼}
  }
}

//移除收藏文章
if (isset($_POST["collectArticleDel"])) {

  $articleId = $_POST["collectArticleDel"];
  $accountId = $_COOKIE["accountId"];
  $sql = "DELETE FROM `collections` WHERE `accountId` = '$accountId' AND `articleId` = '$articleId'";
  $sql2 = "UPDATE `articles` SET `articleCollectCount` = `articleCollectCount` - 1 WHERE `articleId` = '$articleId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result && $result2) {
    $_SESSION["system_message"] = "已取消收藏!";
    header("Location: all-article.php");
    exit; // 確保重新導向後停止執行後續代碼
  }
}

// 文章按讚
if (isset($_POST["likeArticleAdd"])) {

  if (!isset($_COOKIE["accountId"])) {
    $_SESSION["system_message"] = "請先登入會員，才能進行按讚喔!";
    header("Location: all-article.php");
    exit; // 確保重新導向後停止執行後續代碼
  }

  $articleId = $_POST["likeArticleAdd"];
  $accountId = $_COOKIE["accountId"];
  $likeId = uuid_generator();
  $sql = "INSERT INTO `likes` (`likeId`, `accountId`, `articleId`) VALUES ('$likeId', '$accountId', '$articleId')";
  $sql2 = "UPDATE `articles` SET `articleLikeCount` = `articleLikeCount` + 1 WHERE `articleId` = '$articleId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result && $result2) {
    $_SESSION["system_message"] = "已按讚!";
    header("Location: all-article.php");
    exit; // 確保重新導向後停止執行後續代碼
  }
}

// 取消讚文章
if (isset($_POST["likeArticleDel"])) {

  $articleId = $_POST["likeArticleDel"];
  $accountId = $_COOKIE["accountId"];
  $sql = "DELETE FROM `likes` WHERE `accountId` = '$accountId' AND `articleId` = '$articleId'";
  $sql2 = "UPDATE `articles` SET `articleLikeCount` = `articleLikeCount` - 1 WHERE `articleId` = '$articleId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result && $result2) {
    $_SESSION["system_message"] = "已取消讚!";
    header("Location: all-article.php");
    exit; // 確保重新導向後停止執行後續代碼
  }
}

//收藏設備
if (isset($_POST["collectEquipAdd"])) {
  if (!isset($_COOKIE["accountId"])) {
    $_SESSION["system_message"] = "請先登入會員，才能進行收藏喔!";
    header("Location: all-article.php");
    exit; // 確保重新導向後停止執行後續代碼
  }
  $equipmentId = $_POST["collectEquipAdd"];
  $accountId = $_COOKIE["accountId"];
  $collectionId = uuid_generator();
  $sql = "INSERT INTO `collections` (`collectionId`,`accountId`, `equipmentId`) VALUES ('$collectionId','$accountId', '$equipmentId')";
  $sql2 = "UPDATE `equipments` SET `equipmentCollectCount` = `equipmentCollectCount` + 1 WHERE `equipmentId` = '$equipmentId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result && $result2) {
    $_SESSION["system_message"] = "已加入收藏!";
    header("Location: all-article.php");
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
  if ($result && $result2) {
    $_SESSION["system_message"] = "已取消收藏!";
    header("Location: all-article.php");
    exit; // 確保重新導向後停止執行後續代碼
  }
}

// 按讚設備
if (isset($_POST["likeEquipAdd"])) {

  if (!isset($_COOKIE["accountId"])) {
    $_SESSION["system_message"] = "請先登入會員，才能進行按讚喔!";
    header("Location: all-article.php");
    exit; // 確保重新導向後停止執行後續代碼
  }

  $equipmentId = $_POST["likeEquipAdd"];
  $accountId = $_COOKIE["accountId"];
  $likeId = uuid_generator();
  $sql = "INSERT INTO `likes` (`likeId`, `accountId`, `equipmentId`) VALUES ('$likeId', '$accountId', '$equipmentId')";
  $sql2 = "UPDATE `equipments` SET `equipmentLikeCount` = `equipmentLikeCount` + 1 WHERE `equipmentId` = '$equipmentId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result && $result2) {
    $_SESSION["system_message"] = "已按讚!";
    header("Location: all-article.php");
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
  if ($result && $result2) {
    $_SESSION["system_message"] = "已取消讚!";
    header("Location: all-article.php");
    exit; // 確保重新導向後停止執行後續代碼
  }
}


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
  <link rel="stylesheet" href="property-1.0.0/css/icomoon.css">

</head>

<body>

  <!-- 系統訊息 -->
  <?php if (isset($_SESSION["system_message"])) : ?>
    <div id="message" class="alert alert-success" style="position: fixed; top: 10%; left: 50%; transform: translate(-50%, -50%); z-index: 1000; padding: 15px 30px; border-radius: 5px; font-weight: 500; transition: opacity 0.5s;">
      <?php echo $_SESSION["system_message"]; ?>
    </div>
    <?php unset($_SESSION["system_message"]); ?>
  <?php endif; ?>

  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a href="property-1.0.0/index.php"><img class="navbar-brand" src="images/Group 59.png" style="width: 90px; height: auto;"></img></a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> 選單
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item "><a href="property-1.0.0/index.php" class="nav-link">首頁</a></li>
          <li class="nav-item"><a href="property-1.0.0/camp-information.php" class="nav-link">找小鹿</a></li>
          <li class="nav-item"><a href="all-article.php" class="nav-link">鹿的分享</a></li>
          <li class="nav-item"><a href="equipment.php" class="nav-link">鹿的裝備</a></li>
          <li class="nav-item"><a href="property-1.0.0/ad.php" class="nav-link">廣告方案</a></li>

          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="member.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              帳號
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="property-1.0.0/member.php">會員帳號</a>
              <a class="dropdown-item" href="property-1.0.0/member-like.php">我的收藏</a>
              <a class="dropdown-item" href="property-1.0.0/member-record.php">我的紀錄</a>
              <div class="dropdown-divider"></div>
              <?php
              // 檢查是否設置了 accountName 或 accountEmail Cookie
              if (isset($_COOKIE["accountName"]) || isset($_COOKIE["accountEmail"])) {
                echo '<a class="dropdown-item" href="../logout.php?action=logout">登出</a>';
              }
              // 如果沒有設置 Cookie 則顯示登入選項
              else {
                echo '<a class="dropdown-item" href="../login.php">登入</a>';
              }
              ?>
            </div>
          </li>

        </ul>
      </div>
    </div>
  </nav>
  <!-- END nav -->
  <div class="hero page-inner overlay" style="background-image: url('images/Rectangle\ 56.jpg'); height:70vh; min-height: 300px;">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-12 text-center mt-5">
          <h1 class="heading" data-aos="fade-up">鹿的分享
          </h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="property-1.0.0/index.php">首頁</a></li>
              <li class="breadcrumb-item active text-white-50" aria-current="page">鹿的分享
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>


  <?php
  // Top1 article
  $top1_article_sql = "SELECT * FROM articles ORDER BY articleLikeCount DESC LIMIT 1";
  $top1_article_result = mysqli_query($conn, $top1_article_sql);

  if ($top1_article_result && mysqli_num_rows($top1_article_result) > 0) {
    $top1_article_row = mysqli_fetch_assoc($top1_article_result);

    $articleId = $top1_article_row["articleId"];
    $articleContent = $top1_article_row["articleContent"];

    // html中的第一張圖片，作為封面
    $image_src = get_first_image_src($articleContent);

    if ($image_src == "") {
      $image_src = "images/6540.jpg";
    }
    // Default image
    //  $image_src = 'images/6540.jpg';

  }



  ?>
  <section class="ftco-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="row">
            <div class="col-md-11 ftco-animate">
              <div class="single-slider owl-carousel">
                <div class="item">
                  <div class="room-img" style="background-image: url(<?php echo $image_src ?>);"></div>
                </div>
              </div>
            </div>
            <div class="col-md-11 room-single mt-4 mb-5 ftco-animate">
              <h4 style="letter-spacing: 4px;">
                <?php echo $top1_article_row["articleTitle"] ?>
              </h4>
              <br>
              <?php
              $top1ArticleContent = strip_tags($top1_article_row["articleContent"]); // 去除 HTML 標籤
              $encoding = mb_detect_encoding($top1ArticleContent, "UTF-8, GB2312, GBK, BIG5, Shift_JIS, EUC-JP, KOI8-R, ISO-8859-1");
              if ($encoding !== 'UTF-8') {
                $top1ArticleContent = mb_convert_encoding($top1ArticleContent, 'UTF-8', $encoding);
              }
              if (mb_strlen($top1ArticleContent, 'utf-8') > 50) {
                $top1ArticleContent = mb_substr($top1ArticleContent, 0, 200, 'utf-8') . '...';
              }
              ?>
              <p>
                <?php echo $top1ArticleContent . "<a href='article.php?articleId=" . $articleId . "' style='color:#00204a;'>  閱讀全文  </a>"; ?>
              </p>
            </div>

            <div class="container mb-5">
              <h4 style="margin-bottom: 40px;">所有文章</h4>
              <div class="row mb-5">

                <?php
                // 取出已被按讚的文章
                $article_like_sql = "SELECT `articleId` FROM `likes` WHERE `accountId` = '$accountId'";
                $article_like_result = mysqli_query($conn, $article_like_sql);

                // 將查詢結果轉換為包含已按讚文章ID的陣列
                $likedArticles = array();
                while ($row = mysqli_fetch_assoc($article_like_result)) {
                  $likedArticles[] = $row['articleId'];
                }


                // 取出已被收藏的文章
                $article_collect_sql = "SELECT `articleId` FROM `collections` WHERE `accountId` = '$accountId'";
                $article_collect_result = mysqli_query($conn, $article_collect_sql);

                // 將查詢結果轉換為包含已收藏文章ID的陣列
                $collectedArticles = array();
                while ($row = mysqli_fetch_assoc($article_collect_result)) {
                  $collectedArticles[] = $row['articleId'];
                }

                $labelId = isset($_GET["labelId"]) ? $_GET["labelId"] : null;
                $article_search_keyword = isset($_GET['article_search_keyword']) ? trim($_GET['article_search_keyword']) : '';
                $article_page = isset($_GET['article_page']) ? (int) $_GET['article_page'] : 1;

                $result = getArticles($conn, $labelId, $article_search_keyword, $article_page);
                $articles = $result['articles'];
                $article_total_pages = $result['total_pages'];
                $article_current_page = $result['current_page'];

                foreach ($articles as $article_row) {
                  $articleId = $article_row["articleId"];
                  $articleContent = $article_row["articleContent"];

                  // 取得文章第一張圖片
                  $image_src = get_first_image_src($articleContent);

                  // 如果文章沒有圖片，則使用預設圖片
                  if ($image_src == "") {
                    $image_src = 'images/img15.jpg';
                  }

                  // 檢查當前文章是否已按讚
                  $isArticleLiked = in_array($article_row["articleId"], $likedArticles);

                  // 檢查當前文章是否已收藏
                  $isArticleCollected = in_array($article_row["articleId"], $collectedArticles);

                  // 使用 strtotime() 將 datetime 轉換為 Unix 時間戳
                  $timestamp = strtotime($article_row["articleCreateDate"]);

                  // 使用 date() 函數將 Unix 時間戳轉換為所需的格式
                  $formatted_date = date('F j, Y', $timestamp);

                  //若文章內容超過30字做限制
                  $content_length = mb_strlen(strip_tags($article_row["articleContent"]), 'UTF-8');
                  if ($content_length > 30) {
                    $truncated_content = mb_substr(strip_tags($article_row["articleContent"]), 0, 80, 'UTF-8') . '...'; // 截斷文章內容
                  } else {
                    $truncated_content = strip_tags($article_row["articleContent"]);
                  }



                  // 在顯示卡片之前查詢留言數
                  $query = "SELECT COUNT(*) as comment_count FROM comments WHERE articleId = '$articleId'";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);
                  $comment_count = $row['comment_count'];

                  // 格式化按讚數
                  $formatted_like_count = format_like_count($article_row["articleLikeCount"]);

                  echo "<article class='col-md-11 article-list mb-4'>
    <div class='inner'>
        <figure>
            <a href='article.php?articleId=" . $articleId . "'>
                <img src='" . $image_src . "'>
            </a>
        </figure>
        <div class='details'>
            <div class='detail' style='justify-content: space-between;'>
                <span style='display: flex;'>
                    <div class='category'>
                        <a href='article.php?articleId=" . $articleId . "' style='color:#00204a;'>" . $article_row["accountName"] . "</a>
                    </div>
                    <div class='time'>" . $formatted_date . "</div>
                </span>
            </div>
            <h5 style='position: relative;'><a href='article.php?articleId=" . $articleId . "'style='color:#00204a;'>" . $article_row["articleTitle"] . "</a>";
                  echo "<form action='all-article.php' method='post' style='position: absolute; right: 0; top: 50%; transform: translateY(-50%);'>
                <input type='hidden' name='" . ($isArticleCollected ? "collectArticleDel" : "collectArticleAdd") . "' value='" . $articleId . "'>
                <button type='submit' class='btn-icon' >";
                  echo "<i class='" . ($isArticleCollected ? "fas" : "fa-regular") . " fa-bookmark'></i>";
                  echo "</button>
            </form>
            </h5>
            <p style='padding-top: 10px;'>
                " . $truncated_content . "
            </p>
            <footer class='article-footer-div'>
                <p style='margin-bottom: 0px;'>" . $comment_count . " 留言</p>
                <span class='article-footer'>
                    <form action='all-article.php' method='post' style='margin-bottom: 0px;'>
                        <input type='hidden' name='" . ($isArticleLiked ? "likeArticleDel" : "likeArticleAdd") . "' value='" . $articleId . "'>
                        <button type='submit' class='btn-icon' style='display:flex; align-items: center;'>";
                  echo "<i class='" . ($isArticleLiked ? "fas" : "fa-regular") . " fa-heart' ></i>";
                  echo "<p style='margin-bottom: 0px; margin-right:0px;'>" . $formatted_like_count . "</p>";
                  echo "</button>
                    </form>

                </span>
            </footer>
        </div>
    </div>
</article>";
                }


                //                 if ($article_result && mysqli_num_rows($article_result) > 0) {
                //                   while ($article_row = mysqli_fetch_assoc($article_result)) {
                //                     $articleId = $article_row["articleId"];
                //                     $articleContent = $article_row["articleContent"];

                //                     // 取得文章第一張圖片
                //                     $image_src = get_first_image_src($articleContent);

                //                     // 如果文章沒有圖片，則使用預設圖片
                //                     if ($image_src == "") {
                //                       $image_src = 'images/img15.jpg';
                //                     }

                //                     // 檢查當前文章是否已按讚
                //                     $isArticleLiked = in_array($article_row["articleId"], $likedArticles);

                //                     // 檢查當前文章是否已收藏
                //                     $isArticleCollected = in_array($article_row["articleId"], $collectedArticles);

                //                     // 使用 strtotime() 將 datetime 轉換為 Unix 時間戳
                //                     $timestamp = strtotime($article_row["articleCreateDate"]);

                //                     // 使用 date() 函數將 Unix 時間戳轉換為所需的格式
                //                     $formatted_date = date('F j, Y', $timestamp);

                //                     //若文章內容超過30字做限制
                //                     $content_length = mb_strlen(strip_tags($article_row["articleContent"]), 'UTF-8');
                //                     if ($content_length > 30) {
                //                       $truncated_content = mb_substr(strip_tags($article_row["articleContent"]), 0, 80, 'UTF-8') . '...'; // 截斷文章內容
                //                     } else {
                //                       $truncated_content = strip_tags($article_row["articleContent"]);
                //                     }



                //                     // 在顯示卡片之前查詢留言數
                //                     $query = "SELECT COUNT(*) as comment_count FROM comments WHERE articleId = '$articleId'";
                //                     $result = mysqli_query($conn, $query);
                //                     $row = mysqli_fetch_assoc($result);
                //                     $comment_count = $row['comment_count'];

                //                     // 格式化按讚數
                //                     $formatted_like_count = format_like_count($article_row["articleLikeCount"]);

                //                     echo "<article class='col-md-11 article-list mb-4'>
                //     <div class='inner'>
                //         <figure>
                //             <a href='article.php?articleId=" . $articleId . "'>
                //                 <img src='" . $image_src . "'>
                //             </a>
                //         </figure>
                //         <div class='details'>
                //             <div class='detail' style='justify-content: space-between;'>
                //                 <span style='display: flex;'>
                //                     <div class='category'>
                //                         <a href='article.php?articleId=" . $articleId . "' style='color:#00204a;'>" . $article_row["accountName"] . "</a>
                //                     </div>
                //                     <div class='time'>" . $formatted_date . "</div>
                //                 </span>
                //             </div>
                //             <h5 style='position: relative;'><a href='article.php?articleId=" . $articleId . "'style='color:#00204a;'>" . $article_row["articleTitle"] . "</a>";
                //                     echo "<form action='all-article.php' method='post' style='position: absolute; right: 0; top: 50%; transform: translateY(-50%);'>
                //                 <input type='hidden' name='" . ($isArticleCollected ? "collectArticleDel" : "collectArticleAdd") . "' value='" . $articleId . "'>
                //                 <button type='submit' class='btn-icon' >";
                //                     echo "<i class='" . ($isArticleCollected ? "fas" : "fa-regular") . " fa-bookmark'></i>";
                //                     echo "</button>
                //             </form>
                //             </h5>
                //             <p style='padding-top: 10px;'>
                //                 " . $truncated_content . "
                //             </p>
                //             <footer class='article-footer-div'>
                //                 <p style='margin-bottom: 0px;'>" . $comment_count . " 留言</p>
                //                 <span class='article-footer'>
                //                     <form action='all-article.php' method='post' style='margin-bottom: 0px;'>
                //                         <input type='hidden' name='" . ($isArticleLiked ? "likeArticleDel" : "likeArticleAdd") . "' value='" . $articleId . "'>
                //                         <button type='submit' class='btn-icon' style='display:flex; align-items: center;'>";
                //                     echo "<i class='" . ($isArticleLiked ? "fas" : "fa-regular") . " fa-heart' ></i>";
                //                     echo "<p style='margin-bottom: 0px; margin-right:0px;'>" . $formatted_like_count . "</p>";
                //                     echo "</button>
                //                     </form>

                //                 </span>
                //             </footer>
                //         </div>
                //     </div>
                // </article>";
                //                   }
                //                 }
                ?>

              </div>

              <div class="row align-items-center py-5">
                <div class="col-12 d-flex justify-content-center">
                  <div class="custom-pagination">
                    <?php for ($i = 1; $i <= $article_total_pages; $i++) : ?>
                      <a href="?article_page=<?= $i ?>" <?= ($i == $article_current_page) ? 'class="active"' : '' ?>><?= $i ?></a>
                    <?php endfor; ?>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <!-- .col-md-8 -->
        <div class="col-lg-4 sidebar ftco-animate">
          <span class="all-article-top4">

            <?php
            // Top 2~4 熱門文章
            $top234_article_sql = "SELECT articles.*, accounts.accountName FROM articles JOIN accounts ON articles.accountId = accounts.accountId ORDER BY articleLikeCount DESC LIMIT 1, 4";
            $top234_article_result = mysqli_query($conn, $top234_article_sql);

            if ($top234_article_result && mysqli_num_rows($top234_article_result) > 0) {
              while ($top234_article_row = mysqli_fetch_assoc($top234_article_result)) {
                $articleId = $top234_article_row["articleId"];
                $articleContent = $top234_article_row["articleContent"];

                // 取得文章第一張圖片
                $image_src = get_first_image_src($articleContent);

                if ($image_src == "") {
                  $image_src = '../property-1.0.0/images/Rectangle\ 135.png'; // Default image
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

                echo "<div class='col-md-6 d-flex ftco-animate'>
              <div class='blog-entry align-self-stretch'>
                <a href='article.php?articleId=" . $articleId . "' class='block-20' style='background-image: url(" . $image_src . ");'>
                </a>
                <div class='text mt-3 d-block'>
                  <h6 class='heading mt-3' style='font-size:16px;'>
                    <a href='article.php?articleId=" . $articleId . "'>" . $top234_article_row["articleTitle"] . "</a>
                  </h6>
                  <div class='meta mb-3' style='font-size:12px;'>
                    <div><a href='article.php?articleId=" . $articleId . "' style='font-size:12px;'>" . $formatted_date . "</a></div>
                    <div><a href='article.php?articleId=" . $articleId . "' style='font-size:12px;'>" . $top234_article_row["accountName"] . "</a></div>
                    <div><a href='article.php?articleId=" . $articleId . "' class='meta-chat' style='font-size:12px;'><span class='icon-chat'></span> " . $comment_count . "</a></div>
                  </div>
                </div>
              </div>
            </div>";
              }
            }



            ?>
            <!-- <div class="col-md-6 d-flex ftco-animate">
              <div class="blog-entry align-self-stretch">
                <a href="blog-single.html" class="block-20" style="background-image: url('../property-1.0.0/images/Rectangle\ 135.png');">
                </a>
                <div class="text mt-3 d-block">
                  <h6 class="heading2 mt-3">
                    <a href="#">親子露營：營地挑選重點</a>
                  </h6>
                  <div class="meta2 mb-3">
                    <div><a href="#">Dec 6, 2018</a></div>
                    <div><a href="#">Admin</a></div>
                    <div><a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a></div>
                  </div>
                </div>
              </div>
            </div> -->

          </span>

          <div class="mt-5">
            <div class="input-group " style=" justify-content: flex-end;">
              <div id="navbar-search-autocomplete" class="form-outline">
                <form>
                  <input type="search" id="form1" name="article_search_keyword" class="form-control" style="height: 40px; border-radius: 35px;" placeholder="搜尋文章標題..." />
                  <input type="hidden" name="labelId" value="<?php echo $labelId; ?>">
              </div>
              <button type="submit" class="button-search" style="margin-left: 10px;">
                <i class="fa-solid fa-magnifying-glass"></i>
              </button>
              </form>
            </div>

            <a href="/CampTopic/deluxe-master/property-1.0.0/add-article.php">
              <button type="button" class="gray-lg" data-toggle="modal" data-target="#create" style="margin-left: 120px;">
                <h6 style="font-weight: bold;margin-right: -20px;">分享你的露營心得</h6>
                <div class="verticle-line"></div>
                <span style="display: flex; align-items: center; justify-content: flex-start">
                  <i class="fa-solid fa-circle-plus" style="font-size: 18px;margin-right: 8px;margin-left: -25px;"></i>
                  <h6 style="font-weight:bold">貼文</h6>
                </span>
              </button>
            </a>

            <div class="sidebar-box ftco-animate mt-5">
              <h3>文章標籤</h3>
              <div class="tagcloud">
                <?php
                //取得文章所有標籤
                $label_sql = "SELECT * FROM labels WHERE labelType='文章' ";
                $label_result = mysqli_query($conn, $label_sql);
                while ($label_row = mysqli_fetch_assoc($label_result)) {
                  echo "<a href='all-article.php?labelId=" . $label_row["labelId"] . "' class='tag-cloud-link'>" . $label_row["labelName"] . "</a>";
                }
                ?>
              </div>
            </div>
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
          <h4>裝備推薦</h4>
          <article class="col-md-12 mt-5 article-list mb-5">
            <div class="inner" style="display: flex; justify-content: center">


              <?php
              // 依照讚數排行取得三個設備
              $top_equip_sql = "SELECT * FROM `equipments` ORDER BY `equipmentLikeCount` DESC LIMIT 3";
              $top_equip_result = mysqli_query($conn, $top_equip_sql);

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

              if ($top_equip_result && mysqli_num_rows($top_equip_result) > 0) {
                while ($equipmentData = mysqli_fetch_assoc($top_equip_result)) {

                  // 檢查當前設備是否已收藏
                  $isEquipCollected = in_array($equipmentData["equipmentId"], $collectedEquips);

                  // 檢查當前設備是否已按讚
                  $isEquipLiked = in_array($equipmentData["equipmentId"], $likedEquips);

                  //若文章內容超過30字做限制
                  $content_length = mb_strlen(strip_tags($equipmentData["equipmentDescription"]), 'UTF-8');
                  if ($content_length > 20) {
                    $truncated_content = mb_substr(strip_tags($equipmentData["equipmentDescription"]), 0, 20, 'UTF-8') . '...'; // 截斷文章內容
                  } else {
                    $truncated_content = strip_tags($equipmentData["equipmentDescription"]);
                  }

                  // 取得設備圖片
                  $equip_img_src = get_first_image_src($equipmentData["equipmentDescription"]);
                  if ($equip_img_src == '') {
                    $equip_img_src = 'images/M85318677_big.jpeg'; // Default image
                  }




                  // $files_query = "SELECT * FROM files WHERE equipmentId = '$equipmentData[equipmentId]'";
                  // $files_result = mysqli_query($conn, $files_query);
                  // $image_src = 'images/M85318677_big.jpeg'; // Default image

                  // if ($file_result = mysqli_fetch_assoc($files_result)) {
                  //   $file_path = str_replace('Applications/XAMPP/xamppfiles/htdocs', '../..', $file_result['filePath']);
                  //   $image_src = $file_path;
                  // }

                  //格式化按讚數
                  $equipmentlikeCount = format_like_count($equipmentData["equipmentLikeCount"]);

                  echo "<div class='card' style='margin-right: 20px; margin-bottom: 20px;'>
                <img src='" . $equip_img_src . "' class='card-img-top' alt='...'>

                <div class='card-body'>
                  <div class='detail' style='margin-bottom: 0px;'>
                    <span style='display: flex; align-items: center;'>";
                  if ($equipmentData["equipmentType"] === "租") {
                    echo '<span class="fa-stack fa-1x" style="margin-right: 5px; ">';
                    echo '<i class="fas fa-circle fa-stack-2x" style="color:#EFE9DA; font-size:24px;"></i>';
                    echo '<i class="fas fa-stack-1x" style="font-size: 13px;">租</i>';
                    echo '</span>';
                  } else if ($equipmentData["equipmentType"] === "徵") {
                    echo '<span class="fa-stack fa-1x" style="margin-right: 5px; ">';
                    echo '<i class="fas fa-circle fa-stack-2x" style="color:#8d703b; font-size:24px;"></i>';
                    echo '<i class="fas fa-stack-1x fa-inverse" style="font-size: 13px;">徵</i>';
                    echo '</span>';
                  } else if ($equipmentData["equipmentType"] === "賣") {
                    echo '<span class="fa-stack fa-1x" style="margin-right: 5px; ">';
                    echo '<i class="fas fa-circle fa-stack-2x" style="color:#ba4040; font-size:24px;"></i>';
                    echo '<i class="fas fa-stack-1x fa-inverse" style="font-size: 13px;">售</i>';
                    echo '</span>';
                  }
                  echo "<h5 style='box-sizing: content-box; width: 160px;'>" . $equipmentData["equipmentName"] . "</h5>
                    </span>
                    <span class='span-adj' style='justify-content: flex-end; box-sizing: content-box; width: 162px;'>
                      <h4 style='margin-left: 24px;'>$" . number_format($equipmentData["equipmentPrice"]) .
                    "</h4>
                      <form action='all-article.php' method='post'>
                        <input type='hidden' name='" . ($isEquipCollected ? "collectEquipDel" : "collectEquipAdd") . "' value='" . $equipmentData["equipmentId"] . "'>
                        <button type='submit' class='btn-icon'>";
                  echo "<i class='" . ($isEquipCollected ? "fas" : "fa-regular") . " fa-bookmark' " . "></i>";
                  echo "</button>
                      </form>
                    </span>
                  </div>
                  <p class='card-text'>
                    " . $truncated_content . "</p>
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
                  echo
                  "</div>
                      <span style='display: flex; align-items: center;'>
                        <form action='all-article.php' method='post' style='margin-bottom: 0px;'>
                  <input type='hidden' name='" . ($isEquipLiked ? "likeEquipDel" : "likeEquipAdd") . "' value='" . $equipmentData["equipmentId"] . "'>
                  <button type='submit' class='btn-icon'>";
                  echo "<i class='" . ($isEquipLiked ? "fas" : "fa-regular") . " fa-heart' " . " style='margin-left: 120px;'></i>";
                  echo "</button>
                </form>
                  <p style='margin-top:0px'>" . $equipmentlikeCount . "</p>
                      </span>
                    </div>
                  </footer>
                </div>
              </div>";
                }
              }
              ?>

              <!-- <div class="card" style="margin-right: 20px; margin-bottom: 20px;">
                <img src="images/M85318677_big.jpeg" class="card-img-top" alt="...">

                <div class="card-body">
                  <div class="detail" style="margin-bottom: 0px;">
                    <span style="display: flex; align-items: center;">
                      <span class="fa-stack fa-1x" style="margin-right: 5px; ">
                        <i class="fas fa-circle fa-stack-2x" style="color:#EFE9DA; font-size:24px;"></i>
                        <i class="fas fa-stack-1x" style="font-size: 13px;">租</i>
                      </span>
                      <h5>露營帳篷</h5>
                    </span>
                    <span class="span-adj">
                      <h4 style="margin-left: 24px;">$1,291</h4>
                      <button type="button" class="btn-icon">
                        <i class="fa-regular fa-bookmark"></i>
                      </button>
                    </span>
                  </div>
                  <p class="card-text">
                    四人帳篷，空間大，租一天1000元，多天可有優惠，以下是帳篷的現況，有興趣者可私訊。</p>
                  <footer style="margin-top:40px">
                    <div class="card-icon-footer">
                      <div class="tagcloud">
                        <a href="property-single.html">家庭帳</a>
                        <a href="property-single.html">家庭帳</a>
                        <a href="property-single.html">帳篷</a>
                      </div>
                      <span style="display: flex; align-items: center;">
                        <i class="fa-regular fa-heart"></i>
                        <p>1,098</p>
                      </span>
                    </div>
                  </footer>
                </div>
              </div> -->


            </div>
          </article>
        </div>
      </div>
    </div>
  </section>

  <div class="site-footer" style="clear: both;">
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
              <li><a href="property-1.0.0/index.php">首頁</a></li>
              <li><a href="property-1.0.0/camp-information.php">找小鹿</a></li>
              <li><a href="all-article.php">鹿的分享</a></li>
              <li><a href="equipment.php">鹿的裝備</a></li>
              <li><a href="property-1.0.0/ad.php">廣告方案</a></li>
            </ul>
            <ul class="list-unstyled float-start links">
              <li><a href="property-1.0.0/member.php">帳號</a></li>
              <li><a href="property-1.0.0/member.php">會員帳號</a></li>
              <li><a href="property-1.0.0/member-like.php">我的收藏</a></li>
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

    <script>
      function hideMessage() {
        document.getElementById("message").style.opacity = "0";
        setTimeout(function() {
          document.getElementById("message").style.display = "none";
        }, 500);
      }

      setTimeout(hideMessage, 3000);
    </script>
</body>

</html>