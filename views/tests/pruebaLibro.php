<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Libros</title>
    <link rel="stylesheet" href="../../public/css/formulario.css">
</head>
<body data-theme="dark">
    <header>
        <img src="../../public/assets/logo2.png" alt="NitaLink Logo">
        <h1>Prueba Libro</h1>
    </header>
    <form action="../../controllers/testsControllers/pruebaLibroController.php" method="POST">
        <input type="text" name="title" placeholder="Título del Libro"><br>
        <input type="text" name="price" placeholder="Precio"><br>
        <input type="text" name="quantity" placeholder="Cantidad"><br>
        <input type="text" name="isbn" placeholder="ISBN"><br>
        <input type="text" name="author" placeholder="Autor"><br>
        <input type="number" name="pages" placeholder="Número de Páginas"><br>
        <input type="text" name="publisher" placeholder="Editorial"><br>
        <input type="text" name="publishDate" placeholder="Fecha de Publicación (dd/mm/yyyy)"><br>
        <input type="text" name="availabilityDate" placeholder="Fecha de Disponibilidad (dd/mm/yyyy)"><br>
        
        <label for="bookType">Tipo de Libro:</label>
        <select name="bookType" id="bookType" onchange="togglePhysicalFields()">
            <option value="digital">Digital</option>
            <option value="fisico">Físico</option>
        </select><br>
        
        <div id="physicalFields" style="display:none;">
            <input type="number" name="height" step="0.01" placeholder="Altura (cm)"><br>
            <input type="number" name="width" step="0.01" placeholder="Anchura (cm)"><br>
            <input type="number" name="length" step="0.01" placeholder="Longitud (cm)"><br>
            <input type="number" name="weight" step="0.01" placeholder="Peso (kg)"><br>
            <label for="isFragile">¿Es frágil?</label>
            <select name="isFragile" id="isFragile">
                <option value="no">No</option>
                <option value="si">Sí</option>
            </select><br>
        </div>
        
        <input type="submit" value="Registrar">
    </form>
    <footer>
        <p>&copy; 2024 NitaLink. Todos los derechos reservados.</p>
    </footer>
    <script>
        function togglePhysicalFields() {
            var bookType = document.getElementById('bookType').value;
            var display = (bookType === 'fisico') ? 'block' : 'none';
            document.getElementById('physicalFields').style.display = display;
        }
    </script>
</body>
</html>
