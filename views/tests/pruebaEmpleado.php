<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empleados</title>
    <link rel="stylesheet" href="../../public/css/formulario.css">
</head>
<body data-theme="dark">
    <header>
        <img src="../../public/assets/logo2.png" alt="NitaLink Logo">
        <h1>Prueba Empleado</h1>
    </header>
    <form action="../../controllers/testsControllers/pruebaEmpleadoController.php" method="POST">
        <input type="text" name="name" placeholder="Nombre"><br>
        <input type="text" name="address" placeholder="Dirección"><br>
        <input type="text" name="email" placeholder="Email"><br>
        <input type="text" name="phoneNumber" placeholder="Teléfono" ><br>
        <input type="text" name="department" placeholder="Departamento" ><br>
        <input type="number" name="salary" placeholder="Sueldo" ><br>
        
        <input type="text" name="contractDate" placeholder="Fin Contrato, formato dd/mm/yyyy"><br>
        <input type="submit" value="Registrar">
    </form>
    <footer>
        <p>&copy; 2024 NitaLink. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
