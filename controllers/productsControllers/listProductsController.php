<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/database.php');

try {
    $db = new PDO("mysql:host=localhost; dbname=nitalink2", 'root', '');
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

    require_once ($_SERVER['DOCUMENT_ROOT'].'nitalink/views/products/listProducts.php');
} catch (PDOException $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage();
    exit;
}
?>


