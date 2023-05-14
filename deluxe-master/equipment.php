<?php
require_once '../php/conn.php';
require_once '../php/uuid_generator.php';
require_once '../php/get_img_src.php';

if (isset($_COOKIE["accountId"])) {
  $accountId = $_COOKIE["accountId"];
}

session_start();

function getEquipments($conn, $labelId = null, $equipmentType = null, $equipment_search_keyword = '', $equipment_page = 1)
{
  $conditions = array();

  if ($equipmentType) {
    $conditions[] = "equipmentType = '$equipmentType'";
  }

  if ($equipment_search_keyword) {
    $conditions[] = "equipmentName LIKE '%$equipment_search_keyword%'";
  }

  $whereClause = count($conditions) > 0 ? 'WHERE ' . implode(' AND ', $conditions) : '';

  // 如果提供了$labelId，則使用INNER JOIN連接equipments_labels表
  if ($labelId) {
    $joinClause = "INNER JOIN equipments_labels ON equipments.equipmentId = equipments_labels.equipmentId AND equipments_labels.labelId = '$labelId'";
  } else {
    $joinClause = "";
  }

  $equipment_count_sql = "SELECT COUNT(*) as total FROM equipments $joinClause $whereClause";
  $equipment_count_result = $conn->query($equipment_count_sql);
  $row = $equipment_count_result->fetch_assoc();
  $equipment_total_rows = $row['total'];
  $equipment_total_pages = ceil($equipment_total_rows / 4);

  $equipment_perPage = 4;
  $equipment_offset = ($equipment_page - 1) * $equipment_perPage;

  $sql_equipments = "SELECT * FROM equipments $joinClause $whereClause LIMIT $equipment_perPage OFFSET $equipment_offset";
  $result_equipments = mysqli_query($conn, $sql_equipments);

  $equipments = array();
  if (mysqli_num_rows($result_equipments) > 0) {
    while ($row_equipments = mysqli_fetch_assoc($result_equipments)) {
      $equipments[] = $row_equipments;
    }
  }

  return array(
    'equipments' => $equipments,
    'total_pages' => $equipment_total_pages,
    'current_page' => $equipment_page,
  );
}


