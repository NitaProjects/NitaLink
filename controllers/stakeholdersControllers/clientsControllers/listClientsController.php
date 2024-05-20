<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlClientAdapter.php');

$adapter = new MysqlClientAdapter(); 

// Definir el número de clientes por página
$clientsPerPage = 50;

// Obtener el número de página actual desde la solicitud, por defecto es 1
$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
if ($page === null || $page === false || $page < 1) {
    $page = 1;
}

try {
    // Obtener los clientes paginados
    $clients = $adapter->listClients($page, $clientsPerPage);

    // Obtener el número total de clientes para calcular el total de páginas
    $totalClients = $adapter->getTotalClients();
    $totalPages = ceil($totalClients / $clientsPerPage);

    include '../../../views/stakeholders/employees/listClients.php'; 
} catch (Exception $e) {
    $errorMessage = "Error al registrar el cliente:\n\n " . $e->getMessage();
    include '../../../public/css/error.php';
    exit;
}
?>
