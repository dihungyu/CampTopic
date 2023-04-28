<?php
require_once '../php/conn.php';

// $activityId = $_GET['activityId'];
$activityId = '3525062ec997889fc584f54177abda3a';

$sql_getDataQuery = "SELECT * FROM activities WHERE activityId = '$activityId'";
$result = mysqli_query($conn, $sql_getDataQuery);
$row_result = mysqli_fetch_assoc($result);

$activityId = $row_result['activityId'];
$campsiteId = $row_result['campsiteId'];
$accountId = $row_result['accountId'];
$activityTitle = $row_result['activityTitle'];
$activityDescription = $row_result['activityDescription'];
$activityStartDate = $row_result['activityStartDate'];
$activityEndDate = $row_result['activityEndDate'];
$minAttendee = $row_result['minAttendee'];
$maxAttendee = $row_result['maxAttendee'];
$leastAttendeeFee = $row_result['leastAttendeeFee'];
$maxAttendeeFee = $row_result['maxAttendeeFee'];

$sql_campsite = "SELECT * FROM campsites WHERE campsiteId = '$campsiteId'";
$result_campsite = mysqli_query($conn, $sql_campsite);
$row_result_campsite = mysqli_fetch_assoc($result_campsite);

$campsiteName = $row_result_campsite['campsiteName'];

$sql_account = "SELECT * FROM accounts WHERE accountId = '$accountId'";
$result_account = mysqli_query($conn, $sql_account);
$row_result_account = mysqli_fetch_assoc($result_account);

$accountName = $row_result_account['accountName'];

$sql_file = "SELECT * FROM files WHERE campsiteId = '$campsiteId'";
$result_file = mysqli_query($conn, $sql_file);

$sql_route1 = "SELECT * FROM routes WHERE activityId = '$activityId' ORDER BY dayNumber ASC";
$result_route = mysqli_query($conn, $sql_route1);

