<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Proveedor</title>
    <link rel="stylesheet" href="../../../public/css/formulario2.css">
</head>
<body>
    <header>
        <h1>Registrar Proveedor</h1>
    </header>
    
    <main>
        <video class="video" preload="auto" muted playsinline autoplay loop>
            <source type="video/mp4" src="../../../public/assets/fondoHexagonal.mp4">
        </video>
        <form id="providerForm" action="../../../controllers/stakeholdersControllers/providersControllers/newProviderController.php" method="POST">
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="address">Dirección:</label>
                <input type="text" id="address" name="address" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phoneNumber">Teléfono:</label>
                <input type="text" id="phoneNumber" name="phoneNumber" required>
            </div>

            <div class="form-group">
                <label for="providerId">ID del Proveedor:</label>
                <input type="number" id="providerId" name="providerId" required>
            </div>

            <div class="form-group">
                <label for="productSupplied">Producto Suministrado:</label>
                <input type="text" id="productSupplied" name="productSupplied" required>
            </div>

            <div class="form-group">
                <label for="deliveryDays">Días de Reparto:</label>
                <select id="deliveryDays" name="deliveryDays[]" multiple required>
                    <option value="lunes">Lunes</option>
                    <option value="martes">Martes</option>
                    <option value="miércoles">Miércoles</option>
                    <option value="jueves">Jueves</option>
                    <option value="viernes">Viernes</option>
                </select>
            </div>

            <div class="form-group">
                <input type="submit" value="Registrar Proveedor">
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 NitaLink. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
