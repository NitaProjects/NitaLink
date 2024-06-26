<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestión de Proveedores - NitaLink</title>
        <link rel="stylesheet" href="../../../public/css/pruebaDashboardClientes.css">
    </head>
    <body>
        <header>
            <h1>Gestión de Proveedores</h1>
            <nav>
                <ul>
                    <li><a href="dashboardEmployee.php">Inicio</a></li>
                    <li><a href="createProvider.php">Añadir Proveedor</a></li>
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
            <section id="listadoProveedores">
                <?php include '../../../controllers/stakeholdersControllers/providersControllers/listProvidersController.php'; ?>
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

            function deleteProveedor(providerId) {
                if (confirm('¿Está seguro de que desea eliminar este proveedor?')) {
                    fetch('../../../controllers/stakeholdersControllers/providersControllers/deleteProviderController.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'provider_id=' + providerId
                    })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert("Proveedor eliminado con éxito.");
                                    document.getElementById('row-' + providerId).remove();
                                } else {
                                    alert("Error al eliminar el proveedor.");
                                }
                            })
                            .catch(error => console.error('Error:', error));
                }
            }
        </script>
    </body>
</html>

