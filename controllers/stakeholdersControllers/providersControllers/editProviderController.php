<?php
declare(strict_types=1);

require_once '../../config/database.php';
$providerId = filter_input(INPUT_GET, 'providerId', FILTER_SANITIZE_NUMBER_INT);

try {
    $db = new PDO("mysql:host=localhost;dbname=nitalink", 'dani', '');
    $stmt = $db->prepare("SELECT * FROM providers WHERE provider_id = ?");
    $stmt->execute([$providerId]);
    $providerData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Pasar los datos a la vista
    include '../../views/stakeholders/editProvider.php';  // La página que contiene el formulario de edición
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


