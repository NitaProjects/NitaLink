<?php
declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');

// Recolectar los datos del formulario
$name = filter_input(INPUT_POST, 'name');
$address = filter_input(INPUT_POST, 'address');
$email = filter_input(INPUT_POST, 'email');
$phoneNumber = (int) filter_input(INPUT_POST, 'phone_number');
$clientId = (int) filter_input(INPUT_POST, 'client_id');
$membershipType = filter_input(INPUT_POST, 'membership_type');
$accountBalance = (float) filter_input(INPUT_POST, 'account_balance');
$clientType = filter_input(INPUT_POST, 'client_type');
$companyWorkers = (int) filter_input(INPUT_POST, 'company_workers');
$corporateReason = filter_input(INPUT_POST, 'corporate_reason');

try {
    $db = new PDO("mysql:host=localhost;dbname=nitalink", 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Actualizar datos en la tabla `clients`
    $sql = "UPDATE clients SET name = ?, address = ?, email = ?, phone_number = ?, membership_type = ?, account_balance = ?, client_type = ? WHERE client_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$name, $address, $email, $phoneNumber, $membershipType, $accountBalance, $clientType, $clientId]);

    // Verificar si el cliente es de tipo 'empresa'
    if ($clientType === 'empresa') {
        // Comprobar si ya existe entrada en CompanyData
        $check = $db->prepare("SELECT client_id FROM CompanyData WHERE client_id = ?");
        $check->execute([$clientId]);
        if ($check->fetch()) {
            // Actualizar datos en la tabla `CompanyData`
            $sqlCompany = "UPDATE CompanyData SET company_workers = ?, corporate_reason = ? WHERE client_id = ?";
            $stmtCompany = $db->prepare($sqlCompany);
            $stmtCompany->execute([$companyWorkers, $corporateReason, $clientId]);
        } else {
            // Insertar datos si no existen
            $sqlCompany = "INSERT INTO CompanyData (client_id, company_workers, corporate_reason) VALUES (?, ?, ?)";
            $stmtCompany = $db->prepare($sqlCompany);
            $stmtCompany->execute([$clientId, $companyWorkers, $corporateReason]);
        }
    }

    // Redirección después de la actualización exitosa
    header('Location: ../../../views/stakeholders/employees/gestionClientes.php');
    exit();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}



