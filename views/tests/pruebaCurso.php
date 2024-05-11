<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cursos</title>
    <link rel="stylesheet" href="../../public/css/formulario.css">
</head>
<body>
     <header>
        <img src="../../public/assets/logo2.png" alt="NitaLink Logo">
        <h1>Prueba Curso</h1>
    </header>
    <form action="../../controllers/testsControllers/pruebaCursoController.php" method="POST">
        <input type="text" name="name" placeholder="Nombre del Curso" ><br>
        <input type="number" name="price" step="0.01" placeholder="Precio"><br>
        <input type="number" name="quantity" placeholder="Cantidad Disponible"><br>
        <input type="number" name="duration" placeholder="Duración en minutos"><br>
        <input type="text" name="instructor" placeholder="Instructor"><br>
        <input type="text" name="language" placeholder="Idioma"><br>
        <input type="submit" value="Registrar">
    </form>
    <footer>
        <p>&copy; 2024 NitaLink. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

