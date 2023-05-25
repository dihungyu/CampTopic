<?php
session_start();
require_once '../../php/conn.php';
require_once '../../php/uuid_generator.php';
require_once '../../php/get_img_src.php';

//判斷是否登入，若有則對變數初始化
if (isset($_COOKIE["accountId"])) {
    $accountId = $_COOKIE["accountId"];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="author" content="Untree.co" />
    <link rel="shortcut icon" href="images/Frame 5.png" />

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap5" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://kit.fontawesome.com/d02d7e1ecb.css">

    <link rel="stylesheet" href="fonts/icomoon/style.css" />
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css" />

    <link rel="stylesheet" href="css/tiny-slider.css" />
    <link rel="stylesheet" href="css/aos.css" />

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
    <link rel="stylesheet" href="css/style.css" />

    <style>
        .equipment-description-container {
            max-height: 50px;
            /* 適當調整高度 */
            overflow-y: auto;
        }

        .property-content {
            min-height: 250px;
            /* 根據需要調整最小高度 */
        }
    </style>



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
            <a href="index.php"><img class="navbar-brand" src="images/Group 59.png"
                    style="width: 90px; height: auto;"></img></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> 選單
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item  active"><a href="index.php" class="nav-link">首頁</a></li>
                    <li class="nav-item"><a href="manage-article.php" class="nav-link">文章管理</a></li>
                    <li class="nav-item"><a href="manage-equip.php" class="nav-link">設備管理</a></li>
                    <li class="nav-item"><a href="manage-land.php" class="nav-link">營地管理</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="member.php" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            帳號
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="member.php">管理者帳號</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../../logout.php?action=logout">登出</a>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close">
                <span class="icofont-close js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>


    <div class="hero">
        <div class="hero-slide">
            <div class="img overlay" style="background-image: url('images/Rectangle\ 134.png')"></div>
            <div class="img overlay" style="background-image: url('images/Rectangle\ 135.png')"></div>
            <div class="img overlay" style="background-image: url('images/Rectangle\ 136.png')"></div>
        </div>
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-9 text-center">
                    <h1 class="heading" data-aos="fade-up">
                        Start Camping！<br>營在起跑點
                    </h1>
                </div>
            </div>
        </div>
    </div>


    <section class="features-1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="box-feature">
                        <span class="flaticon-member">
                            <i class="fa-solid fa-file-lines"></i></span>
                        <h3 class="mb-3 mt-3">文章管理</h3>
                        <p>查看與審核所有文章</p>
                        <p><a href="manage-article.php" class="learn-more">Go!</a></p>
                    </div>
                </div>
                <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="500">
                    <div class="box-feature">
                        <span class="flaticon-member"><i class="fa-solid fa-fire-extinguisher"></i></span>
                        <h3 class="mb-3 mt-3">設備管理</h3>
                        <p>查看與審核所有設備</p>
                        <p><a href="manage-equip.php" class="learn-more">Go!</a></p>
                    </div>
                </div>
                <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="box-feature">
                        <span class="flaticon-member"><i class="fa-solid fa-tent"></i></span>
                        <h3 class="mb-3 mt-3">營地管理</h3>
                        <p>查看與審核所有營地</p>
                        <p><a href="manage-land.php" class="learn-more">Go!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <div class="container">




        <div class="site-footer" style="margin-top: 0px;">
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
                                <li><a href="index-manage.php">首頁</a></li>
                                <li><a href="manage-article.php">文章管理</a></li>
                                <li><a href="manage-equipment.php">設備管理</a></li>
                                <li><a href="manage-land.php">營地管理</a></li>
                            </ul>
                            <ul class="list-unstyled float-start links">
                                <li><a href="member.php">帳號</a></li>
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
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/d02d7e1ecb.js"></script>

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