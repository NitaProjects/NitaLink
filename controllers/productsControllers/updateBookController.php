<?php
declare(strict_types=1);

require_once '../../config/database.php';

// Recolectar los datos del formulario
$productId = filter_input(INPUT_POST, 'productId', FILTER_VALIDATE_INT);
$name = filter_input(INPUT_POST, 'name');
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
$author = filter_input(INPUT_POST, 'author');
$pages = filter_input(INPUT_POST, 'pages', FILTER_VALIDATE_INT);
$publisher = filter_input(INPUT_POST, 'publisher');

try {
    $db = new PDO("mysql:host=localhost;dbname=nitalink", 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->beginTransaction(); // Inicia una transacción

    // Actualizar información en la tabla 'products'
    $sqlProducts = "UPDATE products SET name = ?, price = ?, quantity = ? WHERE product_id = ?";
    $stmtProducts = $db->prepare($sqlProducts);
    $stmtProducts->execute([$name, $price, $quantity, $productId]);

    // Actualizar información en la tabla 'books'
    $sqlBooks = "UPDATE books SET author = ?, pages = ?, publisher = ? WHERE product_id = ?";
    $stmtBooks = $db->prepare($sqlBooks);
    $stmtBooks->execute([$author, $pages, $publisher, $productId]);

    if ($stmtProducts->rowCount() > 0 || $stmtBooks->rowCount() > 0) {
        $db->commit();  // Confirma la transacción
        echo "Libro actualizado con éxito.";
    } else {
        echo "No se encontraron libros para actualizar o no se cambiaron los datos.";
    }
} catch (PDOException $e) {
    $db->rollBack(); // Revierte la transacción
    echo "Error al actualizar el libro: " . $e->getMessage();
}
?>
