<?php
declare(strict_types=1);


require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/Provider.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/ProviderCompany.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/checkdata/Checker.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/CompanyData.php');

// Filtra los datos enviados
$name = filter_input(INPUT_POST, 'name');
$address = filter_input(INPUT_POST, 'address');
$email = filter_input(INPUT_POST, 'email');
$phoneNumber = filter_input(INPUT_POST, 'phoneNumber');
$providerId = filter_input(INPUT_POST, 'providerId');
$productSupplied = filter_input(INPUT_POST, 'productSupplied');
$deliveryDays = filter_input(INPUT_POST, 'deliveryDays');
$providerType = filter_input(INPUT_POST, 'providerType');

// Datos adicionales para empresas
$companyWorkers = filter_input(INPUT_POST, 'companyWorkers', FILTER_VALIDATE_INT);
$corporateReason = filter_input(INPUT_POST, 'corporateReason');
if ($companyWorkers === false) {
    $companyWorkers = -7000;
}
if ($deliveryDays == null) $deliveryDays = [];
 
try {
    // Verifica el tipo de proveedor
    if ($providerType == 'empresa') {
        // Crea un `ProviderCompany` con la información proporcionada
        $provider = new ProviderCompany($name, $address, $email, $phoneNumber, 3, $productSupplied, $deliveryDays, 1, $companyWorkers, $corporateReason);
    } else {
        // Crea un proveedor normal para particulares
        $provider = new Provider($name, $address, $email, $phoneNumber, 3, $productSupplied, $deliveryDays);
    }

    // Muestra los detalles del proveedor registrado
    echo "Proveedor registrado con éxito:<br> " . $provider->getDetails();
} catch (Exception $ex) {
    // Muestra el mensaje de error en caso de excepción
    echo "Error al registrar el proveedor:<br> " . $ex->getMessage();
}
