<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/persistence/MysqlProviderAdapter.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/model/stakeholders/ProviderCompany.php');

$adapter = new MysqlProviderAdapter();

// Recoger los datos del formulario usando filter_input
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phone_number = filter_input(INPUT_POST, 'phoneNumber', FILTER_SANITIZE_STRING);
$product_supplied = filter_input(INPUT_POST, 'productSupplied', FILTER_SANITIZE_STRING);
$workers = filter_input(INPUT_POST, 'companyWorkers', FILTER_VALIDATE_INT);
$social_reason = filter_input(INPUT_POST, 'corporateReason', FILTER_SANITIZE_STRING);

try {
    $provider = new ProviderCompany($name, $address, $email, $phone_number, $product_supplied, $workers, $social_reason);
    $success = $adapter->addCompanyProvider($provider);

    if ($success) {
        header("Location: ../../../views/stakeholders/employees/gestionProveedores.php?add=success");
        exit;
    } else {
        header("Location: ../../../views/stakeholders/employees/gestionProveedores.php?add=fail");
        exit;
    }
} catch (Exception $e) {
    $errorMessage = "Error al registrar el proveedor:\n\n " . $e->getMessage();
    include '../../../views/stakeholders/error.php';
    exit;
}
?>
