<?php
declare(strict_types=1);
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlProductAdapter.php');

$adapter = new MysqlProductAdapter();
$productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

if ($productId > 0) {
    try {
        if ($adapter->deleteProduct($productId)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el producto.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID de producto inválido.']);
}
?>
