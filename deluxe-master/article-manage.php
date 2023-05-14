<?php

session_start();
require_once '../php/conn.php';
require_once '../php/uuid_generator.php';
require_once '../php/get_img_src.php';

$articleId = $_GET['articleId'];

?>
<!DOCTYPE html>
<html lang="en">

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
    <link rel="stylesheet" href="property-1.0.0/css/icomoon.css">

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

    <script>
        // JavaScript function to handle the delete confirmation dialog
        function deleteArticle(articleId) {
            if (confirm("確認刪除，此動作無法回復?")) {
                window.location.href = "/CampTopic/deluxe-master/property-1.0.0/delete-article.php?articleId=" + articleId;
            }
        }
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

    <div class="hero page-inner overlay" style="background-image: url('images/Rectangle\ 56.jpg');
      height:70vh;
      min-height: 300px;">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-12 text-center mt-5">
                    <h1 class="heading" data-aos="fade-up">文章分享
                    </h1>

                    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                        <ol class="breadcrumb text-center justify-content-center">
                            <li class="breadcrumb-item"><a href="property-1.0.0/index.php">首頁</a></li>
                            <li class="breadcrumb-item"><a href="all-article.php">鹿的分享</a></li>
                            <li class="breadcrumb-item active text-white-50" aria-current="page">
                                文章分享
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>




    <section class="ftco-section ftco-degree-bg">
        <div class="container">
            <div class="row">
                <!-- 主要文章內容 -->
                <?php
                //取得文章資料
                $main_article_sql = "SELECT articles.*, accounts.accountId, accounts.accountName FROM articles JOIN accounts ON articles.accountId = accounts.accountId WHERE articleId = '$articleId'";
                $main_article_result = mysqli_query($conn, $main_article_sql);
                $main_article_row = mysqli_fetch_assoc($main_article_result);

                // 取得發文者頭貼
                $img_src = get_profileImg_src($main_article_row["accountId"], $conn);
                $img_src = str_replace("../", "", $img_src);
                $img_src = "../" . $img_src;

                ?>
                <div class="col-lg-8 ">
                    <span class="img-name">
                        <img src="<?php echo $img_src ?>" alt="Image description"
                            style="border-radius: 50%; width: 45px; height: 45px; margin-right: 8px;">
                        <label style="font-size: 16px; margin-bottom: 0px; ">
                            <?php echo $main_article_row["accountName"]; ?>
                        </label>
                    </span>
                    <div style="display:flex; justify-content: space-between;">
                        <h5 class="mb-5 mt-4">
                            <?php echo $main_article_row["articleTitle"]; ?>
                        </h5>
                        <span style="display:flex; align-items: center;">
                            <?php
                            if ($main_article_row['isReviewed'] == 0) {
                                echo '        <button type="button" class="btn-icon" data-toggle="modal" data-target="#disagreeModal" style="position: relative;">';
                                echo '            <i class="fa-solid fa-circle-check" style="color: #005555; position: absolute; right:10px;bottom:1px;"></i>';
                                echo '        </button>';

                                echo '        <button type="button" class="btn-icon" data-toggle="modal" data-target="#confirmModal" style="position: relative;">';
                                echo '            <i class="fa-solid fa-circle-xmark" style="color: #B02626; position: absolute; bottom: 1px;"></i>';
                                echo '        </button>';
                            }
                            ?>

                        </span>
                    </div>
                    <div id="article-content" class="mt-2">
                        <?php echo $main_article_row["articleContent"]; ?>
                    </div>



                    <!-- 此文章相關標籤 -->
                    <div class="col-lg-8 ftco-animate order-md-last">
                        <div class="tag-widget post-tag-container mb-5 mt-5">
                            <div class="tagcloud">
                                <?php
                                // 查詢文章相關的標籤
                                $article_label_query = "SELECT articles_labels.labelId, labels.labelName FROM articles_labels JOIN labels ON articles_labels.labelId = labels.labelId WHERE articles_labels.articleId = '$articleId'";

                                $article_label_result = mysqli_query($conn, $article_label_query);

                                // 檢查錯誤
                                if (!$article_label_result) {
                                    echo "Error: " . mysqli_error($conn);
                                }

                                $printed_article_tags = 0;
                                while ($article_tags_row = mysqli_fetch_assoc($article_label_result)) {
                                    echo "<a href='#' class='tag-cloud-link'>" . $article_tags_row["labelName"] . "</a>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>



                    <!-- 留言區 -->
                    <?php

                    //可用函式
                    function format_timestamp($timestamp)
                    {
                        date_default_timezone_set("Asia/Taipei");
                        $unix_timestamp = strtotime($timestamp);
                        return date("F j, Y \a\\t g:ia", $unix_timestamp);
                    }

                    //留言區開始
                    // 查詢留言數量
                    $comment_count_sql = "SELECT COUNT(*) as comment_count FROM comments WHERE articleId = '$articleId'";
                    $comment_count_result = mysqli_query($conn, $comment_count_sql);
                    $comment_count_row = mysqli_fetch_assoc($comment_count_result);
                    $comment_count = $comment_count_row["comment_count"];


                    echo "<div class='col-lg-8'>";
                    echo "<div class='pt-5 mt-5'>";
                    echo "<h5 class='mb-5'>目前" . $comment_count . "留言</h5>";
                    echo "<h6 class='mb-5'>由舊到新排序</h6>";
                    echo "<ul class='comment-list'>";


                    // 查詢留言和留言者名稱
                    $comment_query = "SELECT comments.*, accounts.accountName FROM comments JOIN accounts ON comments.accountId = accounts.accountId WHERE articleId = '$articleId' AND replyId IS NULL ORDER BY commentCreateDate ASC";
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
                            echo '<li class="comment">';
                            echo '  <span class="img-name">';
                            echo '    <img src="' . $commenter_img_src . '" style="border-radius: 50%; width: 45px; height: 45px; margin-right: 8px;">';
                            echo '  </span>';
                            echo '  <div class="comment-body" style="position: relative;">';
                            echo '    <h6>' . $comment_result_row["accountName"] . '</h6>';
                            echo '    <div class="meta" style="font-size: 11px;">' . $date_string . '</div>';
                            echo '    <p style="margin-top: 10px;" id="comment-content-' . $comment_result_row["commentId"] . '">' . $comment_result_row["commentContent"] . '</p>';
                            echo '</li>';




                            // 查詢留言回覆者名稱和內容
                            $replyId = $comment_result_row["commentId"];
                            $reply_query = "SELECT comments.*, accounts.accountName FROM comments JOIN accounts ON comments.accountId = accounts.accountId WHERE articleId = '$articleId' AND replyId= '$replyId' ORDER BY commentCreateDate ASC";
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

                                    echo '<li>';
                                    echo '    <span class="img-name">';
                                    echo '        <img src="' . $replyer_img_src . '"  style="border-radius: 50%; width: 30px; height: 30px; margin-right: 8px;">';
                                    echo '    </span>';
                                    echo '    <div class="comment-body" style="position: relative;">';
                                    echo '        <h6>' . $reply_result_row["accountName"] . '</h6>';
                                    echo '        <div class="meta">' . $date_string . '</div>';
                                    echo '        <p id="comment-content-' . $reply_result_row["commentId"] . '">' . $reply_result_row["commentContent"] . '</p>';
                                    echo '    </div>';
                                    echo '</li>';
                                }

                                echo '</ul>';
                            }
                        }
                    }



                    ?>

                    </ul>
                </div>
            </div>
            <!-- END comment-list -->

        </div>
        <div class="container">

            <div class="row" style="display: flex;justify-content: center;">
                <div class="col-md-12 ftco-animate">

                    <?php
                    if ($main_article_row["isReviewed"] == 0) {
                        echo '<h4 class="mb-3">舉報內容</h4>';

                        // 查詢檢舉內容
                        $sql3 = "SELECT * FROM reports WHERE articleId = ?";
                        $stmt3 = $conn->prepare($sql3);
                        $stmt3->bind_param("s", $main_article_row['articleId']);
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
        </div>
        <!-- .col-md-8 -->


        </div>
        </div>

    </section> <!-- .section -->

    <?php
    echo '<form method="POST" action="property-1.0.0/disagreeReport-article.php">';
    echo '<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">';
    echo '<div class="modal-dialog" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<h5 class="modal-title" id="deleteModalLabel">駁回檢舉確認</h5>';
    echo '<button type="button" class="close" data-dismiss="modal" aria-label="取消">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo '確定要駁回「' . $main_article_row['articleTitle'] . '」的審核嗎？';
    echo '</div>';
    echo '<div class="modal-footer">';
    echo '<button class="btn-new1" data-dismiss="modal">取消</button>';
    echo '<input type="hidden" name="articleId" value="' . $main_article_row['articleId'] . '">';
    echo '<button type="submit" class="btn-new" style="background-color: #28A745;">確認</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</form>';

    echo '<form method="POST" action="property-1.0.0/agreeReport-article.php">';
    echo '<div class="modal fade" id="disagreeModal" tabindex="-1" role="dialog" aria-labelledby="disagreeModalLabel" aria-hidden="true">';
    echo '<div class="modal-dialog" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<h5 class="modal-title" id="deleteModalLabel">通過檢舉確認</h5>';
    echo '<button type="button" class="close" data-dismiss="modal" aria-label="取消">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo '確定要通過「' . $main_article_row['articleTitle'] . '」的檢舉並刪除該文章嗎？';
    echo '</div>';
    echo '<div class="modal-footer">';
    echo '<button class="btn-new1" data-dismiss="modal">取消</button>';
    echo '<input type="hidden" name="articleId" value="' . $main_article_row['articleId'] . '">';
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

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#article-content img').addClass('article-img');
            });
        </script>




        <!-- 控制系統訊息 -->
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