if (isset($_POST["collectEquipAdd"]) || isset($_POST["collectEquipDel"]) || isset($_POST["likeEquipAdd"]) || isset($_POST["likeEquipDel"])) {
  if (!isset($_COOKIE["accountId"])) {
    $_SESSION["system_message"] = "請先登入會員，才能進行操作喔!";
    header("Location: equipment.php");
    exit;
  }

  $action = '';
  $equipmentField = '';
  $interactionTable = '';
  $interactionField = '';
  $increment = 0;

  if (isset($_POST["collectEquipAdd"])) {
    $action = "collectEquipAdd";
    $equipmentField = "equipmentCollectCount";
    $interactionTable = "collections";
    $interactionField = "collectionId";
    $increment = 1;
  } elseif (isset($_POST["collectEquipDel"])) {
    $action = "collectEquipDel";
    $equipmentField = "equipmentCollectCount";
    $interactionTable = "collections";
    $interactionField = "collectionId";
    $increment = -1;
  } elseif (isset($_POST["likeEquipAdd"])) {
    $action = "likeEquipAdd";
    $equipmentField = "equipmentLikeCount";
    $interactionTable = "likes";
    $interactionField = "likeId";
    $increment = 1;
  } elseif (isset($_POST["likeEquipDel"])) {
    $action = "likeEquipDel";
    $equipmentField = "equipmentLikeCount";
    $interactionTable = "likes";
    $interactionField = "likeId";
    $increment = -1;
  }

  $equipmentId = $_POST[$action];
  $interactionId = uuid_generator();

  if ($increment == 1) {
    $sql = "INSERT INTO `$interactionTable` (`$interactionField`, `accountId`, `equipmentId`) VALUES ('$interactionId', '$accountId', '$equipmentId')";
  } else {
    $sql = "DELETE FROM `$interactionTable` WHERE `accountId` = '$accountId' AND `equipmentId` = '$equipmentId'";
  }
  $sql2 = "UPDATE `equipments` SET `$equipmentField` = `$equipmentField` + $increment WHERE `equipmentId` = '$equipmentId'";

  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);

  if ($result && $result2) {
    $message = $increment == 1 ? "新增完成!" : "移除成功!";
    $_SESSION["system_message"] = $message;
    header("Location: equipment.php");
    exit;
  }
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
  <link rel="https://kit.fontawesome.com/d02d7e1ecb.css">
  <link rel="stylesheet" href="property-1.0.0/css/icomoon.css">

  <!-- 引入 Bootstrap 的 CSS 檔案 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" integrity="sha512-6YRlfqlTKP+w6p+UqV3c6fPq7VpgG6+Iprc+OLIj6pw+hSWRZfY6UaV7eXQ/hGxVrUvj3amJ3Thf5Eu5OV5+aw==" crossorigin="anonymous" />


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
      setTimeout(function() {
        document.getElementById("message").style.display = "none";
      }, 500);
    }
    setTimeout(hideMessage, 3000);
  </script>
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
          <li class="nav-item "><a href="property-1.0.0/index.php" class="nav-link">首頁</a></li>
          <li class="nav-item"><a href="property-1.0.0/camp-information.php" class="nav-link">找小鹿</a></li>
          <li class="nav-item"><a href="all-article.php" class="nav-link">鹿的分享</a></li>
          <li class="nav-item"><a href="equipment.php" class="nav-link">鹿的裝備</a></li>
          <li class="nav-item"><a href="property-1.0.0/ad.php" class="nav-link">廣告方案</a></li>

          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="member.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              帳號
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="property-1.0.0/member.php">會員帳號</a>
              <a class="dropdown-item" href="property-1.0.0/member-like.php">我的收藏</a>
              <a class="dropdown-item" href="property-1.0.0/member-record.php">發表記錄</a>
              <a class="dropdown-item" href="property-1.0.0/myActivityRecord.php">活動紀錄</a>
              <?php
              // 是否為商家帳號
              if ($_COOKIE["accountType"] == "BUSINESS") {
                echo '<a class="dropdown-item" href="property-1.0.0/myCampsite.php">我的營地</a>';
              }
              ?>
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

  <div class="hero page-inner overlay" style="background-image: url('images/Rectangle\ 340.png'); height:70vh; min-height: 300px;">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-12 text-center mt-5">
          <h1 class="heading" data-aos="fade-up">鹿的設備
          </h1>

          <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
            <ol class="breadcrumb text-center justify-content-center">
              <li class="breadcrumb-item"><a href="property-1.0.0/index.php">首頁</a></li>
              <li class="breadcrumb-item active text-white-50" aria-current="page">
                鹿的設備
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <section class="ftco-section ftco-degree-bg mb-4">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 ftco-animate order-md-last">
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

          $labelId = isset($_GET["labelId"]) ? $_GET["labelId"] : null;
          $equipmentType = isset($_GET["equipmentType"]) ? $_GET["equipmentType"] : null;
          $equipment_search_keyword = isset($_GET['equipment_search_keyword']) ? trim($_GET['equipment_search_keyword']) : '';
          $equipment_page = isset($_GET['equipment_page']) ? (int) $_GET['equipment_page'] : 1;

          $result = getEquipments($conn, $labelId, $equipmentType, $equipment_search_keyword, $equipment_page);
          $equipments = $result['equipments'];
          $equipment_total_pages = $result['total_pages'];
          $equipment_current_page = $result['current_page'];

          $count = 0;
          foreach ($equipments as $equipment) {
            // 檢查當前設備是否已收藏
            $isEquipCollected = in_array($equipment["equipmentId"], $collectedEquips);

            // 檢查當前設備是否已按讚
            $isEquipLiked = in_array($equipment["equipmentId"], $likedEquips);

            //取出設備圖片
            $image_src = get_first_image_src($equipment["equipmentDescription"]);
            if ($image_src == "") {
              $image_src = "property-1.0.0/images/image_8.jpg";
            }

            //若文章內容超過30字做限制
            $content_length = mb_strlen(strip_tags($equipment["equipmentDescription"]), 'UTF-8');
            if ($content_length > 30) {
              $truncated_content = mb_substr(strip_tags($equipment["equipmentDescription"]), 0, 30, 'UTF-8') . '...'; // 截斷文章內容
            } else {
              $truncated_content = strip_tags($equipment["equipmentDescription"]);
            }

            if ($count % 2 == 0) {
              echo '<div class="inner" style="display: flex; margin-left: 20px; justify-content: center">';
            }
            $equipmentId = $equipment["equipmentId"];
            $equipmentType = $equipment["equipmentType"];
            $equipmentName = $equipment["equipmentName"];
            $equipmentPrice = $equipment["equipmentPrice"];
            $equipmentLikeCount = $equipment["equipmentLikeCount"];
            echo '<div class="card-eq" style="margin-right: 20px;margin-bottom: 20px; flex: 1;">';
            echo '<img src="' . $image_src . '" class="card-img-top" alt="..." style="width:397px; height:263px;">';
            echo '<div class="card-body-eq"style=" margin-top:0px;">';
            echo '<div class="detail" style="flex-wrap: wrap; display: flex;">';
            echo '<span style="display: flex; align-items: center;">';
            if ($equipmentType === "租") {
              echo '<span class="fa-stack fa-1x" style="margin-right: 5px; ">';
              echo '<i class="fas fa-circle fa-stack-2x" style="color:#EFE9DA; font-size:28px;"></i>';
              echo '<i class="fas fa-stack-1x" style="font-size: 13px;">' . $equipmentType . '</i>';
              echo '</span>';
            } else if ($equipmentType === "徵") {
              echo '<span class="fa-stack fa-1x" style="margin-right: 5px; ">';
              echo '<i class="fas fa-circle fa-stack-2x" style="color:#8d703b; font-size:28px;"></i>';
              echo '<i class="fas fa-stack-1x fa-inverse" style="font-size: 13px;">' . $equipmentType . '</i>';
              echo '</span>';
            } else if ($equipmentType === "賣") {
              echo '<span class="fa-stack fa-1x" style="margin-right: 5px; ">';
              echo '<i class="fas fa-circle fa-stack-2x" style="color:#ba4040; font-size:28px;"></i>';
              echo '<i class="fas fa-stack-1x fa-inverse" style="font-size: 13px;">' . $equipmentType . '</i>';
              echo '</span>';
            }
            echo '<a href="equip-single.php?equipmentId=' . $equipmentId . '">';
            echo '<h5 style="width: 160px;">' . $equipmentName . '</h5>';
            echo '</a>';
            echo '</span>';
            echo '<span class="span-adj" style="justify-content: flex-end; box-sizing: content-box; width: 162px;">';
            echo '<h4 style="margin-left: 24px; ">$' . format_count($equipmentPrice) . '</h4>';
            echo "<form action='equipment.php' method='post'>";
            echo "<input type='hidden' name='" . ($isEquipCollected ? "collectEquipDel" : "collectEquipAdd") . "' value='" . $equipment["equipmentId"] . "'>";
            echo "<button type='submit' class='btn-icon'>";
            echo "<i class='" . ($isEquipCollected ? "fas" : "fa-regular") . " fa-bookmark' " . "></i>";
            echo "</button>";
            echo "</form>";
            echo '</span>';
            echo '</div>';
            echo '<p class="card-text" style="padding: 10px;">';
            echo '' . $truncated_content . '</p>';
            echo '<footer style="margin-top:40px">';
            echo '<div class="card-icon-footer">';
            echo '<div class="tagcloud">';
            $sql_query_labels = "SELECT equipments_labels.labelId, labels.labelName
                      FROM equipments_labels
                      JOIN labels ON equipments_labels.labelId = labels.labelId
                      WHERE equipments_labels.equipmentId = '$equipmentId'";
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
            echo '<form action="equipment.php" method="post">';
            echo '<input type="hidden" name="' . ($isEquipLiked ? "likeEquipDel" : "likeEquipAdd") . '" value="' . $equipment["equipmentId"] . '">';
            echo '<button type="submit" class="btn-icon">';
            echo '<i class="' . ($isEquipLiked ? "fas" : "fa-regular") . ' fa-heart" . " style="margin-left:0px"></i>';
            echo '</button>';
            echo '</form>';
            echo '<p>' . format_count($equipmentLikeCount) . '</p>';
            echo '</span>';
            echo '</div>';
            echo '</footer>';
            echo '</div>';
            echo '</div>';
            if ($count % 2 != 0 || $count == count($equipments) - 1) {
              if ($count % 2 == 0) {
                echo '<div class="card" style="margin-right: 20px;margin-bottom: 20px; flex: 1; visibility: hidden;"></div>';
              }
              echo '</div>';
            }
            $count++;
          }
          ?>

          <div class="row align-items-center py-5">
            <div class="col-lg-3"></div>
            <div class="col-lg-6 text-center">
              <div class="custom-pagination">
                <?php for ($i = 1; $i <= $equipment_total_pages; $i++) : ?>
                  <a href="?equipment_page=<?= $i ?>" <?= ($i == $equipment_current_page) ? 'class="active"' : '' ?>><?= $i ?></a>
                <?php endfor; ?>
              </div>
            </div>
          </div>
        </div>

        <!-- .col-md-8 -->
        <div class="col-lg-4 sidebar ftco-animate">
          <form>

            <div class="input-group " style=" justify-content: flex-start; margin-left: 8px;">
              <button type="submit" class="button-search" style="margin-left: 0px;">
                <i class="fa-solid fa-magnifying-glass"></i>
              </button>
              <div id="navbar-search-autocomplete" class="form-outline" style="margin-left: 6px;">
                <input type="search" id="form1" name="equipment_search_keyword" class="form-control" placeholder="搜尋裝備..." />
                <input type="hidden" name="labelId" value="<?php echo $labelId; ?>">
                <input type="hidden" name="equipmentType" value="<?php echo $equipmentType; ?>">
              </div>
            </div>
          </form>

          <button type="button" class="gray-lg" data-toggle="modal" data-target="#create">
            <h6>出租多餘設備！</h6>
            <div class="verticle-line"></div>
            <a href="property-1.0.0/add-equip.php" style="color:#000">
              <span style="display: flex; align-items: center; justify-content: flex-start">
                <i class="fa-solid fa-circle-plus" style="font-size: 18px;margin-right: 8px;"></i>
                <h6>貼文</h6>
              </span>
            </a>
          </button>
          <div class="sidebar-box ftco-animate mt-4">
            <div class="categories">
              <div class="categories">
                <h3>類別</h3>
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
                <li><a href="equipment.php">全部 <span>(
                      <?php echo $count_all ?>)
                    </span></a></li>
                <li><a href="equipment.php?equipmentType=租">租 <span>(
                      <?php echo $count_rent ?>)
                    </span></a></li>
                <li><a href="equipment.php?equipmentType=徵">徵 <span>(
                      <?php echo $count_request ?>)
                    </span></a></li>
                <li><a href="equipment.php?equipmentType=售">售 <span>(
                      <?php echo $count_sell ?>)
                    </span></a></li>
              </div>
            </div>
          </div>
          <div class="sidebar-box ftco-animate">
            <h3>熱門標籤</h3>
            <div class="tagcloud">
              <?php
              $sql_labels = "SELECT * FROM labels WHERE labelType = '設備'";
              $result_labels = mysqli_query($conn, $sql_labels);
              $labels = [];
              while ($row_labels = mysqli_fetch_assoc($result_labels)) {
                $labels[] = $row_labels;
              }
              foreach ($labels as $label) {
                echo "<a href='equipment.php?labelId=" . $label["labelId"] . "' class=tag-cloud-link'>" . $label['labelName'] . "</a>";
              }
              ?>
            </div>
          </div>
          <div class="sidebar-box ftco-animate">
            <h3>推薦文章</h3>
            <?php
            $top234_article_sql = "SELECT articles.*, accounts.accountName FROM articles JOIN accounts ON articles.accountId = accounts.accountId ORDER BY articleLikeCount DESC LIMIT 1, 3";
            $top234_article_result = mysqli_query($conn, $top234_article_sql);

            if ($top234_article_result && mysqli_num_rows($top234_article_result) > 0) {
              while ($top234_article_row = mysqli_fetch_assoc($top234_article_result)) {
                $articleId = $top234_article_row["articleId"];

                // $files_query = "SELECT * FROM files WHERE articleId = '$articleId'";
                // $files_result = mysqli_query($conn, $files_query);
                // $image_src = '../property-1.0.0/images/Rectangle\ 135.png'; // Default image

                // if ($file_result = mysqli_fetch_assoc($files_result)) {
                //   $file_path = str_replace('Applications/XAMPP/xamppfiles/htdocs', '../..', $file_result['filePath']);
                //   $image_src = '../property-1.0.0/images/Rectangle\ 135.png';
                // }
                // 取得文章圖片
                $article_img_src = get_first_image_src($top234_article_row["articleContent"]);
                if ($article_img_src == '') {
                  $article_img_src = '../property-1.0.0/images/Rectangle\ 135.png';
                }

                $timestamp = strtotime($top234_article_row["articleCreateDate"]);
                $formatted_date = date('F j, Y', $timestamp);

                $query = "SELECT COUNT(*) as comment_count FROM comments WHERE articleId = '$articleId'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $comment_count = $row['comment_count'];

                echo "<div class='block-21 mb-4 d-flex'>
                        <a class='blog-img mr-4' style='background-image: url(" . $article_img_src . ");'></a>
                        <div class='text'>
                        <div>
                            <h3 class='heading'>
                            <a href='article.php?articleId=" . $articleId . "'>" . $top234_article_row["articleTitle"] . "</a></h3>

                            <div class='meta'>
                                <div><a href='article.php?articleId=" . $articleId . "'><span class='icon-calendar'></span> " . $formatted_date . "</a></div>
                                <div><a href='article.php?articleId=" . $articleId . "'><span class='icon-person'></span> " . $top234_article_row["accountName"] . "</a></div>
                                <div><a href='article.php?articleId=" . $articleId . "'><span class='icon-chat'></span> " . $comment_count . "</a></div>
                            </div>
                        </div>
                        </div>
                      </div>";
              }
            }
            ?>
          </div>
        </div>
      </div>
  </section> <!-- .section -->

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
    <!-- /.container -->
  </div>



  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
      <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
      <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
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
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
  <script src="https://kit.fontawesome.com/d02d7e1ecb.js" crossorigin="anonymous"></script>

</body>

</html>