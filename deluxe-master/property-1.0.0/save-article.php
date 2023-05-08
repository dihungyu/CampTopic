
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
function process_images($content, $conn, $articleId)
{
    // 匹配文章內容中的圖片URL
    preg_match_all('/src="([^"]+)"/i', $content, $matches);

    $images = $matches[1];

    foreach ($images as $image) {
        if (substr($image, 0, 5) === 'data:') {
            // Process data URLs
            $fileId = uuid_generator();
            $upload_dir = "../../upload/";
            $image_parts = explode(";base64,", $image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            // Save the decoded image to the uploads directory
            $fileName = $fileId . '.' . $image_type;
            $file_path = $upload_dir . $fileName;
            file_put_contents($file_path, $image_base64);

            $fileSize = round(filesize($file_path) / 1024, 2); //KB

            $sql_query2 = "INSERT INTO files (fileId, articleId, fileName, fileExtensionName, filePath, fileSize, fileCreateDate, filePathType)
            VALUES ('$fileId', '$articleId', '$fileName', '$image_type', '$file_path', $fileSize, now(), 'article')";

            if (!mysqli_query($conn, $sql_query2)) {
                echo "Error: " . mysqli_error($conn);
            }
            // Replace the image src attribute with the fileId
            $content = str_replace($image, '../upload/' . $fileName, $content);
        }
    }

    return $content;
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["action"] === "insert") {
    require_once '../../php/conn.php';
    require_once '../../php/uuid_generator.php';

    $articleTitle = $_POST["articleTitle"];
    $articleContent = $_POST["articleContent"];
    $tags = $_POST['tags'];

    $accountId = $_POST["accountId"];
    $articleId = uuid_generator();

    // Process images in the article content
    $articleContent = process_images($articleContent, $conn, $articleId);

    $sql_query1 = "INSERT INTO articles (articleId, accountId, articleTitle, articleContent, articleCreateDate, articleUpdateDate, articleCollectCount, articleLikeCount) 
            VALUES ('$articleId', '$accountId', '$articleTitle', '$articleContent', now(), now(), 0, 0)";

    if (!mysqli_query($conn, $sql_query1)) {
        echo "Error: " . mysqli_error($conn);
        $_SESSION["system_message"] = "文章新增失敗";
        header("Location: ../all-article.php");
        exit(); // Add this line
    }

    // Insert tags into articles_labels table
    /*foreach ($tags as $tag) {
        $labelId = uuid_generator();
        $insert_label_sql = "INSERT INTO articles_labels (articleLabelId, articleId, labelId) VALUES ('$labelId','$articleId', '$tag')";

        if (!mysqli_query($conn, $insert_label_sql)) {
            // echo "Error: " . mysqli_error($conn);

            $_SESSION["system_message"] = "標籤有誤，文章新增失敗";
            header("Location: ../all-article.php");
            exit();
        }
    }
*/
    $_SESSION["system_message"] = "文章已新增";
    header("Location: ../all-article.php");
    exit();
}
