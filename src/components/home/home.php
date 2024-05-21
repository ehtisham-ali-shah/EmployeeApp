<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js">
        if (sessionStorage.getItem('refreshPage') === 'true') {
            sessionStorage.removeItem('refreshPage');
            window.location.reload();
        }
    </script>
</head>
<body>
<h1 style='margin: 16px;'>Home</h1>
<button style='margin: 16px;' type='button' onclick="document.location.href='../employee/employee.php';">Add Employee
</button>
<button style='margin: 16px;' type='button' onclick="document.location.href='../department/department.php';">Add
    Department
</button>

<?php
include_once dirname(__DIR__) . "/../database/EmployeeCrud.php";
include_once dirname(__DIR__) . "/../models/Employee.php";

$inst = new EmployeeCrud();
$employees = $inst->getAllEmployees();

echo "<div style='margin: 16px;'>";
foreach ($employees as $employee) {
    if($employee->getImage() == "NoImage"){
        $imageName = "default.png";
    }else{
        $imageName = $employee->getImage();
    }
    $image = htmlspecialchars("../../../uploads/".$imageName);
    echo "<div style='background-color:mintcream; height:50px;width: 100%;align-content: center; display: flex; flex-direction: row;'>";
    echo "<img src='$image' alt='Profile image' width='50' height='50' style='margin-right: 16px;'>";
    echo "<h3>" . $employee->getName() . "</h3>";

    $id = $employee->getId();
    $name = $employee->getName();
    $email = $employee->getEmail();
    $about = $employee->getAbout();
    $dept = $employee->getDepartment();
    $image = $employee->getImage();

    echo "<button class='button' data-action = 'edit' data-id=\"$id\" data-name=\"$name\" data-email=\"$email\" data-about=\"$about\" data-dept=\"$dept\" data-image=\"$image\" style='height: 24px;align-self: center;margin-left: 8px;margin-right: 8px;'>Edit</button>";
    echo "<button class='button' data-action = 'delete' data-id=\"$id\" style='height: 24px;align-self: center;margin-left: 8px;margin-right: 8px;'>Delete</button><br>";
    echo "</div><br><br>";
}
echo "</div>";
?>

<script>
    $('.button').click(function () {
        let action = $(this).data('action');
        let id = $(this).data('id');
        let name = $(this).data('name');
        let email = $(this).data('email');
        let about = $(this).data('about');
        let dept = $(this).data('dept');
        let image = $(this).data('image');

        $.ajax({
            type: "POST",
            url: "controller.php",
            data: {action: action, id: id}
        }).done(function (msg) {
            if (msg === 'success') {
                if (action === 'edit') {
                    location.href = `/project/src/components/employee/employee.php?id=${id}&name=${name}&email=${email}&dept=${dept}&about=${about}&image=${image}`;
                } else if (action === 'delete') {
                    alert("User deleted successfully!");
                    window.location.reload();
                }
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.error("Error: " + textStatus, errorThrown);
        });
    });
</script>
</body>
</html>