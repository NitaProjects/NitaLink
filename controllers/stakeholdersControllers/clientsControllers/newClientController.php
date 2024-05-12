<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/checkdata/Checker.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/exceptions/CheckException.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/exceptions/ServiceException.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlClientAdapter.ph');

$persistence = new MysqlClientAdapter();
$message = "Unsuccessfully Request: ";
$name = filter_input(INPUT_POST, 'name');
$address = filter_input(INPUT_POST, 'address');
$email = filter_input(INPUT_POST, 'email');
$phoneNumber = filter_input(INPUT_POST, 'phoneNumber');
$membershipType = filter_input(INPUT_POST, 'membershipType');
$accountBalance = filter_input(INPUT_POST, 'accountBalance', FILTER_VALIDATE_FLOAT);
$clientType = filter_input(INPUT_POST, 'clientType');
$companyWorkers = filter_input(INPUT_POST, 'companyWorkers', FILTER_VALIDATE_INT);
$corporateReason = filter_input(INPUT_POST, 'corporateReason');
if ($clientType === 'empresa' && $companyWorkers !== false && $corporateReason !== null) {
    $companyData = json_encode([
        'companyWorkers' => $companyWorkers,
        'corporateReason' => $corporateReason
    ]);
} else {
    $companyWorkers = null;
    $corporateReason = null;
    $companyData = null; 
}
  

if ($name && $address && $email && $phoneNumber && $membershipType && $accountBalance !== false) {
    try {
        if ($persistence->exists($email) === false) { 
            $clientId = $persistence->maxClientId() + 1;
            $client = new Client($name, $address, $email, $phoneNumber, $clientId, $membershipType, $accountBalance, $companyData);
            $persistence->addClient($client);
            $message = "Changes done";
        } else {
            $message .= "Client Exists";
        }
    } catch (ServiceException $ex) {
        $message .= $ex->getMessage();
    } catch (CheckException $ex) {
        $message .= $ex->getMessage();
    }
} else {
    $message .= "Insufficient data provided";
}

setcookie('response', $message, 0, '/', 'localhost');
header('Location: ../../views/stakeholders/gestionClientes.php');
