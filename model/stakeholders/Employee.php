<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/model/stakeholders/Person.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/interfaces/Stakeholder.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/exceptions/BuildException.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/model/checkdata/Checker.php');

class Employee extends Person implements Stakeholder {

    protected int $employeeId;
    protected string $department;
    protected float $salary;
    protected DateTime $endContractDate;

    public function __construct(string $name, string $address, string $email, string $phoneNumber, int $employeeId, string $department, float $salary, string $endContractDate) {
        $message = "";
        try {
            parent::__construct($name, $address, $email, $phoneNumber);
        } catch (BuildException $e) {
            $message .= $e->getMessage();
        }
        if ($this->setEmployeeId($employeeId) != 0) {
            $message .= "ID de empleado incorrecto.\n";
        }
        if ($this->setDepartment($department) != 0) {
            $message .= "-Departamento incorrecto.\n";
        }
        if ($this->setSalary($salary) != 0) {
            $message .= "-Salario incorrecto.\n";
        }
        if ($this->setEndContractDate($endContractDate) != 0) {
            $message .= "-Día fin de contrato incorrecto.\n";
        }
        if (strlen($message) > 0) {
            throw new BuildException($message);
        }
    }

    // Getters

    public function getEmployeeId(): int {
        return $this->employeeId;
    }

    public function getDepartment(): string {
        return $this->department;
    }

    public function getSalary(): float {
        return $this->salary;
    }

    public function getEndContractDate(): string {
        return $this->endContractDate;
    }

    public function getDays(): int {
        $currentDate = new DateTime();
        $difference = $currentDate->diff($this->endContractDate);
        return $difference->days;
    }

    // Setters 

    public function setEmployeeId(int $employeeId): int {
        $error = Checker::NumberValidator($employeeId);
        if ($error == 0) {
            $this->employeeId = $employeeId;
        }
        return $error;
    }

    public function setDepartment(string $department): int {
        $error = Checker::StringValidator($department, 2);
        if ($error == 0) {
            $this->department = $department;
        }
        return $error;
    }

    public function setSalary(float $salary): int {
        $error = Checker::NumberValidator($salary);
        if ($error == 0) {
            $this->salary = $salary;
        }
        return $error;
    }

    public function setEndContractDate(string $date): int {
        $error = Checker::checkDate($date);
        if ($error == 0) {
            $this->endContractDate = DateTime::createFromFormat('d/m/Y', $date);
        }
        return $error;
    }

    public function getContactInfo(): string {
        return "Email: {$this->email}, Teléfono: {$this->phoneNumber}";
    }

    public function getDetails(): string {
        return $this->getContactData();
    }

    public function getContactData(): string {
        return "Nombre: {$this->name}, Email: {$this->email}, ID Empleado: {$this->employeeId}, Departamento: {$this->department}, Sueldo: {$this->salary} <br>";
    }
}
