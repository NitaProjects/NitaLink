<?php
declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/Client.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/ClientCompany.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/CompanyData.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/checkdata/Checker.php');

$name = filter_input(INPUT_POST, 'name');
$address = filter_input(INPUT_POST, 'address');
$email = filter_input(INPUT_POST, 'email');
$phoneNumber = filter_input(INPUT_POST, 'phoneNumber');
$membershipType = filter_input(INPUT_POST, 'membershipType');
$accountBalance = filter_input(INPUT_POST, 'accountBalance', FILTER_VALIDATE_FLOAT);
$clientType = filter_input(INPUT_POST, 'clientType');
$companyWorkers = filter_input(INPUT_POST, 'companyWorkers', FILTER_VALIDATE_INT);
$corporateReason = filter_input(INPUT_POST, 'corporateReason');

// Asegura que los valores numéricos tengan valores por defecto.
if ($accountBalance === false) {
    $accountBalance = -7000;
}
if ($companyWorkers === false) {
    $companyWorkers = -7000;
}

try {
    if ($clientType === 'empresa') {
        // Crea el objeto `ClientCompany` usando `CompanyData`.
        $client = new ClientCompany($name, $address, $email, $phoneNumber, 4, $membershipType, $accountBalance, 2, $companyWorkers, $corporateReason);

        // Muestra los detalles del cliente empresarial.
        echo $client->getDetails();
    } else {
        // Crea el objeto `Client` para clientes no empresariales.
        $client = new Client($name, $address, $email, $phoneNumber, 4, $membershipType, $accountBalance);

        // Muestra los detalles del cliente no empresarial.
        echo $client->getDetails();
    }
} catch (Exception $ex) {
    // Captura las excepciones y muestra el mensaje de error.
    echo  $ex->getMessage();
}

