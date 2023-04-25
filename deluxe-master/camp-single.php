<?php
require_once '../php/conn.php';

// $campsiteId = $_GET['campsiteId'];
$campsiteId = '10';
// 查詢 campsite 資料
$sql_query_campsite = "SELECT * FROM campsites WHERE campsiteId = '$campsiteId'";
$result_campsite = mysqli_query($conn, $sql_query_campsite);
$row_campsite = mysqli_fetch_assoc($result_campsite);

$cityId = !empty($row_campsite['cityId']) ? $row_campsite['cityId'] : '無資料';
$campsiteName = !empty($row_campsite['campsiteName']) ? $row_campsite['campsiteName'] : '無資料';
$campsiteDescription = !empty($row_campsite['campsiteDescription']) ? $row_campsite['campsiteDescription'] : '無資料';
$campsiteAddress = !empty($row_campsite['campsiteAddress']) ? $row_campsite['campsiteAddress'] : '無資料';
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
      <a href="index.html"><img class="navbar-brand" src="images/Group 59.png"
          style="width: 90px; height: auto;"></img></a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
        aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> 選單
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item "><a href="property-1.0.0/index.html" class="nav-link">首頁</a></li>
          <li class="nav-item"><a href="rooms.html" class="nav-link">找小鹿</a></li>
          <li class="nav-item"><a href="restaurant.html" class="nav-link">鹿的分享</a></li>
          <li class="nav-item"><a href="about.html" class="nav-link">鹿的設備</a></li>
          <li class="nav-item"><a href="blog.html" class="nav-link">加入起跑點</a></li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="member.html" id="navbarDropdown" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              帳號
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="member.html">會員帳號</a>
              <a class="dropdown-item" href="member-like.html">鹿的收藏</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">登出</a>
            </div>
          </li>

        </ul>
      </div>
    </div>
  </nav>
  <!-- END nav -->

  <div class="hero page-inner overlay" style="background-image: url('images/Rectangle\ 151.jpg');
      height:70vh;
      min-height: 300px;">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-12 text-center mt-5">
          <h1 class="heading" data-aos="fade-up">營地資訊</h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="index.html">首頁</a></li>
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
                <div class="item">
                  <div class="room-img" style="background-image: url(images/148.png);"></div>
                </div>
                <div class="item">
                  <div class="room-img" style="background-image: url(images/149.png);"></div>
                </div>
                <div class="item">
                  <div class="room-img" style="background-image: url(images/150.png);"></div>
                </div>
              </div>
            </div>
            <div class="col-md-12 room-single mt-4 mb-5 ftco-animate">
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
                }
                ?>
              </div>
            </div>
            <div class="col-md-12 room-single ftco-animate mb-5 mt-4">
              <h4 class="mb-4">影片導覽</h4>
              <div class="block-16">
                <figure>

                  <iframe width="800" height="433" src="<?php echo $campsiteVideoLink ?>" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>

                </figure>
              </div>
            </div>


          </div>
        </div> <!-- .col-md-8 -->
        <div class="col-lg-4 sidebar ftco-animate">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder=" search" aria-label="search"
              aria-describedby="basic-addon2">
            <div class="input-group-append">
              <button class="button-search" type="button"><i class="fas fa-search"></i></button>
            </div>
          </div>

          <div class="sidebar-box ftco-animate">
            <div class="categories">
              <h4 style="margin-bottom: 16px">類別</h4>
              <li><a href="#">北部 <span>(12)</span></a></li>
              <li><a href="#">中部 <span>(22)</span></a></li>
              <li><a href="#">南部 <span>(37)</span></a></li>
              <li><a href="#">溪流 <span>(42)</span></a></li>
              <li><a href="#">草原 <span>(14)</span></a></li>
              <li><a href="#">星空 <span>(140)</span></a></li>
            </div>
          </div>

          <div class="sidebar-box ftco-animate">
            <h3>相關文章</h3>
            <div class="block-21 mb-4 d-flex">
              <a class="blog-img mr-4" style="background-image: url(images/image_1.jpg);"></a>
              <div class="text">
                <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about the blind texts</a>
                </h3>
                <div class="meta">
                  <div><a href="#"><span class="icon-calendar"></span> July 12, 2018</a></div>
                  <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                  <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                </div>
              </div>
            </div>
            <div class="block-21 mb-4 d-flex">
              <a class="blog-img mr-4" style="background-image: url(images/image_2.jpg);"></a>
              <div class="text">
                <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about the blind texts</a>
                </h3>
                <div class="meta">
                  <div><a href="#"><span class="icon-calendar"></span> July 12, 2018</a></div>
                  <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                  <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                </div>
              </div>
            </div>
            <div class="block-21 mb-4 d-flex">
              <a class="blog-img mr-4" style="background-image: url(images/image_3.jpg);"></a>
              <div class="text">
                <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about the blind texts</a>
                </h3>
                <div class="meta">
                  <div><a href="#"><span class="icon-calendar"></span> July 12, 2018</a></div>
                  <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                  <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                </div>
              </div>
            </div>
          </div>

          <div class="sidebar-box ftco-animate">
            <h3>營地標籤</h3>
            <div class="tagcloud">
              <a href="#" class="tag-cloud-link">BBQ</a>
              <a href="#" class="tag-cloud-link">溫泉</a>
              <a href="#" class="tag-cloud-link">大自然</a>
              <a href="#" class="tag-cloud-link">手作</a>
              <a href="#" class="tag-cloud-link">懶人露營</a>
              <a href="#" class="tag-cloud-link">網美</a>
              <a href="#" class="tag-cloud-link">拍照</a>
              <a href="#" class="tag-cloud-link">獨立衛浴</a>
            </div>
          </div>

          <div class="sidebar-box ftco-animate">
            <h3>文章</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus itaque, autem necessitatibus voluptate
              quod mollitia delectus aut, sunt placeat nam vero culpa sapiente consectetur similique, inventore eos
              fugit cupiditate numquam!</p>
          </div>
        </div>
      </div>

      <div class="col-md-12 room-single ftco-animate mb-5 mt-5">
        <h4 class="mb-4">顧客回饋</h4>
        <div class="row">
          <div class="col-sm col-md-4 ftco-animate">
            <div class="item">
              <div class="testimonial">
                <img src="images/person_1-min.jpg" alt="Image" class="img-fluid rounded-circle w-25 mb-4" />
                <div class="rate">
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                </div>
                <h3 class="h5 text-primary mb-4">James Smith</h3>
                <blockquote>
                  <p>
                    &ldquo;Far far away, behind the word mountains, far from the
                    countries Vokalia and Consonantia, there live the blind
                    texts. Separated they live in Bookmarksgrove right at the
                    coast of the Semantics, a large language ocean.&rdquo;
                  </p>
                </blockquote>
                <p class="text-black-50">Designer, Co-founder</p>
              </div>
            </div>
          </div>
          <div class="col-sm col-md-4 ftco-animate">
            <div class="item">
              <div class="testimonial">
                <img src="images/person_1-min.jpg" alt="Image" class="img-fluid rounded-circle w-25 mb-4" />
                <div class="rate">
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                </div>
                <h3 class="h5 text-primary mb-4">James Smith</h3>
                <blockquote>
                  <p>
                    &ldquo;Far far away, behind the word mountains, far from the
                    countries Vokalia and Consonantia, there live the blind
                    texts. Separated they live in Bookmarksgrove right at the
                    coast of the Semantics, a large language ocean.&rdquo;
                  </p>
                </blockquote>
                <p class="text-black-50">Designer, Co-founder</p>
              </div>
            </div>
          </div>
          <div class="col-sm col-md-4 ftco-animate">
            <div class="item">
              <div class="testimonial">
                <img src="images/person_1-min.jpg" alt="Image" class="img-fluid rounded-circle w-25 mb-4" />
                <div class="rate">
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                </div>
                <h3 class="h5 text-primary mb-4">James Smith</h3>
                <blockquote>
                  <p>
                    &ldquo;Far far away, behind the word mountains, far from the
                    countries Vokalia and Consonantia, there live the blind
                    texts. Separated they live in Bookmarksgrove right at the
                    coast of the Semantics, a large language ocean.&rdquo;
                  </p>
                </blockquote>
                <p class="text-black-50">Designer, Co-founder</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- .section -->
    <!-- map-->
    <div class="container" style="margin-top:108px;">
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
            <div class="map-wrap" style="height: 445px;" id="map"></div>
            <div class="col-lg-4 d-flex flex-column address-wrap">
              <div class="single-contact-address d-flex flex-row">
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    </div>


    <div class="site-footer">
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
              <div class="widget">
                <ul class="list-unstyled float-start links">
                  <li><a href="#">Partners</a></li>
                  <li><a href="#">Business</a></li>
                  <li><a href="#">Careers</a></li>
                  <li><a href="#">Blog</a></li>
                  <li><a href="#">FAQ</a></li>
                  <li><a href="#">Creative</a></li>
                </ul>
              </div>
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