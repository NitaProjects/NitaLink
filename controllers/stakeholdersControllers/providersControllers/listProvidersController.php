<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/persistence/MysqlProviderAdapter.php');

$adapter = new MysqlProviderAdapter();

// Definir el número de proveedores por página
$providersPerPage = 50;

// Obtener el número de página actual desde la solicitud, por defecto es 1
$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
if ($page === null || $page === false || $page < 1) {
    $page = 1;
}

try {
    // Obtener los proveedores paginados
    $providers = $adapter->listProviders($page, $providersPerPage);

    // Obtener el número total de proveedores para calcular el total de páginas
    $totalProviders = $adapter->getTotalProviders();
    $totalPages = ceil($totalProviders / $providersPerPage);

    include '../../../views/stakeholders/providers/listProviders.php';
} catch (Exception $e) {
    $errorMessage = "Error al registrar el proveedor:\n\n " . $e->getMessage();
    include '../../../views/stakeholders/error.php';
    exit;
}
?>
