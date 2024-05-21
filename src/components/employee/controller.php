<?php

include_once dirname(__DIR__) . "/../database/EmployeeCrud.php";
include_once dirname(__DIR__) . "/../models/Employee.php";
include_once "upload.php";

$id = -1;
$nameErr = $emailErr = $aboutErr = "";
$name = $email = $about = $image = "";
$department = 0;
$title = "Add Employee";

// To Edit an existing employee
if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["id"])) {
    $title = "Edit Employee";
    $id = $_GET["id"];
    $name = $_GET["name"];
    $email = $_GET["email"];
    $about = $_GET["about"];
    $department = $_GET["dept"];
    $image = $_GET["image"];
}

// Form action
if (isset($_POST['action'])) {
    //Resetting the values as POST resets the values.
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
        $name = $_GET["name"];
        $email = $_GET["email"];
        $about = $_GET["about"];
        $department = $_GET["dept"];
        $image = $_GET["image"];
    }

    $action = $_POST['action'];

    switch ($action) {
        case 'delete':
            $inst = new EmployeeCrud();
            $result = $inst->deleteEmployee($id);
            if ($result) {
                echo "<script> alert('Employee Deleted Successfully'); 
                        sessionStorage.setItem('refreshPage', 'true');
                        window.history.go(-2);
                        </script>";
            } else {
                echo "<script> alert('Employee Delete Error!'); </script>";
            }
            break;
        default:
            if (empty($_POST["name"])) {
                $nameErr = "Name is required";
            } else if (empty($_POST["email"])) {
                $emailErr = "Email is required";
            } else if (empty($_POST["about"])) {
                $aboutErr = "About is required";
            } else {
                if (!isset($_FILES["fileToUpload"]) || $_FILES["fileToUpload"]["error"] != UPLOAD_ERR_OK) {
                    if ($image == "")
                        $imgResp = "NoImage";
                    else
                        $imgResp = $image;
                } else {
                    $imgResp = uploadImage($id);
                }
                if (!str_starts_with($imgResp, "Sorry")) {
                    $obj = new EmployeeCrud();
                    if ($id === -1) {
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
                        echo "<script>
                        sessionStorage.setItem('refreshPage', 'true');
                        window.history.go(-2);
                      </script>";
                    }
                } else {
                    echo "<script> 
                    alert('$imgResp') 
                    window.history.go(-1);
                  </script>";
                }
            }
            break;
    }
}
