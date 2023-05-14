<?php
require_once '../php/conn.php';

session_start();

$campsiteId = $_GET['campsiteId'];

// 查詢 campsite 資料
$sql_query_campsite = "SELECT * FROM campsites WHERE campsiteId = '$campsiteId'";
$result_campsite = mysqli_query($conn, $sql_query_campsite);
$row_campsite = mysqli_fetch_assoc($result_campsite);

$cityId = !empty($row_campsite['cityId']) ? $row_campsite['cityId'] : '無資料';
$campsiteName = !empty($row_campsite['campsiteName']) ? $row_campsite['campsiteName'] : '無資料';
$campsiteDescription = !empty($row_campsite['campsiteDescription']) ? $row_campsite['campsiteDescription'] : '無資料';
$campsiteAddress = !empty($row_campsite['campsiteAddress']) ? $row_campsite['campsiteAddress'] : '無資料';
$campsiteAddressLink = !empty($row_campsite['campsiteAddressLink']) ? $row_campsite['campsiteAddressLink'] : '無資料';
$campsiteVideoLink = !empty($row_campsite['campsiteVideoLink']) ? $row_campsite['campsiteVideoLink'] : '無資料';

// 查詢 serviceId 和 iconCode
$sql_query_services = "SELECT campsites_services.serviceId, services.iconId, services.serviceName, icons.iconCode
  FROM campsites_services
  JOIN services ON campsites_services.serviceId = services.serviceId
  JOIN icons ON services.iconId = icons.iconId
  WHERE campsites_services.campsiteId = '$campsiteId'";
$result_services = mysqli_query($conn, $sql_query_services);

$services = [];
while ($row_service = mysqli_fetch_assoc($result_services)) {
  // 將獲取到的 serviceId 和 iconCode 保存到 $services 陣列中
  $serviceId = $row_service['serviceId'];
  $serviceName = $row_service['serviceName'];
  $iconCode = $row_service['iconCode'];
  $services[$serviceName] = $iconCode;
}
$services_count = count($services);

$files_query = "SELECT * FROM files WHERE campsiteId = '$campsiteId'";
$files_result = mysqli_query($conn, $files_query);



