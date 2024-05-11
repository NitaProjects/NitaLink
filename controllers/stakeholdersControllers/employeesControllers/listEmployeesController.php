<?php

// Incluimos el archivo de configuración de la base de datos.
require_once '../../config/database.php';

try {
    // Intentamos establecer conexión con la base de datos usando PDO.
    $db = new PDO("mysql:host=localhost;  dbname=nitalink", 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configuramos PDO para que muestre los errores.

    // Preparamos y ejecutamos la consulta SQL para obtener todos los clientes.
    $stmt = $db->prepare("SELECT * FROM employees");
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtenemos todos los clientes como un array asociativo.

    // Si todo es correcto, incluimos la vista que muestra los clientes.
    include '../../views/stakeholders/listEmployees.php';
} catch (PDOException $e) {
    // Si hay un error de conexión o consulta, mostramos el mensaje de error.
    echo "Error de conexión a la base de datos: " . $e->getMessage();
    exit; // Terminamos la ejecución del script para evitar problemas mayores.
}
?>


