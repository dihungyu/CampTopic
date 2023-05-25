<?php
require_once '../../php/conn.php';
require_once '../../php/uuid_generator.php';

session_start();

//判斷是否登入，若有則對變數初始化
if (isset($_COOKIE["accountId"])) {
    $accountId = $_COOKIE["accountId"];
}

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

//收藏營地
if (isset($_POST["collectCampAdd"])) {
    if (!isset($_COOKIE["accountId"])) {
        $_SESSION["system_message"] = "請先登入會員，才能進行收藏喔!";
        header("Location: all-land.php");
        exit; // 確保重新導向後停止執行後續代碼
    }
    $campsiteId = $_POST["collectCampAdd"];
    $accountId = $_COOKIE["accountId"];
    $collectionId = uuid_generator();
    $sql = "INSERT INTO `collections` (`collectionId`,`accountId`, `campsiteId`) VALUES ('$collectionId','$accountId', '$campsiteId')";
    $sql2 = "UPDATE `campsites` SET `campsiteCollectCount` = `campsiteCollectCount` + 1 WHERE `campsiteId` = '$campsiteId'";
    $result = mysqli_query($conn, $sql);
    $result2 = mysqli_query($conn, $sql2);
    if ($result) {
        $_SESSION["system_message"] = "已加入收藏!";
        header("Location: all-land.php");
        exit; // 確保重新導向後停止執行後續代碼
    }
}

//移除收藏營地
if (isset($_POST["collectCampDel"])) {

    $campsiteId = $_POST["collectCampDel"];
    $accountId = $_COOKIE["accountId"];
    $sql = "DELETE FROM `collections` WHERE `accountId` = '$accountId' AND `campsiteId` = '$campsiteId'";
    $sql2 = "UPDATE `campsites` SET `campsiteCollectCount` = `campsiteCollectCount` - 1 WHERE `campsiteId` = '$campsiteId'";
    $result = mysqli_query($conn, $sql);
    $result2 = mysqli_query($conn, $sql2);
    if ($result) {
        $_SESSION["system_message"] = "已取消收藏!";
        header("Location: all-land.php");
        exit; // 確保重新導向後停止執行後續代碼
    }
}

// 按讚營區
if (isset($_POST["likeCampAdd"])) {

    $campsiteId = $_POST["likeCampAdd"];
    $accountId = $_COOKIE["accountId"];
    $likeId = uuid_generator();
    $sql = "INSERT INTO `likes` (`likeId`, `accountId`, `campsiteId`) VALUES ('$likeId', '$accountId', '$campsiteId')";
    $sql2 = "UPDATE `campsites` SET `campsiteLikeCount` = `campsiteLikeCount` + 1 WHERE `campsiteId` = '$campsiteId'";
    $result = mysqli_query($conn, $sql);
    $result2 = mysqli_query($conn, $sql2);
    if ($result) {
        $_SESSION["system_message"] = "已按讚!";
        header("Location: all-land.php");
        exit; // 確保重新導向後停止執行後續代碼
    }
}

