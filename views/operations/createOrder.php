<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Crear Orden</title>
        <link rel="stylesheet" href="../../public/css/style.css"> 
    </head>
    <body>
        <h1>Crear Nuevo Pedido</h1>
        <form action="../../controllers/operationsControllers/createOrderController.php" method="POST">
            <fieldset>
                <legend>Información del Pedido</legend>

                <label for="orderType">Tipo de Pedido:</label>
                <select id="orderType" name="orderType" required>
                    <option value="purchase">Compra</option>
                    <option value="sale">Venta</option>
                </select><br>

                <!-- Esta sección aparece solo si se selecciona "Compra" -->
                <div id="purchaseDetails" style="display:none;">
                    <label for="partnerType">Comprar a:</label>
                    <select id="partnerType" name="partnerType">
                        <option value="provider">Proveedor</option>
                        <option value="customer">Cliente</option>
                    </select><br>
                </div>

                <label for="customerName">Nombre del Cliente/Proveedor:</label>
                <input type="text" id="customerName" name="customerName" required><br>

                <label for="productRef">Referencia del Producto:</label>
                <input type="text" id="productRef" name="productRef" required><br>

                <label for="quantity">Cantidad:</label>
                <input type="number" id="quantity" name="quantity" required><br>

                <label for="unitPrice">Precio Unitario:</label>
                <input type="number" step="0.01" id="unitPrice" name="unitPrice" required><br>
            </fieldset>

            <input type="submit" value="Crear Orden">
        </form>

        <script>
            document.getElementById('orderType').addEventListener('change', function () {
                var purchaseDetails = document.getElementById('purchaseDetails');
                if (this.value === 'purchase') {
                    purchaseDetails.style.display = 'block';
                } else {
                    purchaseDetails.style.display = 'none';
                }
            });
        </script>
    </body>
</html>



