<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles del Producto</title>
    <link rel="stylesheet" href="../../public/css/tabla.css">
</head>
<body>
    <h1>Detalles del Producto</h1>
    <?php if (isset($productDetails)): ?>
    <table>
        <tr>
            <th>Nombre:</th>
            <td><?= htmlspecialchars($productDetails['name']) ?></td>
        </tr>
        <tr>
            <th>Precio:</th>
            <td><?= htmlspecialchars($productDetails['price']) ?> €</td>
        </tr>
        <tr>
            <th>Cantidad:</th>
            <td><?= htmlspecialchars($productDetails['quantity']) ?> und</td>
        </tr>
        <?php if ($productDetails['product_type'] === 'book'): ?>
        <tr>
            <th>Autor:</th>
            <td><?= htmlspecialchars($productDetails['author']) ?></td>
        </tr>
        <tr>
            <th>Páginas:</th>
            <td><?= htmlspecialchars($productDetails['pages']) ?> páginas</td>
        </tr>
        <tr>
            <th>Editorial:</th>
            <td><?= htmlspecialchars($productDetails['publisher']) ?></td>
        </tr>
        <?php elseif ($productDetails['product_type'] === 'course'): ?>
        <tr>
            <th>Duración (minutos):</th>
            <td><?= htmlspecialchars($productDetails['duration']) ?> minutos</td>
        </tr>
        <tr>
            <th>Instructor:</th>
            <td><?= htmlspecialchars($productDetails['instructor']) ?></td>
        </tr>
        <tr>
            <th>Idioma:</th>
            <td><?= htmlspecialchars($productDetails['language']) ?></td>
        </tr>
        <?php endif; ?>
    </table>
    <?php else: ?>
    <p>Producto no encontrado. Por favor, verifica el ID y vuelve a intentarlo.</p>
    <?php endif; ?>
</body>
</html>