// 取消讚營區
if (isset($_POST["likeCampDel"])) {

    $campsiteId = $_POST["likeCampDel"];
    $accountId = $_COOKIE["accountId"];
    $sql = "DELETE FROM `likes` WHERE `accountId` = '$accountId' AND `campsiteId` = '$campsiteId'";
    $sql2 = "UPDATE `campsites` SET `campsiteLikeCount` = `campsiteLikeCount` - 1 WHERE `campsiteId` = '$campsiteId'";
    $result = mysqli_query($conn, $sql);
    $result2 = mysqli_query($conn, $sql2);
    if ($result) {
        $_SESSION["system_message"] = "已取消讚!";
        header("Location: all-land.php");
        exit; // 確保重新導向後停止執行後續代碼
    }
}
?>
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
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="fonts/icomoon/style.css" />
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css" />
    <link rel="stylesheet" href="css/tiny-slider.css" />
    <link rel="stylesheet" href="css/aos.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

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
                    <li class="nav-item active"><a href="index.php" class="nav-link">首頁</a></li>
                    <li class="nav-item"><a href="camp-information.php" class="nav-link">找小鹿</a></li>
                    <li class="nav-item"><a href="../all-article.php" class="nav-link">鹿的分享</a></li>
                    <li class="nav-item"><a href="../equipment.php" class="nav-link">鹿的裝備</a></li>
                    <li class="nav-item"><a href="ad.php" class="nav-link">廣告方案</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="member.html" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                            <?php
                            // 檢查是否設置了 accountName 或 accountEmail Cookie
                            if (isset($_COOKIE["accountName"]) || isset($_COOKIE["accountEmail"])) {
                                echo '<a class="dropdown-item" href="../../logout.php?action=logout">登出</a>';
                            }
                            // 如果沒有設置 Cookie 則顯示登入選項
                            else {
                                echo '<a class="dropdown-item" href="../../login.php">登入</a>';
                            }
                            ?>
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
                    <h1 class="heading" data-aos="fade-up">所有營地</h1>

                    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                        <ol class="breadcrumb text-center justify-content-center">
                            <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
                            <li class="breadcrumb-item"><a href="member.php">帳號</a></li>
                            <li class="breadcrumb-item active text-white-50" aria-current="page"> 所有營地
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
                    <span style="display:flex ;">
                        <button type="button" class="button-filter" data-toggle="modal" data-target="#filter">
                            <i class="fa-solid fa-bars-staggered" style="margin-right: 4px;"></i>篩選
                        </button>
                        <div id="selected-tags-container" style="margin-top: 10px;"></div>
                    </span>
                    <span style="display:flex ;">
                        <div id="navbar-search-autocomplete" class="form-outline">
                            <input type="search" id="form1" name="camp_search_keyword" class="form-control"
                                style="height: 40px; border-radius: 35px;" placeholder="搜尋營地名稱..." />
                        </div>
                        <button type="submit" class="button-search" style="margin-left: 10px;">
                            <i class="fas fa-search"></i>
                        </button>
                        </sapn>
                </div>

            </div>
        </div>



        <div>
            <div role="tabpanel" aria-labelledby="isReviewed-tab">
                <div class="section section-properties">
                    <div class="container">
                        <div class="row">
                            <article class="col-md-12 article-list" style="display: flex;">
                                <?php
                                // 取出已被收藏的營地
                                $camp_collect_sql = "SELECT `campsiteId` FROM `collections` WHERE `accountId` = '$accountId'";
                                $camp_collect_result = mysqli_query($conn, $camp_collect_sql);

                                // 將查詢結果轉換為包含已收藏營地ID的陣列
                                $collectedCamps = array();
                                while ($row = mysqli_fetch_assoc($camp_collect_result)) {
                                    $collectedCamps[] = $row['campsiteId'];
                                }

                                // 取出已被按讚的營地
                                $camp_like_sql = "SELECT `campsiteId` FROM `likes` WHERE `accountId` = '$accountId'";
                                $camp_like_result = mysqli_query($conn, $camp_like_sql);

                                // 將查詢結果轉換為包含已按讚營地ID的陣列
                                $likedCamps = array();
                                while ($row = mysqli_fetch_assoc($camp_like_result)) {
                                    $likedCamps[] = $row['campsiteId'];
                                }

                                $records_per_page = 6;
                                $current_page = isset($_GET['reviewedPage']) ? $_GET['reviewedPage'] : 1;
                                $offset = ($current_page - 1) * $records_per_page;

                                $sql_total_campsites = "SELECT COUNT(*) as total FROM campsites WHERE isReviewed = 1 AND accountId = '$accountId'";
                                $result_total_campsites = mysqli_query($conn, $sql_total_campsites);
                                $total_campsites = mysqli_fetch_assoc($result_total_campsites)['total'];
                                $total_pages = ceil($total_campsites / $records_per_page);
                                if ($_COOKIE["accountType"] == "BUSINESS") {
                                    $sql_isReviewed_campsites = "SELECT * FROM campsites WHERE isReviewed = 1 AND accountId != '$accountId' LIMIT $records_per_page OFFSET $offset";
                                } else {
                                    $sql_isReviewed_campsites = "SELECT * FROM campsites WHERE isReviewed = 1 LIMIT $records_per_page OFFSET $offset";
                                }
                                $result_isReviewed_campsites = mysqli_query($conn, $sql_isReviewed_campsites);
                                $isReviewed_campsites = [];
                                if (mysqli_num_rows($result_isReviewed_campsites) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_isReviewed_campsites)) {
                                        $isReviewed_campsites[] = $row;
                                    }
                                }

                                $sql_total_campsites = "SELECT COUNT(*) as total FROM campsites WHERE isReviewed = 1";
                                $result_total_campsites = mysqli_query($conn, $sql_total_campsites);
                                $total_campsites = mysqli_fetch_assoc($result_total_campsites)['total'];
                                $total_pages = ceil($total_campsites / $records_per_page);

                                foreach ($isReviewed_campsites as $isReviewed_campsite) {
                                    // 檢查當前營區是否已收藏
                                    $isCampCollected = in_array($isReviewed_campsite["campsiteId"], $collectedCamps);

                                    // 檢查當前營區是否已按讚
                                    $isCampLiked = in_array($isReviewed_campsite["campsiteId"], $likedCamps);

                                    $isReviewed_cover_sql = "SELECT filePath FROM files WHERE campsiteId = '" . $isReviewed_campsite['campsiteId'] . "' AND filePathType = 'campsiteCover' ORDER BY fileCreateDate DESC LIMIT 1";
                                    $isReviewed_cover_result = mysqli_query($conn, $isReviewed_cover_sql);
                                    if ($isReviewed_cover_row = mysqli_fetch_assoc($isReviewed_cover_result)) {
                                        $isReviewed_cover_src = $isReviewed_cover_row["filePath"];
                                    } else {
                                        $isReviewed_cover_src = "images/Rectangle 137.png";
                                    }
                                    echo '<div class="card isReviewed-card">';
                                    echo '  <a href="../camp-single.php?campsiteId=' . $isReviewed_campsite['campsiteId'] . '">';
                                    echo '    <img src="' . $isReviewed_cover_src . '" class="card-img-top" alt="...">';
                                    echo '  </a>';
                                    echo '  <div class="card-body">';
                                    echo '    <span class="span-adj" style="justify-content: space-between;">';
                                    echo '      <h4><span>$' . number_format($isReviewed_campsite['campsiteLowerLimit']) . '起</span></h4>';
                                    echo "<form action='all-land.php' method='post'>";
                                    echo "<input type='hidden' name='" . ($isCampCollected ? "collectCampDel" : "collectCampAdd") . "' value='" . $isReviewed_campsite["campsiteId"] . "'>";
                                    echo "<button type='submit' class='btn-icon'>";
                                    echo "<i class='" . ($isCampCollected ? "fas" : "fa-regular") . " fa-bookmark'></i>";
                                    echo "</button>";
                                    echo "</form>";
                                    echo '    </span>';
                                    echo '    <div>';
                                    echo '      <a href="../camp-single.php?campsiteId=' . $isReviewed_campsite['campsiteId'] . '">';
                                    echo '        <h5 class=\'city d-block mb-3 mt-3\'>' . $isReviewed_campsite['campsiteName'] . '</h5>';
                                    echo '      </a>';

                                    //若文章內容超過30字做限制
                                    $isReviewed_content_length = mb_strlen(strip_tags($isReviewed_campsite["campsiteDescription"]), 'UTF-8');
                                    if ($isReviewed_content_length > 30) {
                                        $isReviewed_content = mb_substr(strip_tags($isReviewed_campsite["campsiteDescription"]), 0, 80, 'UTF-8') . '...'; // 截斷文章內容
                                    } else {
                                        $isReviewed_content = strip_tags($isReviewed_campsite["campsiteDescription"]);
                                    }
                                    echo '      <span class="d-block mb-4 text-black-50">' . $isReviewed_content . '</span>';
                                    echo '      <div class="card-icon-footer">';
                                    echo '        <div class="tagcloud">';
                                    $sql_query_labels = "SELECT campsites_labels.labelId, labels.labelName
                     FROM campsites_labels
                     JOIN labels ON campsites_labels.labelId = labels.labelId
                     WHERE campsites_labels.campsiteId = '" . $isReviewed_campsite['campsiteId'] . "'";
                                    $result_labels = mysqli_query($conn, $sql_query_labels);

                                    $printed_tags = 0;
                                    while ($tags_row = mysqli_fetch_assoc($result_labels)) {
                                        if ($printed_tags >= 3) {
                                            break;
                                        }

                                        echo "<a href='#'>" . $tags_row['labelName'] . "</a>";

                                        $printed_tags++;
                                    }
                                    echo '        </div>';
                                    echo '<span style="display: flex; align-items: center;">';
                                    echo "<form action='all-land.php' method='post'>";
                                    echo "<input type='hidden' name='" . ($isCampLiked ? "likeCampDel" : "likeCampAdd") . "' value='" . $isReviewed_campsite["campsiteId"] . "'>";
                                    echo "<button type='submit' class='btn-icon'>";
                                    echo "<i class='" . ($isCampLiked ? "fas" : "fa-regular") . " fa-heart'></i>";
                                    echo "</button>";
                                    echo "</form>";
                                    echo ' <p style="margin-top:0px">' . format_count($isReviewed_campsite["campsiteLikeCount"]) . '</p>';
                                    echo ' </span>';
                                    echo '      </div>';
                                    echo '    </div>';
                                    echo '  </div>';
                                    echo '</div>';
                                }
                                ?>
                            </article>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center py-5">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6 text-center">
                        <div class="custom-pagination">
                            <?php
                            for ($i = 1; $i <= $total_pages; $i++) {
                                $active_class = ($i == $current_page) ? 'class="active"' : '';
                                echo "<a href=\"?reviewedPage=$i\" $active_class>$i</a>";
                            }
                            ?>
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
                        foreach ($labels as $index => $label) {
                            $labelId = $label['labelId'];
                            $labelName = $label['labelName'];
                            $inputId = "flexCheck_" . $labelId;
                            echo '<div class="form-check">';
                            echo '<input class="form-check-input" type="checkbox" value="" id="' . $inputId . '" data-label-id="' . $labelId . '">';
                            echo '<label class="form-check-label" for="' . $inputId . '">' . $labelName . '</label>';
                            echo '</div>';
                        }
                        ?>
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
                                <li><a href="camp-information.html">找小鹿</a></li>
                                <li><a href="../all-article.html">鹿的分享</a></li>
                                <li><a href="../equipment.html">鹿的裝備</a></li>
                                <li><a href="#">廣告方案</a></li>
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script>
            function hideMessage() {
                document.getElementById("message").style.opacity = "0";
                setTimeout(function () {
                    document.getElementById("message").style.display = "none";
                }, 500);
            }
            setTimeout(hideMessage, 3000);
        </script>


        <script>
            $(document).ready(function () {

                $('#form1').on('input', function () {
                    let searchKeyword = $(this).val().toLowerCase();

                    // 若你只有一種卡片，可直接指定卡片的 class
                    let targetCards = '.isReviewed-card';

                    $(targetCards).each(function () {
                        let campsiteName = $(this).find('.city').text().toLowerCase();
                        if (campsiteName.indexOf(searchKeyword) !== -1) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                });
            });
        </script>

        <script>
            let selectedLabels = [];
            function filterCampsites() {
                selectedLabels = getSelectedLabels();
                let labelIds = selectedLabels.map(label => label.labelId);
                let accountId = <?php echo json_encode($accountId); ?>;
                let bodyContent;
                if (labelIds.length > 0) {
                    bodyContent = "labelIds=" + JSON.stringify(labelIds) + "&accountId=" + accountId;
                } else {
                    bodyContent = "accountId=" + accountId;
                }
                fetch("../../php/Filter/filter_campsites.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: bodyContent
                })
                    .then(response => response.json())
                    .then((filteredCampsites) => {
                        displayFilteredCampsites(filteredCampsites);
                        displaySelectedLabels();
                    });
            }
            document.querySelectorAll(".form-check-input").forEach(checkbox => {
                checkbox.addEventListener("change", () => {
                    filterCampsites();
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
                let selectedLabels = Array.from(checkboxes).filter(checkbox => checkbox.checked).map(checkbox => ({
                    labelName: checkbox.nextElementSibling.textContent,
                    labelId: checkbox.dataset.labelId
                }));
                return selectedLabels;
            }
            function displayFilteredCampsites(campsites) {
                let campsitesContainer = document.querySelector(".col-md-12");
                campsitesContainer.innerHTML = '';
                if (campsites.length === 0) {
                    campsitesContainer.innerHTML = '<h4 style="margin-left: 40px">無相符的資料！</h4>';
                } else {
                    campsites.forEach(campsite => {
                        let campsiteHTML = generateCampsiteCard(campsite);
                        campsitesContainer.innerHTML += campsiteHTML;
                    });
                }
            }
            function generateCampsiteCard(campsite) {
                let campsiteId = campsite.campsiteId;
                let campsiteName = campsite.campsiteName;
                let campsiteDescription = campsite.campsiteDescription;
                let campsiteLowerLimit = campsite.campsiteLowerLimit;
                let campsiteLikeCount = campsite.campsiteLikeCount;
                let img_src = campsite.img_src; // 這裡我們使用回傳的 cover_src 當作營地的圖片
                let isCampCollected = campsite.isCampCollected;
                let isCampLiked = campsite.isCampLiked;
                let tags = campsite.tags;

                return `
<div class="card isReviewed-card">
    <a href="../camp-single.php?campsiteId=${campsiteId}">
        <img src="${img_src}" class="card-img-top" alt="...">
    </a>
    <div class="card-body">
        <span class="span-adj" style="justify-content: space-between;">
            <h4><span>$${campsiteLowerLimit}起</span></h4>
            <form action='all-land.php' method='post'>
                <input type='hidden' name='${isCampCollected ? "collectCampDel" : "collectCampAdd"}' value='${campsiteId}'>
                <button type='submit' class='btn-icon'>
                    <i class='${isCampCollected ? "fas" : "far"} fa-bookmark'></i>
                </button>
            </form>
        </span>
        <div>
            <a href="../camp-single.php?campsiteId=${campsiteId}">
                <h5 class='city d-block mb-3 mt-3'>${campsiteName}</h5>
            </a>
            <span class="d-block mb-4 text-black-50">${campsiteDescription}</span>
            <div class="card-icon-footer">
                <div class="tagcloud">
                    ${tags.slice(0, 3).map(tag => `<a href='#'>${tag}</a>`).join("")}
                </div>
                <span style="display: flex; align-items: center;">
                    <form action='all-land.php' method='post'>
                        <input type='hidden' name='${isCampLiked ? "likeCampDel" : "likeCampAdd"}' value='${campsiteId}'>
                        <button type='submit' class='btn-icon'>
                            <i class='${isCampLiked ? "fas" : "far"} fa-heart'></i>
                        </button>
                    </form>                    <p style="margin-top:0px">${campsiteLikeCount}</p>
                </span>
            </div>
        </div>
    </div>
</div>`;
            }
        </script>

</body>

</html>