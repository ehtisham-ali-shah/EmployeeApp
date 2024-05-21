<?php
include_once 'dbmanager.php';
include_once dirname(__DIR__) . '/models/Employee.php';

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
                    $temp->setAbout($employee["about"]);
                    $employees[] = $temp;
                }
                return $employees;
            }
        } catch (exception $e) {
            echo $e->getMessage();
        } finally {
            $conn->close();
        }
        return $employees;
    }

    function insertEmployee($email, $name, $department_id, $about, $picture): bool
    {
        $conn = establishConnection();
        try {
            $result = $conn->query("INSERT INTO employee (email,name,department_id,about,picture) VALUES ('$email','$name','$department_id','$about','$picture')");
        } catch (exception $e) {
            echo $e->getMessage();
        } finally {
            $conn->close();
        }
        return (bool)$result;
    }

    function updateEmployee($id, $name, $department_id, $about, $picture): bool
    {
        $conn = establishConnection();
        try {
            $employee = $conn->query("SELECT * FROM employee WHERE id = '$id'");
            if ($employee && $employee->num_rows > 0) {
                $result = $conn->query("UPDATE employee SET name='$name',department_id=$department_id,about='$about',picture='$picture' WHERE id = $id");
                if ($result) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (exception $e) {
            echo $e->getMessage();
        } finally {
            $conn->close();
        }
        return false;
    }

    function deleteEmployee($id): bool|null
    {
        $conn = establishConnection();
        try {
            $result = $conn->query("DELETE FROM employee WHERE id = $id");
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            $conn->close();
        }
        return (bool)$result;
    }
}
