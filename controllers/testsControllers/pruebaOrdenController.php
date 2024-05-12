<?php
declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/operations/Order.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/operations/OrderDetail.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/checkdata/Checker.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/exceptions/CheckException.php');

// Captura de datos básicos del pedido
$customerName = filter_input(INPUT_POST, 'customerName', FILTER_SANITIZE_STRING);
$operationType = filter_input(INPUT_POST, 'operationType', FILTER_SANITIZE_STRING);
 
// Capturar múltiples detalles del pedido
$inputs = filter_input_array(INPUT_POST, [
    'productId' => ['filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
    'quantity' => ['filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
    'unitPrice' => ['filter' => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],
    'discount' => ['filter' => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY]
]);

if (!$customerName || !$operationType || !$inputs) {
    echo "Datos incompletos o incorrectos.";
    exit;
}

$productIds = $inputs['productId'];
$quantities = $inputs['quantity'];
$unitPrices = $inputs['unitPrice'];
$discounts = $inputs['discount'];

try {
    // Suponemos que el ID de operación es generado automáticamente o predeterminado
    $operationId = rand(1000, 9999);

    $order = new Order($operationId, $customerName, $operationType);

    // Asegurarse de que hay la misma cantidad de cada array
    if (count($productIds) === count($quantities) && count($quantities) === count($unitPrices) && count($unitPrices) === count($discounts)) {
        foreach ($productIds as $index => $productId) {
            $quantity = $quantities[$index];
            $unitPrice = $unitPrices[$index];
            $discount = $discounts[$index];

            $order->addDetail($productId, $quantity, $unitPrice, $discount);
        }
        echo "Pedido registrado con éxito. Total: $" . $order->getTotalAmount();
    } else {
        throw new Exception("La cantidad de productos, precios, cantidades y descuentos no coincide.");
    }
} catch (Exception $ex) {
    echo "Error al crear el pedido: " . $ex->getMessage();
}
