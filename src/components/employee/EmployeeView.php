<?php

include_once dirname(__DIR__) . "/../database/EmployeeCrud.php";
include_once dirname(__DIR__) . "/../models/Employee.php";

$title = "Add Employee";

$GLOBALS['ERR_IMAGE_SIZE'] = "1001";
$GLOBALS['ERR_IMAGE_FORMAT'] = "1002";
$GLOBALS['ERR_IMAGE_ALREADY_EXIST'] = "1003";
$GLOBALS['ERR_IMAGE_NOT_IMAGE'] = "1004";
$GLOBALS['ERR_IMAGE_UPLOAD'] = "1005";

$nameErr = "";
$emailErr = "";
$aboutErr = "";

$id = -1;
$name = null;
$email = null;
$department = null;
$image = null;
$about = null;

if (!empty($_GET["id"])) {
    $title = "Update Employee";
    $id = $_GET["id"];
    //Get employee data from DB
    $inst = new EmployeeCrud();
    $emp = $inst->getEmployeeById($id);
    $name = $emp->getName();
    $email = $emp->getEmail();
    $about = $emp->getAbout();
    $department = $emp->getDepartment();
    $image = $emp->getImage();
    $about = $emp->getAbout();
}

function uploadImage($user_id): string
{
    $target_dir = dirname(__DIR__) . "/../../uploads/";

    $timestamp = time();
    $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
    $new_file_name = 'profile_' . $user_id . '_' . $timestamp . '.' . $imageFileType;
    $target_file = $target_dir . $new_file_name;

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

    if (!$check) {
        return $GLOBALS['ERR_IMAGE_NOT_IMAGE'];
    }

    if (file_exists($target_file)) {
        return $GLOBALS['ERR_IMAGE_ALREADY_EXIST'];
    }

    if ($_FILES["fileToUpload"]["size"] > 500000) {
        return $GLOBALS['ERR_IMAGE_SIZE'];
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        return $GLOBALS['ERR_IMAGE_FORMAT'];
    }

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        return htmlspecialchars($new_file_name);
    } else {
        return $GLOBALS['ERR_IMAGE_UPLOAD'];
    }
}

if (isset($_POST['action'])) {
    $id = $_POST['id'];
    $image = $_POST['image'];
    switch ($_POST['action']) {
        case 'delete':
            $inst = new EmployeeCrud();
            $result = $inst->deleteEmployee($id);
            if ($result) {
                header('location: ../home/HomeView.php');
                exit();
            } else {
                echo "<script> alert('Employee Delete Error!'); </script>";
            }
            break;

        default:
            if ($_POST["name"] == "") {
                $nameErr = "Name is required";
            } else if ($_POST["email"] == "") {
                $emailErr = "Email is required";
            } else {
                if (!isset($_FILES["fileToUpload"]) || $_FILES["fileToUpload"]["error"] != UPLOAD_ERR_OK) {
                    if ($image == "")
                        $imgResp = "NoImage";
                    else
                        $imgResp = $image;
                } else {
                    $imgResp = uploadImage($id);
                }

                $errorMessage = null;
                switch ($imgResp) {
                    case $GLOBALS['ERR_IMAGE_SIZE']:
                        $errorMessage = "Sorry, your file is too large.";
                        break;

                    case $GLOBALS['ERR_IMAGE_FORMAT']:
                        $errorMessage = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        break;

                    case $GLOBALS['ERR_IMAGE_ALREADY_EXIST']:
                        $errorMessage = "Sorry, the file already exists.";
                        break;

                    case $GLOBALS['ERR_IMAGE_NOT_IMAGE']:
                        $errorMessage = "Sorry, File is not an image.";
                        break;

                    default:
                        $obj = new EmployeeCrud();
                        if ($id == -1) {
                            $result = $obj->insertEmployee($_POST['email'], $_POST['name'], $_POST['dept'], $_POST['about'], $imgResp);
                        } else {
                            $result = $obj->updateEmployee($id, $_POST['name'], $_POST['dept'], $_POST['about'], $imgResp);

                        }
                        if ($result) {
                            if ($id == -1) {
                                echo "<script> alert('Employee Added Successfully'); </script>";
                            } else {
                                echo "<script> alert('Employee Updated Successfully'); </script>";
                            }
                            header('location: ../home/HomeView.php');
                            exit();
                        }
                        break;
                }
                if ($errorMessage != null) {
                    echo "<script> alert('$errorMessage') </script>";
                }
            }
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<body>
<h1><?php echo $title ?></h1>

<form style="margin: 16px;" action="" method="POST" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <br><br>
    Name:<input type="text" name="name" style="width: 200px;" value="<?php echo $name; ?>">
    <span class="error">* <?php echo $nameErr; ?></span>
    <br><br>
    Email: <input type="email" name="email" style="width: 200px;" value="<?php echo $email; ?>">
    <span class="error">* <?php echo $emailErr; ?></span>
    <br><br>
    Department: <select name="dept">
        <?php
        include_once dirname(__DIR__) . "/../database/DepartmentCrud.php";
        include_once dirname(__DIR__) . "/../models/Department.php";

        $inst = new DepartmentCrud();
        $result = $inst->getAllDepartments();
        foreach ($result as $dept) {
            if ($dept->getId() == $department) {
                echo "<option selected='selected' value=" . $dept->getId() . ">" . $dept->getName() . "</option>";
            } else {
                echo "<option value=" . $dept->getId() . ">" . $dept->getName() . "</option>";
            }
        }
        ?>
    </select>
    <br><br>
    About: <input type="text" name="about" style="height: 100px; width: 200px;"
                  value="<?php echo $about; ?>">
    <span class="error">* <?php echo $aboutErr; ?></span>
    <br><br>
    <input type='hidden' name='id' value='<?php echo $id; ?>'>
    <input type='hidden' name='image' value='<?php echo $image; ?>'>
    <button type='submit' name='action' value='submit'>Submit</button>
    <br><br>
    <?php if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["id"])) {
        echo "<button type='submit' name='action' value='delete'>Delete Employee</button><br><br>";
    } ?>
</form>
</body>
</html>
