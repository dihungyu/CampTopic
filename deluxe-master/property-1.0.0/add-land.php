<?php
require_once '../../php/conn.php';

session_start();
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

  <!-- 引入Choices JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

  <!-- choices.js -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">

  <!-- 引入Bootstrap JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

  <!-- 引入Summernote CSS -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet" />

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const choices = new Choices('#tags-select', {
        removeItemButton: true,
        searchEnabled: false,
        placeholderValue: '請選擇標籤...',
        searchPlaceholderValue: '搜尋標籤',
        maxItemCount: 5
      });
    });

    function previewImage(input) {
      const previewDiv = input.parentElement;
      const previewImg = previewDiv.querySelector('.preview-image');
      const removeBtn = previewDiv.querySelector('.remove-image');
      const file = input.files[0];

      const uploadPlaceholder = previewDiv.querySelector('.upload-placeholder');
      uploadPlaceholder.style.display = 'none';

      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          previewImg.src = e.target.result;
          previewImg.style.display = 'block';
          removeBtn.style.display = 'block';
        }
        reader.readAsDataURL(file);
      }
    }

    function removeImage(button) {
      const previewDiv = button.parentElement;
      const previewImg = previewDiv.querySelector('.preview-image');
      const inputFile = previewDiv.querySelector('input[type="file"]');
      const uploadPlaceholder = previewDiv.querySelector('.upload-placeholder');
      uploadPlaceholder.style.display = 'flex';
      inputFile.value = '';
      previewImg.src = '';
      previewImg.style.display = 'none';
      button.style.display = 'none';
    }

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
      <a href="index.html"><img class="navbar-brand" src="images/Group 59.png"
          style="width: 90px; height: auto;"></img></a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
        aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> 選單
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item "><a href="index.html" class="nav-link">首頁</a></li>
          <li class="nav-item"><a href="rooms.html" class="nav-link">找小鹿</a></li>
          <li class="nav-item"><a href="restaurant.html" class="nav-link">鹿的分享</a></li>
          <li class="nav-item"><a href="about.html" class="nav-link">鹿的裝備</a></li>
          <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>

          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="member.html" id="navbarDropdown" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              帳號
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="member.html">會員帳號</a>
              <a class="dropdown-item" href="member-like.html">我的收藏</a>
              <a class="dropdown-item" href="">文章管理</a>
              <a class="dropdown-item" href="manage-equip.html">設備管理</a>
              <a class="dropdown-item" href="manage-land.html">營地管理</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">登出</a>
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
          <h1 class="heading" data-aos="fade-up">營地管理</h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="index.html">首頁</a></li>
              <li class="breadcrumb-item"><a href="member.html">會員帳號</a></li>
              <li class="breadcrumb-item active text-white-50" aria-current="page">
                營地管理
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



    <div class="section section-properties">
      <div class="container">
        <div class="row">
          <span style="display:flex;margin-bottom: 12px;flex-wrap: wrap; margin-left: 100px;">
            <h5 style="font-weight:bold;">新增營地</h5>
          </span>
          <br>
          <form action="../../php/Campsite/createCampsite.php" method="post" enctype="multipart/form-data">
            <span style="display:flex;align-items: flex-end;flex-wrap: wrap;margin-bottom: 17px;">
              <input type="text" placeholder="營地名稱" name="campsiteName"
                style="background-color: #F0F0F0; border-style: none; color:#9D9D9D; width: 1050px; height: 50px; border-radius: 30px;padding: 20px;margin-left: 100px;">
              <br><br>
            </span>
            <span style="display:flex;align-items: flex-end;flex-wrap: wrap;margin-bottom: 17px; margin-top: 17px;">
              <?php
              $sql = "SELECT cityId, cityName FROM cities";
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
                echo '<select name="cityId" id="cityId" style="background-color: #F0F0F0; border-style: none; color:#9D9D9D; width: 500px; height: 50px; border-radius: 30px; padding-left: 20px; margin-left: 100px;">';
                echo '<option disabled selected hidden>請選擇營地所在縣市</option>';
                while ($row = mysqli_fetch_assoc($result)) {
                  echo '<option value="' . $row['cityId'] . '">' . $row['cityName'] . '</option>';
                }
                echo '</select><br />';
              } else {
                echo "沒有找到縣市資料。";
              }
              ?>
              <br><br>
              <input type="text" placeholder="營區地址" name="campsiteAddress"
                style="background-color: #F0F0F0; border-style: none; color:#9D9D9D; width: 500px; height: 50px; border-radius: 30px;padding: 20px;margin-left: 50px;">
              <br><br>
            </span>
            <span style="display:flex;align-items: flex-end;flex-wrap: wrap;margin-bottom: 17px; margin-top: 17px;">
              <input type="text" placeholder="營區價格下限" name="campsiteLowerLimit"
                style="background-color: #F0F0F0; border-style: none; color:#9D9D9D; width: 500px; height: 50px; border-radius: 30px;padding: 20px;margin-left: 100px;">
              <br><br>
              <input type="text" placeholder="營區價格上限" name="campsiteUpperLimit"
                style="background-color: #F0F0F0; border-style: none; color:#9D9D9D; width: 500px; height: 50px; border-radius: 30px;padding: 20px;margin-left: 50px;">
              <br><br>
            </span>
            <span style="display:flex;align-items: flex-end;flex-wrap: wrap;margin-bottom: 17px; margin-top: 17px;">
              <input type="text" placeholder="介紹影片連結" name="campsiteVideoLink"
                style="background-color: #F0F0F0; border-style: none; color:#9D9D9D; width: 500px; height: 50px; border-radius: 30px;padding: 20px;margin-left: 100px;">
              <br><br>
              <input type="text" placeholder="Google地圖連結" name="campsiteAddressLink"
                style="background-color: #F0F0F0; border-style: none; color:#9D9D9D; width: 500px; height: 50px; border-radius: 30px;padding: 20px;margin-left: 50px;">
              <br><br>
            </span>


            <span
              style="display:flex;align-items: center;flex-wrap: nowrap;margin-bottom: 17px;margin-left: 100px;margin-top: 10px;">
              <select id="tags-select" name="tags[]" multiple style="width: 1050px;">
                <!-- 你的選項將在這裡生成，就像在你原始的程式碼中一樣 -->
                <?php
                $sql = "SELECT labelId, labelName FROM labels WHERE labelType = '營地'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) { // 檢查是否有資料
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['labelId'] . '">' . $row['labelName'] . '</option>';
                  }
                }
                ?>
              </select>
            </span>

            <h6 style="font-weight:bold;margin-left: 100px;margin-top: 17px;">設備與設施</h6>
            <span
              style="display:flex;align-items: center;flex-wrap: nowrap;margin-bottom: 17px;margin-left: 100px;margin-top: 10px;">
              <?php
              $sql_services = "SELECT * FROM services";
              $result_services = mysqli_query($conn, $sql_services);

              if (mysqli_num_rows($result_services) > 0) { // 檢查是否有資料
                while ($row_services = mysqli_fetch_assoc($result_services)) {
                  echo '<input type="checkbox" name="services[]" value="' . $row_services['serviceId'] . '" style="color: #F0F0F0;">';
                  echo '<span style="margin-right: 25px;">' . $row_services['serviceName'] . '</span>';
                }
              }
              ?>
            </span>
            <h6 style="font-weight:bold;margin-left: 100px;margin-top: 17px;">封面圖片</h6>
            <span
              style="display:flex;align-items: center;flex-wrap: nowrap;margin-bottom: 17px;margin-left: 100px;margin-top: 10px;">
              <div class="preview"
                style="position:relative;float:left;background-color: #F0F0F0;height:200px;width:330px;text-align:center;border-radius: 20px;">
                <input type="file" id="image_upload1" name="files[]" accept=".jpg, .jpeg, .png"
                  style="height:200px;width:330px;opacity: 0;" onchange="previewImage(this)">
                <div class="upload-placeholder"
                  style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); display: flex; flex-direction: column; align-items: center;">
                  <i class="icon-cloud_upload" style="font-size:50px;color:#acacac;"></i>
                  <p style="color:#797979; margin-top: 10px;">上傳圖片</p>
                </div>
                <img src="" alt="" class="preview-image"
                  style="display:none; position:absolute; top:0; left:0; width:100%; height:100%; object-fit:cover;">
                <button type="button" class="remove-image"
                  style="display:none; position:absolute; top:0; right:0; background-color: red; border: none; font-size: 20px; color: white;"
                  onclick="removeImage(this)">X</button>
              </div>
              <div class="preview"
                style="position:relative;float:left;background-color: #F0F0F0;height:200px;width:330px;text-align:center;border-radius: 20px; margin-left: 20px;">
                <input type="file" id="image_upload2" name="files[]" accept=".jpg, .jpeg, .png"
                  style="height:200px;width:330px;opacity: 0;" onchange="previewImage(this)">
                <div class="upload-placeholder"
                  style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); display: flex; flex-direction: column; align-items: center;">
                  <i class="icon-cloud_upload" style="font-size:50px;color:#acacac;"></i>
                  <p style="color:#797979; margin-top: 10px;">上傳圖片</p>
                </div>
                <img src="" alt="" class="preview-image"
                  style="display:none; position:absolute; top:0; left:0; width:100%; height:100%; object-fit:cover;">
                <button type="button" class="remove-image"
                  style="display:none; position:absolute; top:0; right:0; background-color: red; border: none; font-size: 20px; color: white;"
                  onclick="removeImage(this)">X</button>
              </div>
              <div class="preview"
                style="position:relative;float:left;background-color: #F0F0F0;height:200px;width:330px;text-align:center;border-radius: 20px; margin-left: 20px;">
                <input type="file" id="image_upload3" name="files[]" accept=".jpg, .jpeg, .png"
                  style="height:200px;width:330px;opacity: 0;" onchange="previewImage(this)">
                <div class="upload-placeholder"
                  style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); display: flex; flex-direction: column; align-items: center;">
                  <i class="icon-cloud_upload" style="font-size:50px;color:#acacac;"></i>
                  <p style="color:#797979; margin-top: 10px;">上傳圖片</p>
                </div>
                <img src="" alt="" class="preview-image"
                  style="display:none; position:absolute; top:0; left:0; width:100%; height:100%; object-fit:cover;">
                <button type="button" class="remove-image"
                  style="display:none; position:absolute; top:0; right:0; background-color: red; border: none; font-size: 20px; color: white;"
                  onclick="removeImage(this)">X</button>
              </div>
            </span>
            <div
              style="display:flex; align-items: center; flex-wrap: nowrap; margin-bottom: 17px; margin-left: 100px; margin-top: 10px;">
              <div style="width: 1050px;">
                <textarea id="summernote-editor" name="campsiteDescription" rows="20" class="articletext"></textarea>
              </div>
            </div>
            <span style="margin-left: 1005px;">
              <button class="btn-new1">取消</button>
              <input type="hidden" name="action" value="insert">
              <button type="submit" class="btn-new">新增</button>
            </span>
          </form>

        </div>
      </div>
    </div>

    <br><br>


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
    <script src="js/uploadphoto.js"></script>

    <!-- 引入Summernote JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/lang/summernote-zh-TW.min.js"></script>

    <style>
      .choices {
        width: 1050px;
      }
    </style>

    <script>
      $(document).ready(function () {
        $('#summernote-editor').summernote({
          // 設置編輯器的語言為繁體中文
          lang: 'zh-TW',
          height: 500, // 設置編輯器的高度
          minHeight: null, // 設置編輯器的最小高度
          maxHeight: null, // 設置編輯器的最大高度
          focus: true, // 設置自動聚焦到編輯器
          placeholder: '營區詳細介紹（可上傳圖片）'
        });
      });
    </script>


    <script>
      $(document).ready(function () {
        $('#summernote-editor').summernote({
          callbacks: {
            onImageUpload: function (files) {
              var maxSize = 2 * 1024 * 1024; // 限制檔案大小為 2 MB
              if (files[0].size > maxSize) {
                alert('檔案大小不能超過 2 MB');
                return;
              }
              var formData = new FormData();
              formData.append('file', files[0]);

              $.ajax({
                url: '../../php/upload_image.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                  $('#summernote-editor').summernote('insertImage', response.imageUrl);
                },
                error: function (error) {
                  console.error('圖片上傳失敗', error);
                }
              });
            }
          }
        });
      });
    </script>




</body>

</html>