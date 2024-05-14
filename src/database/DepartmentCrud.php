<?php
include 'DatabaseManager.php';
include '../models/Department.php';

class DepartmentCrud
{
    public array $departments;

    function getAllDepartments(): array
    {
        $conn = establishConnection();
        try {
            $result = $conn->query("SELECT * FROM `department`");
            if ($result && $result->num_rows > 0) {
                $data = $result->fetch_all();
                foreach ($data as $department) {
                    $temp = new Department();
                    $temp->setId($department[0]);
                    $temp->setName($department[1]);
                    $this->departments[] = $temp;
                }
                print_r($this->departments);
                return $this->departments;
            }
        } catch (exception $e) {
            echo $e->getMessage();
        } finally {
            $conn->close();
        }
        return [];
    }

    function addDepartment(string $name): bool
    {
        $conn = establishConnection();
        try {
            $result = $conn->query("INSERT INTO `department` (`name`) VALUES ('$name')");
        } catch (exception $e) {
            echo $e->getMessage();
        } finally {
            $conn->close();
        }
        return (bool)$result;
    }
}

$temp = new DepartmentCrud();
$temp->getAllDepartments();
