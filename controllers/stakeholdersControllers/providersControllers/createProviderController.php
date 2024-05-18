<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlProviderAdapter.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/Provider.php');

$adapter = new MysqlProviderAdapter();

// Recoger los datos del formulario usando filter_input
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phoneNumber = filter_input(INPUT_POST, 'phoneNumber', FILTER_SANITIZE_STRING);
$providerId = filter_input(INPUT_POST, 'providerId', FILTER_VALIDATE_INT);
$productSupplied = filter_input(INPUT_POST, 'productSupplied', FILTER_SANITIZE_STRING);
$deliveryDays = filter_input(INPUT_POST, 'deliveryDays', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

try {
    $provider = new Provider($name, $address, $email, $phoneNumber, $providerId, $productSupplied, $deliveryDays);
    $success = $adapter->addProvider($provider);

    if ($success) {
        header("Location: ../../../views/stakeholders/employees/gestionProveedores.php?add=success");
        exit;
    } else {
        header("Location: ../../../views/stakeholders/employees/gestionProveedores.php?add=fail");
        exit;
    }
} catch (Exception $e) {
    header("Location: ../../../views/stakeholders/employees/gestionProveedores.php?error=" . urlencode($e->getMessage()));
    exit;
}
?>
