<?php

require_once '../../../config/database.php';

try {
    // Intentamos establecer conexión con la base de datos usando PDO.
    $db = new PDO("mysql:host=localhost;  dbname=nitalink", 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparamos y ejecutamos la consulta SQL para obtener todos los clientes.
    $stmt = $db->prepare(  "SELECT c.*, cd.company_workers, cd.corporate_reason
                            FROM Clients c
                            LEFT JOIN CompanyData cd ON c.client_id = cd.client_id
                            order by client_id asc;");
    $stmt->execute();
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    include '../../../views/stakeholders/employees/listClients.php';
} catch (PDOException $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage();
    exit; 
}
?>




