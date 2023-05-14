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

$sql_account = "SELECT * FROM accounts WHERE accountId = '$equipmentOwnerId'";
$result_account = mysqli_query($conn, $sql_account);
$row_account = mysqli_fetch_assoc($result_account);

$ownerName = $row_account['accountName'];
$ownerEmail = $row_account['accountEmail'];
$ownerPhoneNumber = $row_account['accountPhoneNumber'];

//收藏設備
if (isset($_POST["collectEquipAdd"])) {
  if (!isset($_COOKIE["accountId"])) {
    $_SESSION["system_message"] = "請先登入會員，才能進行收藏喔!";
    header("Location: equip-single.php?equipmentId=" . $equipmentId);
    exit; // 確保重新導向後停止執行後續代碼
  }
  $equipmentId = $_POST["collectEquipAdd"];
  $accountId = $_COOKIE["accountId"];
  $collectionId = uuid_generator();
  $sql = "INSERT INTO `collections` (`collectionId`,`accountId`, `equipmentId`) VALUES ('$collectionId','$accountId', '$equipmentId')";
  $sql2 = "UPDATE `equipments` SET `equipmentCollectCount` = `equipmentCollectCount` + 1 WHERE `equipmentId` = '$equipmentId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result) {
    $_SESSION["system_message"] = "已加入收藏!";
    header("Location: equip-single.php?equipmentId=" . $equipmentId);
    exit; // 確保重新導向後停止執行後續代碼
  }
}

//移除收藏設備
if (isset($_POST["collectEquipDel"])) {

  $equipmentId = $_POST["collectEquipDel"];
  $accountId = $_COOKIE["accountId"];
  $sql = "DELETE FROM `collections` WHERE `accountId` = '$accountId' AND `equipmentId` = '$equipmentId'";
  $sql2 = "UPDATE `equipments` SET `equipmentCollectCount` = `equipmentCollectCount` - 1 WHERE `equipmentId` = '$equipmentId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result) {
    $_SESSION["system_message"] = "已取消收藏!";
    header("Location: equip-single.php?equipmentId=" . $equipmentId);
    exit; // 確保重新導向後停止執行後續代碼
  }
}

// 按讚設備
if (isset($_POST["likeEquipAdd"])) {

  if (!isset($_COOKIE["accountId"])) {
    $_SESSION["system_message"] = "請先登入會員，才能進行按讚喔!";
    header("Location: equip-single.php?equipmentId=" . $equipmentId);
    exit; // 確保重新導向後停止執行後續代碼
  }

  $equipmentId = $_POST["likeEquipAdd"];
  $accountId = $_COOKIE["accountId"];
  $likeId = uuid_generator();
  $sql = "INSERT INTO `likes` (`likeId`, `accountId`, `equipmentId`) VALUES ('$likeId', '$accountId', '$equipmentId')";
  $sql2 = "UPDATE `equipments` SET `equipmentLikeCount` = `equipmentLikeCount` + 1 WHERE `equipmentId` = '$equipmentId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result) {
    $_SESSION["system_message"] = "已按讚!";
    header("Location: equip-single.php?equipmentId=" . $equipmentId);
    exit; // 確保重新導向後停止執行後續代碼
  }
}

// 取消讚設備
if (isset($_POST["likeEquipDel"])) {

  $equipmentId = $_POST["likeEquipDel"];
  $accountId = $_COOKIE["accountId"];
  $sql = "DELETE FROM `likes` WHERE `accountId` = '$accountId' AND `equipmentId` = '$equipmentId'";
  $sql2 = "UPDATE `equipments` SET `equipmentLikeCount` = `equipmentLikeCount` - 1 WHERE `equipmentId` = '$equipmentId'";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);
  if ($result) {
    $_SESSION["system_message"] = "已取消讚!";
    header("Location: equip-single.php?equipmentId=" . $equipmentId);
    exit; // 確保重新導向後停止執行後續代碼
  }
}

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

    // JavaScript function to handle the delete confirmation dialog
    function deleteEquipment(equipmentId) {
      if (confirm("確認刪除，此動作無法回復?")) {
        window.location.href = "../php/Equipment/deleteEquipment.php?equipmentId=" + equipmentId;
      }
    }
  </script>

</head>

