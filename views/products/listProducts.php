<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Listado de Productos</title>
        <link rel="stylesheet" href="../../../public/css/listProducts.css">
        <style>
            .hidden {
                display: none;
            }
        </style>
    </head>
    <body>
        <main>
            <div class="filter-buttons">
                <button onclick="filterProducts('')">Todos</button>
                <button onclick="filterProducts('Libro Físico')">Libros Físicos</button>
                <button onclick="filterProducts('Libro Digital')">Libros Digitales</button>
                <button onclick="filterProducts('Curso')">Cursos</button>
                <input type="text" id="search-input" name="name" placeholder="Buscar Producto por nombre" autocomplete="off">
            </div>
            <div class="tabla-paginacion">
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>" class="pagination-link <?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
                <table border="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Tipo de Producto</th>
                            <th class="physical digital">Autor</th>
                            <th class="physical digital">Páginas</th>
                            <th class="physical digital">Editorial</th>
                            <th class="physical digital">Fecha de Publicación</th>
                            <th class="physical digital">Fecha de Disponibilidad</th>
                            <th class="physical digital">ISBN</th>
                            <th class="physical">Dimensiones</th>
                            <th class="physical">Peso</th>
                            <th class="physical">Frágil</th>
                            <th class="course">Duración</th>
                            <th class="course">Instructor</th>
                            <th class="course">Idioma</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="product-list">
                        <?php foreach ($products as $product): ?>
                            <tr id="row-<?= htmlspecialchars($product['product_id']) ?>" class="product-row" data-product-type="<?= htmlspecialchars($product['product_type']) ?>">
                                <td><?= htmlspecialchars($product['product_id']) ?></td>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td><?= htmlspecialchars($product['price']) ?></td>
                                <td><?= htmlspecialchars($product['quantity']) ?></td>
                                <td><?= htmlspecialchars($product['product_type']) ?></td>
                                <td class="physical digital"><?= htmlspecialchars($product['digital_author'] ?? $product['physical_author'] ?? '-') ?></td>
                                <td class="physical digital"><?= htmlspecialchars($product['digital_pages'] ?? $product['physical_pages'] ?? '-') ?></td>
                                <td class="physical digital"><?= htmlspecialchars($product['digital_publisher'] ?? $product['physical_publisher'] ?? '-') ?></td>
                                <td class="physical digital"><?= htmlspecialchars($product['digital_publish_date'] ?? $product['physical_publish_date'] ?? '-') ?></td>
                                <td class="physical digital"><?= htmlspecialchars($product['digital_availability_date'] ?? $product['physical_availability_date'] ?? '-') ?></td>
                                <td class="physical digital"><?= htmlspecialchars($product['digital_isbn'] ?? $product['physical_isbn'] ?? '-') ?></td>
                                <td class="physical"><?= isset($product['height']) && isset($product['width']) && isset($product['length']) ? htmlspecialchars("{$product['height']} x {$product['width']} x {$product['length']}") : '-' ?></td>
                                <td class="physical"><?= isset($product['weight']) ? htmlspecialchars("{$product['weight']} kg") : '-' ?></td>
                                <td class="physical"><?= isset($product['fragile']) && $product['fragile'] == 1 ? 'Sí' : '-' ?></td>
                                <td class="course"><?= htmlspecialchars($product['duration'] ?? '-') ?></td>
                                <td class="course"><?= htmlspecialchars($product['instructor'] ?? '-') ?></td>
                                <td class="course"><?= htmlspecialchars($product['language'] ?? '-') ?></td>
                                <td>
                                    <button onclick="toggleEditForm('edit-form-<?= $product['product_id'] ?>'); setFormAction(<?= $product['product_id'] ?>, '<?= $product['product_type'] ?>')">Editar</button>
                                    <button onclick="deleteProduct(<?= $product['product_id'] ?>)">Borrar</button>
                                </td>
                            </tr>
                            <tr id="edit-form-<?= htmlspecialchars($product['product_id']) ?>" style="display:none;">
                                <td colspan="17">
                                    <form id="edit-form-<?= htmlspecialchars($product['product_id']) ?>-form" method="post">
                                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']) ?>">
                                        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>">
                                        <input type="text" name="price" value="<?= htmlspecialchars($product['price']) ?>">
                                        <input type="number" name="quantity" value="<?= htmlspecialchars($product['quantity']) ?>">
                                        <input type="hidden" name="product_type" value="<?= htmlspecialchars($product['product_type']) ?>">

                                        <?php if ($product['product_type'] == 'Libro Físico'): ?>
                                            <input type="text" name="physical_author" value="<?= htmlspecialchars($product['physical_author'] ?? '') ?>">
                                            <input type="number" name="physical_pages" value="<?= htmlspecialchars($product['physical_pages'] ?? '') ?>">
                                            <input type="text" name="physical_publisher" value="<?= htmlspecialchars($product['physical_publisher'] ?? '') ?>">
                                            <input type="text" name="physical_publish_date" value="<?= htmlspecialchars($product['physical_publish_date'] ?? '') ?>">
                                            <input type="text" name="physical_availability_date" value="<?= htmlspecialchars($product['physical_availability_date'] ?? '') ?>">
                                            <input type="text" name="physical_isbn" value="<?= htmlspecialchars($product['physical_isbn'] ?? '') ?>">
                                            <input type="number" step="0.01" name="height" value="<?= isset($product['height']) ? htmlspecialchars($product['height']) : '' ?>">
                                            <input type="number" step="0.01" name="width" value="<?= isset($product['width']) ? htmlspecialchars($product['width']) : '' ?>">
                                            <input type="number" step="0.01" name="length" value="<?= isset($product['length']) ? htmlspecialchars($product['length']) : '' ?>">
                                            <input type="number" step="0.01" name="weight" value="<?= isset($product['weight']) ? htmlspecialchars($product['weight']) : '' ?>">
                                            <label>Fragil?</label>
                                            <select name="fragile">
                                                <option value="1" <?= isset($product['fragile']) && $product['fragile'] == 1 ? 'selected' : '' ?>>Sí</option>
                                                <option value="0" <?= isset($product['fragile']) && $product['fragile'] == 0 ? 'selected' : '' ?>>No</option>
                                            </select><br>
                                        <?php elseif ($product['product_type'] == 'Libro Digital'): ?>
                                            <input type="text" name="digital_author" value="<?= htmlspecialchars($product['digital_author'] ?? '') ?>">
                                            <input type="number" name="digital_pages" value="<?= htmlspecialchars($product['digital_pages'] ?? '') ?>">
                                            <input type="text" name="digital_publisher" value="<?= htmlspecialchars($product['digital_publisher'] ?? '') ?>">
                                            <input type="text" name="digital_publish_date" value="<?= htmlspecialchars($product['digital_publish_date'] ?? '') ?>">
                                            <input type="text" name="digital_availability_date" value="<?= htmlspecialchars($product['digital_availability_date'] ?? '') ?>">
                                            <input type="text" name="digital_isbn" value="<?= htmlspecialchars($product['digital_isbn'] ?? '') ?>">
                                        <?php elseif ($product['product_type'] == 'Curso'): ?>
                                            <input type="text" name="duration" value="<?= htmlspecialchars($product['duration'] ?? '') ?>">
                                            <input type="text" name="instructor" value="<?= htmlspecialchars($product['instructor'] ?? '') ?>">
                                            <input type="text" name="language" value="<?= htmlspecialchars($product['language'] ?? '') ?>">
                                        <?php endif; ?>
                                        <button type="submit">Guardar Cambios</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>


                    </tbody>
                </table>
            </div>
        </main>
        <script>
            function toggleEditForm(formId) {
                var form = document.getElementById(formId);
                form.style.display = form.style.display === 'none' ? 'table-row' : 'none';
            }

            function filterProducts(productType) {
                const rows = document.querySelectorAll('.product-row');
                rows.forEach(function (row) {
                    if (productType === '' || row.getAttribute('data-product-type') === productType) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
                toggleColumns(productType);
            }

            function toggleColumns(productType) {
                const columnsToShow = {
                    'Libros Físico': ['physical'],
                    'Libros Digital': ['digital'],
                    'Cursos': ['course'],
                    '': ['physical', 'digital', 'course']
                };

                const allColumns = ['physical', 'digital', 'course'];
                const columns = document.querySelectorAll('th, td');
                columns.forEach(column => {
                    allColumns.forEach(colClass => {
                        if (columnsToShow[productType].includes(colClass)) {
                            column.classList.remove('hidden');
                        } else {
                            column.classList.add('hidden');
                        }
                    });
                });
            }

            function searchProductsByName() {
                var input = document.getElementById('search-input').value.toLowerCase();
                var rows = document.querySelectorAll('.product-row');
                rows.forEach(function (row) {
                    var name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    if (name.includes(input)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            document.getElementById('search-input').addEventListener('input', searchProductsByName);

            document.addEventListener('DOMContentLoaded', () => {
                filterProducts(''); // Inicialmente mostrar todos los productos y todas las columnas
            });

            function setFormAction(productId, productType) {
                const form = document.getElementById(`edit-form-${productId}-form`);

                let actionUrl = '';

                switch (productType) {
                    case 'Libro Físico':
                        actionUrl = '/nitalink/controllers/productsControllers/updatePhysicalBookController.php';
                        break;
                    case 'Libro Digital':
                        actionUrl = '/nitalink/controllers/productsControllers/updateDigitalBookController.php';
                        break;
                    case 'Curso':
                        actionUrl = '/nitalink/controllers/productsControllers/updateCourseController.php';
                        break;
                    default:
                        actionUrl = '/nitalink/controllers/productsControllers/updateProductController.php';
                }

                form.action = actionUrl;
            }
        </script>
    </body>
</html>