$sql_account = "SELECT accounts.* FROM activities_accounts JOIN accounts
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

    if ($account_result["accountGender"] == "Male") {
      $maleCount++;
    } elseif ($account_result["accountGender"] == "Female") {
      $femaleCount++;
    }
  }
} else {
  echo "找不到符合的資料";
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
</head>

<body>

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

  <div class="hero page-inner overlay" style="background-image: url('images/Wireshark.png');
      height:70vh;
      min-height: 300px;">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-12 text-center mt-5">
          <h1 class="heading" data-aos="fade-up">活動資訊
          </h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="index.html">首頁</a></li>
              <li class="breadcrumb-item"><a href="index.html">找小鹿</a></li>
              <li class="breadcrumb-item active text-white-50" aria-current="page">
                活動資訊
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <section class="ftco-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="row">
            <div class="col-md-12 ftco-animate">
              <h5 class="mb-4" style="font-weight:bold;">
                <?php echo $activityTitle ?>
              </h5>
              <span style="display: flex;margin-bottom: 64px;align-items: center;">
                <img src="images/person_4.jpg" alt="Image description" style="border-radius: 50%;
                  width: 4%;
                  margin-right: 16px;">
                <label style="font-size: 16px; margin-bottom: 0px;">
                  <?php echo $accountName ?>
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
                  <?php echo $accountName ?>
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
              <span style="display: flex; justify-content: flex-end; margin-right: 15px;">
                <button type="button" class="btn-icon" data-toggle="modal" data-target="#more1">
                  <a href="#more1">查看更多</a>
                </button>
              </span>
              <div>

              </div>
              <div class="col-md-12 room-single ftco-animate mb-5 mt-5" style="margin-left: -15px ;">
                <h4 class="mb-4" style="font-weight:bold;">行程介紹</h4>
                <?php
                while ($route_result = mysqli_fetch_assoc($result_route)) {
                  $routeId = $route_result['routeId'];
                  $dayNumber = $route_result['dayNumber'];
                  $locations = $route_result['locations'];
                  $dayText = 'Day ' . $dayNumber;
                  echo '<div class="block-16">';
                  echo '  <span style="display: flex;">';
                  echo '    <div class="day">';
                  echo '      <p>' . $dayText . '</p>';
                  echo '    </div>';
                  echo '    <div class="spot">';
                  echo '      <p>' . $locations . '</p>';
                  echo '    </div>';
                  echo '  </span>';
                  $sql_tripIntroduction = "SELECT * FROM tripIntroductions WHERE routeId = $routeId";
                  $result_tripIntroduction = mysqli_query($conn, $sql_tripIntroduction);
                  while ($tripIntroduction_result = mysqli_fetch_assoc($result_tripIntroduction)) {
                    $tripIntroductionTitle = $tripIntroduction_result['tripIntroductionTitle'];
                    $tripIntroductionContent = $tripIntroduction_result['tripIntroductionContent'];
                    echo '  <div style="clear: both;">';
                    echo '    <br>';
                    echo '    <h6>' . $tripIntroductionTitle . '</h6>';
                    echo '    <p>' . $tripIntroductionContent . '</p>';
                    echo '  </div>';
                  }
                  echo '</div>';
                  $sql_route_file = "SELECT * FROM files WHERE routeId = $routeId";
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
                <h4>攜帶物品</h4>
                <br>
                <div class="list">
                  <li>睡袋</li>
                  <li>洗漱用品</li>
                  <li>保暖衣物</li>
                  <li>點心</li>
                </div>
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
                // 輸出 accountName
                $displayCount = 0;
                foreach ($accounts as $account) {
                  if ($displayCount >= 3) {
                    break;
                  }
                  $accountName = $account['accountName'];
                  echo '<span style="display: flex;margin-bottom: 16px; align-items: center;">';
                  echo '<img src="images/person_4.jpg" alt="Image description" style="border-radius: 50%; width: 10%; margin-right: 16px;">';
                  echo '<label style="font-size: 16px; margin-bottom: 0px;">' . $accountName . '</label></span>';
                  $displayCount++;
                }
                ?>
                <span class="more">
                  <button type="button" class="btn-icon" data-toggle="modal" data-target="#more2">
                    <a href="#more2">查看更多</a></button>
                </span>

                <div class="box-side">
                  <h6>目前所需用品</h6>
                </div>
                <div class="list" style="font-size: 14px;">
                  <li>睡袋</li>
                  <li>洗漱用品</li>
                  <li>保暖衣物</li>
                  <li>點心</li>
                </div>
                <span class=" more">
                  <button type="button" class="btn-icon" data-toggle="modal" data-target="#more3">
                    <a href="#more3">查看更多</a></button>
                </span>
                <div class="box-side">
                  <button type="button" class="btn-side" id="show" data-toggle="modal" data-target="#exampleModal"
                    data-whatever="@mdo">我要參加！</button>
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
      </div>
  </section>

  <div class="site-footer" style="clear: both;">
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

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modalContent">
        <div class="box-mod">
          <h4 id="exampleModalLabel">參加</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i id="close" class="fa-solid fa-circle-xmark" style="color:#a0a0a0;"></i>
          </button>
        </div>
        <p style="color: #a0a0a0 ">參加活動蒐集勳章！
        <p>

        <div class="modal-list">
          <input type="text" placeholder="電話">
          <input type="email" placeholder="信箱">
          <textarea rows="4" type="text" value="suggest" placeholder="備註 / 建議"></textarea>

          <h6 style="font-weight:bold;">可提供裝備</h6>
          <div class="supply">
            <div class="row">
              <div class="col-md-4">
                <input type="checkbox">
                <p>帳篷</p>
                <select>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                </select>
              </div>

              <div class="col-md-4">
                <input type="checkbox">
                <p>睡袋</p>
                <select>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                </select>
              </div>

              <div class="col-md-4">
                <input type="checkbox">
                <p>手電筒</p>
                <select>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                </select>
              </div>

              <div class="col-md-4">
                <input type="checkbox">
                <p>瓦斯爐</p>
                <select>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                </select>
              </div>

              <div class="col-md-4">
                <input type="checkbox">
                <p>帳篷</p>
                <select>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                </select>
              </div>

              <div class="col-md-4">
                <input type="checkbox">
                <p>帳篷</p>
                <select>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <input type="checkbox">
                <p>帳篷</p>
                <select>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                </select>
              </div>

              <div class="col-md-4">
                <input type="checkbox">
                <p>帳篷</p>
                <select>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                </select>
              </div>

              <div class="col-md-4">
                <input type="checkbox">
                <p>帳篷</p>
                <select>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                </select>
              </div>

              <div class="w-100"></div>
              <div class="col-md-4">
                <input type="checkbox">
                <p>帳篷</p>
                <select>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                </select>
              </div>

              <div class="col-md-4">
                <input type="checkbox">
                <p>帳篷</p>
                <select>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                </select>
              </div>

              <div class="col-md-4">
                <input type="checkbox">
                <p>帳篷</p>
                <select>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                </select>
              </div>
            </div>
          </div>
          <textarea rows="2" placeholder="其他" type="text"></textarea>
        </div>
        <div style=" display: flex;
        justify-content: flex-end;">
          <button class="btn-secondary">提交</button>
        </div>
      </div>
    </div>
  </div>
  <!-- 詳細內容查看更多 -->
  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="more1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">更多詳細內容</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i id="close" class="fa-solid fa-circle-xmark" style="color:#a0a0a0;"></i>
          </button>
        </div>
        <div class="modal-list" style="margin: 32px;">
          <p>
            大家好！想要人多一起露營卻找不到志同道合的人一起嗎？<br>
            我們在找的就是喜愛露營的你，如果害羞也可以找認識的朋友一起來玩！我們也規畫許多景點一起探索~<br>
            我們將在美麗的自然環境中建立露營地，並舉辦一系列的活動，包括徒步旅行、野餐、烤火晚會、星空觀測等，這將是一個絕佳的機會，讓你們放鬆身心，與自然環境建立更深厚的聯繫。<br>
            無論你是一個喜歡戶外活動的新手還是一個經驗豐富的露營達人，我們都歡迎你的加入，這將是一個充滿友誼和探險的旅程，讓我們一起度過一個難忘的夏日！
            馬上報名參加我們的露營活動吧，我們期待著與你們共度美好時光！

          </p>
        </div>
      </div>
    </div>
  </div>

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
                $accountName = $account['accountName'];
                echo '<div class="col-md-4">';
                echo '<span style="display: flex; align-items: center; justify-content: flex-start">';
                echo '<img src="images/person_4.jpg" alt="Image description" style="border-radius: 50%; width: 30%; margin-right: 16px;">';
                echo '<label style="font-size: 16px; margin-bottom: 0px; ">' . $accountName . '</label></span>';
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
                  $color = 'rgba(0, 0, 0, 0.16)';
                  $text = '方向盤';
                } elseif ($attendeeActivityCount >= 11 && $attendeeActivityCount <= 15) {
                  $iconClass = 'fa-solid fa-binoculars';
                  $color = 'rgba(0, 0, 0, 0.16)';
                  $text = '望遠鏡';
                } elseif ($attendeeActivityCount > 15) {
                  $iconClass = 'fa-solid fa-campground';
                  $color = 'rgba(0, 0, 0, 0.16)';
                  $text = '帳篷';
                }
                echo '<i class="' . $iconClass . '" style="color: ' . $color . '; font-size:20px; margin-right: 8px;"></i>';
                echo '<p style="font-size: 14px;">' . $text . '</p>';
                echo '</div>';
                echo '<div class="col-md-4" style="display: flex; align-items: center; justify-content: center;">';
                if ($account['accountGender'] == 'Male') {
                  echo '<i class="fa-solid fa-child fa-lg" style="color: #8DA0D0;"></i>';
                } else if ($account['accountGender'] == 'Female') {
                  echo '<i class="fa-solid fa-child-dress fa-lg" style="color: #F1ACAC;"></i>';
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

  <div class="modal fade" id="more3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modalContent">
        <div class="box-mod">
          <h5 id="exampleModalLabel">所有所需用品</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i id="close" class="fa-solid fa-circle-xmark" style="color:#a0a0a0;"></i>
          </button>
        </div>
        <div class="modal-list">
          <div class="list">
            <li>睡袋</li>
            <li>洗漱用品</li>
            <li>保暖衣物</li>
            <li>瓦斯爐</li>
            <li>瓦斯罐</li>
            <li>露營燈</li>
            <li>點心</li>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- .section -->
  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
      <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
      <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
        stroke="#F96D00" />
    </svg></div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
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


</body>

</html>