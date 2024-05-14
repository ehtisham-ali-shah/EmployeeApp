<?php
include 'DatabaseManager.php';
include '../models/Employee.php';

class EmployeeCrud
{

    function getAllEmployees(): array
    {
        $conn = establishConnection();
        $employees = [];

        try {
            $result = $conn->query("SELECT * FROM employee");
            if ($result && $result->num_rows > 0) {
                $data = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($data as $employee) {
                    $temp = new Employee();
                    $temp->setId($employee["id"]);
                    $temp->setName($employee["name"]);
                    $temp->setEmail($employee["email"]);
                    $temp->setDepartment($employee["department_id"]);
                    $temp->setImage($employee["picture"]);
                    $employees[] = $temp;
                }
                print_r($employees);
                return $employees;
            }
        } catch (exception $e) {
            echo $e->getMessage();
        } finally {
            $conn->close();
        }
        return $employees;
    }

    function insertEmployee($email, $name, $department_id, $picture): bool
    {
        $conn = establishConnection();
        try {
            //Todo: save picture
            $result = $conn->query("INSERT INTO employee (email,name,department_id,picture) VALUES ('$email','$name','$department_id','NoImage')");
        } catch (exception $e) {
            echo $e->getMessage();
        } finally {
            $conn->close();
        }
        return (bool)$result;
    }

    function updateEmployee($id, $email, $name, $department_id, $picture): bool|null
    {
        $conn = establishConnection();
        try {
            $employee = $conn->query("SELECT * FROM employee WHERE email = '$email'");
            if ($employee && $employee->num_rows > 0) {
                $result = $employee->fetch_assoc();
                $updatedEmployee = $result[0];
                if ($updatedEmployee['name'] !== $name)
                    $updatedEmployee['name'] = $name;
                if ($updatedEmployee['department_id'] !== $department_id)
                    $updatedEmployee['department_id'] = $department_id;
                if ($updatedEmployee['picture'] !== $picture)
                    $updatedEmployee['picture'] = $picture;
                $result = $conn->query("UPDATE employee SET $updatedEmployee WHERE email = '$email'");
                if ($result) {
                    return $updatedEmployee;
                }
            }
        } catch (exception $e) {
            echo $e->getMessage();
        } finally {
            $conn->close();
        }
        return null;
    }

    function deleteEmployee($id): bool|null
    {
        $conn = establishConnection();
        try {
            $result = $conn->query("DELETE FROM employee WHERE id = '$id'");
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            $conn->close();
        }
        return (bool)$result;
    }
}

$inst = new EmployeeCrud();
$inst->deleteEmployee(1);
$inst->getAllEmployees();
