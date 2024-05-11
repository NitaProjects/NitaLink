<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Proveedores - NitaLink</title>
    <link rel="stylesheet" href="../../../public/css/formulario2.css">
</head>
<body>
    <header>
        <h1>Gestión de Proveedores</h1>
        <nav>
            <ul>
                <li><a href="dashboardEmployee.php">Inicio</a></li>
                <li><a href="gestionProductos.php">Gestión de Productos</a></li>
                <li><a href="gestionClientes.php">Gestión de Clientes</a></li>
                <li><a href="gestionPedidos.php">Gestión de Pedidos</a></li>
                <li><a href="reportes.php">Reportes</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <video class="video" preload="auto" muted playsinline autoplay loop>
            <source type="video/mp4" src="../../../public/assets/fondoHexagonal.mp4">
        </video>
        <section id="lista-proveedores">
            <h2>Lista de Proveedores</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Contacto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Supongamos que esta fila es generada dinámicamente con PHP -->
                    <tr>
                        <td>1</td>
                        <td>Proveedor ABC</td>
                        <td>contacto@abc.com</td>
                        <td>
                            <button onclick="toggleEditForm('edit-form-1')">Editar</button>
                            <button onclick="deleteProveedor(1)">Borrar</button>
                        </td>
                    </tr>
                    <tr id="edit-form-1" class="edit-form" style="display:none;">
                        <td colspan="4">
                            <form action="update_proveedor.php" method="post">
                                <input type="hidden" name="id" value="1">
                                <label>Nombre: <input type="text" name="nombre" value="Proveedor ABC"></label>
                                <label>Contacto: <input type="email" name="contacto" value="contacto@abc.com"></label>
                                <button type="submit">Actualizar</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
        <section id="añadir-proveedor">
            <h2>Añadir Nuevo Proveedor</h2>
            <form action="add_proveedor.php" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                
                <label for="contacto">Contacto:</label>
                <input type="email" id="contacto" name="contacto" required>
                
                <button type="submit">Añadir Proveedor</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 NitaLink. Todos los derechos reservados.</p>
    </footer>
    <script>
        function toggleEditForm(formId) {
            var form = document.getElementById(formId);
            if (form.style.display === 'none') {
                form.style.display = 'table-row';
            } else {
                form.style.display = 'none';
            }
        }
        
        function deleteProveedor(proveedorId) {
            // Añadir lógica para borrar el proveedor o mostrar un mensaje de confirmación aquí
            alert('Eliminar proveedor con ID: ' + proveedorId);
        }
    </script>
</body>
</html>

