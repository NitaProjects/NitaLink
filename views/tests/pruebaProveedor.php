<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Proveedores</title>
    <link rel="stylesheet" href="../../public/css/formulario.css">
</head>
<body>
    <header>
        <img src="../../public/assets/logo2.png" alt="NitaLink Logo">
        <h1>Prueba Proveedor</h1>
    </header>
    <form action="../../controllers/testsControllers/pruebaProveedorController.php" method="POST">
        <input type="text" name="name" placeholder="Nombre del Proveedor"><br>
        <input type="text" name="address" placeholder="Dirección"><br>
        <input type="text" name="email" placeholder="Email"><br>
        <input type="text" name="phoneNumber" placeholder="Número de Teléfono"><br>
        <input type="text" name="productSupplied" placeholder="Producto Suministrado"><br>

        <!-- Tipo de Proveedor -->
        <label for="providerType">Tipo de Proveedor:</label><br>
        <select name="providerType" id="providerType" onchange="toggleCompanyFields()">
            <option value="particular">Particular</option>
            <option value="empresa">Empresa</option>
        </select><br>

        <!-- Días de Entrega -->
        <label for="deliveryDays">Días de Reparto:</label>
            <select name="deliveryDays[]" id="deliveryDays" multiple size="5">
                <option value="lunes">Lunes</option>
                <option value="martes">Martes</option>
                <option value="miercoles">Miércoles</option>
                <option value="jueves">Jueves</option>
                <option value="viernes">Viernes</option>
            </select>

        <!-- Campos adicionales para datos de empresa -->
        <div id="companyFields" style="display:none;">
            <input type="number" name="companyWorkers" placeholder="Número de Empleados"><br>
            <input type="text" name="corporateReason" placeholder="Razón Social"><br>
        </div>

        <input type="submit" value="Registrar">
    </form>

    <footer>
        <p>&copy; 2024 NitaLink. Todos los derechos reservados.</p>
    </footer>

    <script>
        // Cambia el estilo para mostrar u ocultar los campos adicionales
        function toggleCompanyFields() {
            var providerType = document.getElementById('providerType').value;
            var display = (providerType === 'empresa') ? 'block' : 'none';
            document.getElementById('companyFields').style.display = display;
        }
    </script>
</body>
</html>


