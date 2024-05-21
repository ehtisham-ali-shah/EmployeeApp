<?php
function uploadImage($user_id): string
{
    // Location
    $target_dir = dirname(__DIR__) . "/../../uploads/";

    // Generate a unique file name based on user ID and current timestamp
    $timestamp = time();
    $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
    $new_file_name = 'profile_' . $user_id . '_' . $timestamp . '.' . $imageFileType;

    // Full path for the new file
    $target_file = $target_dir . $new_file_name;

    // Validate image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if (!$check) {
            return "Sorry, File is not an image.";
        }

        // Check if file already exists (this is unlikely due to the unique name)
        if (file_exists($target_file)) {
            return "Sorry, file already exists.";
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            return "Sorry, your file is too large.";
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }

        // Upload file
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            return htmlspecialchars($new_file_name);
        } else {
            return "Sorry, there was an error uploading your file.";
        }
    }
    return "Sorry, your file was not uploaded.";
}
