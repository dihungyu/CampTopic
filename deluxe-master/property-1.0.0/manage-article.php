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
          <li class="nav-item "><a href="index.php" class="nav-link">首頁</a></li>
          <li class="nav-item"><a href="manage-article.php" class="nav-link">文章管理</a></li>
          <li class="nav-item"><a href="manage-equip.php" class="nav-link">設備管理</a></li>
          <li class="nav-item"><a href="manage-land.php" class="nav-link">營地管理</a></li>

          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="member.php" id="navbarDropdown" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              帳號
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="member.php">會員帳號</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="../../logout.php?action=logout">登出</a>
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
              <li class="breadcrumb-item"><a href="index.html">首頁</a></li>
              <li class="breadcrumb-item"><a href="member.html">管理員帳號</a></li>
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
    <div class="container" style="max-width: 1260px;">
      <div class="row mb-6 align-items-center"
        style="margin-top: 20px; margin-bottom: 40px; display:flex;justify-content: space-between;align-items: center;">
        <ul class="nav nav-tabs" style="margin-left: 16px;width: 800px;" id="myTab" role="tablist">
          <li class="nav-item" style="margin-right:20px">
            <a class="nav-link equip" id="equip-tab" data-toggle="tab" href="#paper" role="tab" aria-controls="equip"
              aria-selected="true">所有文章</a>
          </li>
          <li class="nav-item" style="margin-right:20px">
            <a class="nav-link review" id="review-tab" data-toggle="tab" href="#check" role="tab" aria-controls="review"
              aria-selected="true">待審核</a>
          </li>
        </ul>
        <span style="display:flex; box-sizing: content-box; width: 285px;">
          <div id="navbar-search-autocomplete" class="form-outline">
            <input type="search" id="form1" class="form-control" style="border-radius: 35px; height: 40px;" />
          </div>
          <button type="button" class="button-search" style="margin-left: 10px; ">
            <i class="fas fa-search"></i>
          </button>
        </span>
      </div>

    </div>
  </div>

  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="paper" role="tabpanel" aria-labelledby="paper-tab">
      <div class="container" style="max-width: 1260px;">
        <div class="row">
          <article class="col-md-12 article-list">
            <div class="inner">
              <figure>
                <a href="single.html">
                  <img src="images/img15.jpg">
                </a>
              </figure>
              <div class="details">
                <div class="detail" style="justify-content: space-between;">
                  <span style="display: flex;">
                    <div class="category">
                      <a href="category.html">Film</a>
                    </div>
                    <div class="time">December 26, 2016</div>
                  </span>
                  <span style="display: flex; margin-right: 80px;">
                    <button type="button" class="btn-icon" data-toggle="modal" data-target="#exampleModalCenter">
                      <i style="color: #B02626;" class="fa-solid fa-circle-exclamation"></i>
                    </button>
                  </span>
                </div>
                <h1><a href="single.html">推薦給想露營卻沒有經驗的你！</a></h1>
                <p>
                  最近露營潮興起，讓許多想旅行的人，開始選擇懶人露營，
                  不需要買任何配備任何露營用具，讓想露營的人也體以體驗露營的樂趣。.....
                </p>
                <footer style="display: flex;align-items: center; justify-content: space-between;">
                  <span style="display: flex;align-items: center;">
                    <p>100 留言</p>
                  </span>
                  <span style="display: flex; align-items: center; margin-right: 80px;">
                    <i class="fa-regular fa-heart"></i>
                    <p style="margin-right: 0px;">1,098</p>
                  </span>
                </footer>
              </div>
            </div>
          </article>
          <article class="col-md-12 article-list">
            <div class="inner">
              <figure>
                <a href="single.html">
                  <img src="images/img15.jpg">
                </a>
              </figure>
              <div class="details">
                <div class="detail" style="justify-content: space-between;">
                  <span style="display: flex;">
                    <div class="category">
                      <a href="category.html">Film</a>
                    </div>
                    <div class="time">December 26, 2016</div>
                  </span>
                  <span style="display: flex; margin-right: 80px;">
                    <button type="button" class="btn-icon" data-toggle="modal" data-target="#exampleModalCenter">
                      <i style="color: #B02626;" class="fa-solid fa-circle-exclamation"></i>
                    </button>
                  </span>
                </div>
                <h1><a href="single.html">推薦給想露營卻沒有經驗的你！</a></h1>
                <p>
                  最近露營潮興起，讓許多想旅行的人，開始選擇懶人露營，
                  不需要買任何配備任何露營用具，讓想露營的人也體以體驗露營的樂趣。.....
                </p>
                <footer style="display: flex;align-items: center; justify-content: space-between;">
                  <span style="display: flex;align-items: center;">
                    <p>100 留言</p>
                  </span>
                  <span style="display: flex; align-items: center; margin-right: 80px;">
                    <i class="fa-regular fa-heart"></i>
                    <p style="margin-right: 0px;">1,098</p>
                  </span>
                </footer>
              </div>
            </div>
          </article>
          <article class="col-md-12 article-list">
            <div class="inner">
              <figure>
                <a href="single.html">
                  <img src="images/img15.jpg">
                </a>
              </figure>
              <div class="details">
                <div class="detail" style="justify-content: space-between;">
                  <span style="display: flex;">
                    <div class="category">
                      <a href="category.html">Film</a>
                    </div>
                    <div class="time">December 26, 2016</div>
                  </span>
                  <span style="display: flex; margin-right: 80px;">
                    <button type="button" class="btn-icon" data-toggle="modal" data-target="#exampleModalCenter">
                      <i style="color: #B02626;" class="fa-solid fa-circle-exclamation"></i>
                    </button>
                  </span>
                </div>
                <h1><a href="single.html">推薦給想露營卻沒有經驗的你！</a></h1>
                <p>
                  最近露營潮興起，讓許多想旅行的人，開始選擇懶人露營，
                  不需要買任何配備任何露營用具，讓想露營的人也體以體驗露營的樂趣。.....
                </p>
                <footer style="display: flex;align-items: center; justify-content: space-between;">
                  <span style="display: flex;align-items: center;">
                    <p>100 留言</p>
                    <p>30 分享</p>
                  </span>
                  <span style="display: flex; align-items: center; margin-right: 80px;">
                    <i class="fa-regular fa-heart"></i>
                    <p style="margin-right: 0px;">1,098</p>
                  </span>
                </footer>
              </div>
            </div>
          </article>
          <article class="col-md-12 article-list">
            <div class="inner">
              <figure>
                <a href="single.html">
                  <img src="images/img15.jpg">
                </a>
              </figure>
              <div class="details">
                <div class="detail" style="justify-content: space-between;">
                  <span style="display: flex;">
                    <div class="category">
                      <a href="category.html">Film</a>
                    </div>
                    <div class="time">December 26, 2016</div>
                  </span>
                  <span style="display: flex; margin-right: 80px;">
                    <button type="button" class="btn-icon" data-toggle="modal" data-target="#exampleModalCenter">
                      <i style="color: #B02626;" class="fa-solid fa-circle-exclamation"></i>
                    </button>
                  </span>
                </div>
                <h1><a href="single.html">推薦給想露營卻沒有經驗的你！</a></h1>
                <p>
                  最近露營潮興起，讓許多想旅行的人，開始選擇懶人露營，
                  不需要買任何配備任何露營用具，讓想露營的人也體以體驗露營的樂趣。.....
                </p>
                <footer style="display: flex;align-items: center; justify-content: space-between;">
                  <span style="display: flex;align-items: center;">
                    <p>100 留言</p>
                    <p>30 分享</p>
                  </span>
                  <span style="display: flex; align-items: center; margin-right: 80px;">
                    <i class="fa-regular fa-heart"></i>
                    <p style="margin-right: 0px;">1,098</p>
                  </span>
                </footer>
              </div>
            </div>
          </article>

        </div>
      </div>
    </div>
    <!-- Button trigger modal -->

    <!-- Modal -->


    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">發送警告</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i id="close" class="fa-solid fa-circle-xmark" style="color:#a0a0a0;"></i>
            </button>
          </div>
          <div class="modal-body">
            <span style="display: flex; align-items: center; justify-content: flex-start">
              <p style="margin-right: 15px;margin-left: 10px;">作者</p>
              <img src="images/person_4.jpg" alt="Image description" style="border-radius: 50%;
              width: 8%;
              margin-right: 16px;">
              <label style="font-size: 16px; margin-bottom: 0px; ">yizzzzz</label>
            </span>
            <select class="warning">
              <option>內容不當或濫用(例如：裸露、仇恨言語、威脅)</option>
              <option>不實資訊</option>
              <option>搜擾</option>
              <option>其他</option>
            </select>
          </div>
          <div class="modal-footer">
            <div style=" display: flex; justify-content: flex-end;">
              <button class="btn-secondary">提交</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="tab-pane fade show" id="check" role="tabpanel" aria-labelledby="check-tab">
      <div class="container" style="max-width: 1260px;">
        <div class="row">
          <article class="col-md-12 article-list">
            <div class="inner">
              <figure>
                <a href="single.html">
                  <img src="images/img15.jpg">
                </a>
              </figure>
              <div class="details">
                <div class="detail" style="justify-content: space-between;">
                  <span style="display: flex;">
                    <div class="category">
                      <a href="category.html">Film</a>
                    </div>
                    <div class="time">December 26, 2016</div>
                  </span>
                  <span style="display: flex; margin-right: 80px;">
                    <button type="button" class="btn-icon" data-toggle="modal" data-target="example-modal">
                      <i style="color: #005555; margin-right: 8px;" class="fa-solid fa-circle-check"></i>
                      <i style="color: #B02626;" class="fa-solid fa-circle-xmark"></i>
                    </button>
                  </span>
                </div>
                <h1><a href="single.html">推薦給想露營卻沒有經驗的你！</a></h1>
                <p>
                  最近露營潮興起，讓許多想旅行的人，開始選擇懶人露營，
                  不需要買任何配備任何露營用具，讓想露營的人也體以體驗露營的樂趣。.....
                </p>
                <footer style="display: flex;align-items: center; justify-content: space-between;">
                  <span style="display: flex;align-items: center;">
                    <p>100 留言</p>
                  </span>
                  <span style="display: flex; align-items: center; margin-right: 80px;">
                    <i class="fa-regular fa-heart"></i>
                    <p style="margin-right: 0px;">1,098</p>
                  </span>
                </footer>
              </div>
            </div>
          </article>
          <article class="col-md-12 article-list">
            <div class="inner">
              <figure>
                <a href="single.html">
                  <img src="images/img15.jpg">
                </a>
              </figure>
              <div class="details">
                <div class="detail" style="justify-content: space-between;">
                  <span style="display: flex;">
                    <div class="category">
                      <a href="category.html">Film</a>
                    </div>
                    <div class="time">December 26, 2016</div>
                  </span>
                  <span style="display: flex; margin-right: 80px;">
                    <button type="button" class="btn-icon" data-toggle="modal" data-target="example-modal">
                      <i style="color: #005555; margin-right: 8px;" class="fa-solid fa-circle-check"></i>
                      <i style="color: #B02626;" class="fa-solid fa-circle-xmark"></i>
                    </button>
                  </span>
                </div>
                <h1><a href="single.html">推薦給想露營卻沒有經驗的你！</a></h1>
                <p>
                  最近露營潮興起，讓許多想旅行的人，開始選擇懶人露營，
                  不需要買任何配備任何露營用具，讓想露營的人也體以體驗露營的樂趣。.....
                </p>
                <footer style="display: flex;align-items: center; justify-content: space-between;">
                  <span style="display: flex;align-items: center;">
                    <p>100 留言</p>
                  </span>
                  <span style="display: flex; align-items: center; margin-right: 80px;">
                    <i class="fa-regular fa-heart"></i>
                    <p style="margin-right: 0px;">1,098</p>
                  </span>
                </footer>
              </div>
            </div>
          </article>
          <article class="col-md-12 article-list">
            <div class="inner">
              <figure>
                <a href="single.html">
                  <img src="images/img15.jpg">
                </a>
              </figure>
              <div class="details">
                <div class="detail" style="justify-content: space-between;">
                  <span style="display: flex;">
                    <div class="category">
                      <a href="category.html">Film</a>
                    </div>
                    <div class="time">December 26, 2016</div>
                  </span>
                  <span style="display: flex; margin-right: 80px;">
                    <button type="button" class="btn-icon" data-toggle="modal" data-target="example-modal">
                      <i style="color: #005555; margin-right: 8px;" class="fa-solid fa-circle-check"></i>
                      <i style="color: #B02626;" class="fa-solid fa-circle-xmark"></i>
                    </button>
                  </span>
                </div>
                <h1><a href="single.html">推薦給想露營卻沒有經驗的你！</a></h1>
                <p>
                  最近露營潮興起，讓許多想旅行的人，開始選擇懶人露營，
                  不需要買任何配備任何露營用具，讓想露營的人也體以體驗露營的樂趣。.....
                </p>
                <footer style="display: flex;align-items: center; justify-content: space-between;">
                  <span style="display: flex;align-items: center;">
                    <p>100 留言</p>
                  </span>
                  <span style="display: flex; align-items: center; margin-right: 80px;">
                    <i class="fa-regular fa-heart"></i>
                    <p style="margin-right: 0px;">1,098</p>
                  </span>
                </footer>
              </div>
            </div>
          </article>
          <article class="col-md-12 article-list">
            <div class="inner">
              <figure>
                <a href="single.html">
                  <img src="images/img15.jpg">
                </a>
              </figure>
              <div class="details">
                <div class="detail" style="justify-content: space-between;">
                  <span style="display: flex;">
                    <div class="category">
                      <a href="category.html">Film</a>
                    </div>
                    <div class="time">December 26, 2016</div>
                  </span>
                  <span style="display: flex; margin-right: 80px;">
                    <button type="button" class="btn-icon" data-toggle="modal" data-target="example-modal">
                      <i style="color: #005555; margin-right: 8px;" class="fa-solid fa-circle-check"></i>
                      <i style="color: #B02626;" class="fa-solid fa-circle-xmark"></i>
                    </button>
                  </span>
                </div>
                <h1><a href="single.html">推薦給想露營卻沒有經驗的你！</a></h1>
                <p>
                  最近露營潮興起，讓許多想旅行的人，開始選擇懶人露營，
                  不需要買任何配備任何露營用具，讓想露營的人也體以體驗露營的樂趣。.....
                </p>
                <footer style="display: flex;align-items: center; justify-content: space-between;">
                  <span style="display: flex;align-items: center;">
                    <p>100 留言</p>
                  </span>
                  <span style="display: flex; align-items: center; margin-right: 80px;">
                    <i class="fa-regular fa-heart"></i>
                    <p style="margin-right: 0px;">1,098</p>
                  </span>
                </footer>
              </div>
            </div>
          </article>
        </div>
      </div>
    </div>
  </div>

  <div class="row align-items-center py-5">
    <div class="col-lg-3"></div>
    <div class="col-lg-6 text-center">
      <div class="custom-pagination">
        <a href="#">1</a>
        <a href="#" class="active">2</a>
        <a href="#">3</a>
        <a href="#">4</a>
        <a href="#">5</a>
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