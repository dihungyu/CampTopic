<?php
// 此頁面為使用者各項發布紀錄

session_start();

//判斷是否登入
if (!isset($_COOKIE["accountId"])) {
  $_SESSION["system_message"] = "請先登入或註冊成為會員!";
  header("Location: ../../login.php");
  exit;
}

require_once("../../php/conn.php");
require_once("../../php/uuid_generator.php");

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


// 按讚設備
if (isset($_POST["likeEquipAdd"])) {

  $equipmentId = $_POST["likeEquipAdd"];
  $accountId = $_COOKIE["accountId"];
  $likeId = uuid_generator();
  $sql = "INSERT INTO `likes` (`likeId`, `accountId`, `equipmentId`) VALUES ('$likeId', '$accountId', '$equipmentId')";
  $sql2 = "UPDATE `equipments` SET `equipmentLikeCount` = `equipmentLikeCount` + 1 WHERE `equipmentId` = '$equipmentId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result) {
    $_SESSION["system_message"] = "已按讚!";
    header("Location: member-record.php#equip");
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
    header("Location: member-record.php#equip");
    exit; // 確保重新導向後停止執行後續代碼
  }
}

// 按讚文章
if (isset($_POST["likeArticleAdd"])) {

  $articleId = $_POST["likeArticleAdd"];
  $accountId = $_COOKIE["accountId"];
  $likeId = uuid_generator();
  $sql = "INSERT INTO `likes` (`likeId`, `accountId`, `articleId`) VALUES ('$likeId', '$accountId', '$articleId')";
  $sql2 = "UPDATE `articles` SET `articleLikeCount` = `articleLikeCount` + 1 WHERE `articleId` = '$articleId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result) {
    $_SESSION["system_message"] = "已按讚!";
    header("Location: member-record.php#article");
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
  if ($result) {
    $_SESSION["system_message"] = "已取消讚!";
    header("Location: member-record.php#article");
    exit; // 確保重新導向後停止執行後續代碼
  }
}



