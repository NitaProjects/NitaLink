<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/persistence/MysqlProductAdapter.php');

$adapter = new MysqlProductAdapter();

try {
    throw new Exception("Tipo de producto desconocido.");
} catch (Exception $e) {
    $errorMessage = "Error al actualizar el producto:\n\n " . $e->getMessage();
    include '../../../public/css/error.php';
    exit;
}
?>
