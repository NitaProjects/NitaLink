<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Curso</title>
    <link rel="stylesheet" href="../../public/css/formulario2.css">
</head>
<body>
    <h1>Editar Curso</h1>
    <?php if (isset($productData)): ?>
    <form action="../../controllers/productsControllers/updateCourseController.php" method="post">
        <input type="hidden" name="productId" value="<?= $productData['product_id'] ?>">

        <label for="name">Nombre del Curso:</label>
        <input type="text" id="name" name="name" value="<?= $productData['name'] ?>" required><br>

        <label for="price">Precio:</label>
        <input type="number" id="price" name="price" value="<?= $productData['price'] ?>" required><br>

        <label for="quantity">Cantidad:</label>
        <input type="number" id="quantity" name="quantity" value="<?= $productData['quantity'] ?>" required><br>

        <label for="duration">Duración (en minutos):</label>
        <input type="number" id="duration" name="duration" value="<?= $productData['duration'] ?>" required><br>

        <label for="instructor">Instructor:</label>
        <input type="text" id="instructor" name="instructor" value="<?= $productData['instructor'] ?>" required><br>

        <label for="language">Idioma:</label>
        <input type="text" id="language" name="language" value="<?= $productData['language'] ?>" required><br>

        <input type="submit" value="Actualizar Curso">
    </form>
    <?php else: ?>
    <p>Curso no encontrado. Por favor, verifica el ID y vuelve a intentarlo.</p>
    <?php endif; ?>
</body>
</html>