<body>

  <!-- 模态框 HTML 结构 -->
  <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="reportModalLabel">舉報設備</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="report-form">
            <div class="form-group">
              <label for="report-reason">舉報原因</label>
              <select class="form-control" id="report-reason" name="reportReason">
                <option value="垃圾訊息">垃圾訊息</option>
                <option value="冒犯性内容">冒犯性内容</option>
                <option value="疑似詐騙">疑似詐騙</option>
                <option value="其他">其他</option>
              </select>
            </div>
            <div class="form-group">
              <label for="report-description">詳細描述</label>
              <textarea class="form-control" id="report-description" name="reportDescription" rows="3"></textarea>
              <input type="hidden" id="reported-equipment-id" name="equipmentId" value="<?= $equipmentId ?>">

            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
          <button type="button" class="btn btn-primary" id="submit-report">提交</button>
        </div>
      </div>
    </div>
  </div>

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
              <div class="detail" style="display: flex; align-items: center; justify-content: space-between;">
                <span class="span-adj">
                  <span class="fa-stack fa-1x" style="margin-right: 5px; ">
                    <i class="fas fa-circle fa-stack-2x" style="color:#EFE9DA; font-size:30px;padding-left: 0px; "></i>
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
                  if (isset($_COOKIE["accountId"])) {
                    if ($row_equipment["accountId"] == $_COOKIE["accountId"]) {
                      echo '
      <button class="btn-icon">
        <a href="../php/Equipment/deleteEquipment.php?equipmentId=' . $equipmentId . '">
          <i class="fas fa-trash-alt" style="font-weight: 500;color: #000;"></i>
        </a>
      </button>
      <button class="btn-icon">
        <a href="property-1.0.0/edit-equip.php?equipmentId=' . $equipmentId . '">
          <i class="fas fa-edit" style="font-weight: 500;color: #000;"></i>
        </a>
      </button>';
                    } else {
                      echo '
      <button class="btn-icon report-btn" data-equipment-id="' . $equipmentId . '">
        <i class="fas fa-flag" style="font-weight: 500; color: #000;"></i>
      </button>';
                    }
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
                        <p style="margin-bottom: 0px; box-sizing: content-box;width: 60px;">聯絡人</p>
                        <p style="margin-bottom: 0px; margin-left: 10px;">
                          <?php echo $ownerName ?>
                        </p>
                      </span>
                    </li>
                    <li>
                      <span style="display: flex; align-items: center; ">
                        <i class="fa-regular fa-envelope fa-lg"></i>
                        <p style="margin-bottom: 0px; box-sizing: content-box;width: 60px;">信箱</p>
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
          <div class="categories">
            <h4 style="margin-bottom: 16px">類別</h4>
            <?php
            $sql_all = "SELECT COUNT(*) FROM equipments";
            $result_all = mysqli_query($conn, $sql_all);
            $row_all = mysqli_fetch_assoc($result_all);
            $count_all = $row_all['COUNT(*)'];

            $sql_rent = "SELECT COUNT(*) FROM equipments WHERE equipmentType = '租'";
            $result_rent = mysqli_query($conn, $sql_rent);
            $row_rent = mysqli_fetch_assoc($result_rent);
            $count_rent = $row_rent['COUNT(*)'];

            $sql_request = "SELECT COUNT(*) FROM equipments WHERE equipmentType = '徵'";
            $result_request = mysqli_query($conn, $sql_request);
            $row_request = mysqli_fetch_assoc($result_request);
            $count_request = $row_request['COUNT(*)'];

            $sql_sell = "SELECT COUNT(*) FROM equipments WHERE equipmentType = '售'";
            $result_sell = mysqli_query($conn, $sql_sell);
            $row_sell = mysqli_fetch_assoc($result_sell);
            $count_sell = $row_sell['COUNT(*)'];
            ?>
            <li><a href="equipment.php">全部<span>(
                  <?php echo $count_all ?>)
                </span></a></li>
            <li><a href="equipment_rent.php">租<span>(
                  <?php echo $count_rent ?>)
                </span></a></li>
            <li><a href="equipment_request.php">徵<span>(
                  <?php echo $count_request ?>)
                </span></a></li>
            <li><a href="equipment_sell.php">售<span>(
                  <?php echo $count_sell ?>)
                </span></a></li>
          </div>

          <div class="sidebar-box ftco-animate mt-5" style="padding-left:0px;">
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
  </section> <!-- .section -->

  <div class="ad-img">
    <img src="images/Group 147.png">
  </div>
  <section class="ftco-section">
    <div class="container">
      <div class="row" style="display: flex;justify-content: center;">
        <div class="col-md-12 ftco-animate">
          <h5>相關設備</h5>
          <article class="col-md-12 mt-5 article-list">
            <div class="inner" style="display: flex; justify-content: center">
              <?php
              // 取出已被收藏的設備
              $equip_collect_sql = "SELECT `equipmentId` FROM `collections` WHERE `accountId` = '$accountId'";
              $equip_collect_result = mysqli_query($conn, $equip_collect_sql);

              // 將查詢結果轉換為包含已收藏設備ID的陣列
              $collectedEquips = array();
              while ($row = mysqli_fetch_assoc($equip_collect_result)) {
                $collectedEquips[] = $row['equipmentId'];
              }

              // 取出已被按讚的設備
              $equip_like_sql = "SELECT `equipmentId` FROM `likes` WHERE `accountId` = '$accountId'";
              $equip_like_result = mysqli_query($conn, $equip_like_sql);

              // 將查詢結果轉換為包含已按讚設備ID的陣列
              $likedEquips = array();
              while ($row = mysqli_fetch_assoc($equip_like_result)) {
                $likedEquips[] = $row['equipmentId'];
              }

              $sql_recommand_equipment = "SELECT * FROM equipments WHERE equipmentType = '$equipmentType' AND equipmentId != '$equipmentId' ORDER BY RAND() LIMIT 3";
              $result_recommand_equipment = mysqli_query($conn, $sql_recommand_equipment);
              $recommand_equipments = [];
              while ($row_recommand_equipment = mysqli_fetch_assoc($result_recommand_equipment)) {
                $recommand_equipments[] = $row_recommand_equipment;
              }
              foreach ($recommand_equipments as $recommand_equipment) {
                // 檢查當前設備是否已收藏
                $isEquipCollected = in_array($recommand_equipment["equipmentId"], $collectedEquips);

                // 檢查當前設備是否已按讚
                $isEquipLiked = in_array($recommand_equipment["equipmentId"], $likedEquips);

                //取出設備圖片
                $equip_img_src = get_first_image_src($recommand_equipment["equipmentDescription"]);
                if ($equip_img_src == "") {
                  $equip_img_src = "property-1.0.0/images/image_8.jpg";
                }

                //若文章內容超過30字做限制
                $content_length = mb_strlen(strip_tags($recommand_equipment["equipmentDescription"]), 'UTF-8');
                if ($content_length > 30) {
                  $truncated_content = mb_substr(strip_tags($recommand_equipment["equipmentDescription"]), 0, 30, 'UTF-8') . '...'; // 截斷文章內容
                } else {
                  $truncated_content = strip_tags($recommand_equipment["equipmentDescription"]);
                }

                $recommand_equipmentId = $recommand_equipment['equipmentId'];
                $recommand_equipmentName = $recommand_equipment['equipmentName'];
                $recommand_equipmentType = $recommand_equipment['equipmentType'];
                $recommand_equipmentPrice = $recommand_equipment['equipmentPrice'];
                $recommand_equipmentDescription = $recommand_equipment['equipmentDescription'];
                $recommand_equipmentLikeCount = $recommand_equipment['equipmentLikeCount'];
                echo '<div class="card-eq" style=" margin-right: 24px;">';
                echo '<img src="' . $equip_img_src . '" class="card-img-top" alt="..." style="width:379px; height:205px;">';
                echo '<div class="card-body-eq">';

                echo '<div class="detail" style="display:flex;">';

                echo '<span class="fa-stack fa-1x" style="margin-right: 5px;">';

                echo '<i class="fas fa-circle fa-stack-2x" style="color:#EFE9DA; font-size:24px;"></i>';

                echo '<i class="fas fa-stack-1x" style="font-size: 13px;">' . $recommand_equipmentType . '</i>';
                echo '</span>';
                echo '<a href="equip-single.php?equipmentId=' . $recommand_equipmentId . '">';
                echo '<h5 style="width: 180px;">' . $recommand_equipmentName . '</h5>';
                echo '</a>';
                echo '<span class="span-adj">';
                echo '<h4 style="margin-left: 20px; margin-right:0px;">$' . number_format($equipmentPrice) . '</h4>';
                echo "<form action='equip-single.php' method='post' style='margin-bottom: 0px;'>";
                echo "<input type='hidden' name='" . ($isEquipCollected ? "collectEquipDel" : "collectEquipAdd") . "' value='" . $recommand_equipmentId . "'>";
                echo "<button type='submit' class='btn-icon'>";
                echo "<i class='" . ($isEquipCollected ? "fas" : "fa-regular") . " fa-bookmark' " . "></i>";
                echo "</button>";
                echo "</form>";
                echo '</span>';
                echo '</div>';
                echo '<p class="card-text-eq"  style="box-sizing: content-box; width: 300px;">';
                echo '' . $truncated_content . '</p>';
                echo '<footer style="margin-top:40px">';
                echo '<span>';
                echo '<div class="card-icon-footer">';
                echo '<div class="tagcloud">';
                $sql_query_labels = "SELECT equipments_labels.labelId, labels.labelName
                      FROM equipments_labels
                      JOIN labels ON equipments_labels.labelId = labels.labelId
                      WHERE equipments_labels.equipmentId = '$recommand_equipmentId'";
                $result_labels = mysqli_query($conn, $sql_query_labels);

                $printed_tags = 0;
                while ($tags_row = mysqli_fetch_assoc($result_labels)) {
                  if ($printed_tags >= 3) {
                    break;
                  }

                  echo "<a href='#'>" . $tags_row['labelName'] . "</a>";

                  $printed_tags++;
                }
                echo '</div>';
                echo '<span style="display: flex; align-items: center;">';
                echo '<form action="equip-single.php" method="post" style="margin-bottom: 0px;">';
                echo '<input type="hidden" name="' . ($isEquipLiked ? "likeEquipDel" : "likeEquipAdd") . '" value="' . $recommand_equipmentId . '">';
                echo '<button type="submit" class="btn-icon">';
                echo '<i class="' . ($isEquipLiked ? "fas" : "fa-regular") . ' fa-heart" . " style="margin-left: 10px;"></i>';
                echo '</button>';
                echo '</form>';
                echo '<p>' . format_count($recommand_equipmentLikeCount) . '</p>';
                echo '</span>';
                echo '</div>';

                echo '</span>';

                echo '</footer>';
                echo '</div>';
                echo '</div>';
              }
              ?>
          </article>
        </div>
      </div>
    </div>
  </section>


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