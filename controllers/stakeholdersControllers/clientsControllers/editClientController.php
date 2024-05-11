<?php
declare(strict_types=1);

require_once '../../config/database.php';
$clientId = filter_input(INPUT_GET, 'clientId', FILTER_SANITIZE_NUMBER_INT);

try {
    $db = new PDO("mysql:host=localhost;dbname=nitalink", 'root', '');
    $stmt = $db->prepare("SELECT * FROM clients WHERE client_id = ?");
    $stmt->execute([$clientId]);
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Pasar los datos a la vista
    include '../../views/stakeholders/editClient.php';  // La página que contiene el formulario de edición
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
