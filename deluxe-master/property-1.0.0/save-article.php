<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();



if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["action"] === "insert") {
    require_once '../../php/conn.php';
    require_once '../../php/uuid_generator.php';
    require_once '../../php/processFile.php';

    $articleTitle = $_POST["articleTitle"];
    $articleContent = $_POST["articleContent"];
    $tags = $_POST['tags'];

    $accountId = $_POST["accountId"];
    $articleId = uuid_generator();

    $sql_query1 = "INSERT INTO articles (articleId, accountId, articleTitle, articleContent, articleCreateDate, articleUpdateDate, articleCollectCount, articleLikeCount) 
            VALUES ('$articleId', '$accountId', '$articleTitle', '$articleContent', now(), now(), 0, 0)";

    if (!mysqli_query($conn, $sql_query1)) {
        echo "Error: " . mysqli_error($conn);
        $_SESSION["system_message"] = "文章新增失敗";
        header("Location: ../all-article.php");
        exit();
    }

    // Process images in the article content and adjust the image paths
    $processedArticleContent = process_and_save_images($articleContent, $conn, $articleId);

    // Update the article content with the processed content
    $sql_query_update = "UPDATE articles SET articleContent = '$processedArticleContent' WHERE articleId = '$articleId'";

    if (!mysqli_query($conn, $sql_query_update)) {
        echo "Error: " . mysqli_error($conn);
        $_SESSION["system_message"] = "文章更新失敗";
        header("Location: ../all-article.php");
        exit();
    }

    // Insert tags into articles_labels table

    foreach ($tags as $tag) {
        $labelId = uuid_generator();
        $insert_label_sql = "INSERT INTO articles_labels (articleLabelId, articleId, labelId) VALUES ('$labelId','$articleId', '$tag')";

        if (!mysqli_query($conn, $insert_label_sql)) {
            // echo "Error: " . mysqli_error($conn);

            $_SESSION["system_message"] = "標籤有誤，文章新增失敗";
            header("Location: ../all-article.php");
            exit();
        }
    }

    $_SESSION["system_message"] = "文章已新增";
    header("Location: ../all-article.php");
    exit();
}
