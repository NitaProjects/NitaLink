<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Producto</title>
    <link rel="stylesheet" href="../../public/css/formulario.css">
    <script>
        function toggleFields() {
            let productType = document.getElementById("productType").value;
            let bookFields = document.getElementById("bookFields");
            let courseFields = document.getElementById("courseFields");

            if (productType === "book") {
                bookFields.style.display = "block";
                courseFields.style.display = "none";
            } else if (productType === "course") {
                bookFields.style.display = "none";
                courseFields.style.display = "block";
            } else {
                bookFields.style.display = "none";
                courseFields.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <main>
    <h1>Añadir Producto</h1>
    <video class="video" preload="auto" muted playsinline autoplay loop>
            <source type="video/mp4" src="../../public/assets/fondoHexagonal.mp4">
        </video>
    <form action="../../controllers/productsControllers/createProductController.php" method="post">
        <label for="name">Nombre del Producto:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="price">Precio:</label>
        <input type="number" id="price" name="price" step="0.01" required><br>

        <label for="quantity">Cantidad:</label>
        <input type="number" id="quantity" name="quantity" required><br>

        <label for="productType">Tipo de Producto:</label>
        <select id="productType" name="productType" onchange="toggleFields()" required>
            <option value="">Seleccione...</option>
            <option value="book">Libro</option>
            <option value="course">Curso</option>
        </select><br>

        <div id="bookFields" style="display:none;">
            <label for="author">Autor:</label>
            <input type="text" id="author" name="author"><br>

            <label for="pages">Páginas:</label>
            <input type="number" id="pages" name="pages"><br>

            <label for="publisher">Editorial:</label>
            <input type="text" id="publisher" name="publisher"><br>
        </div>

        <div id="courseFields" style="display:none;">
            <label for="duration">Duración (en horas):</label>
            <input type="number" id="duration" name="duration"><br>

            <label for="instructor">Instructor:</label>
            <input type="text" id="instructor" name="instructor"><br>

            <label for="language">Idioma:</label>
            <input type="text" id="language" name="language"><br>
        </div>

        <input type="submit" value="Añadir Producto">
    </form>
    </main>
</body>
</html>


