<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlClientAdapter.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/ClientCompany.php');

$adapter = new MysqlClientAdapter();
// Recoger los datos del formulario para una empresa
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phoneNumber = filter_input(INPUT_POST, 'phoneNumber', FILTER_SANITIZE_STRING);
$membershipType = filter_input(INPUT_POST, 'membershipType', FILTER_SANITIZE_STRING);
$accountBalance = filter_input(INPUT_POST, 'accountBalance', FILTER_VALIDATE_FLOAT);
$companyWorkers = filter_input(INPUT_POST, 'companyWorkers', FILTER_VALIDATE_INT);
$corporateReason = filter_input(INPUT_POST, 'corporateReason', FILTER_SANITIZE_STRING);

$lastClientId = $adapter->maxClientid();
$clientId = $lastClientId + 1;

$client = new ClientCompany($name, $address, $email, $phoneNumber, $clientId, $membershipType, $accountBalance, $companyWorkers, $corporateReason);

// Intentar registrar al cliente empresa utilizando el adaptador
try {
    if ($adapter->addCompanyClient($client)) {
        header("Location: ../../../views/stakeholders/employees/gestionClientes.php?update=success company");
    } else {
        header("Location: ../../../views/stakeholders/employees/gestionClientes.php?update=fail");
    }
} catch (Exception $e) {
    header("Location: ../../../views/error.php?message=" . urlencode($e->getMessage()));
    exit;
}
