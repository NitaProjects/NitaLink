<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Libro</title>
    <link rel="stylesheet" href="../../public/css/formulario2.css">
</head>
<body>
    <video class="video" preload="auto" muted playsinline autoplay loop>
            <source type="video/mp4" src="../../public/assets/fondoHexagonal.mp4">
        </video>
    <h1>Editar Libro</h1>
    <?php if (isset($productData)): ?>
    <form action="../../controllers/productsControllers/updateBookController.php" method="post">
        <input type="hidden" name="productId" value="<?= $productData['product_id'] ?>">

        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($productData['name'] ?? '') ?>" required><br>

        <label for="price">Precio:</label>
        <input type="number" id="price" name="price" value="<?= htmlspecialchars($productData['price'] ?? '') ?>" required><br>

        <label for="quantity">Cantidad:</label>
        <input type="number" id="quantity" name="quantity" value="<?= htmlspecialchars($productData['quantity'] ?? 0) ?>" required><br>

        <label for="author">Autor:</label>
        <input type="text" id="author" name="author" value="<?= htmlspecialchars($productData['author'] ?? '') ?>" required><br>

        <label for="pages">Número de Páginas:</label>
        <input type="number" id="pages" name="pages" value="<?= htmlspecialchars($productData['pages'] ?? 0) ?>" required><br>

        <label for="publisher">Editorial:</label>
        <input type="text" id="publisher" name="publisher" value="<?= htmlspecialchars($productData['publisher'] ?? '') ?>" required><br>

        <input type="submit" value="Actualizar Libro">
    </form>
    <?php else: ?>
    <p>Libro no encontrado. Por favor, verifica el ID y vuelve a intentarlo.</p>
    <?php endif; ?>
</body>
</html>


