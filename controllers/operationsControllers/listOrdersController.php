<?php
declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');

try {
    $db = new PDO("mysql:host=localhost;dbname=nitalink", 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparar y ejecutar la consulta SQL para obtener todos los pedidos
    $stmt = $db->prepare("SELECT operations.operation_id, operations.customer_name, operations.date_time, operations.total_amount, order_details.product_id, order_details.quantity, order_details.unit_price, order_details.discount
                          FROM operations
                          LEFT JOIN order_details ON operations.operation_id = order_details.operation_id
                          ORDER BY operations.operation_id");
    $stmt->execute();
    $rawOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $orders = [];
    foreach ($rawOrders as $row) {
        $operationId = $row['operation_id'];
        if (!isset($orders[$operationId])) {
            $orders[$operationId] = [
                'operation_id' => $operationId,
                'customer_name' => $row['customer_name'],
                'date_time' => $row['date_time'],
                'total_amount' => $row['total_amount'],
                'details' => []
            ];
        }
        $orders[$operationId]['details'][] = [
            'product_id' => $row['product_id'],
            'quantity' => $row['quantity'],
            'unit_price' => $row['unit_price'],
            'discount' => $row['discount']
        ];
    }

    // Cargar la vista con los datos de los pedidos
    include '../../views/operations/listOrders.php';
} catch (PDOException $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage();
}


