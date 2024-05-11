<?php
declare(strict_types=1);

require_once '../../model/stakeholders/Employee.php';
require_once '../../model/checkdata/Checker.php';

// Recuperación de datos del formulario
$name = filter_input(INPUT_POST, 'name');
$address = filter_input(INPUT_POST, 'address');
$email = filter_input(INPUT_POST, 'email');
$phoneNumber = filter_input(INPUT_POST, 'phoneNumber');
$employeeId = filter_input(INPUT_POST, 'employeeId');
$department = filter_input(INPUT_POST, 'department');
$salary = filter_input(INPUT_POST, 'salary', FILTER_VALIDATE_FLOAT);
$endContractDate = filter_input(INPUT_POST, 'contractDate');  
if ($salary == false || $salary == null) {
$salary = -7000;}
try {
   
    $employee = new Employee($name, $address, $email, $phoneNumber, 2, $department, $salary, $endContractDate);
    
    echo "Empleado registrado con éxito:<br>" . $employee->getDetails(); 
    echo "Al empleado le quedan: ".$employee->getDays(). " días de contrato.";
} catch (Exception $ex) {
    echo "Error al registrar al empleado:<br>" . $ex->getMessage();
}
