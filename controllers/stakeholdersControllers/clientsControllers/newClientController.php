<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlClientAdapter.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/Client.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/ClientCompany.php');  

// Crear una nueva instancia del adaptador de base de datos
$adapter = new MysqlClientAdapter();

// Recoger los datos del formulario
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phoneNumber = filter_input(INPUT_POST, 'phoneNumber', FILTER_SANITIZE_STRING);
$membershipType = filter_input(INPUT_POST, 'membershipType', FILTER_SANITIZE_STRING);
$accountBalance = filter_input(INPUT_POST, 'accountBalance', FILTER_VALIDATE_FLOAT);
$clientType = filter_input(INPUT_POST, 'clientType', FILTER_SANITIZE_STRING);


$lastClientId = $adapter->maxClientid();
$clientId = $lastClientId + 1;


// Determinar el tipo de cliente y crear la instancia adecuada
if ($clientType == 'empresa') {
    $companyWorkers = filter_input(INPUT_POST, 'companyWorkers', FILTER_VALIDATE_INT);
    $corporateReason = filter_input(INPUT_POST, 'corporateReason', FILTER_SANITIZE_STRING);

    // Crear una instancia de CompanyClient y establecer tipo
    $client = new ClientCompany($name, $address, $email, $phoneNumber, $clientId, $membershipType, $accountBalance, $companyWorkers, $corporateReason);
} else {
    $dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_STRING);
    
    // Crear una instancia de Client para particulares, asumiendo que Client maneja los particulares
    $client = new Client( $name, $address, $email, $phoneNumber, $clientId,$membershipType, $accountBalance, $dni);
}

// Intentar registrar al cliente utilizando el adaptador
try {
    if ($clientType == 'empresa') {
    if ($adapter->addCompanyClient($client)) {
        // Redirección con mensaje de éxito
        header("Location: ../../../views/stakeholders/employees/gestionClientes.php?update=success");
        exit;
    } else {
        // Redirección con mensaje de error si no se logra registrar
        header("Location: ../../../views/stakeholders/employees/gestionClientes.php?update=fail");
        exit;
    }
    }
    else {
        if ($adapter->addIndividualClient($client)) {
        // Redirección con mensaje de éxito
        header("Location: ../../../views/stakeholders/employees/gestionClientes.php?update=success");
        exit;
    } else {
        // Redirección con mensaje de error si no se logra registrar
        header("Location: ../../../views/stakeholders/employees/gestionClientes.php?update=fail");
        exit;
    }
    }
} catch (Exception $e) {
    // Captura de excepciones y redirección con mensaje de error
    header("Location: ../../../views/error.php?message=" . urlencode($e->getMessage()));
    exit;
}
?>

