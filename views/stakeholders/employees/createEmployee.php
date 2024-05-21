<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Crear Empleado</title>
        <link rel="stylesheet" href="../../../public/css/formulario2.css">
    </head>
    <body>
        <header>
            <h1>Registrar Empleado</h1>
        </header>
        <main>
            <video class="video" preload="auto" muted playsinline autoplay loop>
                <source type="video/mp4" src="../../../public/assets/fondoHexagonal.mp4">
            </video>
            <form action="../../controllers/stakeholdersControllers/createEmployeeController.php" method="POST">
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" required><br>

                <label for="address">Dirección:</label>
                <input type="text" id="address" name="address" required><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>

                <label for="phone">Teléfono:</label>
                <input type="text" id="phone" name="phone" required><br>

                <label for="department">Departamento:</label>
                <input type="text" id="department" name="department" required><br>

                <label for="salary">Salario:</label>
                <input type="number" id="salary" name="salary" step="0.01" required><br>

                <input type="submit" value="Crear Empleado">
            </form>
        </main>

        <footer>
            <p>&copy; 2024 NitaLink. Todos los derechos reservados.</p>
        </footer>
    </body>
</html>




