<?php
declare(strict_types=1);

require_once '../../config/database.php';

// Recolectar datos del formulario
$name = filter_input(INPUT_POST, 'name');
$address = filter_input(INPUT_POST, 'address');
$email = filter_input(INPUT_POST, 'email');
$phoneNumber = (int) filter_input(INPUT_POST, 'phoneNumber');
$providerId = (int) filter_input(INPUT_POST, 'providerId');
$productSupplied = filter_input(INPUT_POST, 'productSupplied');
$deliveryDays = json_decode(filter_input(INPUT_POST, 'deliveryDays'), true);  // Suponiendo que los días de entrega se envían como JSON
$companyWorkers = (int) filter_input(INPUT_POST, 'companyWorkers');
$corporateReason = filter_input(INPUT_POST, 'corporateReason');

try {
    $db = new PDO("mysql:host=localhost;dbname=nitalink", 'root', '');
    $sql = "UPDATE providers SET name = ?, address = ?, email = ?, phone_number = ?, product_supplied = ?, delivery_days = ?, company_workers = ?, corporate_reason = ? WHERE provider_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$name, $address, $email, $phoneNumber, $productSupplied, json_encode($deliveryDays), $companyWorkers, $corporateReason, $providerId]);

    echo "Proveedor actualizado con éxito.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
