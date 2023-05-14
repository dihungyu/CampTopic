<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
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
require_once("../../php/get_img_src.php");

//判斷是否登入，若有則對變數初始化
if (isset($_COOKIE["accountId"])) {
  $accountId = $_COOKIE["accountId"];
}

// 取得使用者參加活動紀錄
// $attend_activity_sql = "SELECT * FROM activities_accounts WHERE accountId = '$accountId'";
// $attend_activity_result = mysqli_query($conn, $attend_activity_sql);
// if ($attend_activity_result && mysqli_num_rows($attend_activity_result) > 0) {
//   $activitys = array();
//   while ($attend_activity_row = mysqli_fetch_assoc($attend_activity_result)) {
//     $activityId = $attend_activity_row["activityId"];
//     $activity_sql = "SELECT * FROM activities WHERE activityId = '$activityId'";
//     $activity_result = mysqli_query($conn, $activity_sql);
//     if ($activity_result && mysqli_num_rows($activity_result) > 0) {
//       $activity_row = mysqli_fetch_assoc($activity_result);
//       $activitys[] = $activity_row;
//     }
//   }
// }

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
              <?php
              // 是否為商家帳號
              if ($_COOKIE["accountType"] == "BUSINESS") {
                echo '<a class="dropdown-item" href="myCampsite.php">我的營地</a>';
              }
              ?>
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
          <h1 class="heading" data-aos="fade-up">活動紀錄</h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
              <li class="breadcrumb-item"><a href="member.php">會員帳號</a></li>
              <li class="breadcrumb-item active text-white-50" aria-current="page">
                活動記錄
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
            <a class="nav-link activity" id="activity-tab" data-toggle="tab" href="#activity" role="tab" aria-controls="activity" aria-selected="true">進行中</a>
          </li>
          <li class="nav-item" style="margin-right:20px">
            <a class=" nav-link paper" id="paper-tab" data-toggle="tab" href="#paper" role="tab" aria-controls="paper" aria-selected="true">即將到來</a>
          </li>
          <li class="nav-item" style="margin-right:20px">
            <a class="nav-link equip" id="equip-tab" data-toggle="tab" href="#equip" role="tab" aria-controls="equip" aria-selected="true">已結束</a>
          </li>

        </ul>
      </div>
    </div>

    <div class="tab-content" id="myTabContent">

      <!-- 進行中 -->
      <div class="tab-pane fade show active" id="activity" role="tabpanel" aria-labelledby="activity-tab">
        <div class="container">
          <div class="row">





            <?php
            // 搜尋關鍵字
            $ongoing_activity_search_keyword = isset($_GET['ongoing_activity_search_keyword']) ? trim($_GET['ongoing_activity_search_keyword']) : '';

            // 使用關鍵字搜尋已參加活動的總數
            $ongoing_activity_keyword_condition = $ongoing_activity_search_keyword ? "AND activities.activityTitle LIKE '%$ongoing_activity_search_keyword%'" : "";

            // 以下是修改部分，新增篩選進行中活動的條件
            $current_date = date('Y-m-d');
            $ongoing_condition = "AND activities.activityStartDate <= '$current_date' AND activities.activityEndDate >= '$current_date'";

            // $ongoing_count_sql = "SELECT COUNT(*) as total FROM activities_accounts INNER JOIN activities ON activities_accounts.activityId = activities.activityId WHERE activities_accounts.accountId = '$accountId' $ongoing_activity_keyword_condition $ongoing_condition";
            // $ongoing_count_result = $conn->query($ongoing_count_sql);
            // $ongoing_row = $ongoing_count_result->fetch_assoc();
            // $ongoing_total_rows = $ongoing_row['total'];
            // $ongoing_total_pages = ceil($ongoing_total_rows / 6);

            // $perPage = 6;
            // $ongoing_activity_current_page = isset($_GET['ongoing_activity_page']) ? (int)$_GET['ongoing_activity_page'] : 1;
            // $offset = ($ongoing_activity_current_page - 1) * $perPage;

            // 查詢所有參加的活動資料
            $sql_ongoing_activities = "SELECT * FROM activities_accounts
