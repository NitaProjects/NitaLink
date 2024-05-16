<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Cliente</title>
    <link rel="stylesheet" href="../../../public/css/formulario2.css">
</head>
<body>
    <header>
        <h1>Registrar Cliente</h1>
    </header>
    
    <main>
        <video class="video" preload="auto" muted playsinline autoplay loop>
            <source type="video/mp4" src="../../../public/assets/fondoHexagonal.mp4">
        </video>
        <form action="../../../controllers/stakeholdersControllers/clientsControllers/newClientController.php" method="POST">
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
                <label for="membershipType">Tipo de Membresía:</label>
                <select id="membershipType" name="membershipType">
                    <option value="Standard">Standard</option>
                    <option value="Gold">Gold</option>
                    <option value="Premium">Premium</option>
                </select>
            </div>

            <div class="form-group">
                <label for="accountBalance">Balance de Cuenta:</label>
                <input type="number" id="accountBalance" name="accountBalance" required>
            </div>

            <div class="form-group">
                <label for="clientType">Tipo de Cliente:</label>
                <select id="clientType" name="clientType" onchange="toggleClientInfo()">
                    <option value="particular">Particular</option>
                    <option value="empresa">Empresa</option>
                </select>
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
                <input type="submit" value="Registrar Cliente">
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 NitaLink. Todos los derechos reservados.</p>
    </footer>

    <script>
        function toggleClientInfo() {
            var clientType = document.getElementById('clientType').value;
            var companyInfo = document.getElementById('companyInfo');
            var individualInfo = document.getElementById('individualInfo');
            if (clientType === 'empresa') {
                companyInfo.style.display = 'block';
                individualInfo.style.display = 'none';
            } else if (clientType === 'particular') {
                companyInfo.style.display = 'none';
                individualInfo.style.display = 'block';
            }
        }
    </script>
</body>
</html>
