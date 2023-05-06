<?php
// 開啟錯誤報告
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../php/conn.php';

session_start();

$accountId = '54ec96dae8b611edad24e22a0f5e8453';

$sql_allCampsites = "SELECT * FROM campsites";
$result_allCampsites = mysqli_query($conn, $sql_allCampsites);

// 搜尋關鍵字
$activity_search_keyword = isset($_GET['activity_search_keyword']) ? trim($_GET['activity_search_keyword']) : '';

// 使用關鍵字搜尋活動
$activity_keyword_condition = $activity_search_keyword ? "AND (activities.activityTitle LIKE '%$activity_search_keyword%' OR activities.activityDescription LIKE '%$activity_search_keyword%')" : "";

// 查詢所有活動總數
$activity_count_sql = "SELECT COUNT(*) as total FROM activities WHERE activities.accountId != '$accountId' $activity_keyword_condition";
$activity_count_result = $conn->query($activity_count_sql);
$row = $activity_count_result->fetch_assoc();
$activity_total_rows = $row['total'];
$activity_total_pages = ceil($activity_total_rows / 4); // 每四個活動換下一頁

$activity_perPage = 4;
$activity_current_page = isset($_GET['activity_page']) ? (int) $_GET['activity_page'] : 1;
$activity_offset = ($activity_current_page - 1) * $activity_perPage;

// 查詢所有活動資料
$sql_activities = "SELECT * FROM activities
  LEFT JOIN accounts ON activities.accountId = accounts.accountId
  LEFT JOIN campsites ON activities.campsiteId = campsites.campsiteId
  WHERE activities.accountId != '$accountId' $activity_keyword_condition";
$result_activities = mysqli_query($conn, $sql_activities);