INNER JOIN activities ON activities_accounts.activityId = activities.activityId
LEFT JOIN accounts ON activities.accountId = accounts.accountId
LEFT JOIN campsites ON activities.campsiteId = campsites.campsiteId
WHERE activities_accounts.accountId = '$accountId' $ongoing_activity_keyword_condition $ongoing_condition AND activities.accountId != '$accountId'"; // 這裡加入了排除自己舉辦的活動的條件


            $result_ongoing_activities = mysqli_query($conn, $sql_ongoing_activities);


            // 檢查是否有結果
            $ongoing_activities = array();
            if (mysqli_num_rows($result_ongoing_activities) > 0) {
              while ($row_ongoing_activities = mysqli_fetch_assoc($result_ongoing_activities)) {
                $ongoing_activities[] = $row_ongoing_activities;
              }
            }

            if (count($ongoing_activities) == 0) {
              echo '<div class="col-md-12 text-center" style="margin-bottom: 40px;">
              <h4>目前沒有正在進行的活動！</h4>
              <a href="camp-information.php" class="btn btn-primary" style="margin-top: 20px;">前往參加活動</a>
              </div>';
            } else {
              // 輸出活動資料
              foreach ($ongoing_activities as $activity) {
                $activityCreatorId = $activity['accountId'];
                $activityId = $activity['activityId'];
                $campsiteId = $activity['campsiteId'];
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

                // 判斷當前時間是否在活動時間內
                $activityEndTimestamp = strtotime($activityEndDate);
                $currentTimestamp = strtotime(date('Y-m-d'));
                $isActivityEnded = $currentTimestamp > $activityEndTimestamp;
                $isActivityOngoing = $currentTimestamp >= strtotime($activityStartDate) && $currentTimestamp <= $activityEndTimestamp;

                // 取得當前使用者報名狀態
                $signUpStatus_query = "SELECT * FROM activities_accounts WHERE accountId = '$accountId' AND activityId = '$activityId'";
                $signUpStatus_result = mysqli_query($conn, $signUpStatus_query);
                $signUpStatus = mysqli_fetch_assoc($signUpStatus_result);

                if ($signUpStatus["isApproved"] == 1) {
                  // 取得頭像
                  $activity_img_src = get_profileImg_src($activityCreatorId, $conn);

                  // 取得營地封面
                  $cover_sql = "SELECT filePath FROM files WHERE campsiteId = '" . $campsiteId . "' AND filePathType = 'campsiteCover' ORDER BY fileCreateDate DESC LIMIT 1";
                  $cover_result = mysqli_query($conn, $cover_sql);

                  if ($cover_row = mysqli_fetch_assoc($cover_result)) {
                    $cover_src = $cover_row["filePath"];
                  } else {
                    $cover_src = "images/Rectangle 134.png";
                  }

                  echo '<div class="card-container" style="display: flex; justify-content: center; width: 100%;">'; // 新增了 card-container div 來置中卡片
                  echo '<div class="card" style="width:600px; margin-bottom: 40px; padding: 0px;">';
                  echo '  <img class="card-img-top" src="' . $cover_src . '" alt="Card image cap">';
                  echo '<a href="../camper.php?activityId=' . $activityId . '">';
                  echo '  <span class="card-head">';
                  echo '    <img src="' . $activity_img_src . '"  />';
                  echo '    <p>' . $accountName . '</p>';
                  echo '  </span>';

                  echo '  <div class="card-body" style="padding-top: 10px;">';

                  echo '    <h5 class="card-title">' . $activityStartMonthDay . '-' . $activityEndMonthDay . ' ' . $activityTitle . '</h5>';
                  echo '    <div style="display: flex;flex-direction: column">';
                  echo '      <div class="findcamper">';
                  echo '        <span class="findcamper-icon">';
                  echo '          <i class="fa-solid fa-calendar-days"></i>' . $activityStartMonthDay . '-' . $activityEndMonthDay . '</span>';
                  echo '        <span class="findcamper-icon">';
                  echo '          <i class="fa-solid fa-person"></i>' . $minAttendee . '-' . $maxAttendee . ' 人';
                  echo '        </span>';
                  echo '        <span class="findcamper-icon" style="display: flex; align-items: center; width:240px;">';
                  echo '          <i class="icon-map"></i>' . $campsiteName . '</span>';
                  echo '        <span class="findcamper-icon">';
                  echo '          <i class="fa-solid fa-sack-dollar"></i>' . $leastAttendeeFee . '-' . $maxAttendeeFee . '元</span>';
                  echo '      </div>';

                  echo '    </div>';
                  echo '    <hr>';
                  echo '    <div class="findcamper-bottom">';
                  echo '      <p>已有' . $activityAttendence . '人參加 </p>';
                  echo '<button class="btn btn-info" style="padding-top: 8px; padding-bottom: 8px; font-size: 14px;" disabled>進行中</button>';
                  echo '    </div>';
                  echo '  </div>';
                  echo '</a>';
                  echo '</div>';
                  echo '</div>'; // 關閉新增的 card-container div

                }
              }
            }




            ?>



          </div>
        </div>
      </div>

      <!-- 即將到來 -->
      <div class="tab-pane fade show " id="paper" role="tabpanel" aria-labelledby="paper-tab">
        <div class="container">
          <div class="row">



            <div class="col-md-12">
              <form method="GET" action="myActivityRecord.php#paper" class="mb-4">
                <div class="input-group " style="display:flex;justify-content: flex-end; margin-bottom: 40px; width: 98%;">
                  <div id="navbar-search-autocomplete" class="form-outline">
                    <input type="search" id="form1" name="upcoming_activity_search_keyword" class="form-control" style="height: 40px; border-radius: 35px;" placeholder="搜尋活動名稱..." />
                  </div>&nbsp;
                  <button type="submit" class="button-search">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
            </div>


            <?php
            // 搜尋關鍵字
            $upcoming_activity_search_keyword = isset($_GET['upcoming_activity_search_keyword']) ? trim($_GET['upcoming_activity_search_keyword']) : '';

            // 使用關鍵字搜尋即將到來的活動總數
            $upcoming_activity_keyword_condition = $upcoming_activity_search_keyword ? "AND activities.activityTitle LIKE '%$upcoming_activity_search_keyword%'" : "";
            $upcoming_count_sql = "SELECT COUNT(*) as total FROM activities_accounts INNER JOIN activities ON activities_accounts.activityId = activities.activityId WHERE activities_accounts.accountId = '$accountId' AND activities.activityStartDate > CURDATE() $upcoming_activity_keyword_condition";
            $upcoming_count_result = $conn->query($upcoming_count_sql);
            $upcoming_row = $upcoming_count_result->fetch_assoc();
            $upcoming_total_rows = $upcoming_row['total'];
            $upcoming_total_pages = ceil($upcoming_total_rows / 6);

            $upcoming_perPage = 6;
            $upcoming_activity_current_page = isset($_GET['upcoming_activity_page']) ? (int)$_GET['upcoming_activity_page'] : 1;
            $upcoming_offset = ($upcoming_activity_current_page - 1) * $upcoming_perPage;

            // 查詢即將到來的活動資料
            $sql_upcoming_activities = "SELECT * FROM activities_accounts
