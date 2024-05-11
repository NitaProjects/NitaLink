<?php
declare(strict_types=1);

require_once '../../config/database.php';

// Recolectar datos del formulario
$name = filter_input(INPUT_POST, 'name');
$address = filter_input(INPUT_POST, 'address');
$email = filter_input(INPUT_POST, 'email');
$phoneNumber = (int) filter_input(INPUT_POST, 'phoneNumber');
$employeeId = (int) filter_input(INPUT_POST, 'employeeId');
$department = filter_input(INPUT_POST, 'department');
$salary = (float) filter_input(INPUT_POST, 'salary');

try {
    $db = new PDO("mysql:host=localhost;dbname=nitalink", 'root', '');
    $sql = "UPDATE employees SET name = ?, address = ?, email = ?, phone_number = ?, department = ?, salary = ? WHERE employee_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$name, $address, $email, $phoneNumber, $department, $salary, $employeeId]);

    echo "Empleado actualizado con éxito.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
