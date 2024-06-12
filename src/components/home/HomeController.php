<?php
include_once dirname(__DIR__) . "/../database/EmployeeCrud.php";
include_once dirname(__DIR__) . "/../models/Employee.php";

class HomeController
{
    public $action = '';
    public $id = '';

    function submitForm(): void
    {
        switch ($this->action) {
            case 'Delete':
                $inst = new EmployeeCrud();
                $result = $inst->deleteEmployee($this->id);
                if ($result) {
                    echo "<script>
             alert('Employee deleted successfully!');
             window.history.go(-1);
            </script>";
                } else {
                    echo "<script>
             alert('Something went wrong!');
             window.history.go(-1);
            </script>";
                }
                break;
            case 'Edit':
                header('Location: ' . '../employee/EmployeeView.php?id=' . $this->id);
                exit();
            default:
                echo "Unknown action";
                break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inst = new HomeController();
    $inst->action = $_POST['action'];
    $inst->id = $_POST['id'];
    $inst->submitForm();
}
