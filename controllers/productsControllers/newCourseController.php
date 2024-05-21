<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/persistence/MysqlProductAdapter.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/model/products/Course.php');

$adapter = new MysqlProductAdapter();

// Recoger los datos del formulario usando filter_input
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
$duration = filter_input(INPUT_POST, 'duration', FILTER_VALIDATE_INT);
$instructor = filter_input(INPUT_POST, 'instructor', FILTER_SANITIZE_STRING);
$language = filter_input(INPUT_POST, 'language', FILTER_SANITIZE_STRING);

$lastProductId = $adapter->maxProductid();
$productId = $lastProductId + 1;

try {
    $course = new Course($productId, $name, $price, $quantity, $duration, $instructor, $language);
    $success = $adapter->addCourse($course);

    if ($success) {
        header("Location: ../../views/stakeholders/employees/gestionProductos.php?add=success");
        exit;
    } else {
        header("Location: ../../views/stakeholders/employees/gestionProductos.php?add=fail");
        exit;
    }
} catch (Exception $e) {
    $errorMessage = "Error al registrar el cliente:\n\n " . $e->getMessage();
    include '../../views\stakeholders\error.php';
    exit;
}
?>

