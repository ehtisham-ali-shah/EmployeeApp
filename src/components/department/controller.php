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
