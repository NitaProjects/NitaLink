<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlProductAdapter.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/products/Course.php');

$adapter = new MysqlProductAdapter();

// Recoger los datos del formulario usando filter_input
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
$duration = filter_input(INPUT_POST, 'duration', FILTER_VALIDATE_INT);
$instructor = filter_input(INPUT_POST, 'instructor', FILTER_SANITIZE_STRING);
$language = filter_input(INPUT_POST, 'language', FILTER_SANITIZE_STRING);

try {
    $course = new Course($name, $price, $quantity, null, $duration, $instructor, $language);
    $success = $adapter->addCourse($course);

    if ($success) {
        header("Location: ../../../views/products/gestionProductos.php?add=success");
        exit;
    } else {
        header("Location: ../../../views/products/gestionProductos.php?add=fail");
        exit;
    }
} catch (Exception $e) {
    header("Location: ../../../views/products/gestionProductos.php?error=" . urlencode($e->getMessage()));
    exit;
}
?>

