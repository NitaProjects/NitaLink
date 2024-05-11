<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Pedidos</title>
    <link rel="stylesheet" href="../../public/css/formulario.css">
</head>
<body>
    <header>
        <img src="../../public/assets/logo2.png" alt="NitaLink Logo">
        <h1>Prueba Pedido</h1>
    </header>
    <form action="../../controllers/testsControllers/pruebaOrdenController.php" method="POST">
        <input type="text" name="customerName" placeholder="Nombre del Cliente"><br>
        <label for="operationType">Tipo de Operación:</label>
        <select name="operationType" id="operationType" onchange="toggleOperationFields()">
            <option value="">Seleccione el Tipo de Operación</option>
            <option value="compra">Compra</option>
            <option value="venta">Venta</option>
            <option value="devolucion">Devolución</option>
            <option value="cambio">Cambio</option>
        </select><br>

        <!-- Detalles de Compra y Venta -->
        <div id="compraVentaFields" style="display:none;">
            <input type="number" name="productId" placeholder="ID del Producto"><br>
            <input type="number" name="price" placeholder="Precio"><br>
            <input type="number" name="quantity" placeholder="Cantidad"><br>
            <input type="number" name="discount" placeholder="Descuento (%)" step="0.01"><br>
        </div>

        <!-- Detalles de Devolución -->
        <div id="devolucionFields" style="display:none;">
            <input type="number" name="productIdDevolucion" placeholder="ID del Producto"><br>
            <input type="number" name="quantityDevolucion" placeholder="Cantidad"><br>
        </div>

        <!-- Detalles de Cambio -->
        <div id="cambioFields" style="display:none;">
            <h3>Producto a Devolver</h3>
            <input type="number" name="productIdDevolver" placeholder="ID del Producto a Devolver"><br>
            <input type="number" name="quantityDevolver" placeholder="Cantidad"><br>
            
            <h3>Producto a Sustituir</h3>
            <input type="number" name="productIdSustituir" placeholder="ID del Producto a Sustituir"><br>
            <input type="number" name="quantitySustituir" placeholder="Cantidad"><br>
            <input type="number" name="unitPriceSustituir" placeholder="Precio Unitario"><br>
            <input type="number" name="discountSustituir" placeholder="Descuento (%)" step="0.01"><br>
        </div>

        <input type="submit" value="Enviar">
    </form>

    <footer>
        <p>&copy; 2024 NitaLink. Todos los derechos reservados.</p>
    </footer>

    <script>
        function toggleOperationFields() {
            var operationType = document.getElementById('operationType').value;

            // Ocultar todos los campos
            document.getElementById('compraVentaFields').style.display = 'none';
            document.getElementById('devolucionFields').style.display = 'none';
            document.getElementById('cambioFields').style.display = 'none';

            // Mostrar campos según el tipo de operación seleccionado
            if (operationType === 'compra' || operationType === 'venta') {
                document.getElementById('compraVentaFields').style.display = 'block';
            } else if (operationType === 'devolucion') {
                document.getElementById('devolucionFields').style.display = 'block';
            } else if (operationType === 'cambio') {
                document.getElementById('cambioFields').style.display = 'block';
            }
        }
    </script>
</body>
</html>

