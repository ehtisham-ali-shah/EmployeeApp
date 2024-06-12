<?php
include_once 'DatabaseManager.php';
include_once dirname(__DIR__) . '/models/Department.php';

class DepartmentCrud
{

    function getAllDepartments(): array
    {
        $conn = establishConnection();
        $departments = [];
        try {
            $result = $conn->query("SELECT * FROM `department`");
            if ($result && $result->num_rows > 0) {
                $data = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($data as $department) {
                    $temp = new Department();
                    $temp->setId($department["id"]);
                    $temp->setName($department["name"]);
                    $departments[] = $temp;
                }
                return $departments;
            }
        } catch (exception $e) {
            echo $e->getMessage();
        } finally {
            $conn->close();
        }
        return $departments;
    }

    function addDepartment(string $name): bool
    {
        $conn = establishConnection();
        try {
            $result = $conn->query("INSERT INTO `department` (`name`) VALUES ('$name')");
        } catch (exception $e) {
            return false;
        } finally {
            $conn->close();
        }
        return (bool)$result;
    }
}
