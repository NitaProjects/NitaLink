<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlProductsAdapter.php');

$adapter = new MysqlClientAdapter(); 

try {
    $clients = $adapter->listClients(); 
    include '../../../views/stakeholders/employees/listProducts.php'; 
} catch (Exception $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage();
    exit;
}
?>


