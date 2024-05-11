<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pedidos - NitaLink</title>
    <link rel="stylesheet" href="../../../public/css/formulario2.css">
</head>
<body>
    <header>
        <h1>Gestión de Pedidos</h1>
        <nav>
            <ul>
                <li><a href="dashboardEmployee.php">Inicio</a></li>
                <li><a href="gestionProductos.php">Gestión de Productos</a></li>
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
        <section id="lista-pedidos-clientes">
            <h2>Pedidos de Clientes</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Ejemplo de fila de pedido de cliente -->
                    <tr>
                        <td>1001</td>
                        <td>Juan Pérez</td>
                        <td>2024-01-15</td>
                        <td>Pendiente</td>
                        <td>
                            <button onclick="toggleEditForm('edit-form-1001')">Actualizar</button>
                            <button onclick="toggleEditForm('edit-form-1001')">Detalles</button>
                        </td>
                    </tr>
                    <tr id="edit-form-1001" class="edit-form" style="display:none;">
                        <td colspan="5">
                            <form action="update_pedido_cliente.php" method="post">
                                <input type="hidden" name="id_pedido" value="1001">
                                <label>Estado:
                                    <select name="estado">
                                        <option value="Pendiente" selected>Pendiente</option>
                                        <option value="Enviado">Enviado</option>
                                        <option value="Entregado">Entregado</option>
                                        <option value="Cancelado">Cancelado</option>
                                    </select>
                                </label>
                                <button type="submit">Guardar Cambios</button>
                            </form>
                        </td>
                    </tr>
                    <!-- Más pedidos de clientes -->
                </tbody>
            </table>
        </section>
        <section id="pedidos-proveedores">
            <h2>Pedidos a Proveedores</h2>
            <button onclick="showForm()">Añadir Pedido</button>
            <div id="new-order-form" style="display:none;">
                <form action="add_pedido_proveedor.php" method="post">
                    <label>Proveedor:
                        <select name="proveedor_id">
                            <!-- Opciones de proveedores cargadas dinámicamente -->
                        </select>
                    </label>
                    <label>Producto:
                        <input type="text" name="producto" required>
                    </label>
                    <label>Cantidad:
                        <input type="number" name="cantidad" required>
                    </label>
                    <button type="submit">Enviar Pedido</button>
                </form>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 NitaLink. Todos los derechos reservados.</p>
    </footer>
    <script>
        function toggleEditForm(formId) {
            var form = document.getElementById(formId);
            form.style.display = form.style.display === 'none' ? 'table-row' : 'none';
        }

        function showForm() {
            var form = document.getElementById('new-order-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>
</html>
