<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto</title>
    <link rel="stylesheet" href="../../public/css/formulario2.css">
</head>
<body>
    <header>
        <h1>Registrar Producto</h1>
    </header>
    
    <main>
        <video class="video" preload="auto" muted playsinline autoplay loop>
            <source type="video/mp4" src="../../public/assets/fondoHexagonal.mp4">
        </video>
        <form id="productForm" action="../../../controllers/productsControllers/newProductController.php" method="POST">
            <div class="form-group">
                <label for="productType">Tipo de Producto:</label>
                <select id="productType" name="productType" onchange="toggleProductInfo()" required>
                    <option value="Libro Físico">Libro Físico</option>
                    <option value="Libro Digital">Libro Digital</option>
                    <option value="Curso">Curso</option>
                </select>
            </div>

            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="price">Precio:</label>
                <input type="number" id="price" name="price" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="quantity">Cantidad:</label>
                <input type="number" id="quantity" name="quantity" required>
            </div>

            <div id="bookInfo" class="form-group">
                <div id="bookCommonInfo">
                    <label for="author">Autor:</label>
                    <input type="text" id="author" name="author">
                    <label for="pages">Páginas:</label>
                    <input type="number" id="pages" name="pages">
                    <label for="publisher">Editorial:</label>
                    <input type="text" id="publisher" name="publisher">
                    <label for="publishDate">Fecha de Publicación:</label>
                    <input type="text" id="publishDate" name="publishDate" placeholder="dd/mm/yyyy">
                    <label for="availabilityDate">Fecha de Disponibilidad:</label>
                    <input type="text" id="availabilityDate" name="availabilityDate" placeholder="dd/mm/yyyy">
                    <label for="isbn">ISBN:</label>
                    <input type="text" id="isbn" name="isbn">
                </div>
                <div id="physicalBookInfo" style="display:none;">
                    <label for="height">Altura (cm):</label>
                    <input type="number" id="height" name="height" step="0.01">
                    <label for="width">Ancho (cm):</label>
                    <input type="number" id="width" name="width" step="0.01">
                    <label for="length">Largo (cm):</label>
                    <input type="number" id="length" name="length" step="0.01">
                    <label for="weight">Peso (kg):</label>
                    <input type="number" id="weight" name="weight" step="0.01">
                    <label for="fragile">Frágil:</label>
                    <select id="fragile" name="fragile">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                    </select>
                </div>
            </div>

            <div id="courseInfo" class="form-group" style="display:none;">
                <label for="duration">Duración (horas):</label>
                <input type="number" id="duration" name="duration">
                <label for="instructor">Instructor:</label>
                <input type="text" id="instructor" name="instructor">
                <label for="language">Idioma:</label>
                <input type="text" id="language" name="language">
            </div>

            <div class="form-group">
                <input type="submit" value="Registrar Producto">
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 NitaLink. Todos los derechos reservados.</p>
    </footer>

    <script>
        function toggleProductInfo() {
            var form = document.getElementById('productForm');
            var productType = document.getElementById('productType').value;
            var bookInfo = document.getElementById('bookInfo');
            var bookCommonInfo = document.getElementById('bookCommonInfo');
            var physicalBookInfo = document.getElementById('physicalBookInfo');
            var courseInfo = document.getElementById('courseInfo');

            if (productType === 'Libro Físico') {
                bookInfo.style.display = 'block';
                bookCommonInfo.style.display = 'block';
                physicalBookInfo.style.display = 'block';
                courseInfo.style.display = 'none';
                form.action = "../../controllers/productsControllers/newPhysicalBookController.php";
            } else if (productType === 'Libro Digital') {
                bookInfo.style.display = 'block';
                bookCommonInfo.style.display = 'block';
                physicalBookInfo.style.display = 'none';
                courseInfo.style.display = 'none';
                form.action = "../../../controllers/productsControllers/newDigitalBookController.php";
            } else if (productType === 'Curso') {
                bookInfo.style.display = 'none';
                courseInfo.style.display = 'block';
                form.action = "../../../controllers/productsControllers/newCourseController.php";
            }
        }

        // Inicializar la visualización del formulario
        document.addEventListener("DOMContentLoaded", function() {
            toggleProductInfo();
        });
    </script>
</body>
</html>
