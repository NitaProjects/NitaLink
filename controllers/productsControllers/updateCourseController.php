<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/persistence/MysqlProductAdapter.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/model/products/Course.php');

$adapter = new MysqlProductAdapter();

// Recoger los datos del formulario usando filter_input
$product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
$duration = filter_input(INPUT_POST, 'duration', FILTER_VALIDATE_INT);
$instructor = filter_input(INPUT_POST, 'instructor', FILTER_SANITIZE_STRING);
$language = filter_input(INPUT_POST, 'language', FILTER_SANITIZE_STRING);

try {
    $product = new Course($product_id, $name, $price, $quantity, $duration, $instructor, $language);
    $success = $adapter->updateCourse($product);

    if ($success) {
        header("Location: ../../views/stakeholders/employees/gestionProductos.php?update=success");
        exit;
    } else {
        header("Location: ../../views/stakeholders/employees/gestionProductos.php?update=fail");
        exit;
    }
} catch (Exception $e) {
    $errorMessage = "Error al actualizar el curso:\n\n " . $e->getMessage();
    header('Location: ../../views\stakeholders\error.php');
    exit;
}
?>
