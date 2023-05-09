<?php
function process_and_save_images($content, $conn, $articleId)
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

            $sql_query2 = "INSERT INTO files (fileId, articleId, fileName, fileExtensionName, filePath, fileSize, fileCreateDate, fileUpdateDate, filePathType)
            VALUES ('$fileId', '$articleId', '$fileName', '$image_type', '$file_path', $fileSize, now(), now(), 'article')";

            if (!mysqli_query($conn, $sql_query2)) {
                echo "Error: " . mysqli_error($conn);
            }
            // Replace the image src attribute with the fileId
            $content = str_replace($image, '../upload/' . $fileName, $content);
        }
    }

    return $content;
}
