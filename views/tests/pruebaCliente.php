<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba Clientes</title>
    <link rel="stylesheet" href="../../public/css/formulario.css">
</head>
<body>
    <header>
        <h1>Prueba Cliente</h1>
    </header>
    <main>
        <video class="video" preload="auto" muted playsinline autoplay loop>
            <source type="video/mp4" src="../../public/assets/fondoFormulario.mp4">
        </video>
        <form action="../../controllers/testsControllers/pruebaClienteController.php" method="POST">
            <input type="text" name="name" placeholder="Nombre del Cliente" autocomplete="off"><br>
            <input type="text" name="address" placeholder="Dirección" autocomplete="off"><br>
            <input type="text" name="email" placeholder="Email" autocomplete="off"><br>
            <input type="text" name="phoneNumber" placeholder="Número de Teléfono" autocomplete="off"><br>
            
            <select name="clientType" id="clientType" onchange="toggleCompanyFields()">
                <option value="particular">Particular</option>
                <option value="empresa">Empresa</option>
            </select><br>
            
            <select name="membershipType">
                <option value="standard">Standard</option>
                <option value="gold">Gold</option>
                <option value="premium">Premium</option>
            </select><br>

            <input type="number" name="accountBalance" placeholder="Saldo" autocomplete="off"><br>
            
            <div id="companyFields" style="display:none;">
                <input type="number" name="companyWorkers" placeholder="Número de Empleados"><br>
                <input type="text" name="corporateReason" placeholder="Razón Social"><br>
            </div>

            <input type="submit" value="Enviar">
        </form>
    </main>
    <footer>
        <p>&copy; 2024 NitaLink. Todos los derechos reservados.</p>
    </footer>
    <script>
        function toggleCompanyFields() {
            var clientType = document.getElementById('clientType').value;
            var display = (clientType === 'empresa') ? 'block' : 'none';
            document.getElementById('companyFields').style.display = display;
        }
    </script>
</body>
</html>
