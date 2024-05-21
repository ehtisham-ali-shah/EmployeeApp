<?php include_once 'controller.php' ?>
<!DOCTYPE html>
<html lang="en">
<body>
<h1><?php echo $title ?></h1>
<form action="controller.php" method="post" enctype="multipart/form-data">
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
    <button type='submit' name='action' value='submit'>Submit</button>
    <br><br>
    <?php if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["id"])) {
        echo "<button type='submit' name='action' value='delete'>Delete Employee</button><br><br>";
    } ?>
</form>
</body>
</html>
