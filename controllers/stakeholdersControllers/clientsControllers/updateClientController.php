<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlClientAdapter.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/Client.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/ClientCompany.php');  

$adapter = new MysqlClientAdapter();

// Recoger los datos del formulario usando filter_input
$client_id = filter_input(INPUT_POST, 'client_id', FILTER_VALIDATE_INT);
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phone_number = filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING);
$account_balance = filter_input(INPUT_POST, 'account_balance', FILTER_VALIDATE_FLOAT);
$membership_type = filter_input(INPUT_POST, 'membership_type', FILTER_SANITIZE_STRING);
$clientType = filter_input(INPUT_POST, 'client_type', FILTER_SANITIZE_STRING);

try {
    if ($clientType == 'Empresa') {
        $workers = filter_input(INPUT_POST, 'workers', FILTER_VALIDATE_INT);
        $social_reason = filter_input(INPUT_POST, 'social_reason', FILTER_SANITIZE_STRING);
        $client = new ClientCompany($name, $address, $email, $phone_number, $client_id, $membership_type, $account_balance, $workers, $social_reason);
        $success = $adapter->updateClientCompany($client);
    } else {
        $dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_STRING);
        $client = new Client($name, $address, $email, $phone_number, $client_id, $membership_type, $account_balance, $dni);
        $success = $adapter->updateClient($client);
    }

    if ($success) {
        // Redirección con mensaje de éxito
        header("Location: ../../../views/stakeholders/employees/gestionClientes.php?update=success");
        exit;
    } else {
        // Redirección con mensaje de error si no hubo cambios
        header("Location: ../../../views/stakeholders/employees/gestionClientes.php?update=fail");
        exit;
    }
} catch (Exception $e) {
    // Redirección con mensaje de error en caso de excepción
    header("Location: ../../../views/stakeholders/employees/listClients.php?error=" . urlencode($e->getMessage()));
    exit;
}
?>