INNER JOIN activities ON activities_accounts.activityId = activities.activityId
LEFT JOIN accounts ON activities.accountId = accounts.accountId
LEFT JOIN campsites ON activities.campsiteId = campsites.campsiteId
WHERE activities_accounts.accountId = '$accountId' AND activities.activityStartDate > CURDATE() $upcoming_activity_keyword_condition AND activities.accountId != '$accountId' LIMIT $upcoming_offset, $upcoming_perPage"; // 這裡加入了排除自己舉辦的活動的條件


            $result_upcoming_activities = mysqli_query($conn, $sql_upcoming_activities);

            // 檢查是否有結果
            $upcoming_activities = array();
            if (mysqli_num_rows($result_upcoming_activities) > 0) {
              while ($row_upcoming_activities = mysqli_fetch_assoc($result_upcoming_activities)) {
                $upcoming_activities[] = $row_upcoming_activities;
              }
            }

            if (count($upcoming_activities) == 0) {
              echo '<div class="col-md-12 text-center" style="margin-bottom: 40px;">
              <h4>目前沒有即將到來的活動，快去參加吧！</h4>
              <a href="camp-information.php" class="btn btn-primary" style="margin-top: 20px;">前往活動列表</a>
              </div>';
            } else {
              // 輸出活動資料
              foreach ($upcoming_activities as $activity) {
                $activityCreatorId = $activity['accountId'];
                $activityId = $activity['activityId'];
                $campsiteId = $activity['campsiteId'];
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

                // 判斷當前時間是否在活動時間內
                $activityEndTimestamp = strtotime($activityEndDate);
                $currentTimestamp = strtotime(date('Y-m-d'));
                $isActivityEnded = $currentTimestamp > $activityEndTimestamp;
                $isActivityOngoing = $currentTimestamp >= strtotime($activityStartDate) && $currentTimestamp <= $activityEndTimestamp;

                // 取得當前使用者報名狀態
                $signUpStatus_query = "SELECT * FROM activities_accounts WHERE accountId = '$accountId' AND activityId = '$activityId'";
                $signUpStatus_result = mysqli_query($conn, $signUpStatus_query);
                $signUpStatus = mysqli_fetch_assoc($signUpStatus_result);

                if ($signUpStatus["isApproved"] == 1) {
                  // 取得頭像
                  $activity_img_src = get_profileImg_src($activityCreatorId, $conn);

                  // 取得營地封面
                  $cover_sql = "SELECT filePath FROM files WHERE campsiteId = '" . $campsiteId . "' AND filePathType = 'campsiteCover' ORDER BY fileCreateDate DESC LIMIT 1";
                  $cover_result = mysqli_query($conn, $cover_sql);

                  if ($cover_row = mysqli_fetch_assoc($cover_result)) {
                    $cover_src = $cover_row["filePath"];
                  } else {
                    $cover_src = "images/Rectangle 134.png";
                  }

                  echo '<div class="card" style="width:600px; margin-left: 0px; margin-bottom: 40px; padding: 0px;">';
                  echo '  <img class="card-img-top" src="' . $cover_src . '" alt="Card image cap">';
                  echo '<a href="../camper.php?activityId=' . $activityId . '">';
                  echo '  <span class="card-head">';
                  echo '    <img src="' . $activity_img_src . '"  />';
                  echo '    <p>' . $accountName . '</p>';
                  echo '  </span>';

                  echo '  <div class="card-body" style="padding-top: 10px;">';

                  echo '    <h5 class="card-title">' . $activityStartMonthDay . '-' . $activityEndMonthDay . ' ' . $activityTitle . '</h5>';
                  echo '    <div style="display: flex;flex-direction: column">';
                  echo '      <div class="findcamper">';
                  echo '        <span class="findcamper-icon">';
                  echo '          <i class="fa-solid fa-calendar-days"></i>' . $activityStartMonthDay . '-' . $activityEndMonthDay . '</span>';
                  echo '        <span class="findcamper-icon">';
                  echo '          <i class="fa-solid fa-person"></i>' . $minAttendee . '-' . $maxAttendee . ' 人';
                  echo '        </span>';
                  echo '        <span class="findcamper-icon" style="display: flex; align-items: center; width:240px;">';
                  echo '          <i class="icon-map"></i>' . $campsiteName . '</span>';
                  echo '        <span class="findcamper-icon">';
                  echo '          <i class="fa-solid fa-sack-dollar"></i>' . $leastAttendeeFee . '-' . $maxAttendeeFee . '元</span>';
                  echo '      </div>';

                  echo '    </div>';
                  echo '    <hr>';
                  echo '    <div class="findcamper-bottom">';
                  echo '      <p>已有' . $activityAttendence . '人參加 </p>';
                  echo '<button class="btn btn-danger" style="padding-top: 8px; padding-bottom: 8px; font-size: 14px;" disabled>未到活動時間</button>';
                  echo '    </div>';
                  echo '  </div>';
                  echo '</a>';
                  echo '</div>';
                } else {
                  // 取得頭像
                  $activity_img_src = get_profileImg_src($activityCreatorId, $conn);

                  // 取得營地封面
                  $cover_sql = "SELECT filePath FROM files WHERE campsiteId = '" . $campsiteId . "' AND filePathType = 'campsiteCover' ORDER BY fileCreateDate DESC LIMIT 1";
                  $cover_result = mysqli_query($conn, $cover_sql);

                  if ($cover_row = mysqli_fetch_assoc($cover_result)) {
                    $cover_src = $cover_row["filePath"];
                  } else {
                    $cover_src = "images/Rectangle 134.png";
                  }

                  echo '<div class="card" style="width:600px; margin-left: 0px; margin-bottom: 40px; padding: 0px;">';
                  echo '  <img class="card-img-top" src="' . $cover_src . '" alt="Card image cap">';
                  echo '<a href="../camper.php?activityId=' . $activityId . '">';
                  echo '  <span class="card-head">';
                  echo '    <img src="' . $activity_img_src . '"  />';
                  echo '    <p>' . $accountName . '</p>';
                  echo '  </span>';

                  echo '  <div class="card-body" style="padding-top: 10px;">';

                  echo '    <h5 class="card-title">' . $activityStartMonthDay . '-' . $activityEndMonthDay . ' ' . $activityTitle . '</h5>';
                  echo '    <div style="display: flex;flex-direction: column">';
                  echo '      <div class="findcamper">';
                  echo '        <span class="findcamper-icon">';
                  echo '          <i class="fa-solid fa-calendar-days"></i>' . $activityStartMonthDay . '-' . $activityEndMonthDay . '</span>';
                  echo '        <span class="findcamper-icon">';
                  echo '          <i class="fa-solid fa-person"></i>' . $minAttendee . '-' . $maxAttendee . ' 人';
                  echo '        </span>';
                  echo '        <span class="findcamper-icon" style="display: flex; align-items: center; width:240px;">';
                  echo '          <i class="icon-map"></i>' . $campsiteName . '</span>';
                  echo '        <span class="findcamper-icon">';
                  echo '          <i class="fa-solid fa-sack-dollar"></i>' . $leastAttendeeFee . '-' . $maxAttendeeFee . '元</span>';
                  echo '      </div>';

                  echo '    </div>';
                  echo '    <hr>';
                  echo '    <div class="findcamper-bottom">';
                  echo '      <p>已有' . $activityAttendence . '人參加 </p>';
                  echo '<button class="btn btn-warning" style="padding-top: 8px; padding-bottom: 8px; font-size: 14px; cursor: not-allowed;" disabled>待發起者確認</button>';
                  echo '    </div>';
                  echo '  </div>';
                  echo '</a>';
                  echo '</div>';
                }
              }
            }




            ?>

            <div class="row align-items-center py-5">
              <div class="col-lg-3"></div>
              <div class="col-lg-6 text-center">
                <div class="custom-pagination">
                  <?php for ($i = 1; $i <= $upcoming_total_pages; $i++) : ?>
                    <a href="?upcoming_activity_page=<?= $i ?>#paper" <?= ($i == $upcoming_activity_current_page) ? 'class="active"' : '' ?>><?= $i ?></a>
                  <?php endfor; ?>
                </div>
              </div>
            </div>

          </div> <!-- Close the "row" div here -->
        </div> <!-- Close the "container" div here -->
      </div>


      <!-- 已結束活動 -->
      <div class="tab-pane fade show " id="equip" role="tabpanel" aria-labelledby="equip-tab">
        <div class="container">
          <div class="row">

            <div class="col-md-12">
              <form method="GET" action="myActivityRecord.php#equip" class="mb-4">
                <div class="input-group " style="display:flex;justify-content: flex-end; margin-bottom: 40px; width: 98%;">
                  <div id="navbar-search-autocomplete" class="form-outline">
                    <input type="search" id="form1" name="ended_activity_search_keyword" class="form-control" style="height: 40px; border-radius: 35px;" placeholder="搜尋活動名稱..." />
                  </div>&nbsp;
                  <button type="submit" class="button-search">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
            </div>


            <?php
            // 搜尋關鍵字
            $ended_activity_search_keyword = isset($_GET['ended_activity_search_keyword']) ? trim($_GET['ended_activity_search_keyword']) : '';

            // 使用關鍵字搜尋已參加活動的總數
            $ended_activity_keyword_condition = $ended_activity_search_keyword ? "AND activities.activityTitle LIKE '%$ended_activity_search_keyword%'" : "";
            $ended_count_sql = "SELECT COUNT(*) as total FROM activities_accounts INNER JOIN activities ON activities_accounts.activityId = activities.activityId WHERE activities_accounts.accountId = '$accountId' $ended_activity_keyword_condition AND NOW() > activities.activityEndDate";
            $ended_count_result = $conn->query($ended_count_sql);
            $ended_row = $ended_count_result->fetch_assoc();
            $ended_total_rows = $ended_row['total'];
            $ended_total_pages = ceil($ended_total_rows / 6);

            $ended_perPage = 6;
            $ended_activity_current_page = isset($_GET['activity_page']) ? (int)$_GET['activity_page'] : 1;
            $ended_offset = ($ended_activity_current_page - 1) * $ended_perPage;

            // 查詢所有已結束的參加活動資料
            $ended_sql_activities = "SELECT * FROM activities_accounts
  INNER JOIN activities ON activities_accounts.activityId = activities.activityId
  LEFT JOIN accounts ON activities.accountId = accounts.accountId
  LEFT JOIN campsites ON activities.campsiteId = campsites.campsiteId
  WHERE activities_accounts.accountId = '$accountId' $ended_activity_keyword_condition AND NOW() > activities.activityEndDate AND activities.accountId != '$accountId' LIMIT $ended_offset, $ended_perPage"; // 這裡加入了排除自己舉辦的活動的條件


            $result_ended_activities = mysqli_query($conn, $ended_sql_activities);

            // 檢查是否有結果
            $ended_activities = array();
            if (mysqli_num_rows($result_ended_activities) > 0) {
              while ($row_activities = mysqli_fetch_assoc($result_ended_activities)) {
                $ended_activities[] = $row_activities;
              }
            }


            if (count($ended_activities) == 0) {
              echo '<div class="col-md-12 text-center" style="margin-bottom: 40px;">
              <h4>目前沒有已結束的活動紀錄，快去參加吧！</h4>
              <a href="camp-information.php" class="btn btn-primary" style="margin-top: 20px;">前往活動列表</a>
              </div>';
            } else {
              // 輸出活動資料
              foreach ($ended_activities as $activity) {
                $activityCreatorId = $activity['accountId'];
                $activityId = $activity['activityId'];
                $campsiteId = $activity['campsiteId'];
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

                // 判斷當前時間是否在活動時間內
                $activityEndTimestamp = strtotime($activityEndDate);
                $currentTimestamp = strtotime(date('Y-m-d'));
                $isActivityEnded = $currentTimestamp > $activityEndTimestamp;
                $isActivityOngoing = $currentTimestamp >= strtotime($activityStartDate) && $currentTimestamp <= $activityEndTimestamp;

                // 取得當前使用者報名狀態
                $signUpStatus_query = "SELECT * FROM activities_accounts WHERE accountId = '$accountId' AND activityId = '$activityId'";
                $signUpStatus_result = mysqli_query($conn, $signUpStatus_query);
                $signUpStatus = mysqli_fetch_assoc($signUpStatus_result);

                if ($signUpStatus["isApproved"] == 1) {
                  // 取得頭像
                  $activity_img_src = get_profileImg_src($activityCreatorId, $conn);

                  // 取得營地封面
                  $cover_sql = "SELECT filePath FROM files WHERE campsiteId = '" . $campsiteId . "' AND filePathType = 'campsiteCover' ORDER BY fileCreateDate DESC LIMIT 1";
                  $cover_result = mysqli_query($conn, $cover_sql);

                  if ($cover_row = mysqli_fetch_assoc($cover_result)) {
                    $cover_src = $cover_row["filePath"];
                  } else {
                    $cover_src = "images/Rectangle 134.png";
                  }

                  echo '<div class="card" style="width:600px; margin-left: 0px; margin-bottom: 40px; padding: 0px;">';
                  echo '  <img class="card-img-top" src="' . $cover_src . '" alt="Card image cap">';
                  echo '<a href="../camper.php?activityId=' . $activityId . '">';
                  echo '  <span class="card-head">';
                  echo '    <img src="' . $activity_img_src . '"  />';
                  echo '    <p>' . $accountName . '</p>';
                  echo '  </span>';

                  echo '  <div class="card-body" style="padding-top: 10px;">';

                  echo '    <h5 class="card-title">' . $activityStartMonthDay . '-' . $activityEndMonthDay . ' ' . $activityTitle . '</h5>';
                  echo '    <div style="display: flex;flex-direction: column">';
                  echo '      <div class="findcamper">';
                  echo '        <span class="findcamper-icon">';
                  echo '          <i class="fa-solid fa-calendar-days"></i>' . $activityStartMonthDay . '-' . $activityEndMonthDay . '</span>';
                  echo '        <span class="findcamper-icon">';
                  echo '          <i class="fa-solid fa-person"></i>' . $minAttendee . '-' . $maxAttendee . ' 人';
                  echo '        </span>';
                  echo '        <span class="findcamper-icon" style="display: flex; align-items: center; width:240px;">';
                  echo '          <i class="icon-map"></i>' . $campsiteName . '</span>';
                  echo '        <span class="findcamper-icon">';
                  echo '          <i class="fa-solid fa-sack-dollar"></i>' . $leastAttendeeFee . '-' . $maxAttendeeFee . '元</span>';
                  echo '      </div>';

                  echo '    </div>';
                  echo '    <hr>';
                  echo '    <div class="findcamper-bottom">';
                  echo '      <p>已有' . $activityAttendence . '人參加 </p>';
                  echo '<button class="btn btn-secondary" style="padding-top: 8px; padding-bottom: 8px; font-size: 14px;" disabled>已結束</button>';
                  echo '    </div>';
                  echo '  </div>';
                  echo '</a>';
                  echo '</div>';
                }
              }
            }




            ?>

            <div class="row align-items-center py-5">
              <div class="col-lg-3"></div>
              <div class="col-lg-6 text-center">
                <div class="custom-pagination">
                  <?php for ($i = 1; $i <= $ended_total_pages; $i++) : ?>
                    <a href="?ended_activity_page=<?= $i ?>#equip" <?= ($i == $ended_activity_current_page) ? 'class="active"' : '' ?>><?= $i ?></a>
                  <?php endfor; ?>
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