$activities = array();
if (mysqli_num_rows($result_activities) > 0) {
  while ($row_activities = mysqli_fetch_assoc($result_activities)) {
    $activities[] = $row_activities;
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="author" content="Untree.co" />
  <link rel="shortcut icon" href="Frame 5.png" />

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
  <link rel="stylesheet" href="fonts/docs/css/ionicons.min.css">
  <link rel="stylesheet" href="css/skins/all.css">




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


  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>

    function setDateInputBehavior(dateInputId) {
      const dateInput = $(dateInputId);

      dateInput.on('focus', function () {
        dateInput.attr('type', 'date');
      });

      dateInput.on('blur', function () {
        if (!dateInput.val()) {
          dateInput.attr('type', 'text');
        }
      });

      dateInput.on('change', function () {
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

    function validateForm() {
      const fields = [
        { name: "attendeePhoneNumber", errorId: "attendeePhoneNumberError", containerId: "attendeePhoneNumberContainer" },
        { name: "attendeeEmail", errorId: "attendeeEmailError", containerId: "attendeeEmailContainer" },
      ];

      let isValid = true;

      fields.forEach(field => {
        const fieldValue = document.forms["attendForm"][field.name].value;
        const fieldContainer = document.getElementById(field.containerId);
        const fieldError = document.getElementById(field.errorId);

        if (fieldValue === "") {
          fieldError.style.display = "block";
          fieldContainer.style.marginBottom = "10px";
          isValid = false;
        } else {
          fieldError.style.display = "none";
          fieldContainer.style.marginBottom = "20px";
        }
      });

      return isValid;
    }


    function validateNewActivityForm() {
      const fields = [
        { name: "activityTitle", errorId: "activityTitleError", containerId: "activityTitleContainer" },
        { name: "activityStartDate", errorId: "activityStartDateError", containerId: "activityStartDateContainer" },
        { name: "activityEndDate", errorId: "activityEndDateError", containerId: "activityEndDateContainer" },
        { name: "minAttendee", errorId: "minAttendeeError", containerId: "minAttendeeContainer" },
        { name: "maxAttendee", errorId: "maxAttendeeError", containerId: "maxAttendeeContainer" },
        { name: "leastAttendeeFee", errorId: "leastAttendeeFeeError", containerId: "leastAttendeeFeeContainer" },
        { name: "maxAttendeeFee", errorId: "maxAttendeeFeeError", containerId: "maxAttendeeFeeContainer" },
        { name: "activityDescription", errorId: "activityDescriptionError", containerId: "activityDescriptionContainer" },
      ];

      let isValid = true;

      fields.forEach(field => {
        const fieldValue = document.forms["newActivityForm"][field.name].value;
        const fieldContainer = document.getElementById(field.containerId);
        const fieldError = document.getElementById(field.errorId);

        if (fieldValue === "") {
          fieldError.style.display = "block";
          isValid = false;
        } else {
          fieldError.style.display = "none";
          fieldContainer.style.marginBottom = "20px";
        }
      });

      return isValid;
    }


    // Run this when the document is ready
    $(document).ready(function () {
      setDateInputBehavior('#start-date-input');
      setDateInputBehavior('#end-date-input');

      // Add event listener to the attendForm submit button
      $('#attendForm button.btn-secondary').on('click', function (event) {
        event.preventDefault();
        if (validateForm()) {
          // Submit the form
          $('#attendForm').submit();
        }
      });

      // Add event listener to the newActivityForm submit button
      $('#newActivityForm button.btn-secondary').on('click', function (event) {
        event.preventDefault();
        if (validateNewActivityForm()) {
          // Submit the form
          $('#newActivityForm').submit();
        }
      });

    });

    let selectedLabels = [];

    function filterActivities() {
      selectedLabels = getSelectedLabels();
      let labelIds = selectedLabels.map(label => label.labelId);
      let accountId = <?php echo json_encode($accountId); ?>;

      let bodyContent;

      if (labelIds.length > 0) {
        bodyContent = "labelIds=" + JSON.stringify(labelIds) + "&accountId=" + accountId;
      } else {
        bodyContent = "accountId=" + accountId;
      }

      fetch("../php/Filter/filter_activities.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: bodyContent
      })
        .then(response => response.json())
        .then((filteredActivities) => {
          displayFilteredActivities(filteredActivities);
          displaySelectedLabels();
        });
    }

    document.querySelectorAll(".form-check-input").forEach(checkbox => {
      checkbox.addEventListener("change", () => {
        filterActivities();
      });
    });

    function displaySelectedLabels() {
      let container = document.getElementById("selected-tags-container");
      container.innerHTML = "";

      selectedLabels.forEach(label => {
        let tag = document.createElement("a");
        tag.classList.add("tag-filter");
        tag.setAttribute("data-label-id", label.labelId);
        tag.innerHTML = `${label.labelName}`;
        container.appendChild(tag);
      });
    }


    function getSelectedLabels() {
      let checkboxes = document.querySelectorAll(".form-check-input");
      let selectedLabels = Array.from(checkboxes).filter(checkbox => checkbox.checked).map(checkbox => ({ labelName: checkbox.nextElementSibling.textContent, labelId: checkbox.dataset.labelId }));
      return selectedLabels;
    }

    function displayFilteredActivities(activities) {
      let activitiesContainer = document.querySelector(".col-xs-12.col-sm-6");
      activitiesContainer.innerHTML = '';

      activities.forEach(activity => {
        let activityHTML = generateActivityCard(activity);
        activitiesContainer.innerHTML += activityHTML;
      });
    }

    function generateActivityCard(activity) {
      let activityId = activity.activityId;
      let campsiteName = activity.campsiteName;
      let accountName = activity.accountName;
      let activityTitle = activity.activityTitle;
      let activityStartDate = activity.activityStartDate;
      let activityStartMonthDay = new Date(activityStartDate).toLocaleDateString("en-US", { month: "2-digit", day: "2-digit" });
      let activityEndDate = activity.activityEndDate;
      let activityEndMonthDay = new Date(activityEndDate).toLocaleDateString("en-US", { month: "2-digit", day: "2-digit" });
      let minAttendee = activity.minAttendee;
      let maxAttendee = activity.maxAttendee;
      let activityAttendence = activity.activityAttendence;
      let leastAttendeeFee = activity.leastAttendeeFee;
      let maxAttendeeFee = activity.maxAttendeeFee;

      return `
    <div class="card" style="width:600px;margin-left: 0px; margin-bottom: 40px;">
      <img class="card-img-top" src="images/Rectangle 144.png" alt="Card image cap">
      <a href="../deluxe-master/camper.php?activityId=' . $activityId . '">
      <span class="card-head">
        <img src="images/person_4-min.jpg" alt="Admin" />
        <p>${accountName}</p>
      </span>
      <div class="card-body" style="margin-top: 0px;">
        <h5 class="card-title">${activityStartMonthDay}-${activityEndMonthDay} ${activityTitle}</h5>
        <div style="display: flex;flex-direction: column">
          <div class="findcamper">
            <span class="findcamper-icon">
              <i class="fa-solid fa-calendar-days"></i>${activityStartMonthDay}-${activityEndMonthDay}</span>
            <span class="findcamper-icon">
              <i class="fa-solid fa-person"></i>${minAttendee}-${maxAttendee} 人
            </span>
          </div>
          <div class="findcamper">
            <span class="findcamper-icon" style="display: flex; align-items: center;">
              <i class="icon-map"></i>${campsiteName}</span>
            <span class="findcamper-icon">
              <i class="fa-solid fa-sack-dollar"></i>${leastAttendeeFee}-${maxAttendeeFee}元</span>
          </div>
        </div>
        <hr>
        <div class="findcamper-bottom">
          <p>已有${activityAttendence}人參加 </p>
          <button class="btn btn-primary" style="padding-top: 8px; padding-bottom: 8px; font-size: 14px;"
            data-toggle="modal" data-target="#Modal${activityId}">
            參加！</button>
        </div>
      </div>
      </a>
    </div>`;
    }


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
          <li class="nav-item active"><a href="index.html" class="nav-link">首頁</a></li>
          <li class="nav-item"><a href="rooms.html" class="nav-link">找小鹿</a></li>
          <li class="nav-item"><a href="restaurant.html" class="nav-link">鹿的分享</a></li>
          <li class="nav-item"><a href="about.html" class="nav-link">鹿的裝備</a></li>
          <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="member.html" id="navbarDropdown" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              帳號
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="member.html">會員帳號</a>
              <a class="dropdown-item" href="member-like.html">我的收藏</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="file:///Applications/XAMPP/xamppfiles/htdocs/CampTopic/login.html">登出</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- END nav -->

  <div class="hero page-inner overlay" style="background-image: url('images/Rectangle\ 151.png');
      height:70vh;
      min-height: 300px;">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-12 text-center mt-5">
          <h1 class="heading" data-aos="fade-up">找小鹿
          </h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="index.html">首頁</a></li>
              <li class="breadcrumb-item active text-white-50" aria-current="page">
                找小鹿
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
        <div class="input-group" style="display: flex; justify-content: space-between;">
          <span style="display:flex;align-items: center;justify-content: center">
            <button type="button" class="button-filter" data-toggle="modal" data-target="#filter">
              <i class="fa-solid fa-bars-staggered" style="margin-right: 4px;"></i>篩選
            </button>
            <div id="selected-tags-container"></div>
          </span>
          <span style="display:flex ;">
            <div id="navbar-search-autocomplete" class="form-outline">
              <form>
                <input type="search" id="form1" name="activity_search_keyword" class="form-control"
                  style="border-radius: 35px;" />
            </div>
            <button type="submit" class="button-search" style="margin-left: 10px; ">
              <i class="fas fa-search"></i>
            </button>
            </form>
          </span>
        </div>
        <?php
        $sql_account = "SELECT * FROM accounts WHERE accountId = '$accountId'";
        $result_account = mysqli_query($conn, $sql_account);
        $row_account = mysqli_fetch_assoc($result_account);
        $accountName = $row_account['accountName'];
        $attendeeActivityCount = $row_account['attendeeActivityCount'];
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
        ?>
        <div class="input-group" style="display: flex; justify-content: space-between;">
          <button type="button" class="gray-lg" data-toggle="modal" data-target="#exampleModalCenter">
            <img src="images/person_4.jpg" alt="Image description" style="border-radius: 50%; width: 15%;">
            <label style="font-size: 14px; margin-bottom: 0px;margin-left: -16px; font-weight: 600; ">
              <?php echo $accountName ?>
            </label>
            <div class="verticle-line"></div>
            <span style="display: flex; align-items: center; justify-content: flex-start">
              <i class="<?php echo $iconClass ?>"
                style="color: <?php echo $color ?>; font-size:18px; margin-right: 8px;"></i>
              <h6 style="margin: 0rem;">
                <?php echo $text ?>
              </h6>
            </span>
          </button>
          <button type="button" class="gray-lg" data-toggle="modal" data-target="#create">
            <h6>發起露營活動！</h6>
            <div class="verticle-line"></div>
            <span style="display: flex; align-items: center; justify-content: flex-start">
              <i class="fa-solid fa-hand-fist" style="font-size: 18px;margin-right: 8px;"></i>
              <h6>創建</h6>
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="tab-content" id="myTabContent">
    <div class="section section-properties">
      <div class="container" style="max-width: 1260px">
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <?php
            foreach ($activities as $activity) {
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

              echo '<div class="card" style="width:600px; margin-left: 0px; margin-bottom: 40px;">';
              echo '  <img class="card-img-top" src="images/Rectangle 144.png" alt="Card image cap">';
              echo '<a href="../deluxe-master/camper.php?activityId=' . $activityId . '">';
              echo '  <span class="card-head">';
              echo '    <img src="images/person_4-min.jpg" alt="Admin" />';
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
              echo '      <button class="btn btn-primary" style="padding-top: 8px; padding-bottom: 8px; font-size: 14px;"';
              echo '        data-toggle="modal" data-target="#Modal' . $activityId . '">';
              echo '        參加！</button>';
              echo '    </div>';
              echo '  </div>';
              echo '</a>';
              echo '</div>';
            }
            ?>

          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <div class="row align-items-center py-5">
    <div class="col-lg-3"></div>
    <div class="col-lg-6 text-center">
      <div class="custom-pagination">
        <?php for ($i = 1; $i <= $activity_total_pages; $i++): ?>
          <a href="?activity_page=<?= $i ?>" <?= ($i == $activity_current_page) ? 'class="active"' : '' ?>><?= $i ?></a>
        <?php endfor; ?>
      </div>
    </div>
  </div>
  </div>

  </div>
  </div>
  </div>
  </article>

  </div>
  </div>
  </div>
  </div>

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
      <?php
      foreach ($activities as $activity) {
        $activityId = $activity['activityId'];
        echo '<form name="attendForm" action="../php/Activity/attendActivity.php" method="POST" onsubmit="return validateForm()">';
        echo '<div class="modal fade" id="Modal' . $activityId . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">';
        echo '<div class="modal-dialog" role="document">';
        echo '<div class="modalContent">';
        echo '<div class="box-mod">';
        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        echo '<i id="close" class="fa-solid fa-circle-xmark" style="color:#a0a0a0;"></i>';
        echo '</button>';
        echo '<h4 id="exampleModalLabel">參加</h4>';
        echo '</div>';
        echo '<p style="color: #a0a0a0">參加活動蒐集勳章！</p>';
        echo '<div class="modal-list">';
        echo '<div id="attendeePhoneNumberContainer" class="input-container">';
        echo '<div id="attendeePhoneNumberError" class="error-message">*必填</div>';
        echo '<input name="attendeePhoneNumber" type="text" placeholder="電話">';
        echo '</div>';
        echo '<div id="attendeeEmailContainer" class="input-container">';
        echo '<div id="attendeeEmailError" class="error-message">*必填</div>';
        echo '<input name="attendeeEmail" type="email" placeholder="信箱">';
        echo '</div>';
        echo '<textarea name="attendeeRemark" rows="4" type="text" placeholder="備註 /建議"></textarea>';
        echo '</div>';
        echo '<div style="display: flex; justify-content: flex-end;">';
        echo '<input type="hidden" name="activityId" value="' . $activityId . '">';
        echo '<input type="hidden" name="accountId" value="' . $accountId . '">';
        echo '<button class="btn-secondary" type="submit">提交</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</form>';
      }
      ?>


      <form action="../php/Activity/createActivity.php" method="post" id="newActivityForm"
        onsubmit="return validateNewActivityForm();">
        <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="false">
          <div class="modal-dialog" role="document">
            <div class="modalContent">
              <div class="box-mod">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i id="close" class="fa-solid fa-circle-xmark" style="color:#a0a0a0;"></i>
                </button>
                <h4 id="exampleModalLabel">創建露營活動</h4>

              </div>
              <p style="color: #a0a0a0 ">尋找其他小鹿一起冒險！
              <p>

              <div class="modal-list">
                <div style="margin-bottom: 10px">
                  <div id="activityTitleContainer">
                    <div id="activityTitleError" class="error-message">*必填</div>
                    <input type="text" name="activityTitle" placeholder="活動名稱">
                  </div>

                </div>
                <div id="campsiteIdContainer">
                  <select name="campsiteId">
                    <?php
                    if ($result_allCampsites->num_rows > 0) {
                      // 輸出每行資料
                      while ($row = $result_allCampsites->fetch_assoc()) {
                        echo "<option value='" . $row["campsiteId"] . "'>" . $row["campsiteName"] . "</option>";
                      }
                    } else {
                      echo "<option value=''>沒有可用的營地名稱</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="supply">
                  <div class="row">
                    <div class="col-md-6" style="margin-bottom: 10px">
                      <div id="activityStartDateContainer">
                        <div id="activityStartDateError" class="error-message">*必填</div>
                        <input id="start-date-input" type="text" name="activityStartDate" style="width: 200px;"
                          placeholder="開始日期">
                      </div>

                    </div>
                    <div class="col-md-6" style="margin-bottom: 10px">
                      <div id="activityEndDateContainer">
                        <div id="activityEndDateError" class="error-message">*必填</div>
                        <input id="end-date-input" type="text" name="activityEndDate" style="width: 200px;"
                          placeholder="結束日期">
                      </div>

                    </div>
                    <div class="col-md-6" style="margin-bottom: 10px">
                      <div id="minAttendeeContainer">
                        <div id="minAttendeeError" class="error-message">*必填</div>
                        <input name="minAttendee" type="text" style="width: 200px;" placeholder="最少人數">
                      </div>

                    </div>
                    <div class="col-md-6" style="margin-bottom: 10px">
                      <div id="maxAttendeeContainer">
                        <div id="maxAttendeeError" class="error-message">*必填</div>
                        <input name="maxAttendee" type="text" style="width: 200px;" placeholder="最多人數">
                      </div>

                    </div>
                    <div class="col-md-6" style="margin-bottom: 10px">
                      <div id="leastAttendeeFeeContainer">
                        <div id="leastAttendeeFeeError" class="error-message">*必填</div>
                        <input name="leastAttendeeFee" type="price" style="width: 200px;" placeholder="最低費用">
                      </div>

                    </div>
                    <div class="col-md-6" style="margin-bottom: 10px">
                      <div id="maxAttendeeFeeContainer">
                        <div id="maxAttendeeFeeError" class="error-message">*必填</div>
                        <input name="maxAttendeeFee" type="price" style="width: 200px;" placeholder="最高費用">
                      </div>

                    </div>
                  </div>
                </div>
                <div id="activityDescriptionContainer" style="margin-top: -20px;">
                  <div id="activityDescriptionError" class="error-message" style="display:none;">*必填</div>
                  <textarea name="activityDescription" rows="3" placeholder="備註" type="text"></textarea>
                </div>

              </div>
              <div style=" display: flex; justify-content: flex-end;">
                <input type="hidden" name="action" value="insert">
                <input type="hidden" name="accountId" value="<?= $accountId ?>">
                <button class="btn-secondary">提交</button>
              </div>
            </div>
          </div>
        </div>
      </form>

      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <span style="display: flex;">
                <h6>徽章進度</h6>
                <span-i style="margin-left: 20px;">
                  <i class="fa-solid fa-fire"
                    style="color: <?= ($attendeeActivityCount >= 0 && $attendeeActivityCount <= 3) ? '#B02626' : 'rgba(0, 0, 0, 0.16)' ?>"></i>
                  <i class="fa-solid fa-compass"
                    style="color: <?= ($attendeeActivityCount >= 4 && $attendeeActivityCount <= 10) ? '#002049' : 'rgba(0, 0, 0, 0.16)' ?>"></i>
                  <i class="fa-solid fa-binoculars"
                    style="color: <?= ($attendeeActivityCount >= 11 && $attendeeActivityCount <= 15) ? '#7d7d7d' : 'rgba(0, 0, 0, 0.16)' ?>"></i>
                  <i class="fa-solid fa-campground"
                    style="color: <?= ($attendeeActivityCount > 15) ? '#525F58' : 'rgba(0, 0, 0, 0.16)' ?>"></i>
                </span-i>

              </span>
              <div style="display: flex; justify-content: space-between;">
                <span style="display: flex;">
                  <p>已參加活動</p>
                  <p>
                    <?php echo $attendeeActivityCount ?>
                  </p>
                  <p>次</p>
                </span>
                <?php
                $remainingActivities = 0;
                $progressPercentage = 0;

                if ($attendeeActivityCount >= 0 && $attendeeActivityCount <= 3) {
                  $remainingActivities = 4 - $attendeeActivityCount;
                  $progressPercentage = ($attendeeActivityCount / 4) * 100;
                } elseif ($attendeeActivityCount >= 4 && $attendeeActivityCount <= 10) {
                  $remainingActivities = 11 - $attendeeActivityCount;
                  $progressPercentage = (($attendeeActivityCount - 4) / (11 - 4)) * 100;
                } elseif ($attendeeActivityCount >= 11 && $attendeeActivityCount <= 15) {
                  $remainingActivities = 16 - $attendeeActivityCount;
                  $progressPercentage = (($attendeeActivityCount - 11) / (16 - 11)) * 100;
                } elseif ($attendeeActivityCount > 15) {
                  $remainingActivities = 0;
                  $progressPercentage = 100;
                }
                ?>
                <span style="display: flex;">
                  <p>還差</p>
                  <p>
                    <?= $remainingActivities ?>
                  </p>
                  <p>次升級</p>
                </span>
              </div>
              </span>
              <div class="progress" style="height:0.7rem; border-radius:35px;">
                <div class="progress-bar" role="progressbar"
                  style="width: <?= $progressPercentage ?>%; background-color:#8D703B;"
                  aria-valuenow="<?= $progressPercentage ?>" aria-valuemin="0" aria-valuemax="100">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--篩選 -->
      <div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modalContent-filter">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">篩選標籤</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i id="close" class="fa-solid fa-circle-xmark" style="color:#a0a0a0;"></i>
              </button>
            </div>
            <div class="modal-body">
              <?php
              $sql_labels = "SELECT * FROM labels WHERE labelType = '營地'";
              $result_labels = mysqli_query($conn, $sql_labels);
              $labels = [];
              while ($row_labels = mysqli_fetch_assoc($result_labels)) {
                $labels[] = $row_labels;
              }
              foreach ($labels as $label) {
                $labelId = $label['labelId'];
                $labelName = $label['labelName'];
                echo '<div class="form-check">';
                echo '<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" data-label-id="' . $labelId . '">';
                echo '<label class="form-check-label" for="flexCheckDefault">' . $labelName . '</label>';
                echo '</div>';
              }
              ?>
            </div>
            <div class="modal-footer">
              <div style=" display: flex; justify-content: flex-end;">
                <button type="button" class="btn-secondary" data-dismiss="modal"
                  onclick="filterActivities()">確認</button>
              </div>
            </div>
          </div>
        </div>
      </div>

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



</body>

</html>