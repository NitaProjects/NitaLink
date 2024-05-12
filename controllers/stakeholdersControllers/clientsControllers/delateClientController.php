<?php
declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');

$clientId = filter_input(INPUT_POST, 'client_id', FILTER_VALIDATE_INT);

if (!$clientId) {
    echo "Error: No se ha especificado ningún ID de cliente válido.";
    exit;
}

try {
    $db = new PDO("mysql:host=localhost;dbname=nitalink", 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "DELETE FROM clients WHERE client_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$clientId]);

    
} catch (PDOException $e) {
    echo "Error al eliminar el cliente: " . $e->getMessage();
    exit;
}
?>
