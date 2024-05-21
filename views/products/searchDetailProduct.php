<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Buscar Producto para Editar</title>
        <link rel="stylesheet" href="../../public/css/style.css">
    </head>
    <body>
        <h1>Buscar Producto para Editar</h1>
        <form action="../../controllers/productsControllers/detailProductController.php" method="get">
            <label for="productId">ID del Producto:</label>
            <input type="text" id="productId" name="productId">
            <input type="submit" value="Buscar">
        </form>
    </body>
</html>

