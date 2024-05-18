<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Productos</title>
    <link rel="stylesheet" href="../../../public/css/tabla.css">
</head>
<body>
    <div class="filter-buttons">
        <button onclick="filterProducts('')">Todos</button>
        <button onclick="filterProducts('Libro Físico')">Libros Físicos</button>
        <button onclick="filterProducts('Libro Digital')">Libros Digitales</button>
        <button onclick="filterProducts('Curso')">Cursos</button>
    </div>
    <table border="1">
        <thead>
            <tr>
                <th>ID Producto</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Tipo de Producto</th>
                <th>Autor</th>
                <th>Páginas</th>
                <th>Editorial</th>
                <th>Fecha de Publicación</th>
                <th>Fecha de Disponibilidad</th>
                <th>Dimensiones</th>
                <th>Peso</th>
                <th>Frágil</th>
                <th>Duración</th>
                <th>Instructor</th>
                <th>Idioma</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="product-list">
            <?php foreach ($products as $product): ?>
                <tr id="row-<?= htmlspecialchars($product['product_id']) ?>"class="product-row" data-product-type="<?= htmlspecialchars($product['product_type']) ?>">
                    <td><?= htmlspecialchars($product['product_id']) ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['price']) ?></td>
                    <td><?= htmlspecialchars($product['quantity']) ?></td>
                    <td><?= htmlspecialchars($product['product_type']) ?></td>
                    <td><?= htmlspecialchars($product['digital_author'] ?? $product['physical_author'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($product['digital_pages'] ?? $product['physical_pages'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($product['digital_publisher'] ?? $product['physical_publisher'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($product['digital_publish_date'] ?? $product['physical_publish_date'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($product['digital_availability_date'] ?? $product['physical_availability_date'] ?? '-') ?></td>
                    <td><?= isset($product['height']) && isset($product['width']) && isset($product['length']) ? htmlspecialchars("{$product['height']} x {$product['width']} x {$product['length']}") : '-' ?></td>
                    <td><?= isset($product['weight']) ? htmlspecialchars("{$product['weight']} kg") : '-' ?></td>
                    <td><?= isset($product['fragile']) && $product['fragile'] == 1 ? 'Sí' : 'No' ?></td>
                    <td><?= htmlspecialchars($product['duration'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($product['instructor'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($product['language'] ?? '-') ?></td>
                    <td>
                        <button onclick="toggleEditForm('edit-form-<?= $product['product_id'] ?>')">Editar</button>
                        <button onclick="deleteProduct(<?= $product['product_id'] ?>)">Borrar</button>
                    </td>
                </tr>
                <tr id="edit-form-<?= htmlspecialchars($product['product_id']) ?>" style="display:none;">
                    <td colspan="17">
                        <form action="../../../controllers/stakeholdersControllers/productsControllers/updateProductController.php" method="post">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']) ?>">
                            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>">
                            <input type="text" name="price" value="<?= htmlspecialchars($product['price']) ?>">
                            <input type="number" name="quantity" value="<?= htmlspecialchars($product['quantity']) ?>">
                            <input type="text" name="author" value="<?= htmlspecialchars($product['digital_author'] ?? $product['physical_author'] ?? '') ?>">
                            <input type="number" name="pages" value="<?= htmlspecialchars($product['digital_pages'] ?? $product['physical_pages'] ?? '') ?>">
                            <input type="text" name="publisher" value="<?= htmlspecialchars($product['digital_publisher'] ?? $product['physical_publisher'] ?? '') ?>">
                            <input type="text" name="publish_date" value="<?= htmlspecialchars($product['digital_publish_date'] ?? $product['physical_publish_date'] ?? '') ?>">
                            <input type="text" name="availability_date" value="<?= htmlspecialchars($product['digital_availability_date'] ?? $product['physical_availability_date'] ?? '') ?>">
                            <input type="text" name="dimensions" value="<?= isset($product['height']) && isset($product['width']) && isset($product['length']) ? htmlspecialchars("{$product['height']} x {$product['width']} x {$product['length']}") : '' ?>">
                            <input type="text" name="weight" value="<?= isset($product['weight']) ? htmlspecialchars("{$product['weight']} kg") : '' ?>">
                            <input type="text" name="fragile" value="<?= isset($product['fragile']) && $product['fragile'] == 1 ? 'Sí' : 'No' ?>">
                            <input type="text" name="duration" value="<?= htmlspecialchars($product['duration'] ?? '') ?>">
                            <input type="text" name="instructor" value="<?= htmlspecialchars($product['instructor'] ?? '') ?>">
                            <input type="text" name="language" value="<?= htmlspecialchars($product['language'] ?? '') ?>">
                            <button type="submit">Guardar Cambios</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <script>
        function toggleEditForm(formId) {
            var form = document.getElementById(formId);
            if (form.style.display === 'none') {
                form.style.display = 'table-row';
            } else {
                form.style.display = 'none';
            }
        }

        function filterProducts(productType) {
            const rows = document.querySelectorAll('.product-row');
            rows.forEach(row => {
                if (productType === '' || row.getAttribute('data-product-type') === productType) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
