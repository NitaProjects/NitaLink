<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlClientAdapter.php');

$adapter = new MysqlClientAdapter(); 

// Definir el número de clientes por página
$clientsPerPage = 5;

// Obtener el número de página actual desde la solicitud, por defecto es 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

try {
    // Obtener los clientes paginados
    $clients = $adapter->listClients($page, $clientsPerPage);

    // Obtener el número total de clientes para calcular el total de páginas
    $totalClients = $adapter->getTotalClients();
    $totalPages = ceil($totalClients / $clientsPerPage);

    include '../../../views/stakeholders/employees/listClients.php'; 
} catch (Exception $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage();
    exit;
}
?>
