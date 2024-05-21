<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlProductAdapter.php');

$adapter = new MysqlProductAdapter(); 

// Definir el número de productos por página
$productsPerPage = 50;

// Obtener el número de página actual desde la solicitud, por defecto es 1
$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
if ($page === null || $page === false || $page < 1) {
    $page = 1;
}


try {
    // Obtener los productos paginados y filtrados
    $products = $adapter->listProducts($page, $productsPerPage);

    // Obtener el número total de productos para calcular el total de páginas
    $totalProducts = $adapter->getTotalProducts();
    $totalPages = ceil($totalProducts / $productsPerPage);

    include $_SERVER['DOCUMENT_ROOT'].'/nitalink/views/products/listProducts.php';
} catch (Exception $e) {
    $errorMessage = "Error al registrar el cliente:\n\n " . $e->getMessage();
    include '../../views\stakeholders\error.php';
    exit;
}
?>


