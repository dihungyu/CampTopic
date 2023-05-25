<?php
require_once '../php/conn.php';
require_once '../php/uuid_generator.php';
require_once '../php/get_img_src.php';

session_start();

function format_count($count)
{
    if ($count < 1000) {
        return $count;
    } elseif ($count < 1000000) {
        return round($count / 1000, 1) . 'k';
    } else {
        return round($count / 1000000, 1) . 'm';
    }
}

//判斷是否登入，若有則對變數初始化
if (isset($_COOKIE["accountId"])) {
    $accountId = $_COOKIE["accountId"];
}

$equipmentId = $_GET['equipmentId'];

$sql_equipment = "SELECT * FROM equipments WHERE equipmentId = '$equipmentId'";
$result_equipment = mysqli_query($conn, $sql_equipment);
$row_equipment = mysqli_fetch_assoc($result_equipment);
$equipmentOwnerId = $row_equipment["accountId"];
$equipmentName = $row_equipment['equipmentName'];
$equipmentType = $row_equipment["equipmentType"];
$equipmentName = $row_equipment["equipmentName"];
$equipmentDescription = $row_equipment["equipmentDescription"];
$equipmentPrice = $row_equipment["equipmentPrice"];
$equipmentLikeCount = $row_equipment["equipmentLikeCount"];
$isReviewed = $row_equipment["isReviewed"];

$sql_account = "SELECT * FROM accounts WHERE accountId = '$equipmentOwnerId'";
$result_account = mysqli_query($conn, $sql_account);
$row_account = mysqli_fetch_assoc($result_account);

