<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/Employee.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlAdapter.php');

class MysqlEmployeeAdapter extends MysqlAdapter {

    public function getEmployee(int $employeeId): Employee {
        $data = $this->readQuery("SELECT employeeId, name, address, email, phoneNumber, department, salary, contractDate FROM employees WHERE employeeId = " . $employeeId . ";");
        if (count($data) > 0) {
            return new Employee($data[0]["name"], $data[0]["address"], $data[0]["email"], $data[0]["phoneNumber"],
                                (int) $data[0]["employeeId"], $data[0]["department"], (float) $data[0]["salary"], $data[0]["contractDate"]);
        } else {
            throw new ServiceException("No Employee found with employeeId = " . $employeeId);
        }
    }

    public function deleteEmployee(int $employeeId): bool {
        try {
            return $this->writeQuery("DELETE FROM employees WHERE employeeId = " . $employeeId . ";");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error al borrar al empleado " . $employeeId . "-->" . $ex->getMessage());
        }
    }

    public function addEmployee(Employee $e): bool {
        try {
            return $this->writeQuery("INSERT INTO employees (employeeId, name, address, email, phoneNumber, department, salary, contractDate) VALUES (" . 
                    $e->getEmployeeId() . ", \"" . $e->getName() . "\", \"" . $e->getAddress() . "\", \"" . $e->getEmail() . "\", \"" . 
                    $e->getPhoneNumber() . "\", \"" . $e->getDepartment() . "\", " . $e->getSalary() . ", \"" . $e->getContractDate() . "\");");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error al insertar empleado -->" . $ex->getMessage());
        }
    }

    public function updateEmployee(Employee $e): bool {
        try {
            return $this->writeQuery("UPDATE employees SET name = \"" . $e->getName() . "\", address = \"" . $e->getAddress() . 
                    "\", email = \"" . $e->getEmail() . "\", phoneNumber = \"" . $e->getPhoneNumber() . "\", department = \"" . 
                    $e->getDepartment() . "\", salary = " . $e->getSalary() . ", contractDate = \"" . $e->getContractDate() . 
                    "\" WHERE employeeId = " . $e->getEmployeeId() . ";");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error al actualizar empleado -->" . $ex->getMessage());
        }
    }
}
