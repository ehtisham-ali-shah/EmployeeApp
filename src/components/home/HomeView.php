<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
        }

        th, td {
            text-align: left;
            padding: 16px;
            align-content: center;
        }
    </style>
</head>
<body>
<h1 style='margin: 16px;'>Home</h1>

<div>
    <button style='margin: 16px;' type='button' onclick="document.location.href='../department/DepartmentView.php';">Add Database</button>
    <button style='margin: 16px;' type='button' onclick="document.location.href='../employee/EmployeeView.php';">Add Employee</button>
</div>

<br><br>

<table>
    <tr>
        <th>No.</th>
        <th>Profile Image</th>
        <th>Employee Name</th>
        <th>Department</th>
        <th>Actions</th>
    </tr>

    <?php
    include_once dirname(__DIR__) . "/../database/EmployeeCrud.php";
    include_once dirname(__DIR__) . "/../models/Employee.php";
    include_once dirname(__DIR__) . "/../database/DepartmentCrud.php";

    $allDepts = (new DepartmentCrud())->getAllDepartments();
    $depts = [];
    foreach ($allDepts as $dept) {
        $depts[$dept->getId()] = $dept->getName();
    }

    $inst = new EmployeeCrud();
    $employees = $inst->getAllEmployees();
    foreach ($employees as $index => $employee) {
        $id = $employee->getId();
        $name = $employee->getName();
        $deptId = $employee->getDepartment();
        $image = $employee->getImage();

        if ($employee->getImage() == "NoImage") {
            $imageName = "default.png";
        } else {
            $imageName = $employee->getImage();
        }
        $image = htmlspecialchars("../../../uploads/" . $imageName);
        echo "<tr>";
        echo "<td>" . $index + 1 . "</td>";
        echo "<td><img src='$image' alt='Profile image' width='50' height='50' style='margin-right: 16px;'></td>";
        echo "<td>" . $name . "</td>";
        echo "<td>" . $depts[$deptId] . "</td>";
        echo "<td>";
        echo "<form action='HomeController.php' method='POST'>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "<input type='submit' name='action' value='Edit' style='height: 24px;align-self: center;margin-left: 8px;margin-right: 8px;'>";
        echo "<input type='submit' name='action' value='Delete' style='height: 24px;align-self: center;margin-left: 8px;margin-right: 8px;' /><br>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
</table>
</body>
</html>

