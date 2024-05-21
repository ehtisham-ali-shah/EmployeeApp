<?php
include_once dirname(__DIR__) . "/../database/DepartmentCrud.php";


$nameErr = '';

if (isset($_POST['submit'])) {
    if (!empty($_POST["name"])) {
        $obj = new DepartmentCrud();
        $result = $obj->addDepartment($_POST['name']);
        if ($result) {
            echo "<script>
             alert('Department added successfully!');
             window.history.go(-2);
            </script>";
        }
    } else {
        $nameErr = "Name is required";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<body>
<h1>Add a new department</h1>

<form method="POST" action="">
    Department Name: <input type="text" name="name">
    <span class="error">* <?php echo $nameErr; ?></span>
    <br><br>
    <input type="submit" name="submit" value="Add department" formaction="">
</form>

</body>
</html>