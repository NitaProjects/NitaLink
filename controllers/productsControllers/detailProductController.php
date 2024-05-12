<?php
declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');
$productId = filter_input(INPUT_GET, 'productId', FILTER_VALIDATE_INT);

try {
    $db = new PDO("mysql:host=localhost;dbname=nitalink", 'root', '');
    $stmt = $db->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->execute([$productId]);
    $productData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$productData) {
        throw new Exception("Producto no encontrado.");
    }

    switch ($productData['product_type']) {
        case 'book':
            $additionalStmt = $db->prepare("SELECT * FROM books WHERE product_id = ?");
            break;
        case 'course':
            $additionalStmt = $db->prepare("SELECT * FROM courses WHERE product_id = ?");
            break;
        default:
            throw new Exception("Tipo de producto desconocido.");
    }
    $additionalStmt->execute([$productId]);
    $additionalData = $additionalStmt->fetch(PDO::FETCH_ASSOC);

    // Combine general product data with specific data
    $productDetails = array_merge($productData, $additionalData);

    // Pass all data to the view
    include '../../views/products/detailProduct.php';
} catch (PDOException $e) {
    echo "Error de base de datos: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>



