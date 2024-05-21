error_log(print_r($_POST, true));
<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlClientAdapter.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/Client.php');

$adapter = new MysqlClientAdapter();
// Recoger los datos del formulario
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phoneNumber = filter_input(INPUT_POST, 'phoneNumber', FILTER_SANITIZE_STRING);
$membershipType = filter_input(INPUT_POST, 'membershipType', FILTER_SANITIZE_STRING);
$accountBalance = filter_input(INPUT_POST, 'accountBalance', FILTER_VALIDATE_FLOAT);
$dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_STRING);

$lastClientId = $adapter->maxClientid();
$clientId = $lastClientId + 1;

try {
    $client = new Client($name, $address, $email, $phoneNumber, $clientId, $membershipType, $accountBalance, $dni);
    
    if ($adapter->addIndividualClient($client)) {
        header("Location: ../../../views/stakeholders/employees/gestionClientes.php?update=success individual");
    } else {
        header("Location: ../../../views/stakeholders/employees/gestionClientes.php?update=fail");
    }
} catch (Exception $e) {
    $errorMessage = "Error al registrar el cliente:\n\n " . $e->getMessage();
    include '../../../views\stakeholders\error.php';
    exit;
}
