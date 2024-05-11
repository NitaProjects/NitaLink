<?php
declare(strict_types=1);

require_once '../../model/products/Course.php';
require_once '../../model/checkdata/Checker.php'; 

// Recuperación de datos del formulario
$name = filter_input(INPUT_POST, 'name');
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$productId = 3;
$quantity = filter_input(INPUT_POST, 'quantity');
$duration = filter_input(INPUT_POST, 'duration');
$instructor = filter_input(INPUT_POST, 'instructor');
$language = filter_input(INPUT_POST, 'language');

if ($price == false) {
    $price = -3.0; 
}
if ($quantity == false) {
    $quantity = -3; 
}
if ($duration == false) {
    $duration = -3; 
}


try {
    // Intenta crear el objeto Course
    $course = new Course($productId, $name, $price, $quantity, $duration, $instructor, $language);
    echo "Curso registrado con éxito: <br>" . $course->getDetails(); 
} catch (Exception $ex) {
    echo "Error al registrar el curso: <br>" . $ex->getMessage();
}
