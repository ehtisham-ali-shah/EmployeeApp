<!DOCTYPE html>
<html lang="en">
<body>
<?php
include_once dirname(__DIR__) . "/../database/EmployeeCrud.php";
include_once dirname(__DIR__) . "/../models/Employee.php";
include_once "upload.php";

$id = -1;
$nameErr = $emailErr = $aboutErr = "";
$name = $email = $about = $image = "";
$department = 0;
$title = "Add Employee";

if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["id"])) {
    $title = "Edit Employee";
    $id = $_GET["id"];
    $name = $_GET["name"];
    $email = $_GET["email"];
    $about = $_GET["about"];
    $department = $_GET["dept"];
    $image = $_GET["image"];
}

if (isset($_POST['submit'])) {
    //resetting the values for now as POST resets the values.
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
        $name = $_GET["name"];
        $email = $_GET["email"];
        $about = $_GET["about"];
        $department = $_GET["dept"];
        $image = $_GET["image"];
    }
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
}
?>
<h1><?php echo $title ?></h1>
<form action="" method="post" enctype="multipart/form-data">
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
    About: <input type="text" name="about" style="height: 100px; width: 200px;" value="<?php echo $about; ?>">
    <span class="error">* <?php echo $aboutErr; ?></span>
    <br><br>
    <input type="submit" name="submit" value="Submit">


</form>

</body>
</html>