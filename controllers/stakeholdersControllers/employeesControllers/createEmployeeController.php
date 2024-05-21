<?php

declare(strict_types=1);

//ARREGLAR!!
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/config/Database.php');

// Recolectar los datos del formulario
$name = filter_input(INPUT_POST, 'name');
$address = filter_input(INPUT_POST, 'address');
$email = filter_input(INPUT_POST, 'email');
$phoneNumber = (int) filter_input(INPUT_POST, 'phoneNumber');
$employeeId = (int) filter_input(INPUT_POST, 'employeeId');
$department = filter_input(INPUT_POST, 'department');
$salary = (float) filter_input(INPUT_POST, 'salary');

// Instanciar el objeto Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();

try {
    if (!$name or !$address or !$email or !$phoneNumber or !$employeeId or !$department or !isset($salary)) {
        throw new Exception("Por favor, complete todos los campos requeridos.");
    }

    // Preparar la consulta SQL
    $sql = "INSERT INTO employees (id, name, address, email, phone_number, department, salary) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);

    // Vincular los parámetros
    $stmt->bind_param("isssisd", $employeeId, $name, $address, $email, $phoneNumber, $department, $salary);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Empleado creado con éxito y datos guardados en la base de datos.<br>";
    } else {
        throw new Exception("Error al insertar datos en la base de datos: " . $stmt->error);
    }

    // Crear el objeto Employee
    $employee = new Employee($name, $address, $email, $phoneNumber, $employeeId, $department, $salary);
    echo "Datos del Empleado: <br>" . $employee->getContactData();
} catch (Exception $e) {
    echo "Error al crear el empleado: " . $e->getMessage();
} finally {
    $stmt->close();
    $db->close();
}
?>



