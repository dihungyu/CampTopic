<?php
session_start();

//判斷是否登入
if (!isset($_COOKIE["accountId"])) {
  $_SESSION["system_message"] = "請先登入或註冊成為會員!";
  header("Location: ../../login.php");
  exit;
}
require_once "../../php/conn.php";
require_once "../../php/uuid_generator.php";
require_once "../../php/get_img_src.php";

//判斷是否登入，若有則對變數初始化
if (isset($_COOKIE["accountId"])) {
  $accountId = $_COOKIE["accountId"];
}

// 取得會員資料

$stmt = $conn->prepare("SELECT * FROM `accounts` WHERE `accountId` = ?");
$stmt->bind_param("s", $accountId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) exit('No rows');
if ($row = mysqli_fetch_assoc($result)) {
  $accountId = $row["accountId"];
  $accountName = $row["accountName"];
  $accountGender = $row["accountGender"];
  $accountBirthday = $row["accountBirthday"];
  $accountPassword = $row["accountPassword"];
  $accountEmail = $row["accountEmail"];
  $accountPhoneNumber = $row["accountPhoneNumber"];
  $attendeeActivityCount = $row["attendeeActivityCount"];
}

if (isset($_POST["updateMember"]) && $_POST["updateMember"] == "yes") {
  $accountName = $_POST["accountName"];
  $accountGender = $_POST["accountGender"];
  $accountBirthday = $_POST["accountBirthday"];
  $accountEmail = $_POST["accountEmail"];
  $accountPhoneNumber = $_POST["accountPhoneNumber"];

  $stmt = $conn->prepare("UPDATE accounts SET accountName = ?, accountGender = ?, accountBirthday = ?, accountEmail = ?, accountPhoneNumber = ? WHERE accountId = ?");
  $stmt->bind_param("ssssss", $accountName, $accountGender, $accountBirthday, $accountEmail, $accountPhoneNumber, $accountId);
  $stmt->execute();

  //跳出提示窗，內容為修改成功
  $_SESSION["system_message"] = "更新成功";
  header("Location: member.php");
  exit;
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
  <link rel="stylesheet" href="https://kit.fontawesome.com/d02d7e1ecb.css" crossorigin="anonymous">

  <!-- 上傳頭貼用 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0-alpha1/dist/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    .btn-custom-size {
      font-size: 0.8rem;
      padding: 0.4rem 0.6rem;
    }

    .avatar-wrapper {
      width: 110px;
      height: 110px;
      border-radius: 50%;
      overflow: hidden;
    }

    .avatar {
      width: 100%;
      height: 100%;
      object-fit: cover;
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
  <div class="hero page-inner overlay" style="background-image: url('images/Rectangle\ 136.png')">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-9 text-center mt-5">
          <h1 class="heading" data-aos="fade-up">會員資料</h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
              <li class="breadcrumb-item active text-white-50" aria-current="page">
                會員資料
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <div class="section">
    <div class="container">
      <div class="row" style="justify-content: space-evenly;">
        <div class="col-md-6 mb-3">
          <div class="card" style="border:none; padding-left:100px; padding-top:70px;">
            <div class="card-member">
              <div class="card-body">

                <div class="d-flex flex-column align-items-center text-center">
                  <div class="mb-3">
                    <?php
                    // 取得頭像
                    $image_src = get_profileImg_src($accountId, $conn);
                    ?>
                    <div class="avatar-wrapper">
                      <img src="<?php echo $image_src ?>" alt="Admin" class="avatar">
                    </div>
                  </div>
                  <form action="uploadProfilePic.php" method="post" enctype="multipart/form-data">
                    <div class="d-flex justify-content-end">
                      <input type="file" class="form-control d-none" id="avatar" name="avatar" accept="image/*" required>
                      <button class="btn btn-primary btn-sm ms-3 btn-custom-size" id="uploadBtn" type="button" style="margin-bottom: 16px;">更換頭像</button>
                      <button class="btn btn-success btn-sm d-none" id="submitBtn" type="submit" name="submit">上傳</button>
                    </div>
                  </form>
                  <div class="mb-3">
                    <h5><?php echo $accountName; ?></h5>
                  </div>
                </div>










                <hr>
                <span>
                  <h6>徽章進度</h6>
                  <span-i>
                    <i class="fa-solid fa-fire" style="color:#B02626"></i>
                    <i class="fa-solid fa-compass" style="color:rgba(0, 0, 0, 0.16)"></i>
                    <i class="fa-solid fa-binoculars" style="color:rgba(0, 0, 0, 0.16)"></i>
                    <i class="fa-solid fa-campground" style="color:rgba(0, 0, 0, 0.16)"></i>
                  </span-i>
                </span>
                <span style="margin-bottom:0px;">
                  <p>已參加活動</p> &nbsp;
                  <p><?php echo $attendeeActivityCount ?></p> &nbsp;
                  <p>次</p>
                  <span style="margin-left:210px;margin-bottom:0px;">
                    <p>差</p>&nbsp;
                    <p>1</p>&nbsp;
                    <p>次升級</p>
                  </span>
                </span>
                <div class="progress" style="height:0.7rem; border-radius:35px;">
                  <div class="progress-bar" role="progressbar" style="width: 50%;
                        background-color:#8D703B;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 mb-3 mt-5"">
          <form action=" member.php" method="post">
          <input type="hidden" name="updateMember" value="yes">
          <div class="column">

            <span style="width: 400px;
              flex-wrap: wrap;
              font-size: 16px;
              font-weight: bolder;
              margin-left: 4px;
              align-items: center;
              ">
              <i class="fa-solid fa-pencil" style="margin-right: 16px; margin-bottom: 48px;"></i>編輯會員資料</span>

            <span class="member-input">
              <p>姓名</p>
              <input type="text" name="accountName" class="form-control" style="font-size: 14px; margin-bottom: 0px; height: 42px;" placeholder="請輸入名字" value="<?php echo $accountName; ?>" required />

            </span>

            <span class="member-input">
              <p>電話</p>
              <input type="tel" name="accountPhoneNumber" class="form-control" style="font-size: 14px; margin-bottom: 0px; height: 42px;" placeholder="請輸入電話" value="<?php echo $accountPhoneNumber; ?>" required />

            </span>

            <span class="member-input">
              <p>信箱</p>
              <input type="email" name="accountEmail" class="form-control" style="font-size: 14px; margin-bottom: 0px; height: 42px;" placeholder="請輸入電子郵件" value="<?php echo $accountEmail; ?>" required />

            </span>

            <span class="member-input">
              <p>生日</p>
              <input type="date" name="accountBirthday" id="birthday" class="form-control" style="font-size: 14px; margin-bottom: 0px; height: 42px;" placeholder="請選擇日期" value="<?php echo $accountBirthday; ?>" required>
            </span>

            <span class="member-input">
              <p>性別</p>
              <input type="radio" name="accountGender" value="Female" style="margin-left: 12px; margin-bottom:0px; width: 13px; height:13px;" <?php if ($accountGender == "Female") {
                                                                                                                                                echo "checked";
                                                                                                                                              } ?> required>
              <label for="Female" style="font-weight: bold;font-size:16px; margin-left:8px">女</label>
              <input type="radio" name="accountGender" value="Male" style=" margin-left: 20px; margin-bottom:0px; width: 13px; height:13px" <?php if ($accountGender == "Male") {
                                                                                                                                              echo "checked";
                                                                                                                                            } ?> required>
              <label for=" Male" style="font-weight: bold;font-size:16px; margin-left:8px">男</label>
            </span>

            <hr width="100%" size="3" style="margin-top: 20px; margin-bottom: 52px;">

            <span class="member-input">
              <p>密碼</p>
              <a href="password.php" style="margin-left: 32px;">設定新的密碼</a>
            </span>

            <div class="col-10 mb-3"">

                <span class=" member-bottom">
              <input type="reset" value="取消" class="btn btn-secondary" style="margin-right: 12px;color: #000; background-color: #f1f1f1; padding: 10px; font-weight: 400;">
              <input type="submit" value="確認修改" class="btn btn-primary" style="padding: 10px; font-weight: 400;">
            </div></span>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- /.untree_co-section -->

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
  <script>
    $(function() {
      // 取得當前日期再減去 18 年的日期，並將其設置為生日欄位的最大可選日期
      var today = new Date();
      var maxBirthday = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
      $("#birthday").attr("max", maxBirthday.toISOString().slice(0, 10));

      // 初始化日期選擇器
      $("#birthday").datepicker({
        language: 'zh-TW', // 設置語言為繁體中文
        autoclose: true, // 選擇日期後自動關閉
        clearBtn: false, // 清除按鈕
        format: "yyyy-mm-dd", // 日期格式
        beforeShowDay: function(date) {
          var selectable = true;
          var cssClass = '';
          var tooltip = '';

          // 判斷日期是否小於18年前的日期，如是，則不可選
          if (date >= maxBirthday) {
            selectable = false;
            cssClass = 'disabled';
            tooltip = '必須年滿18歲才能註冊';
          }

          return {
            enabled: selectable, // 是否可選
            classes: cssClass, // 當前日期的樣式
            tooltip: tooltip, // 滑鼠提示內容
            content: date.getDate() // 當前日期單元格顯示的內容
          }
        }
      });
    });
  </script>

  <!-- 上傳頭貼與預覽頭貼 -->
  <script>
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('.avatar').attr('src', e.target.result);
          $('#submitBtn').removeClass('d-none');
        };

        reader.readAsDataURL(input.files[0]);
      }
    }

    $(document).ready(function() {
      $('#uploadBtn').on('click', function(event) {
        event.preventDefault();
        $('#avatar').click();
      });

      $('#avatar').on('change', function() {
        readURL(this);
      });
    });
  </script>


  <!-- 控制系統訊息 -->
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