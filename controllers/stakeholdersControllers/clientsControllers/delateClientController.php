<?php
declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlClientAdapter.php');

$adapter = new MysqlClientAdapter();
$clientId = filter_input(INPUT_POST, 'client_id', FILTER_VALIDATE_INT);

if ($clientId > 0) {
    try {
        if ($adapter->deleteClient((int) $clientId)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el cliente.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID de cliente inválido.']);
}
?>
