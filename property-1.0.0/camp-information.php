<?php
require_once '../php/conn.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="author" content="Untree.co" />
  <link rel="shortcut icon" href="Frame 5.png" />

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
  <link rel="stylesheet" href="fonts/docs/css/ionicons.min.css">
  <link rel="stylesheet" href="css/skins/all.css">




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

  <div class="hero page-inner overlay" style="background-image: url('images/Rectangle\ 151.png');
      height:70vh;
      min-height: 300px;">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-12 text-center mt-5">
          <h1 class="heading" data-aos="fade-up">找小鹿
          </h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="index.html">首頁</a></li>
              <li class="breadcrumb-item active text-white-50" aria-current="page">
                找小鹿
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
          <span style="display:flex;align-items: center;justify-content: center">
            <button type="button" class="button-filter">
              <i class="fa-solid fa-bars-staggered" style="margin-right: 4px;"></i>篩選
            </button>
            <a class="tag-filter" href="#">櫻花
              <i class="fa-solid fa-circle-xmark" style="margin-left:10px;"></i>
            </a>
            <a class="tag-filter" href="#">標籤
              <i class="fa-solid fa-circle-xmark" style="margin-left:10px;"></i>
            </a>
            <a class="tag-filter" href="#">標籤
              <i class="fa-solid fa-circle-xmark" style="margin-left:10px;"></i>
            </a>
            <a class="tag-filter" href="#">標籤
              <i class="fa-solid fa-circle-xmark" style="margin-left:10px;"></i>
            </a>
            <a class="tag-filter" href="#">標籤
              <i class="fa-solid fa-circle-xmark" style="margin-left:10px;"></i>
            </a>
          </span>
          <span style="display:flex ;">
            <div id="navbar-search-autocomplete" class="form-outline">
              <input type="search" id="form1" class="form-control" style="border-radius: 35px;" />
            </div>
            <button type="button" class="button-search" style="margin-left: 10px; ">
              <i class="fas fa-search"></i>
            </button>
          </span>
        </div>
        <div class="input-group" style="display: flex; justify-content: space-between;">
          <button type="button" class="gray-lg" data-toggle="modal" data-target="#exampleModalCenter">
            <img src="images/person_4.jpg" alt="Image description" style="border-radius: 50%; width: 15%;">
            <label style="font-size: 14px; margin-bottom: 0px;margin-left: -16px; font-weight: 600; ">yizz</label>
            <div class="verticle-line"></div>
            <span style="display: flex; align-items: center; justify-content: flex-start">
              <i class="fa-solid fa-fire" style="color: #B02626; font-size:18px; margin-right: 8px;"></i>
              <h6 style="margin: 0rem;">新手營火</h6>
            </span>
          </button>
          <button type="button" class="gray-lg" data-toggle="modal" data-target="#create">
            <h6>發起露營活動！</h6>
            <div class="verticle-line"></div>
            <span style="display: flex; align-items: center; justify-content: flex-start">
              <i class="fa-solid fa-hand-fist" style="font-size: 18px;margin-right: 8px;"></i>
              <h6>創建</h6>
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="tab-content" id="myTabContent">
    <div class="section section-properties">
      <div class="container" style="max-width: 1260px">
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="card" style="width: 600px;margin-left: 0px; margin-bottom: 40px;">
              <img class="card-img-top" src="images/Rectangle 137.png" alt="Card image cap">
              <span class="card-head">
                <img src="images/person_4-min.jpg" alt="Admin" />
                <p>yizzz</p>
              </span>

              <div class="card-body" style="margin-top: 0px;">
                <h5 class="card-title">2/3-2/5 元宵'星空露營</h5>
                <div style="display: flex;flex-direction: column">
                  <div class="findcamper">
                    <span class="findcamper-icon">
                      <i class="fa-solid fa-calendar-days"></i>2晚,2/3-2/5</span>
                    <span class="findcamper-icon">
                      <i class="fa-solid fa-person"></i>4-6 人
                    </span>
                  </div>

                  <div class="findcamper">
                    <span class="findcamper-icon" style="display: flex; align-items: center;">
                      <i class="icon-map"></i>合歡山北峰步道</span>
                    <span class="findcamper-icon">
                      <i class="fa-solid fa-sack-dollar"></i>2000-2500元</span>
                  </div>

                </div>
                <hr>
                <div class="findcamper-bottom">
                  <p>已有4人參加 </p>
                  <button class="btn btn-primary" style="padding-top: 8px; padding-bottom: 8px; font-size: 14px;"
                    data-toggle="modal" data-target="#exampleModal">
                    參加！</button>
                </div>
              </div>
            </div>

            <div class="card" style="width: 600px;margin-left: 0px;margin-bottom: 40px;">
              <img class="card-img-top" src="images/Rectangle 137.png" alt="Card image cap">
              <span class="card-head">
                <img src="images/person_4-min.jpg" alt="Admin" />
                <p>yizzz</p>
              </span>

              <div class="card-body" style="margin-top: 0px;">
                <h5 class="card-title">2/3-2/5 元宵'星空露營</h5>
                <div style="display: flex;flex-direction: column">
                  <div class="findcamper">
                    <span class="findcamper-icon">
                      <i class="fa-solid fa-calendar-days"></i>2晚,2/3-2/5</span>
                    <span class="findcamper-icon">
                      <i class="fa-solid fa-person"></i>4-6 人
                    </span>
                  </div>

                  <div class="findcamper">
                    <span class="findcamper-icon" style="display: flex; align-items: center;">
                      <i class="icon-map"></i>合歡山北峰步道</span>
                    <span class="findcamper-icon">
                      <i class="fa-solid fa-sack-dollar"></i>2000-2500元</span>
                  </div>

                </div>
                <hr>
                <div class="findcamper-bottom">
                  <p>已有4人參加 </p>
                  <button class="btn btn-primary" style="padding-top: 8px; padding-bottom: 8px; font-size: 14px;"
                    data-toggle="modal" data-target="#exampleModal">
                    參加！</button>
                </div>
              </div>
            </div>

            <div class="card" style="width: 600px;margin-left: 0px;margin-bottom: 40px;">
              <img class="card-img-top" src="images/Rectangle 137.png" alt="Card image cap">
              <span class="card-head">
                <img src="images/person_4-min.jpg" alt="Admin" />
                <p>yizzz</p>
              </span>

              <div class="card-body" style="margin-top: 0px;">
                <h5 class="card-title">2/3-2/5 元宵'星空露營</h5>
                <div style="display: flex;flex-direction: column">
                  <div class="findcamper">
                    <span class="findcamper-icon">
                      <i class="fa-solid fa-calendar-days"></i>2晚,2/3-2/5</span>
                    <span class="findcamper-icon">
                      <i class="fa-solid fa-person"></i>4-6 人
                    </span>
                  </div>

                  <div class="findcamper">
                    <span class="findcamper-icon" style="display: flex; align-items: center;">
                      <i class="icon-map"></i>合歡山北峰步道</span>
                    <span class="findcamper-icon">
                      <i class="fa-solid fa-sack-dollar"></i>2000-2500元</span>
                  </div>

                </div>
                <hr>
                <div class="findcamper-bottom">
                  <p>已有4人參加 </p>
                  <button class="btn btn-primary" style="padding-top: 8px; padding-bottom: 8px; font-size: 14px;"
                    data-toggle="modal" data-target="#exampleModal">
                    參加！</button>
                </div>
              </div>
            </div>
          </div>
          <!-- .item -->

          <div class="col-xs-12 col-sm-6">

            <div class="card" style="width: 600px;margin-left: 0px;margin-bottom: 40px;">
              <img class="card-img-top" src="images/Rectangle 137.png" alt="Card image cap">
              <span class="card-head">
                <img src="images/person_4-min.jpg" alt="Admin" />
                <p>yizzz</p>
              </span>

              <div class="card-body" style="margin-top: 0px;">
                <h5 class="card-title">2/3-2/5 元宵'星空露營</h5>
                <div style="display: flex;flex-direction: column">
                  <div class="findcamper">
                    <span class="findcamper-icon">
                      <i class="fa-solid fa-calendar-days"></i>2晚,2/3-2/5</span>
                    <span class="findcamper-icon">
                      <i class="fa-solid fa-person"></i>4-6 人
                    </span>
                  </div>

                  <div class="findcamper">
                    <span class="findcamper-icon" style="display: flex; align-items: center;">
                      <i class="icon-map"></i>合歡山北峰步道</span>
                    <span class="findcamper-icon">
                      <i class="fa-solid fa-sack-dollar"></i>2000-2500元</span>
                  </div>

                </div>
                <hr>
                <div class="findcamper-bottom">
                  <p>已有4人參加 </p>
                  <button class="btn btn-primary" style="padding-top: 8px; padding-bottom: 8px; font-size: 14px;"
                    data-toggle="modal" data-target="#exampleModal">
                    參加！</button>
                </div>
              </div>
            </div>


            <div class="card" style="width: 600px;margin-left: 0px;margin-bottom: 40px;">
              <img class="card-img-top" src="images/Rectangle 137.png" alt="Card image cap">
              <span class="card-head">
                <img src="images/person_4-min.jpg" alt="Admin" />
                <p>yizzz</p>
              </span>

              <div class="card-body" style="margin-top: 0px;">
                <h5 class="card-title">2/3-2/5 元宵'星空露營</h5>
                <div style="display: flex;flex-direction: column">
                  <div class="findcamper">
                    <span class="findcamper-icon">
                      <i class="fa-solid fa-calendar-days"></i>2晚,2/3-2/5</span>
                    <span class="findcamper-icon">
                      <i class="fa-solid fa-person"></i>4-6 人
                    </span>
                  </div>

                  <div class="findcamper">
                    <span class="findcamper-icon" style="display: flex; align-items: center;">
                      <i class="icon-map"></i>合歡山北峰步道</span>
                    <span class="findcamper-icon">
                      <i class="fa-solid fa-sack-dollar"></i>2000-2500元</span>
                  </div>

                </div>
                <hr>
                <div class="findcamper-bottom">
                  <p>已有4人參加 </p>
                  <button class="btn btn-primary" style="padding-top: 8px; padding-bottom: 8px; font-size: 14px;"
                    data-toggle="modal" data-target="#exampleModal">
                    參加！</button>
                </div>
              </div>
            </div>

            <div class="card" style="width: 600px;margin-left: 0px;margin-bottom: 40px;">
              <img class="card-img-top" src="images/Rectangle 137.png" alt="Card image cap">
              <span class="card-head">
                <img src="images/person_4-min.jpg" alt="Admin" />
                <p>yizzz</p>
              </span>

              <div class="card-body" style="margin-top: 0px;">
                <h5 class="card-title">2/3-2/5 元宵'星空露營</h5>
                <div style="display: flex;flex-direction: column">
                  <div class="findcamper">
                    <span class="findcamper-icon">
                      <i class="fa-solid fa-calendar-days"></i>2晚,2/3-2/5</span>
                    <span class="findcamper-icon">
                      <i class="fa-solid fa-person"></i>4-6 人
                    </span>
                  </div>

                  <div class="findcamper">
                    <span class="findcamper-icon" style="display: flex; align-items: center;">
                      <i class="icon-map"></i>合歡山北峰步道</span>
                    <span class="findcamper-icon">
                      <i class="fa-solid fa-sack-dollar"></i>2000-2500元</span>
                  </div>

                </div>
                <hr>
                <div class="findcamper-bottom">
                  <p>已有4人參加 </p>
                  <button class="btn btn-primary" style="padding-top: 8px; padding-bottom: 8px; font-size: 14px;"
                    data-toggle="modal" data-target="#exampleModal">
                    參加！</button>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- .item -->
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

  </div>
  </div>
  </div>
  </article>

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
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="false">
        <div class="modal-dialog" role="document">
          <div class="modalContent">
            <div class="box-mod">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i id="close" class="fa-solid fa-circle-xmark" style="color:#a0a0a0;"></i>
              </button>
              <h4 id="exampleModalLabel">參加</h4>

            </div>
            <p style="color: #a0a0a0 ">參加活動蒐集勳章！
            <p>

            <div class="modal-list">
              <input type="text" placeholder="電話">
              <input type="email" placeholder="信箱">
              <textarea rows="4" type="text" value="suggest" placeholder="備註 / 建議"></textarea>

              <h6 style="color: black;">可提供裝備</h6>
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


      <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="false">
        <div class="modal-dialog" role="document">
          <div class="modalContent">
            <div class="box-mod">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i id="close" class="fa-solid fa-circle-xmark" style="color:#a0a0a0;"></i>
              </button>
              <h4 id="exampleModalLabel">創建露營活動</h4>

            </div>
            <p style="color: #a0a0a0 ">尋找其他小鹿一起冒險！
            <p>

            <div class="modal-list">
              <input type="text" placeholder="活動名稱">
              <input type="text" placeholder="活動地點">
              <div class="supply">
                <div class="row">
                  <div class="col-md-6">
                    <input type="date" style="width: 200px;" placeholder="開始日期">
                  </div>
                  <div class="col-md-6">
                    <input type="date" style="width: 200px;" placeholder="結束日期">
                  </div>
                  <div class="col-md-6">
                    <input type="text" style="width: 200px;" placeholder="最少人數">
                  </div>
                  <div class="col-md-6">
                    <input type="text" style="width: 200px;" placeholder="最多人數">
                  </div>
                  <div class="col-md-6">
                    <input type="price" style="width: 200px;" placeholder="最低費用">
                  </div>
                  <div class="col-md-6">
                    <input type="price" style="width: 200px;" placeholder="最高費用">
                  </div>
                </div>
              </div>
              <textarea rows="3" placeholder="備註" type="text"></textarea>
            </div>
            <div style=" display: flex;
          justify-content: flex-end;">
              <button class="btn-secondary">提交</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <span style="display: flex;">
                <h6>徽章進度</h6>
                <span-i style="margin-left: 20px;">
                  <i class="fa-solid fa-fire" style="color:#B02626"></i>
                  <i class="fa-solid fa-compass" style="color:rgba(0, 0, 0, 0.16)"></i>
                  <i class="fa-solid fa-binoculars" style="color:rgba(0, 0, 0, 0.16)"></i>
                  <i class="fa-solid fa-campground" style="color:rgba(0, 0, 0, 0.16)"></i>
                </span-i>
              </span>
              <div style="display: flex; justify-content: space-between;">
                <span style="display: flex;">
                  <p>已參加活動</p>
                  <p>2</p>
                  <p>次</p>
                </span>
                <span style="display: flex;">
                  <p>差</p>
                  <p>1</p>
                  <p>次升級</p>
                </span>
              </div>


              </span>
              <div class="progress" style="height:0.7rem; border-radius:35px;">
                <div class="progress-bar" role="progressbar" style="width: 66%;
                      background-color:#8D703B;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </div>


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