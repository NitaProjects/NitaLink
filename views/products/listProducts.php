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
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Tipo de Producto</th>
                <th>Autor</th>
                <th>Páginas</th>
                <th>Editorial</th>
                <th>Fecha de Publicación</th>
                <th>Fecha de Disponibilidad</th>
                <th>ISBN</th>
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
                    <td><?= htmlspecialchars($product['digital_isbn'] ?? $product['physical_isbn'] ?? '-') ?></td>
                    <td><?= isset($product['height']) && isset($product['width']) && isset($product['length']) ? htmlspecialchars("{$product['height']} x {$product['width']} x {$product['length']}") : '-' ?></td>
                    <td><?= isset($product['weight']) ? htmlspecialchars("{$product['weight']} kg") : '-' ?></td>
                    <td><?= isset($product['fragile']) && $product['fragile'] == 1 ? 'Sí' : '-' ?></td>
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
                        <form action="../../../controllers/productsControllers/updateProductController.php" method="post">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']) ?>">
                            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>">
                            <input type="text" name="price" value="<?= htmlspecialchars($product['price']) ?>">
                            <input type="number" name="quantity" value="<?= htmlspecialchars($product['quantity']) ?>">
                            <input type="text" name="product_type" value="<?= htmlspecialchars($product['product_type']) ?>">
                            <input type="text" name="author" value="<?= htmlspecialchars($product['digital_author'] ?? $product['physical_author'] ?? '') ?>">
                            <input type="number" name="pages" value="<?= htmlspecialchars($product['digital_pages'] ?? $product['physical_pages'] ?? '') ?>">
                            <input type="text" name="publisher" value="<?= htmlspecialchars($product['digital_publisher'] ?? $product['physical_publisher'] ?? '') ?>">
                            <input type="text" name="publish_date" value="<?= htmlspecialchars($product['digital_publish_date'] ?? $product['physical_publish_date'] ?? '') ?>">
                            <input type="text" name="availability_date" value="<?= htmlspecialchars($product['digital_availability_date'] ?? $product['physical_availability_date'] ?? '') ?>">
                            <input type="text" name="isbn" value="<?= htmlspecialchars($product['digital_isbn'] ?? $product['physical_isbn'] ?? '') ?>">
                            <input type="number" step="0.01" name="height" value="<?= isset($product['height']) ? htmlspecialchars($product['height']) : '' ?>">
                            <input type="number" step="0.01" name="width" value="<?= isset($product['width']) ? htmlspecialchars($product['width']) : '' ?>">
                            <input type="number" step="0.01" name="length" value="<?= isset($product['length']) ? htmlspecialchars($product['length']) : '' ?>">
                            <input type="number" step="0.01" name="weight" value="<?= isset($product['weight']) ? htmlspecialchars($product['weight']) : '' ?>">
                            <input type="text" name="duration" value="<?= htmlspecialchars($product['duration'] ?? '') ?>">
                            <input type="text" name="instructor" value="<?= htmlspecialchars($product['instructor'] ?? '') ?>">
                            <input type="text" name="language" value="<?= htmlspecialchars($product['language'] ?? '') ?>">
                            <label>Fragil?</label>
                            <select name="fragile">
                                <option value="1" <?= isset($product['fragile']) && $product['fragile'] == 1 ? 'selected' : '' ?>>Sí</option>
                                <option value="0" <?= isset($product['fragile']) && $product['fragile'] == 0 ? 'selected' : '' ?>>No</option>
                            </select><br>
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

        function deleteProduct(productId) {
            if (confirm('¿Está seguro de que desea eliminar este producto?')) {
                fetch('../../../controllers/productsControllers/deleteProductController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'product_id=' + productId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Producto eliminado con éxito.");
                        document.getElementById('row-' + productId).remove();
                    } else {
                        alert("Error al eliminar el producto.");
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
</body>
</html>
