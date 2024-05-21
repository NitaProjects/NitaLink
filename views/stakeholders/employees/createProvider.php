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
            <nav>
                <ul>
                    <li><a href="gestionProveedores.php">Volver</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <video class="video" preload="auto" muted playsinline autoplay loop>
                <source type="video/mp4" src="../../../public/assets/fondoHexagonal.mp4">
            </video>
            <form id="providerForm" action="../../../controllers/stakeholdersControllers/providersControllers/newProviderController.php" method="POST">
                <div class="form-group">
                    <label for="providerType">Tipo de Proveedor:</label>
                    <select id="providerType" name="providerType" onchange="toggleProviderInfo()">
                        <option value="particular">Particular</option>
                        <option value="empresa">Empresa</option>
                    </select>
                </div>
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
                    <label for="productSupplied">Producto Suministrado:</label>
                    <input type="text" id="productSupplied" name="productSupplied" required>
                </div>

                <div id="individualInfo" class="form-group">
                    <label for="dni">DNI:</label>
                    <input type="text" id="dni" name="dni">
                </div>

                <div id="companyInfo" class="form-group" style="display:none;">
                    <label for="companyWorkers">Número de Empleados:</label>
                    <input type="number" id="companyWorkers" name="companyWorkers">
                    <label for="corporateReason">Razón Social:</label>
                    <input type="text" id="corporateReason" name="corporateReason">
                </div>

                <div class="form-group">
                    <input type="submit" value="Registrar Proveedor">
                </div>
            </form>
        </main>

        <footer>
            <p>&copy; 2024 NitaLink. Todos los derechos reservados.</p>
        </footer>

        <script>
            function toggleProviderInfo() {
                var form = document.getElementById('providerForm');
                var providerType = document.getElementById('providerType').value;
                var companyInfo = document.getElementById('companyInfo');
                var individualInfo = document.getElementById('individualInfo');
                if (providerType === 'empresa') {
                    companyInfo.style.display = 'block';
                    individualInfo.style.display = 'none';
                    form.action = "../../../controllers/stakeholdersControllers/providersControllers/newProviderCompanyController.php";
                } else if (providerType === 'particular') {
                    companyInfo.style.display = 'none';
                    individualInfo.style.display = 'block';
                    form.action = "../../../controllers/stakeholdersControllers/providersControllers/newProviderController.php";
                }
            }
        </script>
    </body>
</html>
