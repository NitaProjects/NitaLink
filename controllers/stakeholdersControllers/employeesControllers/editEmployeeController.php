<?php
declare(strict_types=1);

require_once '../../config/database.php';
$employeeId = filter_input(INPUT_GET, 'employeeId', FILTER_SANITIZE_NUMBER_INT);

try {
    $db = new PDO("mysql:host=localhost;dbname=nitalink", 'root', '');
    $stmt = $db->prepare("SELECT * FROM employees WHERE employee_id = ?");
    $stmt->execute([$employeeId]);
    $employeeData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Pasar los datos a la vista
    include '../../views/stakeholders/editEmployee.php';  // La página que contiene el formulario de edición
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


