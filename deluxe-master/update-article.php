<?php
if (!isset($articleId)) {
    $articleId = $_GET['articleId'];
}
session_start();
// 連接資料庫
require_once '../php/conn.php';
require_once '../php/get_img_src.php';

// 取得文章內容
$articleTitle = '';
$articleContent = '';

if (isset($articleId)) {
    $sql = "SELECT * FROM articles WHERE articleId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $articleId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $articleTitle = $row['articleTitle'];
        $articleContent = $row['articleContent'];
    }
}

if (isset($_POST["action"]) && $_POST["action"] == "update" && isset($_POST['articleId']) && isset($_POST['articleTitle']) && isset($_POST['articleContent'])) {

    $articleId = $_POST['articleId'];
    $articleTitle = $_POST['articleTitle'];
    $articleContent = $_POST['articleContent'];

    // 更新文章
    $sql = "UPDATE articles SET articleTitle = ?, articleContent = ? WHERE articleId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $articleTitle, $articleContent, $articleId);

    if ($stmt->execute()) {
        // 更新成功，導回文章列表頁面
        $_SESSION["system_message"] = "文章更新成功!";
        header("Location: /CampTopic/deluxe-master/article.php?articleId=$articleId");
        exit();
    } else {
        // 更新失敗，導回原本的編輯頁面，並顯示錯誤訊息
        // $_SESSION["system_message"] = "文章更新失敗!";
        $_SESSION["system_message"] = $stmt->error;
        header("Location: /CampTopic/deluxe-master/property-1.0.0/update-article.php?articleId=$articleId");
        exit();
    }
} elseif (isset($_POST["action"])) {
    // 更新失敗，導回原本的編輯頁面，並顯示錯誤訊息
    $_SESSION["system_message"] = "文章標題和內容不能為空。";
    header("Location: /CampTopic/deluxe-master/property-1.0.0/update-article.php?articleId=$articleId");
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
    <title>
        Start Camping &mdash; 一起展開露營冒險！
    </title>


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


    <!-- 引入Bootstrap CSS -->
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" /> -->

    <!-- 引入Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet" />


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
                    <li class="nav-item active"><a href="property-1.0.0/index.php" class="nav-link">首頁</a></li>
                    <li class="nav-item"><a href="property-1.0.0/camp-information.php" class="nav-link">找小鹿</a></li>
                    <li class="nav-item"><a href="all-article.php" class="nav-link">鹿的分享</a></li>
                    <li class="nav-item"><a href="equipment.php" class="nav-link">鹿的裝備</a></li>
                    <li class="nav-item"><a href="property-1.0.0/ad.php" class="nav-link">廣告方案</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="member.html" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            帳號
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="property-1.0.0/member.php">會員帳號</a>
                            <a class="dropdown-item" href="property-1.0.0/member-like.php">我的收藏</a>
                            <a class="dropdown-item" href="property-1.0.0/member-record.php">我的紀錄</a>
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

    <div class="hero page-inner overlay" style="background-image: url('images/Rectangle\ 134.png')">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-9 text-center mt-5">
                    <h1 class="heading" data-aos="fade-up">文章管理</h1>

                    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                        <ol class="breadcrumb text-center justify-content-center">
                            <li class="breadcrumb-item"><a href="property-1.0.0/index.php">首頁</a></li>
                            <li class="breadcrumb-item"><a href="all-article.php">鹿的分享</a></li>
                            <li class="breadcrumb-item active text-white-50" aria-current="page">
                                文章管理
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



            </div>
        </div>



        <?php
        $img_src = get_profileImg_src($_COOKIE["accountId"], $conn);
        ?>
        <div class="section section-properties">
            <div class="container">
                <div class="row">
                    <span style="margin-left: 80px; margin-bottom: 20px;" class="mt-2 mb-4">
                        <img src="<?php echo $img_src; ?>" alt="Image description" style="border-radius: 50%; width: 3%;">
                        <label style="font-size: 14px; margin-bottom: 0px;margin-left: 20px; font-weight: 600; "><?php echo $_COOKIE["accountName"]; ?></label>
                    </span>
                    <span style="display:flex;align-items: center;justify-content:flex-start; margin-left:76px">
                        <a class="tag-filter" href="#">櫻花
                            <i class="fa-solid fa-circle-xmark" style="margin-left:10px;"></i></a>
                        <a class="tag-filter" href="#">標籤
                            <i class="fa-solid fa-circle-xmark" style="margin-left:10px;"></i></a>
                        <a class="tag-filter" href="#">標籤
                            <i class="fa-solid fa-circle-xmark" style="margin-left:10px;"></i></a>
                        <a class="tag-filter" href="#">標籤
                            <i class="fa-solid fa-circle-xmark" style="margin-left:10px;"></i>
                        </a>
                        <a class="tag-filter" href="#">標籤
                            <i class="fa-solid fa-circle-xmark" style="margin-left:10px;"></i>
                        </a>
                        <a class="tag-filter" href="#" data-toggle="modal" data-target="#exampleModalCenter">新增標籤</a>
                    </span>

                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content" style="width:450px;height:200px;">
                                <div class="modal-body">
                                    <span style="display: flex;justify-content: space-between;">
                                        <h5 style="margin-top: 5px;margin-left: 10px;">新增標籤</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i id="close" class="fa-solid fa-circle-xmark" style="color:#a0a0a0;"></i>
                                        </button>
                                    </span>

                                    <input type="text" value="標籤名稱" class="articletag">
                                    <a href="add-equip.html" style="display:flex;justify-content: flex-end; margin-right:32px">
                                        <button class="btn-more"> 確認
                                        </button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </span>
                <span style="display:flex; justify-content:center;margin-left:20px">
                    <form id="article-form" action="update-article.php" method="post" enctype="multipart/form-data">
                        <span style="display:flex;align-items: flex-end;flex-wrap: wrap;margin-bottom: 16px;margin-top: 16px;">
                            <input type="text" name="articleTitle" placeholder="文章標題" class="articletitle" value="<?php echo htmlspecialchars($articleTitle); ?>">
                        </span>

                        <textarea id="summernote-editor" name="articleContent" placeholder="開始撰寫貼文..." rows="20" class="articletext"><?php echo htmlspecialchars($articleContent); ?></textarea>
                </span>
                <span>

                    <!-- <div>
        <input type="file" id="image_uploads" name="image_uploads" accept=".jpg, .jpeg, .png" style="position:absolute;height:200px;width:330px;opacity: 0;">
      </div>
      <div class="preview" style="float:left;background-color: #F0F0F0;height:200px;width:330px;text-align:center;border-radius: 20px;">
        <i class="icon-cloud_upload" style="font-size:50px;color:#acacac;"></i>
        <p style="line-height: 100px;color:#797979;">上傳圖片</p>
      </div> -->

                </span>

                <span style="display:flex;justify-content: flex-end;margin-right: 10px;">
                    <input type="hidden" name="articleId" value="<?php echo $_GET["articleId"] ?>">
                    <input type="hidden" name="accountId" value="<?php echo $_COOKIE["accountId"] ?>">
                    <input type="hidden" name="action" value="update">
                    <a href="../article.php?articleId=<?php echo $articleId ?>" class="btn-new1" style="margin-right:10px">取消</a>
                    <button class="btn-new" type="submit">分享</button>

                </span>
                </form>






            </div>
        </div>
    </div>

    <br><br>


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
                            <li><a href="#">首頁</a></li>
                            <li><a href="#">找小鹿</a></li>
                            <li><a href="#">鹿的分享</a></li>
                            <li><a href="#">鹿的裝備</a></li>
                            <li><a href="#">廣告方案</a></li>
                        </ul>
                        <ul class="list-unstyled float-start links">
                            <li><a href="#">帳號</a></li>
                            <li><a href="#">會員帳號</a></li>
                            <li><a href="#">我的收藏</a></li>
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
    <script src="js/uploadphoto.js"></script>
    <!-- 引入jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- 引入Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- 引入Summernote JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/lang/summernote-zh-TW.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#summernote-editor').summernote({

                // 設置編輯器的語言為繁體中文
                lang: 'zh-TW',
                height: 500, // 設置編輯器的高度
                minHeight: null, // 設置編輯器的最小高度
                maxHeight: null, // 設置編輯器的最大高度
                focus: true, // 設置自動聚焦到編輯器
                placeholder: '請輸入內容', // 設置placeholder

            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#summernote-editor').summernote({
                callbacks: {
                    onImageUpload: function(files) {
                        var maxSize = 2 * 1024 * 1024; // 限制檔案大小為 2 MB
                        if (files[0].size > maxSize) {
                            alert('檔案大小不能超過 2 MB');
                            return;
                        }
                        var formData = new FormData();
                        formData.append('file', files[0]);

                        $.ajax({
                            url: '../php/upload_image.php',
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                $('#summernote-editor').summernote('insertImage', response.imageUrl);
                            },
                            error: function(error) {
                                console.error('圖片上傳失敗', error);
                            }
                        });
                    }
                }
            });
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