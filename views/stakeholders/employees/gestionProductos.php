<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos - NitaLink</title>
    <link rel="stylesheet" href="../../../public/css/formulario2.css">
</head>
<body>
    <header>
        <h1>Gestión de Productos</h1>
        <nav>
            <ul>
                <li><a href="dashboardEmployee.php">Inicio</a></li>
                <li><a href="gestionClientes.php">Gestión de Clientes</a></li>
                <li><a href="gestionProveedores.php">Gestión de Proveedores</a></li>
                <li><a href="reportes.php">Reportes</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <video class="video" preload="auto" muted playsinline autoplay loop>
            <source type="video/mp4" src="../../../public/assets/fondoHexagonal.mp4">
        </video>
        <section id="lista-productos">
            <h2>Inventario de Productos</h2>
            
            <table>
                <thead>
                    <tr>
                        <th>ID Producto</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Categoría</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MySQLAdapter.php');
                    require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MySQLBookAdapter.php');
                    $adapter = new MysqlBookAdapter();
                    $products = $adapter->fetchAllProducts(); 
                    foreach ($products as $product) {
                        echo "<tr>";
                        echo "<td>{$product['product_id']}</td>";
                        echo "<td>{$product['name']}</td>";
                        echo "<td>\${$product['price']}</td>";
                        echo "<td>{$product['quantity']}</td>";
                        echo "<td>{$product['product_type']}</td>";
                        echo "<td>
                                <button onclick=\"toggleEditForm('edit-product-{$product['product_id']}')\">Editar</button>
                                <button onclick=\"deleteProduct({$product['product_id']})\">Borrar</button>
                              </td>";
                        echo "</tr>";
                        echo "<tr id='edit-product-{$product['product_id']}' class='edit-form' style='display:none;'>
                                <td colspan='5'>
                                    <form action='update_producto.php' method='post'>
                                        <input type='hidden' name='producto_id' value='{$product['product_id']}'>
                                        <label>Nombre: <input type='text' name='nombre' value='{$product['name']}'></label>
                                        <label>Precio: <input type='text' name='precio' value='{$product['price']}'></label>
                                        <label>Cantidad: <input type='number' name='cantidad' value='{$product['quantity']}'></label>
                                        <button type='submit'>Guardar Cambios</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
        <button onclick="showAddForm()">Añadir Producto</button>
        <div id="new-product-form" style="display:none;">
            <form action="add_producto.php" method="post">
                <label>Nombre: <input type="text" name="nombre" required></label>
                <label>Precio: <input type="text" name="precio" required></label>
                <label>Cantidad: <input type="number" name="cantidad" required></label>
                <button type="submit">Agregar Producto</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 NitaLink. Todos los derechos reservados.</p>
    </footer>
    <script>
        function toggleEditForm(formId) {
            var form = document.getElementById(formId);
            form.style.display = form.style.display === 'none' ? 'table-row' : 'none';
        }

        function showAddForm() {
            var form = document.getElementById('new-product-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        function deleteProduct(productId) {
            if(confirm('¿Está seguro de que desea eliminar este producto?')) {
                window.location.href = 'delete_producto.php?producto_id=' + productId;
            }
        }
    </script>
</body>
</html>