$ownerName = $row_account['accountName'];
$ownerEmail = $row_account['accountEmail'];
$ownerPhoneNumber = $row_account['accountPhoneNumber'];

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

    <script>
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
            <a href="property-1.0.0/index.php"><img class="navbar-brand" src="images/Group 59.png"
                    style="width: 90px; height: auto;"></img></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> 選單
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item "><a href="property-1.0.0/index-manage.php" class="nav-link">首頁</a></li>
                    <li class="nav-item"><a href="property-1.0.0/manage-article.php" class="nav-link">文章管理</a></li>
                    <li class="nav-item"><a href="property-1.0.0/manage-equip.php" class="nav-link">設備管理</a></li>
                    <li class="nav-item"><a href="property-1.0.0/manage-land.php" class="nav-link">營地管理</a></li>

                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="member.php" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            帳號
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="property-1.0.0/member.php">會員帳號</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../logout.php?action=logout">登出</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END nav -->
    <div class="hero page-inner overlay" style="background-image: url('images/Rectangle\ 134.png')">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-9 text-center mt-5">
                    <h1 class="heading" data-aos="fade-up">設備詳細資訊</h1>

                    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                        <ol class="breadcrumb text-center justify-content-center">
                            <li class="breadcrumb-item"><a href="property-1.0.0/index.php">首頁</a></li>
                            <li class="breadcrumb-item"><a href="equipment.php">鹿的裝備</a></li>
                            <li class="breadcrumb-item active text-white-50" aria-current="page">
                                設備詳細資訊
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

                        <div class="col-md-11 room-single mt-2 mb-5 ftco-animate" style="overflow:hidden;">
                            <div class="detail"
                                style="display: flex; align-items: center; justify-content: space-between;">
                                <span class="span-adj">
                                    <span class="fa-stack fa-1x" style="margin-right: 5px; ">
                                        <i class="fas fa-circle fa-stack-2x"
                                            style="color:#EFE9DA; font-size:30px;padding-left: 0px; "></i>
                                        <i class="fas fa-stack-1x" style="font-size: 13px;padding-left: 0px;">
                                            <?php echo $equipmentType ?>
                                        </i>
                                    </span>
                                    <h1>
                                        <?php echo $equipmentName ?>
                                    </h1>
                                </span>
                                <span style="display:flex; align-items: center;">
                                    <h4 class="equiph4">
                                        <?php echo "$" . number_format($equipmentPrice) ?>
                                    </h4>

                                    <?php
                                    if ($isReviewed == 0) {
                                        echo '        <button type="button" class="btn-icon" data-toggle="modal" data-target="#disagreeModal" style="position: relative;">';
                                        echo '            <i class="fa-solid fa-circle-check" style="color: #005555;"></i>';
                                        echo '        </button>';

                                        echo '        <button type="button" class="btn-icon" data-toggle="modal" data-target="#confirmModal" style="position: relative;">';
                                        echo '            <i class="fa-solid fa-circle-xmark" style="color: #B02626;"></i>';
                                        echo '        </button>';
                                    }
                                    ?>

                                </span>
                            </div>
                            <h6 style="margin-top: 56px">設備描述</h6>
                            <p style="padding:4px; margin-top:20px;">
                                <?php echo $equipmentDescription ?>
                            </p>
                            <div class="col-md-7 room-single mt-2 mb-2 ftco-animate" style="margin-bottom: -100px;">
                                <h6 style="margin-top: 56px">聯絡資訊</h6>
                                <div class="d-md-flex mt-4 mb-4">
                                    <ul class="list">
                                        <li>
                                            <span style="display: flex; align-items: center;">
                                                <i class="fa-regular fa-user fa-xl"></i>
                                                <p style="margin-bottom: 0px; box-sizing: content-box;width: 60px;">聯絡人
                                                </p>
                                                <p style="margin-bottom: 0px; margin-left: 10px;">
                                                    <?php echo $ownerName ?>
                                                </p>
                                            </span>
                                        </li>
                                        <li>
                                            <span style="display: flex; align-items: center; ">
                                                <i class="fa-regular fa-envelope fa-lg"></i>
                                                <p style="margin-bottom: 0px; box-sizing: content-box;width: 60px;">信箱
                                                </p>
                                                <p style="margin-bottom: 0px; margin-left: 10px;">
                                                    <?php echo $ownerEmail ?>
                                                </p>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>


                    </div>


                </div> <!-- .col-md-8 -->



                <div class="col-lg-4 sidebar ftco-animate">
                    <div class="sidebar-box" style="padding-left:0px;">
                        <h3>設備標籤</h3>
                        <div class="tagcloud">
                            <?php
                            $sql1 = "SELECT labelId FROM equipments_labels WHERE equipmentId = ?";
                            $stmt1 = $conn->prepare($sql1);
                            $stmt1->bind_param("s", $equipmentId);
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
        <div class="container">

            <div class="row" style="display: flex;justify-content: center;">
                <div class="col-md-12 ftco-animate">

                    <?php
                    if ($isReviewed == 0) {
                        echo '<h4 class="mb-3">舉報內容</h4>';

                        // 查詢檢舉內容
                        $sql3 = "SELECT * FROM reports WHERE equipmentId = ?";
                        $stmt3 = $conn->prepare($sql3);
                        $stmt3->bind_param("s", $equipmentId);
                        $stmt3->execute();

                        $result3 = $stmt3->get_result();
                        $reports = [];
                        while ($row3 = $result3->fetch_assoc()) {
                            $reports[] = $row3;
                        }

                        foreach ($reports as $report) {
                            $reportAccountId = $report['accountId'];
                            $reportCreateDate = $report['reportCreateDate'];
                            $reportDescription = $report['reportDescription'];
                            $reportReason = $report['reportReason'];

                            // 查詢使用者名稱
                            $sql4 = "SELECT accountname FROM accounts WHERE accountId = ?";
                            $stmt4 = $conn->prepare($sql4);
                            $stmt4->bind_param("s", $reportAccountId);
                            $stmt4->execute();
                            $result4 = $stmt4->get_result();
                            $row4 = $result4->fetch_assoc();
                            $reportAccountName = $row4['accountname'];

                            echo '
                            <div class="card mb-3">
                                <div class="card-header">
                                    <strong>' . $reportAccountName . '</strong> 於 <em>' . $reportCreateDate . '</em> 提交了舉報
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">舉報原因：' . $reportReason . '</h5>
                                    <p class="card-text">舉報內容說明：' . $reportDescription . '</p>
                                </div>
                            </div>';
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
    </section> <!-- .section -->

    <?php
    echo '<form method="POST" action="../php/Equipment/disagreeReport.php">';
    echo '<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">';
    echo '<div class="modal-dialog" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<h5 class="modal-title" id="deleteModalLabel">駁回檢舉確認</h5>';
    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    echo '<i id="close" class="fa-solid fa-circle-xmark" style="color:#a0a0a0;"></i>';
    echo '</button>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo '確定要駁回「' . $equipmentName . '」的審核嗎？';
    echo '</div>';
    echo '<div class="modal-footer">';
    echo '<input type="hidden" name="equipmentId" value="' . $equipmentId . '">';
    echo '<button type="submit" class="btn-secondary">確認</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</form>';

    echo '<form method="POST" action="../php/Equipment/agreeReport.php">';
    echo '<div class="modal fade" id="disagreeModal" tabindex="-1" role="dialog" aria-labelledby="disagreeModalLabel" aria-hidden="true">';
    echo '<div class="modal-dialog" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<h5 class="modal-title" id="deleteModalLabel">通過檢舉確認</h5>';
    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    echo '<i id="close" class="fa-solid fa-circle-xmark" style="color:#a0a0a0;"></i>';
    echo '</button>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo '確定要通過「' . $equipmentName . '」的檢舉並刪除該設備嗎？';
    echo '</div>';
    echo '<div class="modal-footer">';
    echo '<input type="hidden" name="equipmentId" value="' . $equipmentId . '">';
    echo '<button type="submit" class="btn-secondary" style="background-color: #B02626;">確認</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</form>';
    ?>

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
            $(document).ready(function () {
                // 當使用者點擊檢舉按鈕時，顯示模態框
                $('.report-btn').on('click', function () {
                    var equipmentId = $(this).data('equipment-id');
                    $('#equipmentId').val(equipmentId);
                    $('#reportModal').modal('show');
                });

                // 處理表單提交
                $('#submit-report').on('click', function () {
                    var formData = $('#report-form').serialize();
                    console.log("表單數據:", formData); // 輸出表單數據到控制台

                    // 使用 AJAX 將表單資料發送到伺服器
                    $.post('report-equipment.php', formData, function (response) {
                        // 解析伺服器返回的 JSON 响應
                        var jsonResponse = JSON.parse(response);
                        console.log("伺服器回應:", jsonResponse); // 輸出伺服器回應到控制台

                        // 根據回應狀態顯示相應的提示訊息
                        if (jsonResponse.status === 'success') {
                            alert('提交成功！謝謝您為我們的平台盡一份力，請耐心等待管理員審核。');
                        } else {
                            alert(jsonResponse.message);
                        }
                    });

                    // 關閉模態框
                    $('#reportModal').modal('hide');
                });
            });
        </script>
</body>

</html>