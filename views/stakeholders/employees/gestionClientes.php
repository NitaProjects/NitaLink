<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestión de Clientes - NitaLink</title>
        <link rel="stylesheet" href="../../../public/css/pruebaDashboardClientes.css">
    </head>
    <body>
        <header>
            <h1>Gestión de Clientes</h1>
            <nav>
                <ul>
                    <li><a href="dashboardEmployee.php">Inicio</a></li>
                    <li><a href="createClient.php">Añadir Cliente</a></li>
                    <li><a href="gestionProductos.php">Gestión de Productos</a></li>              
                    <li><a href="gestionProveedores.php">Gestión de Proveedores</a></li>
                    <li><a href="gestionPedidos.php">Gestión de Pedidos</a></li>
                    <li><a href="reportes.php">Reportes</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <video class="video" preload="auto" muted playsinline autoplay loop>
                <source type="video/mp4" src="../../../public/assets/bosqueOtoño.mp4">
            </video>
            <section id="listadoClientes">
                <?php include '../../../controllers/stakeholdersControllers/clientsControllers/listClientsController.php'; ?>
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
            function deleteCliente(clientId) {
                if (confirm('¿Está seguro de que desea eliminar este cliente?')) {
                    fetch('../../../controllers/stakeholdersControllers/clientsControllers/delateClientController.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'client_id=' + clientId
                    })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert("Cliente eliminado con éxito.");
                                    document.getElementById('row-' + clientId).remove();
                                } else {
                                    alert("Error al eliminar el cliente.");
                                }
                            })
                            .catch(error => console.error('Error:', error));
                }
            }
        </script>
    </body>
</html>
