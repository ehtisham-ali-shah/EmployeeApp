<?php
include_once dirname(__DIR__) . "/../database/EmployeeCrud.php";
include_once dirname(__DIR__) . "/../models/Employee.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'];

    switch ($action) {
        case 'delete':
            $inst = new EmployeeCrud();
            $result = $inst->deleteEmployee($id);
            if ($result) {
                echo "success";
            }
            break;
        case 'edit':
            // Handle action 2
            echo "success";
            break;
        default:
            echo "Unknown action";
            break;
    }
}
?>