?>
<!DOCTYPE html>

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
  <link rel="stylesheet" href="property-1.0.0/css/icomoon.css">


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

  <html lang="en">

  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a href="property-1.0.0/index.php"><img class="navbar-brand" src="images/Group 59.png"
          style="width: 90px; height: auto;"></img></a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
        aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
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
            <a class="nav-link dropdown-toggle" href="member.php" id="navbarDropdown" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              帳號
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="property-1.0.0/member.php">會員帳號</a>
              <a class="dropdown-item" href="property-1.0.0/member-like.php">我的收藏</a>
              <a class="dropdown-item" href="property-1.0.0/member-record.php">發表記錄</a>
              <a class="dropdown-item" href="property-1.0.0/myActivityRecord.php">活動紀錄</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="../login.php">登出</a>
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
          <h1 class="heading" data-aos="fade-up">營地資訊</h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="property-1.0.0/index.html">首頁</a></li>
              <li class="breadcrumb-item active text-white-50" aria-current="page">
                營地
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
              <h3 class="mb-4">
                <?php echo $campsiteName ?>
              </h3>
              <div class="single-slider owl-carousel">
                <?php
                while ($file_result = mysqli_fetch_assoc($files_result)) {
                  $file_name = $file_result['fileName'];
                  $file_path = '../upload/' . $file_name;
                  echo "<div class='item'>";
                  echo "<div class='room-img' style='background-image: url($file_path);'></div>";
                  echo "</div>";
                }
                ?>

              </div>
            </div>
            <div class="col-md-12 room-single mt-4 mb-4 ftco-animate">
              <h6 style="margin-top: 56px">營地描述</h6>
              <p>
                <?php echo $campsiteDescription ?>
              </p>
              <h6 style="margin-top: 56px">設備與服務</h6>
              <div class="d-md-flex mt-4 mb-4">
                <?php
                // 將 $services 陣列中的資料分組輸出成多個 <ul> 列表
                if ($services_count > 0) {
                  echo '<ul class="list">';

                  $i = 1;
                  foreach ($services as $serviceName => $iconCode) {
                    // 如果已經輸出了四個項目，則開始新的 <ul> 列表
                    if ($i % 5 == 0) {
                      echo '</ul><ul class="list ml-md-5">';
                    }

                    // 輸出 <li> 列表項
                    echo '<li><span><i class="' . $iconCode . '" style="margin-right: 8px;"></i></span>' . $serviceName . '</li>';

                    $i++;
                  }

                  echo '</ul>';
                } else {
                  echo '<span>尚無相關設備</span>';
                }
                ?>
              </div>
            </div>
            <div class="col-md-12 room-single ftco-animate mb-5 mt-4">
              <h4 class="mb-4">影片導覽</h4>
              <div class="block-16">
                <figure>
                  <?php
                  if ($campsiteVideoLink == '無資料') {
                    echo '<span>尚無相關影片</span>';
                  } else {
                    echo '<iframe width="800" height="433" src="' . $campsiteVideoLink . '" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>';
                  }
                  ?>
                </figure>
              </div>
            </div>


          </div>
        </div> <!-- .col-md-8 -->
        <div class="col-lg-4 sidebar ftco-animate">
          <div class="sidebar-box ftco-animate">
            <h3>推薦文章</h3>
            <?php
            $top234_article_sql = "SELECT articles.*, accounts.accountName FROM articles JOIN accounts ON articles.accountId = accounts.accountId ORDER BY articleLikeCount DESC LIMIT 1, 3";
            $top234_article_result = mysqli_query($conn, $top234_article_sql);

            if ($top234_article_result && mysqli_num_rows($top234_article_result) > 0) {
              while ($top234_article_row = mysqli_fetch_assoc($top234_article_result)) {
                $articleId = $top234_article_row["articleId"];

                $files_query = "SELECT * FROM files WHERE articleId = '$articleId'";
                $files_result = mysqli_query($conn, $files_query);
                $image_src = '../property-1.0.0/images/Rectangle\ 135.png'; // Default image
            
                if ($file_result = mysqli_fetch_assoc($files_result)) {
                  $file_path = str_replace('Applications/XAMPP/xamppfiles/htdocs', '../..', $file_result['filePath']);
                  $image_src = $file_path;
                }

                $timestamp = strtotime($top234_article_row["articleCreateDate"]);
                $formatted_date = date('F j, Y', $timestamp);

                $query = "SELECT COUNT(*) as comment_count FROM comments WHERE articleId = '$articleId'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $comment_count = $row['comment_count'];

                echo "<div class='block-21 mb-4 d-flex'>
                        <a class='blog-img mr-4' style='background-image: url(" . $image_src . ");'></a>
                        <div class='text'>
                        <div>
                            <h3 class='heading'>
                            <a href='article.php?articleId=" . $articleId . "'>" . $top234_article_row["articleTitle"] . "</a></h3>

                            <div class='meta'>
                                <div><a href='article.php?articleId=" . $articleId . "'><span class='icon-calendar'></span> " . $formatted_date . "</a></div>
                                <div><a href='article.php?articleId=" . $articleId . "'><span class='icon-person'></span> " . $top234_article_row["accountName"] . "</a></div>
                                <div><a href='article.php?articleId=" . $articleId . "'><span class='icon-chat'></span> " . $comment_count . "</a></div>
                            </div>
                        </div>
                        </div>
                      </div>";
              }
            }
            ?>
          </div>

          <div class="sidebar-box ftco-animate">
            <h3>營地標籤</h3>
            <div class="tagcloud">
              <?php
              // 查詢campsites_labels資料表以獲取labelId
              $sql1 = "SELECT labelId FROM campsites_labels WHERE campsiteId = ?";
              $stmt1 = $conn->prepare($sql1);
              $stmt1->bind_param("s", $campsiteId);
              $stmt1->execute();
              $result1 = $stmt1->get_result();

              // 查詢labels資料表以獲取labelName
              $labelNames = array();
              if ($result1->num_rows > 0) {
                while ($row1 = $result1->fetch_assoc()) {
                  $labelId = $row1['labelId'];
                  $sql2 = "SELECT labelName FROM labels WHERE labelId = ?";
                  $stmt2 = $conn->prepare($sql2);
                  $stmt2->bind_param("s", $labelId);
                  $stmt2->execute();
                  $result2 = $stmt2->get_result();

                  if ($result2->num_rows > 0) {
                    $row2 = $result2->fetch_assoc();
                    $labelNames[] = $row2['labelName'];
                  }
                }
              }
              // 輸出結果
              if (!empty($labelNames)) {
                foreach ($labelNames as $labelName) {
                  echo "<a href='#' class=tag-cloud-link'>" . $labelName . "</a>";
                }
              } else {
                echo "<span>尚無相關標籤</span>";
              }
              ?>
              <?php
              // 查詢campsites_labels資料表以獲取labelId
              $sql1 = "SELECT labelId FROM campsites_labels WHERE campsiteId = ?";
              $stmt1 = $conn->prepare($sql1);
              $stmt1->bind_param("s", $campsiteId);
              $stmt1->execute();
              $result1 = $stmt1->get_result();

              // 查詢labels資料表以獲取labelName
              $labelNames = array();
              if ($result1->num_rows > 0) {
                while ($row1 = $result1->fetch_assoc()) {
                  $labelId = $row1['labelId'];
                  $sql2 = "SELECT labelName FROM labels WHERE labelId = ?";
                  $stmt2 = $conn->prepare($sql2);
                  $stmt2->bind_param("s", $labelId);
                  $stmt2->execute();
                  $result2 = $stmt2->get_result();

                  if ($result2->num_rows > 0) {
                    $row2 = $result2->fetch_assoc();
                    $labelNames[] = $row2['labelName'];
                  }
                }
              }
              // 輸出結果
              if (!empty($labelNames)) {
                foreach ($labelNames as $labelName) {
                  echo "<a href='#' class=tag-cloud-link'>" . $labelName . "</a>";
                }
              } else {
                echo "<span>尚無相關標籤</span>";
              }
              ?>
            </div>
          </div>

        </div>
      </div>

    </div>

    <!-- .section -->
    <!-- map-->
    <div class="container" style="margin-top:40px;">
      <div class="col-md-12 room-single ftco-animate mb-5 mt-5">
        <h4 class="mb-4">找到我們</h4>
        <div class="contact-page-area section-gap">
          <span>
            <h6>地址</h6>
            <p style="color:#A0A0A0">
              <?php echo $campsiteAddress ?>
            </p>
          </span>
          <div class="row">
            <div class="map-wrap" style="height: 445px;">
              <?php
              if ($campsiteAddressLink == '無資料') {
                echo '<span style="margin-left: 16px;">尚無相關地圖</span>';
              } else {
                echo '<iframe src="' . $campsiteAddressLink . '" width="1300" height="445" style="border:0;"
              allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
              }
              ?>
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
          <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
            stroke="#F96D00" />
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
      <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
      <script src="js/google-map.js"></script>
      <script src="js/main.js"></script>
      <script src="https://kit.fontawesome.com/d02d7e1ecb.js" crossorigin="anonymous"></script>

</body>

</html>