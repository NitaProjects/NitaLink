<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Gestión de Usuarios - NitaLink</title>
        <link rel="stylesheet" href="../../../public/css/newUser.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <header>
            <nav>
                <ul>
                    <li><a href="../../../index.html">Inicio</a></li> 
                </ul>
            </nav>
        </header>
        <main>
            <video class="video" preload="auto" muted playsinline autoplay loop>
                <source type="video/mp4" src="../../../public/assets/fondoUser.mp4">
            </video>
            <section>
                <h3>Registro de Nuevo Usuario</h3>
                <form action="../../../controllers/stakeholdersControllers/usersControllers/NewUserController.php" method="POST">
                    <label for="name">Nombre:</label>
                    <input type="text" id="name" name="name" required><br>

                    <label for="pswd">Contraseña:</label>
                    <input type="password" id="pswd" name="pswd" required><br>

                    <label for="type">Tipo de usuario:</label>
                    <select id="type" name="type" onchange="toggleAdditionalInfo()">
                        <option value="client">Cliente</option>
                        <option value="employee">Empleado</option>
                        <option value="provider">Proveedor</option>
                    </select><br><br>
                    <input type="submit" value="Añadir Usuario">
                </form>
            </section>
        </main>
        <footer>
            <p>&copy; 2024 NitaLink. Todos los derechos reservados.</p>
        </footer>
        <script>
            function toggleAdditionalInfo() {
                var userType = document.getElementById('type').value;
                var display = (userType === 'provider' || userType === 'employee') ? 'block' : 'none';
                document.getElementById('additionalInfo').style.display = display;
            }
        </script>
    </body>
</html>
