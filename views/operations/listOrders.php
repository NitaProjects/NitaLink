<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Pedidos</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <h1>Listado de Pedidos</h1>
    <table border="1">
    <thead>
        <tr>
            <th>ID del Pedido</th>
            <th>Nombre del Cliente</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Detalles del Pedido</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= htmlspecialchars($order['operation_id']) ?></td>
                <td><?= htmlspecialchars($order['customer_name']) ?></td>
                <td><?= htmlspecialchars($order['date_time']) ?></td>
                <td><?= htmlspecialchars(number_format($order['total_amount'], 2)) ?>€</td>
                <td>
                    <?php foreach ($order['details'] as $detail): ?>
                        Producto ID: <?= htmlspecialchars($detail['product_id']) ?>, 
                        Cantidad: <?= htmlspecialchars($detail['quantity']) ?>, 
                        Precio Unitario: <?= htmlspecialchars(number_format($detail['unit_price'], 2)) ?>€, 
                        Descuento: <?= htmlspecialchars($detail['discount']) ?>%<br>
                    <?php endforeach; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
</body>
</html>
