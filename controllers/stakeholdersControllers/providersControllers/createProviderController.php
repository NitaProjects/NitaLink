<?php
declare(strict_types=1);

require_once '../../model/stakeholders/Provider.php';
require_once '../../model/stakeholders/CompanyData.php';
require_once '../../lib/Check.php';
require_once '../../lib/StatusCode.php';
require_once '../../config/database.php';

// Recolectar los datos del formulario
$name = filter_input(INPUT_POST, 'name');
$address = filter_input(INPUT_POST, 'address');
$email = filter_input(INPUT_POST, 'email');
$phoneNumber = (int) filter_input(INPUT_POST, 'phoneNumber');
$providerId = (int) filter_input(INPUT_POST, 'providerId');
$productSupplied = filter_input(INPUT_POST, 'productSupplied');
$deliveryDays = json_decode(filter_input(INPUT_POST, 'deliveryDays'), true); // Asumiendo que es enviado como JSON
$companyWorkers = (int) filter_input(INPUT_POST, 'companyWorkers');
$corporateReason = filter_input(INPUT_POST, 'corporateReason');

$companyData = null;
if (!empty($companyWorkers) && !empty($corporateReason)) {
    $companyData = new CompanyData($companyWorkers, $corporateReason);
}

// Instanciar el objeto Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();

try {
    if (!$name or !$address or !$email or !$phoneNumber or !$providerId or !$productSupplied) {
        throw new Exception("Por favor, complete todos los campos requeridos.");
    }

    // Preparar la consulta SQL
    $sql = "INSERT INTO providers (provider_id, name, address, email, phone_number, product_supplied, delivery_days, company_workers, corporate_reason) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    
    // Vincular los parámetros
    $stmt->bind_param("isssissis", $providerId, $name, $address, $email, $phoneNumber, $productSupplied, json_encode($deliveryDays), $companyWorkers, $corporateReason);

    // Ejecutar la consulta
    if($stmt->execute()) {
        echo "Proveedor creado con éxito y datos guardados en la base de datos.<br>";
    } else {
        throw new Exception("Error al insertar datos en la base de datos: " . $stmt->error);
    }

    // Crear el objeto Provider
    $provider = new Provider($name, $address, $email, $phoneNumber, $providerId, $productSupplied, $deliveryDays, $companyData);
    echo "Datos del Proveedor: <br>" . $provider->getContactData();

} catch (Exception $e) {
    echo "Error al crear el proveedor: " . $e->getMessage();
} finally {
    $stmt->close();
    $db->close();
}
?>


