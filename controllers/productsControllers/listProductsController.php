<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlProductAdapter.php');

$adapter = new MysqlProductAdapter(); 

try {
    $products = $adapter->listProducts(); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/views/products/listProducts.php');
} catch (Exception $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage();
    exit;
}
?>


