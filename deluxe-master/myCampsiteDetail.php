<?php
require_once '../php/conn.php';

session_start();

// 初始化accountId
if (isset($_COOKIE["accountId"])) {
    $accountId = $_COOKIE["accountId"];
}

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
$isReviewed = $row_campsite['isReviewed'];

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

$files_query = "SELECT * FROM files WHERE campsiteId = '$campsiteId' AND filePathType = 'campsiteCover'";
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
    <!-- 系統訊息 -->
    <?php if (isset($_SESSION["system_message"])): ?>
        <div id="message" class="alert alert-success"
            style="position: fixed; top: 10%; left: 50%; transform: translate(-50%, -50%); z-index: 1000; padding: 15px 30px; border-radius: 5px; font-weight: 500; transition: opacity 0.5s;">
            <?php echo $_SESSION["system_message"]; ?>
        </div>
        <?php unset($_SESSION["system_message"]); ?>
    <?php endif; ?>

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

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="member.php" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                    <h1 class="heading" data-aos="fade-up">營地資訊</h1>

                    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                        <ol class="breadcrumb text-center justify-content-center">
                            <li class="breadcrumb-item"><a href="property-1.0.0/index.php">首頁</a></li>
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
                            <h4 class="mb-4" style="display:flex;justify-content: space-between; align-items: center;">
                                <?php echo $campsiteName; ?>
                                <button class="btn-icon">
                                    <a
                                        href="/CampTopic/deluxe-master/property-1.0.0/myCampsiteUpdate.php?campsiteId=<?php echo $campsiteId ?>">
                                        <i class="fas fa-edit" style="font-weight: 500;color: #000; "></i>
                                    </a>
                                </button>
                            </h4>
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
                                <?php

                                echo $campsiteDescription ?>
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

        <!-- footer -->
        <?php
        echo '<form method="POST" action="../php/Campsite/isReviewed_update.php">';
        echo '<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">';
        echo '<div class="modal-dialog" role="document">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header">';
        echo '<h5 class="modal-title" id="deleteModalLabel">審核確認</h5>';
        echo '<button type="button" class="close" data-dismiss="modal" aria-label="取消">';
        echo '<span aria-hidden="true">&times;</span>';
        echo '</button>';
        echo '</div>';
        echo '<div class="modal-body">';
        echo '確定要讓「' . $campsiteName . '」上架嗎？';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '<button class="btn-new1" data-dismiss="modal">取消</button>';
        echo '<input type="hidden" name="campsiteId" value="' . $campsiteId . '">';
        echo '<button type="submit" class="btn-new" style="background-color: #28A745;">確認</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</form>';

        echo '<form method="POST" action="../php/Campsite/deleteCampsite.php">';
        echo '<div class="modal fade" id="disagreeModal" tabindex="-1" role="dialog" aria-labelledby="disagreeModalLabel" aria-hidden="true">';
        echo '<div class="modal-dialog" role="document">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header">';
        echo '<h5 class="modal-title" id="deleteModalLabel">刪除確認</h5>';
        echo '<button type="button" class="close" data-dismiss="modal" aria-label="取消">';
        echo '<span aria-hidden="true">&times;</span>';
        echo '</button>';
        echo '</div>';
        echo '<div class="modal-body">';
        echo '確定要否決「' . $campsiteName . '」嗎？';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '<button class="btn-new1" data-dismiss="modal">取消</button>';
        echo '<input type="hidden" name="campsiteId" value="' . $campsiteId . '">';
        echo '<button type="submit" class="btn-new" style="background-color: #B02626;">確認</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</form>';
        ?>

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
            <script>
                function hideMessage() {
                    document.getElementById("message").style.opacity = "0";
                    setTimeout(function () {
                        document.getElementById("message").style.display = "none";
                    }, 500);
                }
                setTimeout(hideMessage, 3000);
            </script>

</body>

</html>