<?php

require_once '../../config/database.php';

try {
    $db = new PDO("mysql:host=localhost; dbname=nitalink", 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta que une las tablas products, books y courses para obtener todos los detalles relevantes.
    $stmt = $db->prepare("SELECT p.product_id, p.name, p.price, p.quantity, p.discount_percent, p.product_type, 
                                 b.author, b.pages, b.publisher,
                                 c.duration, c.instructor, c.language
                          FROM products p
                          LEFT JOIN books b ON p.product_id = b.product_id
                          LEFT JOIN courses c ON p.product_id = c.product_id");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    include '../../views/products/listProducts.php';
} catch (PDOException $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage();
    exit;
}
?>


