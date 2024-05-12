<?php
declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');

// Recolectar los datos del formulario
$productId = filter_input(INPUT_POST, 'productId', FILTER_VALIDATE_INT);
$name = filter_input(INPUT_POST, 'name');
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
$duration = filter_input(INPUT_POST, 'duration', FILTER_VALIDATE_INT);
$instructor = filter_input(INPUT_POST, 'instructor');
$language = filter_input(INPUT_POST, 'language');

try {
    $db = new PDO("mysql:host=localhost;dbname=nitalink", 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->beginTransaction(); // Inicia una transacción

    // Actualizar información en la tabla 'products'
    $sqlProducts = "UPDATE products SET name = ?, price = ?, quantity = ? WHERE product_id = ?";
    $stmtProducts = $db->prepare($sqlProducts);
    $stmtProducts->execute([$name, $price, $quantity, $productId]);

    // Actualizar información en la tabla 'courses'
    $sqlCourses = "UPDATE courses SET duration = ?, instructor = ?, language = ? WHERE product_id = ?";
    $stmtCourses = $db->prepare($sqlCourses);
    $stmtCourses->execute([$duration, $instructor, $language, $productId]);

    if ($stmtProducts->rowCount() > 0 || $stmtCourses->rowCount() > 0) {
        $db->commit();  // Confirma la transacción
        echo "Curso actualizado con éxito.";
    } else {
        echo "No se encontraron cursos para actualizar o no se cambiaron los datos.";
    }
} catch (PDOException $e) {
    $db->rollBack(); // Revierte la transacción
    echo "Error al actualizar el curso: " . $e->getMessage();
}
?>



