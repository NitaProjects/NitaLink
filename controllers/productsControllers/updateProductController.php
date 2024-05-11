<?php
declare(strict_types=1);

require_once '../../config/database.php';
$productId = filter_input(INPUT_GET, 'productId', FILTER_SANITIZE_NUMBER_INT);

try {
    $db = new PDO("mysql:host=localhost;dbname=nitalink", 'root', '');
    // Primero obtenemos el tipo de producto para saber cómo proceder
    $typeStmt = $db->prepare("SELECT product_type FROM products WHERE product_id = ?");
    $typeStmt->execute([$productId]);
    $typeResult = $typeStmt->fetch(PDO::FETCH_ASSOC);

    if (!$typeResult) {
        throw new Exception("Producto no encontrado.");
    }

    $productType = $typeResult['product_type'];

    // Ahora, basado en el tipo de producto, cargamos los datos adicionales y mostramos la vista correcta
    switch ($productType) {
        case 'book':
            $stmt = $db->prepare("SELECT p.*, b.author, b.pages, b.publisher FROM products p JOIN books b ON p.product_id = b.product_id WHERE p.product_id = ?");
            $stmt->execute([$productId]);
            $productData = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$productData) {
                throw new Exception("Libro no encontrado.");
            }
            include '../../views/products/editBook.php';
            break;
        case 'course':
            $stmt = $db->prepare("SELECT p.*, c.duration, c.instructor, c.language FROM products p JOIN courses c ON p.product_id = c.product_id WHERE p.product_id = ?");
            $stmt->execute([$productId]);
            $productData = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$productData) {
                throw new Exception("Curso no encontrado.");
            }
            include '../../views/products/editCourse.php';
            break;
        default:
            throw new Exception("Tipo de producto desconocido.");
    }
} catch (PDOException $e) {
    echo "Error de base de datos: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}


