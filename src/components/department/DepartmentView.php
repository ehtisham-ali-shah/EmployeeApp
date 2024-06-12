<?php
include_once dirname(__DIR__) . "/../database/DepartmentCrud.php";

$nameErr = '';

if (isset($_POST['submit'])) {
    if (!empty($_POST["name"])) {
        $obj = new DepartmentCrud();
        $result = $obj->addDepartment($_POST['name']);
        if ($result) {
            echo "<script> alert('Department added successfully!');</script>";
            header("location: ../home/HomeView.php");
            exit();
        }else{
            $nameErr = "Department already exists!";
        }
    } else {
        $nameErr = "Name is required";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<body>
<h1>Add Department</h1>

<form style="margin: 16px;" method="POST" action="">
    Department Name: <input type="text" name="name">
    <span class="error">* <?php echo $nameErr; ?></span>
    <br><br>
    <input type="submit" name="submit" value="Add department">
</form>

</body>
</html>