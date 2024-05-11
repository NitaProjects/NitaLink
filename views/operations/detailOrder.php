<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Pedido</title>
    <link rel="stylesheet" href="../../public/css/style.css"> 
</head>
<body>
    <h1>Detalle del Pedido</h1>
    <form action="../../controllers/operationsControllers/detailOrderController.php" method="POST">
        <label for="orderId">Ingrese ID del pedido para ver detalles:</label>
        <input type="text" id="orderId" name="orderId" required><br>
        <input type="submit" value="Buscar Orden">
    </form>
</body>
</html>
