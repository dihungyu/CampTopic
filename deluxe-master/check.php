<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
require_once '../php/conn.php';
require_once '../php/uuid_generator.php';
require_once '../php/get_img_src.php';
session_start();


$activityId = $_GET['activityId'];

$sql_getDataQuery = "SELECT * FROM activities WHERE activityId = '$activityId'";
$result = mysqli_query($conn, $sql_getDataQuery);
$row_result = mysqli_fetch_assoc($result);

$campsiteId = $row_result['campsiteId'];
$accountId = $row_result['accountId'];
// 活動發起者ID
$activityCreatorId = $row_result['accountId'];
$activityTitle = $row_result['activityTitle'];
$activityDescription = $row_result['activityDescription'];
$activityStartDate = $row_result['activityStartDate'];
$activityEndDate = $row_result['activityEndDate'];
$minAttendee = $row_result['minAttendee'];
$maxAttendee = $row_result['maxAttendee'];
$leastAttendeeFee = $row_result['leastAttendeeFee'];
$maxAttendeeFee = $row_result['maxAttendeeFee'];

// 判斷活動是否已結束
$activityEndTimestamp = strtotime($activityEndDate);
$currentTimestamp = strtotime(date('Y-m-d'));
$isActivityEnded = $currentTimestamp > $activityEndTimestamp;
$isActivityOngoing = $currentTimestamp >= strtotime($activityStartDate) && $currentTimestamp <= $activityEndTimestamp;

$sql_campsite = "SELECT * FROM campsites WHERE campsiteId = '$campsiteId'";
$result_campsite = mysqli_query($conn, $sql_campsite);
$row_result_campsite = mysqli_fetch_assoc($result_campsite);

$campsiteName = $row_result_campsite['campsiteName'];

$sql_account = "SELECT * FROM accounts WHERE accountId = '$accountId'";
$result_all_account = mysqli_query($conn, $sql_account);
$row_result_account = mysqli_fetch_assoc($result_all_account);

$activityCreator = $row_result_account['accountName'];

$sql_file = "SELECT * FROM files WHERE campsiteId = '$campsiteId'";
$result_file = mysqli_query($conn, $sql_file);

$sql_route1 = "SELECT * FROM routes WHERE activityId = '$activityId' ORDER BY dayNumber ASC";
$result_route = mysqli_query($conn, $sql_route1);

$routes = [];
while ($route_result = mysqli_fetch_assoc($result_route)) {
  $routes[] = $route_result;
}

$sql_account = "SELECT accounts.*, activities_accounts.isApproved, activities_accounts.attendeeEmail FROM activities_accounts JOIN accounts
  ON activities_accounts.accountId = accounts.accountId
  WHERE activities_accounts.activityId = '$activityId'";
$result_account = mysqli_query($conn, $sql_account);

$maleCount = 0;
$femaleCount = 0;
$accounts = [];

// 計算男性和女性的數量並將查詢結果儲存在陣列中
if ($result_account->num_rows > 0) {
  while ($account_result = $result_account->fetch_assoc()) {
    $accounts[] = $account_result;

    if ($account_result["accountGender"] == "Male" && $account_result["isApproved"] == 1) {
      $maleCount++;
    } elseif ($account_result["accountGender"] == "Female" && $account_result["isApproved"] == 1) {
      $femaleCount++;
    }
  }
}
$sql_allCampsite = "SELECT * FROM campsites ";
$result_allCampsite = mysqli_query($conn, $sql_allCampsite);



