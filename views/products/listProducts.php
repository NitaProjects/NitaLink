<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Productos</title>
    <link rel="stylesheet" href="../../public/css/tabla.css">
</head>
<body>
    <h1>Listado de Productos</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID Producto</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Descuento</th>
                <th>Tipo de Producto</th>
                <th>Autor/Libro</th>
                <th>Páginas/Libro</th>
                <th>Editorial/Libro</th>
                <th>Duración/Curso</th>
                <th>Instructor/Curso</th>
                <th>Idioma/Curso</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['product_id']) ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['price']) ?>€</td>
                <td><?= htmlspecialchars($product['quantity']) ?></td>
                <td><?= htmlspecialchars($product['discount_percent']) ?>%</td>
                <td><?= htmlspecialchars($product['product_type']) ?></td>
                <td><?= $product['product_type'] === 'book' ? htmlspecialchars($product['author']) : 'N/A' ?></td>
                <td><?= $product['product_type'] === 'book' ? htmlspecialchars($product['pages']) : 'N/A' ?></td>
                <td><?= $product['product_type'] === 'book' ? htmlspecialchars($product['publisher']) : 'N/A' ?></td>
                <td><?= $product['product_type'] === 'course' ? htmlspecialchars($product['duration']) : 'N/A' ?></td>
                <td><?= $product['product_type'] === 'course' ? htmlspecialchars($product['instructor']) : 'N/A' ?></td>
                <td><?= $product['product_type'] === 'course' ? htmlspecialchars($product['language']) : 'N/A' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>