// 可用函式區
function get_img_src($accountId, $conn)
{
  $pic_sql = "SELECT `filePath` FROM `files` WHERE `accountId` = '$accountId' ORDER BY `fileCreateDate` DESC LIMIT 1";
  $pic_result = mysqli_query($conn, $pic_sql);

  if ($pic_row = mysqli_fetch_assoc($pic_result)) {
    $img_src = $pic_row["filePath"];
  } else {
    $img_src = "../../upload/profileDefault.jpeg";
  }

  return $img_src;
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
  <link rel="https://kit.fontawesome.com/d02d7e1ecb.css">

  <!-- 引入 Bootstrap 的 CSS 檔案 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" integrity="sha512-6YRlfqlTKP+w6p+UqV3c6fPq7VpgG6+Iprc+OLIj6pw+hSWRZfY6UaV7eXQ/hGxVrUvj3amJ3Thf5Eu5OV5+aw==" crossorigin="anonymous" />


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
  <link rel="stylesheet" href="deluxe-master/property-1.0.0/css/style.css" />

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
      <a href="index.php"><img class="navbar-brand" src="images/Group 59.png" style="width: 90px; height: auto;"></img></a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> 選單
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item "><a href="index.php" class="nav-link">首頁</a></li>
          <li class="nav-item"><a href="camp-information.php" class="nav-link">找小鹿</a></li>
          <li class="nav-item"><a href="../all-article.php" class="nav-link">鹿的分享</a></li>
          <li class="nav-item"><a href="../equipment.php" class="nav-link">鹿的裝備</a></li>
          <li class="nav-item"><a href="blog.html" class="nav-link">廣告方案</a></li>

          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="member.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              帳號
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="member.php">會員帳號</a>
              <a class="dropdown-item" href="member-like.php">我的收藏</a>
              <a class="dropdown-item" href="member-record.php">我的紀錄</a>
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
          <h1 class="heading" data-aos="fade-up">發布紀錄</h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
              <li class="breadcrumb-item"><a href="member.php">會員帳號</a></li>
              <li class="breadcrumb-item active text-white-50" aria-current="page">
                我的紀錄
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
            <a class="nav-link activity" id="activity-tab" data-toggle="tab" href="#activity" role="tab" aria-controls="activity" aria-selected="true">活動</a>
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

      <!-- 發布活動紀錄 -->
      <div class="tab-pane fade show active" id="activity" role="tabpanel" aria-labelledby="activity-tab">
        <div class="section section-properties">
          <div class="container">
            <div class="row">

              <div class="container">
                <div class="row">
                  <div class="col-md-12">
                    <form method="GET" action="member-record.php#activity" class="mb-4">
                      <div class="input-group " style="display:flex;justify-content: flex-end; margin-bottom: 40px; width: 98%;">
                        <div id="navbar-search-autocomplete" class="form-outline">
                          <input type="search" id="form1" name="activity_search_keyword" class="form-control" style="height: 40px; border-radius: 35px;" placeholder="搜尋活動名稱..." />
                        </div>&nbsp;
                        <button type="submit" class="button-search">
                          <i class="fas fa-search"></i>
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>


              <?php
              // 搜尋關鍵字
              $activity_search_keyword = isset($_GET['activity_search_keyword']) ? trim($_GET['activity_search_keyword']) : '';

              // 使用關鍵字搜尋已發布活動的總數
              $activity_keyword_condition = $activity_search_keyword ? "AND activityTitle LIKE '%$activity_search_keyword%'" : "";
              $count_sql = "SELECT COUNT(*) as total FROM activities WHERE accountId = '$accountId' $activity_keyword_condition";
              $count_result = $conn->query($count_sql);
              $row = $count_result->fetch_assoc();
              $total_rows = $row['total'];
              $total_pages = ceil($total_rows / 4);

              $perPage = 4;
              $activity_current_page = isset($_GET['activity_page']) ? (int)$_GET['activity_page'] : 1;
              $offset = ($activity_current_page - 1) * $perPage;

              // 查詢所有活動資料
              $sql_activities = "SELECT * FROM activities
  LEFT JOIN accounts ON activities.accountId = accounts.accountId
  LEFT JOIN campsites ON activities.campsiteId = campsites.campsiteId
  WHERE activities.accountId = '$accountId' $activity_keyword_condition LIMIT $offset, $perPage";
              $result_activities = mysqli_query($conn, $sql_activities);


              // 檢查是否有結果
              $activities = array();
              if (mysqli_num_rows($result_activities) > 0) {
                while ($row_activities = mysqli_fetch_assoc($result_activities)) {
                  $activities[] = $row_activities;
                }
              }

              // 輸出活動資料
              foreach ($activities as $activity) {
                $accountId = $activity['accountId'];
                $activityId = $activity['activityId'];
                $campsiteName = $activity['campsiteName'];
                $accountName = $activity['accountName'];
                $activityTitle = $activity['activityTitle'];
                $activityStartDate = $activity['activityStartDate'];
                $activityStartMonthDay = date('m/d', strtotime($activityStartDate));
                $activityEndDate = $activity['activityEndDate'];
                $activityEndMonthDay = date('m/d', strtotime($activityEndDate));
                $minAttendee = $activity['minAttendee'];
                $maxAttendee = $activity['maxAttendee'];
                $activityAttendence = $activity['activityAttendence'];
                $leastAttendeeFee = $activity['leastAttendeeFee'];
                $maxAttendeeFee = $activity['maxAttendeeFee'];
                // 取得頭像
                $img_src = get_img_src($accountId, $conn);

                echo '<div class="card" style="width:600px; margin-left: 0px; margin-bottom: 40px;">';
                echo '  <img class="card-img-top" src="images/Rectangle 134.png" alt="Card image cap">';
                echo '<a href="../check.php?activityId=' . $activityId . '">';
                echo '  <span class="card-head">';
                echo '    <img src="' . $img_src . '"  />';
                echo '    <p>' . $accountName . '</p>';
                echo '  </span>';

                echo '  <div class="card-body" style="margin-top: 0px;">';

                echo '    <h5 class="card-title">' . $activityStartMonthDay . '-' . $activityEndMonthDay . ' ' . $activityTitle . '</h5>';
                echo '    <div style="display: flex;flex-direction: column">';
                echo '      <div class="findcamper">';
                echo '        <span class="findcamper-icon">';
                echo '          <i class="fa-solid fa-calendar-days"></i>' . $activityStartMonthDay . '-' . $activityEndMonthDay . '</span>';
                echo '        <span class="findcamper-icon">';
                echo '          <i class="fa-solid fa-person"></i>' . $minAttendee . '-' . $maxAttendee . ' 人';
                echo '        </span>';
                echo '      </div>';

                echo '      <div class="findcamper">';
                echo '        <span class="findcamper-icon" style="display: flex; align-items: center;">';
                echo '          <i class="icon-map"></i>' . $campsiteName . '</span>';
                echo '        <span class="findcamper-icon">';
                echo '          <i class="fa-solid fa-sack-dollar"></i>' . $leastAttendeeFee . '-' . $maxAttendeeFee . '元</span>';
                echo '      </div>';

                echo '    </div>';
                echo '    <hr>';
                echo '    <div class="findcamper-bottom">';
                echo '      <p>已有' . $activityAttendence . '人參加 </p>';
                echo '    </div>';
                echo '  </div>';
                echo '</a>';
                echo '</div>';
              }


              ?>

              <div class="row align-items-center py-5">
                <div class="col-lg-3"></div>
                <div class="col-lg-6 text-center">
                  <div class="custom-pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                      <a href="?activity_page=<?= $i ?>#activity" <?= ($i == $activity_current_page) ? 'class="active"' : '' ?>><?= $i ?></a>
                    <?php endfor; ?>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>
      </div>

      <!-- 文章紀錄區 -->
      <div class="tab-pane fade show " id="paper" role="tabpanel" aria-labelledby="paper-tab">
        <div class="container">
          <div class="row">


            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <form method="GET" action="member-record.php#paper" class="mb-4">
                    <div class="input-group " style="display:flex;justify-content: flex-end; margin-bottom: 40px; width: 98%;">
                      <div id="navbar-search-autocomplete" class="form-outline">
                        <input type="search" id="form1" name="article_search_keyword" class="form-control" style="height: 40px; border-radius: 35px;" placeholder="搜尋文章標題..." />
                      </div>&nbsp;
                      <button type="submit" class="button-search">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <?php
            // 搜尋關鍵字
            $article_search_keyword = isset($_GET['article_search_keyword']) ? trim($_GET['article_search_keyword']) : '';

            // 使用關鍵字搜尋已發布文章的總數
            $article_keyword_condition = $article_search_keyword ? "AND articleTitle LIKE '%$article_search_keyword%'" : "";
            $article_count_sql = "SELECT COUNT(*) as total FROM articles WHERE accountId = '$accountId' $article_keyword_condition";
            $article_count_result = $conn->query($article_count_sql);
            $row = $article_count_result->fetch_assoc();
            $article_total_rows = $row['total'];
            $article_total_pages = ceil($article_total_rows / 9);

            $article_perPage = 9;
            $article_current_page = isset($_GET['article_page']) ? (int)$_GET['article_page'] : 1;
            $article_offset = ($article_current_page - 1) * $article_perPage;

            // 取出已被按讚的文章
            $article_like_sql = "SELECT articleId FROM likes WHERE accountId='$accountId'";
            $article_like_result = $conn->query($article_like_sql);

            // 將查詢結果轉換為包含已按讚文章ID的陣列
            $likedArticles = array();
            while ($row = mysqli_fetch_assoc($article_like_result)) {
              $likedArticles[] = $row['articleId'];
            }

            // 使用使用者ID查詢相關文章資料
            $sql = "SELECT articles.*, accounts.accountName FROM articles
            LEFT JOIN accounts ON articles.accountId = accounts.accountId
            WHERE articles.accountId = '$accountId' $article_keyword_condition
            LIMIT $article_offset, $article_perPage";

            $articleResult = $conn->query($sql);

            // 檢查是否有結果，如果有則輸出文章資料
            if ($articleResult && $articleResult->num_rows > 0) {

              $counter = 0;
              while ($articleData = $articleResult->fetch_assoc()) {

                // 檢查當前文章是否已按讚
                $isArticleLiked = in_array($articleData["articleId"], $likedArticles);


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

                echo "
            <article class='col-md-8 article-list'>
              <div class='inner'>
                <figure>
                  <a href='../article.php?articleId=" . $articleId . "'>
                    <img src='" . $image_src . "'>
                  </a>
                </figure>
                <div class='details'>
                  <div class='detail' style='display: flex;'>
                    <div class='category'>
                      <a href='#'>" . $articleData["accountName"] . "</a>
                    </div>
                    <div class='time'>" . $formatted_date . "</div>
                  </div>
                  <h5><a href='../article.php?articleId=" . $articleId . "'>" . $articleData["articleTitle"] . "</a></h5>
                  <p>
                    " . $truncated_content . "
                  </p>
                  <footer style='justify-content: space-between; padding-top: 10px;'>
                    <p style='white-space: nowrap;'>" . $comment_count .
                  " 則留言</p>
                    <span style='display:flex; align-items:center;'>
                      <form action='member-record.php' method='post'>
                        <input type='hidden' name='" . ($isArticleLiked ? "likeArticleDel" : "likeArticleAdd") . "' value='" . $articleId . "'>
                        <button type='submit' class='btn-icon'>";
                echo "<i class='" . ($isArticleLiked ? "fas" : "fa-regular") . " fa-heart' " . "></i>";


                echo "</button>
                      </form>
                      <p style='margin-right: 0px;'>" . $formatted_like_count . "</p>
                    </span>
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
              <a href='#'>
                <img src='images/Group 74.png'>
              </a>
              <figcaption>Advertisement</figcaption>
              </div>
            </aside>
          </div>";
                }
              }
            } else {
              echo "快去發表第一篇文章！";
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

      <!-- 設備紀錄區 -->
      <div class="tab-pane fade show " id="equip" role="tabpanel" aria-labelledby="equip-tab">
        <div class="container">
          <div class="row">
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <form method="GET" action="member-record.php#equip" class="mb-4">
                    <div class="input-group " style="display:flex;justify-content: flex-end; margin-bottom: 40px; width: 98%;">
                      <div id="navbar-search-autocomplete" class="form-outline">
                        <input type="search" id="form1" name="equip_search_keyword" class="form-control" style="height: 40px; border-radius: 35px;" placeholder="搜尋設備名稱..." />
                      </div>&nbsp;
                      <button type="submit" class="button-search">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>


            <?php
            // 搜尋關鍵字
            $equip_search_keyword = isset($_GET['equip_search_keyword']) ? trim($_GET['equip_search_keyword']) : '';

            // 使用關鍵字搜尋已發布設備的總數
            $equip_keyword_condition = $equip_search_keyword ? "AND equipmentName LIKE '%$equip_search_keyword%'" : "";
            $equip_count_sql = "SELECT COUNT(*) as total FROM equipments WHERE accountId = '$accountId' $equip_keyword_condition";
            $equip_count_result = $conn->query($equip_count_sql);
            $row = $equip_count_result->fetch_assoc();
            $equip_total_rows = $row['total'];
            $equip_total_pages = ceil($equip_total_rows / 8);

            $equip_perPage = 8;
            $equip_current_page = isset($_GET['equip_page']) ? (int)$_GET['equip_page'] : 1;
            $equip_offset = ($equip_current_page - 1) * $equip_perPage;

            // 取出已被按讚的設備
            $equip_like_sql = "SELECT `equipmentId` FROM `likes` WHERE `accountId` = '$accountId'";
            $equip_like_result = mysqli_query($conn, $equip_like_sql);

            // 將查詢結果轉換為包含已按讚設備ID的陣列
            $likedEquips = array();
            while ($row = mysqli_fetch_assoc($equip_like_result)) {
              $likedEquips[] = $row['equipmentId'];
            }

            // 使用使用者ID查詢相關設備資料
            $sql = "SELECT * FROM equipments WHERE accountId = '$accountId' $equip_keyword_condition LIMIT $equip_offset, $equip_perPage";
            $equipmentResult = $conn->query($sql);

            // 檢查是否有結果，如果有則輸出設備資料
            if ($equipmentResult && $equipmentResult->num_rows > 0) {


              $equip_card_counter = 0;
              $ad_counter = 0;
              echo
              '<div class="container">';
              echo '<div class="row">';
              while ($equipmentData = $equipmentResult->fetch_assoc()) {

                $equipmentId = $equipmentData['equipmentId'];

                $files_query = "SELECT * FROM files WHERE equipmentId = '$equipmentData[equipmentId]'";
                $files_result = mysqli_query($conn, $files_query);
                $image_src = 'images/M85318677_big.jpeg'; // Default image

                //格式化按讚數
                $equipmentlikeCount = format_like_count($equipmentData["equipmentLikeCount"]);

                // 檢查當前設備是否已按讚
                $isEquipLiked = in_array($equipmentData["equipmentId"], $likedEquips);

                if ($file_result = mysqli_fetch_assoc($files_result)) {
                  $file_path = str_replace('Applications/XAMPP/xamppfiles/htdocs', '../..', $file_result['filePath']);
                  $image_src = $file_path;
                }
                // 每兩個card會被一個article標籤包裹
                if ($equip_card_counter % 2 === 0) {
                  echo '<article class="col-md-8 article-list"">
              <div class="innereq">';
                }

                // 輸出card
                echo '<div class="card">';
                echo '<img src="' . $image_src . '" class="card-img-top" alt="...">';
                echo '<div class="card-body">';
                echo '<div class="detail"style="margin-bottom: 0px;">';
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

                echo '<h5><a href="../equip-single.php?equipmentId=' . $equipmentId . '">' . $equipmentData['equipmentName'] . '</a></h5>';
                echo '<h4>$' . number_format($equipmentData["equipmentPrice"]) . '</h4>';


                echo '</div>';
                echo '<div class="row">';
                echo '<p class="card-text mb-2">' . $equipmentData['equipmentDescription'] . '</p>';
                echo '</div>'; // row


                echo "<footer style='padding-top: 10px; display: flex; justify-content: space-between; align-items: center;'>";
                echo "<span>";

                // 以下程式碼用於查詢設備相關的標籤
                // 請根據您的資料庫結構和命名進行調整
                $equipment_label_query = "SELECT equipments_labels.labelId, labels.labelName FROM equipments_labels JOIN labels ON equipments_labels.labelId = labels.labelId WHERE equipments_labels.equipmentId = '$equipmentData[equipmentId]'";

                $equipment_label_result = mysqli_query($conn, $equipment_label_query);

                // 檢查錯誤
                if (!$equipment_label_result) {
                  echo "Error: " . mysqli_error($conn);
                }

                $printed_equipment_tags = 0;
                while ($equipment_tags_row = mysqli_fetch_assoc($equipment_label_result)) {
                  if ($printed_equipment_tags >= 3) {
                    break;
                  }

                  echo "<button class='tag-fav' disabled> " . $equipment_tags_row['labelName'] . " 
      </button>";

                  $printed_equipment_tags++;
                }

                echo "</span>";

                // 插入愛心和按讚數代碼
                echo
                "<div style='display: flex; align-items: center;'>
                        <form action='member-record.php' method='post'>
                        <input type='hidden' name='" . ($isEquipLiked ? "likeEquipDel" : "likeEquipAdd") . "' value='" . $equipmentData["equipmentId"] . "'>
                        <button type='submit' class='btn-icon'>";
                echo "<i class='" . ($isEquipLiked ? "fas" : "fa-regular") . " fa-heart' " . "></i>";
                echo "</button>
                        </form>
                        <p style='margin-left: 5px;'>" . $equipmentlikeCount . "</p>
                        </div>";

                echo "</footer>";


                echo '</div>';
                echo '</div>';

                $equip_card_counter++;

                // 每兩個card生成後，右邊會顯示一個廣告
                if ($equip_card_counter % 2 === 0) {
                  echo '</div>';
                  echo '</article>';

                  // 當生成兩個廣告後，將不再顯示廣告
                  if ($ad_counter < 2) {
                    echo '<div class="col-md-2 sidebar">';
                    echo '<aside>';
                    echo '<div class="aside-body">';
                    echo '<figure class="ads">';
                    echo '<a href="#">';
                    echo '<img src="images/Group 74.png">';
                    echo '</a>';
                    echo '<figcaption>Advertisement</figcaption>';
                    echo '</figure>';
                    echo '</div>';
                    echo '</aside>';
                    echo '</div>';

                    $ad_counter++;
                  }
                }
              }

              // 如果card數量為奇數，則需要閉合最後一個article標籤
              if ($equip_card_counter % 2 !== 0) {
                echo '</article>';
              }

              echo '</div>'; // row
              echo '</div>'; // container
            } else {
              echo '上架你的設備吧！';
            }

            ?>


            <div class="row align-items-center py-5">
              <div class="col-lg-3"></div>
              <div class="col-lg-6 text-center">
                <div class="custom-pagination">
                  <?php for ($i = 1; $i <= $equip_total_pages; $i++) : ?>
                    <a href="?equip_page=<?= $i ?>#equip" <?= ($i == $equip_current_page) ? 'class="active"' : '' ?>><?= $i ?></a>
                  <?php endfor; ?>
                </div>
              </div>
            </div>


          </div>
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
                <li><a href="#">首頁</a></li>
                <li><a href="#">找小鹿</a></li>
                <li><a href="#">鹿的分享</a></li>
                <li><a href="#">鹿的裝備</a></li>
                <li><a href="#">廣告方案</a></li>
              </ul>
              <ul class="list-unstyled float-start links">
                <li><a href="#">帳號</a></li>
                <li><a href="#">會員帳號</a></li>
                <li><a href="#">我的收藏</a></li>
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
    <script src="https://kit.fontawesome.com/d02d7e1ecb.js"></script>
    <!-- 引入 Bootstrap 的 JavaScript 檔案，放在 </body> 前面 
      -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.min.js" integrity="sha512-KsH8Gw+WJ4ZfTw3YqzWmn9pPpxdG+R14gTVjTdwryW8f/WQHm4mZ4z3qf0Wm9vBISlRlSjFVCyTlkWbBBwF0iA==" crossorigin="anonymous" defer></script>

    <script>
      $(document).ready(function() {
        // Check if the URL hash is "#paper", "#activity", or "#equip"
        if (window.location.hash === "#paper") {
          // Remove "active" class from other tabs
          $('.nav-link.activity').removeClass('active');
          $('.tab-pane#activity').removeClass('active');
          $('.nav-link.equip').removeClass('active');
          $('.tab-pane#equip').removeClass('active');

          // Add "active" class to the "文章" tab
          $('.nav-link.paper').addClass('active');
          $('.tab-pane#paper').addClass('active');
        } else if (window.location.hash === "#activity") {
          // Remove "active" class from other tabs
          $('.nav-link.paper').removeClass('active');
          $('.tab-pane#paper').removeClass('active');
          $('.nav-link.equip').removeClass('active');
          $('.tab-pane#equip').removeClass('active');

          // Add "active" class to the "活動" tab
          $('.nav-link.activity').addClass('active');
          $('.tab-pane#activity').addClass('active');
        } else if (window.location.hash === "#equip") {
          // Remove "active" class from other tabs
          $('.nav-link.paper').removeClass('active');
          $('.tab-pane#paper').removeClass('active');
          $('.nav-link.activity').removeClass('active');
          $('.tab-pane#activity').removeClass('active');

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