// 可用函式區
// 格式化時間戳
function format_timestamp($timestamp)
{
  date_default_timezone_set("Asia/Taipei");
  $unix_timestamp = strtotime($timestamp);
  return date("F j, Y \a\\t g:ia", $unix_timestamp);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title> Starting Camping &mdash; 開啟你的露營冒險！</title>
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


  <link rel="stylesheet" href="css/flaticon.css">
  <link rel="stylesheet" href="css/icomoon.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css" />
  <link rel="stylesheet" href="css/aos.css" />
  <title>
    Starting Camping &mdash; 開啟你的露營冒險！
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

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    function setDateInputBehavior(dateInputId) {
      const dateInput = $(dateInputId);

      dateInput.on('focus', function() {
        dateInput.attr('type', 'date');
      });

      dateInput.on('blur', function() {
        if (!dateInput.val()) {
          dateInput.attr('type', 'text');
        }
      });

      dateInput.on('change', function() {
        if (dateInput.val()) {
          dateInput.attr('type', 'date');
        } else {
          dateInput.attr('type', 'text');
        }
      });

      if (!dateInput.val()) {
        dateInput.attr('type', 'text');
      }
    }

    $(document).ready(function() {
      setDateInputBehavior('#start-date-input');
      setDateInputBehavior('#end-date-input');

      let approvalStatus = {};

      $('.accept').on('click', function() {
        let accountId = $(this).data('account-id');
        $(this).css('opacity', '1');
        $(this).siblings('.reject').css('opacity', '0.5');
        approvalStatus[accountId] = 'accepted';
      });
      $('.reject').on('click', function() {
        let accountId = $(this).data('account-id');
        $(this).css('opacity', '1');
        $(this).siblings('.accept').css('opacity', '0.5');
        approvalStatus[accountId] = 'rejected';
      });

      $('#approval-form').on('submit', function(e) {
        $('<input>').attr({
          type: 'hidden',
          name: 'approvalStatus',
          value: JSON.stringify(approvalStatus)
        }).appendTo('#approval-form');
      });

      $(".file-upload").change(function() {
        var id = $(this).data("id");
        readURL(this, id);
      });

      function readURL(input, id) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
            $("#preview-image-db-" + id).attr("src", e.target.result).css("display", "block");
            $("#remove-image-db-" + id).css("display", "block");
          };
          reader.readAsDataURL(input.files[0]);
        }
      }

      $(document).on("click", "button.remove-image-button", function(event) {
        event.preventDefault();
        const id = $(this).attr("id").split("-").slice(-2).join("-");
        $("#preview-image-db-" + id).attr("src", "#").css("display", "none");
        $("#remove-image-db-" + id).css("display", "none");
        $(".file-upload[data-id='" + id + "']").val("");
      });

      document.querySelectorAll('.remove-image-button').forEach(function(button) {
        button.addEventListener('click', function() {
          const fileId = this.getAttribute('data-file-id');
          // 將 fileId 添加到對應的隱藏輸入框中
          this.parentElement.querySelector('.delete-image-input').value = fileId;
          // 隱藏圖片和刪除按鈕
          this.parentElement.querySelector('img').style.display = 'none';
          this.style.display = 'none';
        });
      });
    });

    function hideMessage() {
      document.getElementById("message").style.opacity = "0";
      setTimeout(function() {
        document.getElementById("message").style.display = "none";
      }, 500);
    }
    setTimeout(hideMessage, 3000);
  </script>

  <style>
    #article-content .article-img {
      max-width: 100%;
      height: auto;
    }

    .article-comment {
      height: 40px;
      width: 300px;
      border-radius: 35px;
      background-color: #F0F0F0;
      border: none;
      padding: 20px;
      color: #ADADAD;
      margin-left: 10px;
    }

    .delete-comment {
      position: absolute;
      top: 0;
      right: 0;
      margin-top: 0.5rem;
      margin-right: 0.5rem;
      font-size: 1rem;
      color: #6c757d;
      cursor: pointer;
    }

    .delete-comment:hover {
      color: #dc3545;
    }

    .btn {
      font-size: 13px;
      width: 60px;
      height: 40px;
      background-color: #d9d9d9;
    }

    .vcard bio {
      border-radius: 50%;
      width: 5%;
      margin-right: 16px;
    }
  </style>

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


          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="member.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              帳號
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="property-1.0.0/member.php">會員帳號</a>
              <a class="dropdown-item" href="property-1.0.0/member-like.php">我的收藏</a>
              <a class="dropdown-item" href="property-1.0.0/member-record.php">發表記錄</a>
              <a class="dropdown-item" href="property-1.0.0/myActivityRecord.php">活動紀錄</a>
              <?php
              // 是否為商家帳號
              if ($_COOKIE["accountType"] == "BUSINESS") {
                echo '<a class="dropdown-item" href="property-1.0.0/myCampsite.php">我的營地</a>';
              }
              ?>
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

  <div class="hero page-inner overlay" style="background-image: url('images/Rectangle 341.png');
      height:70vh;
      min-height: 300px;">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-12 text-center mt-5">
          <h1 class="heading" data-aos="fade-up">活動資訊
          </h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="property-1.0.0/index.php">首頁</a></li>
              <li class="breadcrumb-item"><a href="property-1.0.0/camp-information.php">找小鹿</a></li>
              <li class="breadcrumb-item active text-white-50" aria-current="page">
                活動資訊
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <?php
  // 取得發起者頭貼
  // 取得活動發起人的大頭貼
  //取得頭貼
  $activityCreator_img_src = get_profileImg_src($accountId, $conn);
  $activityCreator_img_src = str_replace("../", "", $activityCreator_img_src);
  $activityCreator_img_src = "../" . $activityCreator_img_src;

  ?>

  <section class="ftco-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="row">
            <div class="col-md-12 ftco-animate">
              <span style="display:flex;justify-content: space-between;">
                <h5 class="mb-4" style="font-weight:bold;">
                  <?php echo $activityTitle ?>
                </h5>
                <span class="span-adj;">
                  <button class="btn-icon">
                    <a href="../php/Activity/deleteActivity.php?activityId=<?php echo $activityId ?>">
                      <i class="fas fa-trash-alt" style="font-weight: 500;color: #B02626; margin-left: 500px;"></i>
                    </a>
                  </button>
                  <button type="button" class="btn-icon" data-toggle="modal" data-target="#main">
                    <i class="fa-regular fa-pen-to-square"></i></button>
                </span>
              </span>
              <span style="display: flex;margin-bottom: 64px;align-items: center;">
                <img src="<?php echo $activityCreator_img_src; ?>" alt="Image description" style="border-radius: 50%;
                  width: 40px;
                  height: 40px;
                  margin-right: 16px;">
                <label style="font-size: 16px; margin-bottom: 0px;">
                  <?php echo $activityCreator ?>
                </label></span>
              <h6 class="mb-4" style="font-weight:bold;">基本資訊</h6>
              <div class="single-slider owl-carousel">
                <?php
                while ($file_result = mysqli_fetch_assoc($result_file)) {
                  $file_name = $file_result['fileName'];
                  $file_path = '../upload/' . $file_name;
                  echo "<div class='item'>";
                  echo "<div class='room-img' style='background-image: url($file_path);'></div>";
                  echo "</div>";
                }
                ?>
              </div>
            </div>
            <div class="col-md-12 room-single mt-4 mb-5 ftco-animate">

              <span class="camp-icon">
                <i class="fa-regular fa-user fa-xl"></i>
                <label>負責人</label>
                <p>
                  <?php echo $activityCreator ?>
                </p>
              </span>

              <span class="camp-icon">
                <i class="fa-regular fa-calendar-days fa-xl"></i>
                <label>日期</label>
                <p>
                  <?php echo $activityStartDate ?>
                  -
                  <?php echo $activityEndDate ?>
                </p>
              </span>

              <span class="camp-icon">
                <i class="fa-solid fa-campground fa-lg"></i>
                <label>地點</label>
                <p>
                  <?php echo $campsiteName ?>
                </p>
              </span>

              <span class="camp-icon">
                <i class="fa-solid fa-user-group fa-lg"></i>
                <label>人數</label>
                <p>
                  <?php echo $minAttendee ?>
                  -
                  <?php echo $maxAttendee ?>
                  人
                </p>
              </span>

              <span class="camp-icon">
                <i class="fa-solid fa-coins fa-xl"></i>
                <label>費用</label>
                <p>
                  <?php echo $leastAttendeeFee ?>
                  -
                  <?php echo $maxAttendeeFee ?>
                  / 人
                </p>
              </span>

            </div>

            <div class="modal-body">
              <h4 style="font-weight:bold;">詳細內容</h4>
              <br>
              <p>
                <?php echo $activityDescription ?>
              </p>
              <div>
              </div>
              <div class="col-md-12 room-single ftco-animate mb-5 mt-5" style="margin-left: -15px ;">
                <h4 class="mb-4" style="font-weight:bold;">行程介紹</h4>
                <?php
                $routesCount = count($routes);

                if ($routesCount < 5) {
                  $inserted = false;

                  // Check each day number and insert empty data if necessary
                  for ($i = 1; $i <= 5; $i++) {
                    $found = false;

                    foreach ($routes as $route) {
                      if ($route['dayNumber'] == $i) {
                        $found = true;
                        break;
                      }
                    }

                    if (!$found) {
                      $routes[] = [
                        'routeId' => uuid_generator(),
                        'dayNumber' => $i,
                        'locations' => ''
                      ];

                      $inserted = true;
                    }
                  }

                  // If data was inserted, sort by dayNumber
                  if ($inserted) {
                    usort($routes, function ($a, $b) {
                      return $a['dayNumber'] - $b['dayNumber'];
                    });
                  }
                }

                foreach ($routes as $route) {
                  $routeId = $route['routeId'];
                  $dayNumber = $route['dayNumber'];
                  $sql_tripIntroduction = "SELECT * FROM tripIntroductions WHERE routeId = '$routeId'";
                  $result_tripIntroduction = mysqli_query($conn, $sql_tripIntroduction);
                  $tripIntroductions = [];
                  if (mysqli_num_rows($result_tripIntroduction) > 0) {
                    while ($tripIntroduction_result = mysqli_fetch_assoc($result_tripIntroduction)) {
                      $tripIntroductions[] = [
                        'tripIntroductionId' => $tripIntroduction_result['tripIntroductionId'],
                        'tripIntroductionTitle' => $tripIntroduction_result['tripIntroductionTitle'],
                        'tripIntroductionContent' => $tripIntroduction_result['tripIntroductionContent']
                      ];
                    }
                  }
                  $dayNumber = $route['dayNumber'];
                  $locations = $route['locations'];
                  $dayText = 'Day ' . $dayNumber;
                  echo '<div class="block-16">';
                  echo '  <span style="display: flex;">';
                  echo '    <div class="day">';
                  echo '      <p>' . $dayText . '</p>';
                  echo '    </div>';
                  echo '    <div class="spot">';
                  echo '      <p>' . $locations . '</p>';
                  echo '<button type="button" class="btn-icon" data-toggle="modal" data-target="#modal' . $dayNumber . '">';
                  echo '<i class="fa-regular fa-pen-to-square"></i></button>';
                  echo '    </div>';
                  echo '  </span>';
                  foreach ($tripIntroductions as $tripIntroduction) {
                    $tripIntroductionTitle = $tripIntroduction['tripIntroductionTitle'];
                    $tripIntroductionContent = $tripIntroduction['tripIntroductionContent'];
                    echo '  <div style="clear: both;">';
                    echo '    <br>';
                    echo '    <h6>' . $tripIntroductionTitle . '</h6>';
                    echo '    <p>' . $tripIntroductionContent . '</p>';
                    echo '  </div>';
                  }
                  echo '</div>';
                  $sql_route_file = "SELECT * FROM files WHERE routeId = '$routeId'";
                  $result_route_file = mysqli_query($conn, $sql_route_file);
                  echo '<div class="col-md-12 room-single ftco-animate mb-5 mt-5">';
                  echo '  <div class="row">';
                  while ($route_file_result = mysqli_fetch_assoc($result_route_file)) {
                    $file_name = $route_file_result['fileName'];
                    $file_path = '../upload/' . $file_name;
                    echo '    <div class="col-sm col-md-6 ftco-animate" style="padding-left: 0px; padding-right: 30px;">';
                    echo '      <div class="room">';
                    echo '        <a class="img img-2 d-flex justify-content-center align-items-center" style="background-image: url(' . $file_path . ');">';
                    echo '        </a>';
                    echo '      </div>';
                    echo '    </div>';
                  }
                  echo '  </div>';
                  echo '</div>';
                }
                echo '</div>';
                ?>
              </div>
            </div>
          </div> <!-- .col-md-8 -->


          <div class="col-lg-4 ftco-animate" style=" width:400px; margin-left: 40px;">
            <div class="sidebar-box ftco-animate" style="border-style: solid; border-color: #F0F0F0;">
              <div class="categories">
                <div class="box-side">
                  <span>
                    <h6>目前參加人員</h6>
                  </span>
                  <span style="display: flex; align-items: center">
                    <i class="fa-solid fa-child fa-lg" style="color: #8DA0D0;"></i>
                    <p style="margin-right: 8px;">
                      <?php echo $maleCount ?>
                    </p>
                    <i class="fa-solid fa-child-dress fa-lg" style="color: 	#F1ACAC;"></i>
                    <p>
                      <?php echo $femaleCount ?>
                    </p>
                  </span>
                </div>

                <?php
                $sql_attendee_account = "SELECT a.*, b.accountName FROM activities_accounts a JOIN accounts b ON a.accountId = b.accountId WHERE a.activityId = '$activityId' AND a.isApproved = 1";
                $result_attendee_account = mysqli_query($conn, $sql_attendee_account);
                $attendees = [];
                while ($attendee_result = mysqli_fetch_assoc($result_attendee_account)) {
                  $attendees[] = $attendee_result;
                }
                if (!empty($attendees)) {
                  // 輸出 accountName
                  $displayCount = 0;
                  foreach ($attendees as $account) {
                    if ($displayCount >= 3) {
                      break;
                    }
                    // 取得頭貼
                    $attendeeId = $account['accountId'];
                    $attendee_img_src = get_profileImg_src($attendeeId, $conn);
                    $attendee_img_src = str_replace('../', '', $attendee_img_src);
                    $attendee_img_src = "../" . $attendee_img_src;

                    $accountName = $account['accountName'];
                    echo '<span style="display: flex;margin-bottom: 16px; align-items: center;">';
                    echo '<img src="' . $attendee_img_src . '" alt="Image description" style="border-radius: 50%; width: 10%; margin-right: 16px;">';
                    echo '<label style="font-size: 16px; margin-bottom: 0px;">' . $accountName . '</label></span>';
                    $displayCount++;
                  }

                  echo '<span class="more">';
                  echo '<button type="button" class="btn-icon" data-toggle="modal" data-target="#more2">';
                  echo '<a href="#more2">查看更多</a></button>';
                  echo '</span>';
                } else {
                  echo '<span style="display: flex;margin-bottom: 16px; align-items: center;">目前無參加人員！</span>';
                }
                ?>
                <?php
                $hasUnapprovedAccounts = false;
                $unapprovedCount = 0;

                foreach ($accounts as $account) {
                  if ($account['isApproved'] == 0) {
                    $hasUnapprovedAccounts = true;
                    $unapprovedCount++;
                  }
                }

                ?>

                <div class="box-side">
                  <?php if (!$isActivityOngoing && !$isActivityEnded) : ?>
                    <button type="button" class="btn-side" id="show" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">
                      審核人員
                      <?php if ($hasUnapprovedAccounts) : ?>
                        <span class="badge badge-warning" style="position: relative; top: -13px; left: 125px;"><?php echo $unapprovedCount ?></span>
                      <?php endif; ?>
                    </button>
                  <?php elseif ($isActivityOngoing) : ?>
                    <button type="button" class="btn-side" id="show" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" disabled>
                      進行中
                    </button>
                  <?php elseif ($isActivityEnded) : ?>
                    <button type="button" class="btn-side" id="show" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" disabled>
                      活動已結束
                    </button>
                  <?php endif; ?>
                </div>





              </div>
            </div>

            <div class="notice">
              <span class="box-side" style="justify-content: flex-start; margin-bottom: 16px; ">
                <i class="fa-solid fa-triangle-exclamation fa-sm"></i>
                <h6>注意事項</h6>
              </span>
              <div class="list">
                <li>確認參加後，表接受可能隨時取消活動，及金錢無法退款等問題。</li>
                <li>有安全疑慮者，建議結伴朋友報名參與，並隨身攜帶防身用品。</li>
                <li>本平台不參與金錢之交易，請小心詐騙。</li>
              </div>
            </div>
          </div>

        </div>
        <!-- 留言區 -->
        <?php


        //留言區開始
        // 查詢留言數量
        $comment_count_sql = "SELECT COUNT(*) as comment_count FROM comments WHERE activityId = '$activityId'";
        $comment_count_result = mysqli_query($conn, $comment_count_sql);
        $comment_count_row = mysqli_fetch_assoc($comment_count_result);
        $comment_count = $comment_count_row["comment_count"];


        // 查詢我的頭像
        $accountId = $_COOKIE["accountId"];
        $img_src = get_profileImg_src($accountId, $conn);
        $img_src = str_replace("../", "", $img_src);
        $img_src = "../" . $img_src;

        echo "<div class='pt-5 mt-5'>
            <h5 class='mb-5'>目前" . $comment_count . "留言</h5>
            <h6 class='mb-5'>由舊到新排序</h6>
            <ul class='comment-list'>";

        // 輸出留言
        // 如果未登入，則不顯示留言區塊
        if (!isset($_COOKIE["accountId"])) {
          echo "<h6 class='mb-5'>請先登入才能留言</h6>";
        } else {
          // 如果已登入，則顯示留言區塊
          echo '<li class="comment">
  <div style="display: flex; align-items: center;">
    <span class="img-name">
      <img src="' . $img_src . '" style="border-radius: 50%; width: 45px; height: 45px; margin-right: 8px;">
    </span>
    <div class="comment-body" style="position: relative;">
      <h6>' . $_COOKIE["accountName"] . '</h6>
      <form action="submit_comment.php" method="post">
      <input type="hidden" name="type" value="activity">
        <input type="hidden" name="action" value="comment">
        <input type="hidden" name="activityId" value="' . $activityId . '">
        <input type="text" name="commentContent" placeholder="提問..." id="form1" class="article-comment" />
        <button type="submit" class="btn">發布</button>
      </form>
    </div>
  </div>
</li>';
        }





        // 查詢留言和留言者名稱
        $comment_query = "SELECT comments.*, accounts.accountName FROM comments JOIN accounts ON comments.accountId = accounts.accountId WHERE activityId = '$activityId' AND replyId IS NULL ORDER BY commentCreateDate ASC";
        $comment_result = mysqli_query($conn, $comment_query);


        // 顯示留言
        if ($comment_result && $comment_result->num_rows > 0) {
          while ($comment_result_row = mysqli_fetch_assoc($comment_result)) {

            // 查詢該留言者頭像
            $commenterId = $comment_result_row["accountId"];
            $commenter_img_src = get_profileImg_src($commenterId, $conn);
            $commenter_img_src = str_replace("../", "", $commenter_img_src);
            $commenter_img_src = "../" . $commenter_img_src;

            // 將 Unix 時間戳格式化為指定格式的日期時間字串
            $date_string = format_timestamp($comment_result_row["commentCreateDate"]);

            // 輸出留言
            echo '<li class="comment">
              <span class="img-name">
                <img src="' . $commenter_img_src . '"  style="border-radius: 50%; width: 45px; height: 45px; margin-right: 8px;">
              </span>
              <div class="comment-body" style="position: relative;">
                <h6>' . $comment_result_row["accountName"] . '</h6>
    <div class="meta" style="font-size:11px;"> ' . $date_string . '</div>
    <p style="margin-top:10px;" id="comment-content-' . $comment_result_row["commentId"] . '" >' . $comment_result_row["commentContent"] . '</p>';

            // 如果是自己的留言，或者是發文者，顯示刪除按鈕
            if ($_COOKIE["accountId"] == $comment_result_row["accountId"] || $_COOKIE["accountId"] == $activityCreatorId) {
              echo '<span class="delete-comment" onclick="confirmDelete(\'' . $activityId . '\', \'' . $comment_result_row["commentId"] . '\')"><i class="far fa-trash-alt"></i></span>';
            }






            // 查詢留言回覆者名稱和內容
            $replyId = $comment_result_row["commentId"];
            $reply_query = "SELECT comments.*, accounts.accountName FROM comments JOIN accounts ON comments.accountId = accounts.accountId WHERE activityId = '$activityId' AND replyId= '$replyId' ORDER BY commentCreateDate ASC";
            $reply_result = mysqli_query($conn, $reply_query);


            if ($reply_result && $reply_result->num_rows > 0) {
              echo '<ul class="reply-list">';
              while ($reply_result_row = mysqli_fetch_assoc($reply_result)) {

                // 查詢該留言者頭像
                $replyerId = $reply_result_row["accountId"];
                $replyer_img_src = get_profileImg_src($replyerId, $conn);
                $replyer_img_src = str_replace("../", "", $replyer_img_src);
                $replyer_img_src = "../" . $replyer_img_src;

                // 將 Unix 時間戳格式化為指定格式的日期時間字串
                $date_string = format_timestamp($reply_result_row["commentCreateDate"]);

                echo '<li>
          <span class="img-name" >
            <img src="' . $replyer_img_src . '"  style="border-radius: 50%; width: 30px; height: 30px; margin-right: 8px;">
          </span>
          <div class="comment-body" style="position: relative;">
            <h6>' . $reply_result_row["accountName"] . '</h6>
            <div class="meta">' . $date_string . '</div>
            <p id="comment-content-' . $reply_result_row["commentId"] . '">' . $reply_result_row["commentContent"] . '</p>';

                // 如果是自己的留言，或者是發文者，顯示刪除按鈕
                if ($_COOKIE["accountId"] == $reply_result_row["accountId"] || $_COOKIE["accountId"] == $activityCreatorId) {
                  echo '<span class="delete-comment" onclick="confirmDelete(\'' . $activityId . '\', \'' . $reply_result_row["commentId"] . '\')"><i class="far fa-trash-alt"></i></span>';
                }



                echo '</div>
        </li>';
              }
              if ($_COOKIE["accountName"]) {
                echo '<!-- 使用者回覆區 -->
  <li>
    <div style="display: flex; align-items: center;">
      <span class="img-name">
        <img src="' . $img_src . '" alt="Image description" style="border-radius: 50%; width: 30px; height: 30px; margin-right: 8px;">
      </span>
      <div class="reply-form" style="display: flex; align-items: center;">
        <form action="submit_comment.php" method="post">
        <input type="hidden" name="type" value="activity">
          <input type="hidden" name="action" value="reply">
          <input type="hidden" name="activityId" value="' . $activityId . '">
          <input type="hidden" name="replyId" value="' . $comment_result_row["commentId"] . '">
          <input type="text"   name="commentContent" placeholder="回覆" id="form1" class="article-comment" />
          <button type="submit" class="btn" >發布</button>
        </form>
      </div>
    </div>
  </li>';
              }
              echo '</ul>';
            } else {
              if ($_COOKIE["accountName"]) {
                echo '<!-- 使用者回覆區 -->
  <li>
    <div style="display: flex; align-items: center;">
      <span class="img-name">
        <img src="' . $img_src . '" alt="Image description" style="border-radius: 50%; width: 30px; height: 30px; margin-right: 8px;">
      </span>
      <div class="reply-form" style="display: flex; align-items: center;">
        <form action="submit_comment.php" method="post">
        <input type="hidden" name="type" value="activity">
          <input type="hidden" name="action" value="reply">
          <input type="hidden" name="activityId" value="' . $activityId . '">
          <input type="hidden" name="replyId" value="' . $comment_result_row["commentId"] . '">
          <input type="text"   name="commentContent" placeholder="回覆" id="form1" class="article-comment" />
          <button type="submit" class="btn" >發布</button>
        </form>
      </div>
    </div>
  </li>';
              }
            }
          }
        }



        ?>

        </ul>
      </div>
      <!-- END comment-list -->
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
    <!-- /.container -->
  </div>

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modalContent">
        <div class="box-mod">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i id="close" class="fa-solid fa-circle-xmark" style="color:#a0a0a0;"></i>
          </button>
          <h5 id="exampleModalLabel">審核</h5>

        </div>
        <p style="color: #a0a0a0 ">審核參加人員
        <p>

        <form id="approval-form" action="../php/Route/updateApproval.php" method="post">
          <input type="hidden" name="activityId" value="<?php echo $activityId; ?>">
          <div class="modal-list">
            <div class="supply">
              <div class="row">
                <?php
                $hasUnapprovedAccounts = false;
                foreach ($accounts as $account) {
                  $isApproved = $account['isApproved'];
                  if ($isApproved == 0) {
                    $hasUnapprovedAccounts = true;
                    $accountId = $account['accountId'];
                    $accountName = $account['accountName'];
                    $accountGender = $account['accountGender'];

                    // 取得頭貼
                    $attendeeId = $account['accountId'];
                    $attendee_img_src = get_profileImg_src($attendeeId, $conn);
                    $attendee_img_src = str_replace('../', '', $attendee_img_src);
                    $attendee_img_src = "../" . $attendee_img_src;

                    echo '<div class="col-md-4">';
                    echo '  <span style="display: flex; align-items: center; justify-content: flex-start">';
                    echo '    <img src="' . $attendee_img_src . '" alt="Image description" style="border-radius: 50%; width: 30%; margin-right: 16px;">';
                    echo '    <label style="font-size: 16px; margin-bottom: 0px; ">' . $accountName . '</label>';
                    echo '  </span>';
                    echo '</div>';
                    if ($accountGender == 'Female') {
                      echo '<div class="col-md-4" style="display: flex; align-items: center; justify-content: center;">';
                      echo '  <i class="fa-solid fa-child-dress fa-lg" style="color: #F1ACAC;"></i>';
                      echo '</div>';
                    } else {
                      echo '<div class="col-md-4" style="display: flex; align-items: center; justify-content: center;">';
                      echo '  <i class="fa-solid fa-child fa-lg" style="color: #8DA0D0;"></i>';
                      echo '</div>';
                    }
                    echo '<div class="col-md-4" style="display: flex; align-items: center; justify-content: flex-end;">';
                    echo '  <button type="button" class="btn-icon accept" data-account-id="' . $accountId . '">';
                    echo '    <i class="fa-solid fa-circle-check fa-lg" style="color: #005555;"></i>';
                    echo '  </button>';
                    echo '  <button type="button" class="btn-icon reject" data-account-id="' . $accountId . '">';
                    echo '    <i class="fa-solid fa-circle-xmark fa-lg" style="color: #B02626;"></i>';
                    echo '  </button>';
                    echo '</div>';
                  }
                }
                if (!$hasUnapprovedAccounts) {
                  echo '<div class="col-md-12" style="text-align: center;">目前無待審核的會員！</div>';
                }
                ?>
              </div>
            </div>
          </div>
          <div style="display: flex; justify-content: flex-end;">

            <button type="submit" class="btn-secondary" <?php echo $hasUnapprovedAccounts ? '' : 'style="display: none;"'; ?>>確認</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- .section -->
  <!-- 編輯行程 D1-D5 -->
  <?php
  foreach ($routes as $route) {
    $routeId = $route['routeId'];
    $dayNumber = $route['dayNumber'];
    $sql_tripIntroduction = "SELECT * FROM tripIntroductions WHERE routeId = '$routeId'";
    $result_tripIntroduction = mysqli_query($conn, $sql_tripIntroduction);
    if (mysqli_num_rows($result_tripIntroduction) == 0) {
      $tripIntroductions = [];
    } else {
      $tripIntroductions = [];
      while ($tripIntroduction_result = mysqli_fetch_assoc($result_tripIntroduction)) {
        $tripIntroductions[] = [
          'tripIntroductionId' => $tripIntroduction_result['tripIntroductionId'],
          'tripIntroductionTitle' => $tripIntroduction_result['tripIntroductionTitle'],
          'tripIntroductionContent' => $tripIntroduction_result['tripIntroductionContent']
        ];
      }
    }
    $dayNumber = $route['dayNumber'];
    $locations = $route['locations'];
    echo '<form action="../php/Route/updateRoute.php" method="post" enctype="multipart/form-data">';
    echo '<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal' . $dayNumber . '">';
    echo '<div class="modal-dialog modal-lg">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<h5 class="modal-title" id="exampleModalLongTitle">編輯行程</h5>';
    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    echo '<i id="close" class="fa-solid fa-circle-xmark" style="color:#a0a0a0;"></i>';
    echo '</button>';
    echo '</div>';
    echo '<div class="modal-list" style="margin: 32px;">';
    echo '<input name="locations" style="width: 100%; type="day" placeholder="標題" value="' . $locations . '">';
    // 用於填充空白輸入框和文本區域的預設值
    $default = ['tripIntroductionTitle' => '', 'tripIntroductionContent' => ''];
    // 確保 $results 至少包含三個元素（可能是空的）
    while (count($tripIntroductions) < 3) {
      $tripIntroductions[] = $default;
    }
    // 顯示輸入框和文本區域
    for ($i = 0; $i < 3; $i++) {
      $marginLeft = $i * 2.5;
      echo '<div class="col-md-4" style="padding-right: 0px; padding-left: 0;">';
      echo '<input type="hidden" name="tripIntroductionId[]" value="' . $tripIntroductions[$i]['tripIntroductionId'] . '">';
      echo '<input name="tripIntroductionTitle[]" style="width: 95%; margin-left: ' . $marginLeft . '%;" type="text" placeholder="請輸入景點名稱" value="' . htmlspecialchars($tripIntroductions[$i]['tripIntroductionTitle']) . '">';
      echo '</div>';
    }
    for ($i = 0; $i < 3; $i++) {
      $marginLeft = $i * 2.5;
      echo '<div class="col-md-4" style="padding-right: 0px; padding-left: 0;">';
      echo '<input type="hidden" name="tripIntroductionId[]" value="' . $tripIntroductions[$i]['tripIntroductionId'] . '">';
      echo '<textarea name="tripIntroductionContent[]" style="width: 95%; margin-left: ' . $marginLeft . '%;" rows="10" type="text" placeholder="請輸入景點介紹">' . htmlspecialchars($tripIntroductions[$i]['tripIntroductionContent']) . '</textarea>';
      echo '</div>';
    }
    $sql_route_file = "SELECT * FROM files WHERE routeId = '$routeId'";
    $result_route_file = mysqli_query($conn, $sql_route_file);
    $image_urls = array();
    while ($route_file_result = mysqli_fetch_assoc($result_route_file)) {
      $file_name = $route_file_result['fileName'];
      $file_path = '../upload/' . $file_name;
      $file_id = $route_file_result['fileId'];
      $image_urls[] = ['fileId' => $file_id, 'filePath' => $file_path];
    }
    for ($i = 0; $i < 2; $i++) {
      $image_url = isset($image_urls[$i]['filePath']) ? $image_urls[$i]['filePath'] : "";
      $image_display = !empty($image_url) ? "block" : "none";
      $button_display = !empty($image_url) ? "block" : "none";
      $isNew = !isset($image_urls[$i]['fileId']);
      echo '<div class="col-md-6" style="padding-right: 16px; padding-left: 0px; position:relative;">';
      echo '<input name="file[]" type="file" class="file-upload" data-id="' . $routeId . '-' . ($i + 1) . '"' . ($isNew ? ' data-new="true"' : '') . '>';
      echo '<input type="hidden" name="isNew[]" value="' . ($isNew ? '1' : '0') . '">';
      echo '<input type="hidden" name="fileId[]" value="' . $image_urls[$i]['fileId'] . '">';
      echo '<input type="hidden" name="delete_image[]" value="" class="delete-image-input">';
      echo '<img id="preview-image-db-' . $routeId . '-' . ($i + 1) . '" src="' . $image_url . '" alt="" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; padding-right: 16px; border-radius: 4px; object-fit: cover; display:' . $image_display . ';"/>';
      echo '<button class="remove-image-button" id="remove-image-db-' . $routeId . '-' . ($i + 1) . '" data-file-id="' . $image_urls[$i]['fileId'] . '" style="display:' . $button_display . ';">X</button>';
      echo '</div>';
    }

    echo '</div>';
    echo '<div class="modal-footer">';
    echo '<input type="hidden" name="routeId" value="' . $routeId . '">';
    echo '<input type="hidden" name="activityId" value="' . $activityId . '">';
    echo '<input type="hidden" name="dayNumber" value="' . $dayNumber . '">';
    echo '<button type="submit" class="btn-secondary">確認</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</form>';
  }
  ?>

  <!-- 編輯首要內容 -->
  <form action="../php/Activity/updateActivity.php?activityId=<?php echo $activityId ?>" method="post" name="formEdit" id="formEdit">
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="main">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">編輯活動資訊</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i id="close" class="fa-solid fa-circle-xmark" style="color:#a0a0a0;"></i>
            </button>
          </div>
          <div class="modal-list" style="margin: 32px;">
            <div class="col-md-6" style="padding-right: 0px; padding-left: 0px;">
              <input type="text" name="activityTitle" value="<?php echo $activityTitle ?>" placeholder="活動標題" style="width: 98%; float: left;">
            </div>
            <div class="col-md-6" style="padding-right: 0px; padding-left: 0px;">
              <select name="campsiteId" style="width: 98%; float: right;">
                <?php
                if ($result_allCampsite->num_rows > 0) {
                  // 輸出每行資料
                  while ($row = $result_allCampsite->fetch_assoc()) {
                    echo "<option value='" . $row["campsiteId"] . "'>" . $row["campsiteName"] . "</option>";
                  }
                } else {
                  echo "<option value=''>沒有可用的營地名稱</option>";
                }
                ?>
              </select>
            </div>


            <div class="col-md-6" style="padding-right: 0px; padding-left: 0px;">
              <input type="date" name="activityStartDate" id="start-date-input" value="<?php echo $activityStartDate ?>" style="width: 98%; float: left;">
            </div>
            <div class="col-md-6" style="padding-right: 0px; padding-left: 0px;">
              <input type="date" name="activityEndDate" id="end-date-input" value="<?php echo $activityEndDate ?>" style="width: 98%; float: right;">
            </div>
            <div class="col-md-6" style="padding-right: 0px; padding-left: 0px;">
              <input type="text" name="minAttendee" value="<?php echo $minAttendee ?>" placeholder="最低參加人數（人）" style="width: 98%; float: left;">
            </div>
            <div class="col-md-6" style="padding-right: 0px; padding-left: 0px;">
              <input type="text" name="maxAttendee" value="<?php echo $maxAttendee ?>" placeholder="最高參加人數（人）" style="width: 98%; float: right;">
            </div>
            <div class="col-md-6" style="padding-right: 0px; padding-left: 0px;">
              <input type="text" name="leastAttendeeFee" value="<?php echo $leastAttendeeFee ?>" placeholder="最低預估費用（元/人）" style="width: 98%; float: left;">
            </div>
            <div class="col-md-6" style="padding-right: 0px; padding-left: 0px;">
              <input type="text" name="maxAttendeeFee" value="<?php echo $maxAttendeeFee ?>" placeholder="最高預估費用（元/人）" style="width: 98%; float: right;">
            </div>
            <textarea name="activityDescription" class="lg" rows="8" type="text" placeholder="請輸入活動介紹"><?php echo $activityDescription ?></textarea>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="action" value="update">
            <button type="submit" class="btn-secondary">確認</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- 詳細內容查看更多 -->


  <div class="modal fade" id="more2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modalContent">
        <div class="box-mod">
          <h5 id="exampleModalLabel">所有參加人員</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i id="close" class="fa-solid fa-circle-xmark" style="color:#a0a0a0;"></i>
          </button>
        </div>

        <div class="modal-list">
          <div class="supply">
            <div class="row">
              <?php
              foreach ($accounts as $account) {
                $isApproved = $account['isApproved'];
                if ($isApproved == 1) {
                  $accountId = $account['accountId'];
                  $accountName = $account['accountName'];
                  $attendeeEmail = $account['attendeeEmail'];

                  // 取得頭貼
                  $attendeeId = $account['accountId'];
                  $all_attendee_img_src = get_profileImg_src($attendeeId, $conn);
                  $all_attendee_img_src = str_replace('../', '', $all_attendee_img_src);
                  $all_attendee_img_src = "../" . $all_attendee_img_src;

                  echo '<div class="col-md-4">';
                  echo '<span style="display: flex; align-items: center; justify-content: flex-start;">';
                  echo '<img src="' . $all_attendee_img_src . '" alt="Image description" style="border-radius: 50%; width: 30%; margin-right: 16px;">';
                  echo '<div class="name-email-container" style="width: 150px;"><label class="account-name" style="font-size: 16px; margin-bottom: 0px;" data-name="' . $accountName . '" data-email="' . $attendeeEmail . '">' . $accountName . '</label></div>';
                  echo '</span>';
                  echo '</div>';
                  echo '<div class="col-md-4" style="display: flex; align-items: center; justify-content: flex-end;">';
                  $attendeeActivityCount = $account['attendeeActivityCount'];
                  $iconClass = '';
                  $color = '';
                  $text = '';
                  if ($attendeeActivityCount >= 0 && $attendeeActivityCount <= 3) {
                    $iconClass = 'fa-solid fa-fire';
                    $color = '#B02626';
                    $text = '新手營火';
                  } elseif ($attendeeActivityCount >= 4 && $attendeeActivityCount <= 10) {
                    $iconClass = 'fa-solid fa-compass"';
                    $color = '#002049';
                    $text = '方向盤';
                  } elseif ($attendeeActivityCount >= 11 && $attendeeActivityCount <= 15) {
                    $iconClass = 'fa-solid fa-binoculars';
                    $color = '#7d7d7d';
                    $text = '望遠鏡';
                  } elseif ($attendeeActivityCount > 15) {
                    $iconClass = 'fa-solid fa-campground';
                    $color = '#525F58';
                    $text = '帳篷';
                  }
                  echo '<i class="' . $iconClass . ' badge-icon" style="color: ' . $color . '; font-size:20px; margin-right: 8px;"></i>'; // 添加了 class "badge-icon"
                  echo '<p class="badge-text" style="font-size: 14px;">' . $text . '</p>'; // 添加了 class "badge-text"

                  echo '</div>';
                  echo '<div class="col-md-4" style="display: flex; align-items: center; justify-content: center;">';
                  if ($account['accountGender'] == 'Male') {
                    echo '<i class="fa-solid fa-child fa-lg" style="color: #8DA0D0;"></i>';
                  } else if ($account['accountGender'] == 'Female') {
                    echo '<i class="fa-solid fa-child-dress fa-lg" style="color: #F1ACAC;"></i>';
                  }
                }
                echo '</div>';
              }
              ?>
            </div>
          </div>
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
    const showBtn = document.getElementById("show");
    const infoModal = document.getElementById("infoModal");

    showBtn.addEventListener("click", () => {
      infoModal.style.display = "block";
    });

    window.onclick = function(event) {
      if (event.target == infoModal) {
        infoModal.style.display = "none";
      }
    }
  </script>

  <script>
    function confirmDelete(activityId, commentId) {
      if (confirm('確定要刪除這條留言嗎？')) {
        window.location.href = 'delete_comment.php?level=check&type=activity&id=' + activityId + '&commentId=' + commentId;
      }
    }
  </script>

  <!-- 顯示用戶信箱 -->
  <script>
    $(document).ready(function() {
      $(".name-email-container").on("mouseenter", function() {
        var attendeeEmail = $(this).find(".account-name").data("email");
        $(this).find(".account-name").text(attendeeEmail);
        $(this).closest('.row').find(".badge-icon, .badge-text").hide(); // 隱藏徽章圖示和說明
      });

      $(".name-email-container").on("mouseleave", function() {
        var accountName = $(this).find(".account-name").data("name");
        $(this).find(".account-name").text(accountName);
        $(this).closest('.row').find(".badge-icon, .badge-text").show(); // 顯示徽章圖示和說明
      });
    });
  </script>
</body>

</html>