<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes - NitaLink</title>
    <link rel="stylesheet" href="../../../public/css/formulario2.css">
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
            <source type="video/mp4" src="../../../public/assets/fondoHexagonal.mp4">
        </video>
        <table>
            <section id="listadoClientes">
            <h2>Listado de Clientes</h2>
            <?php include '../../../controllers/stakeholdersControllers/clientsControllers/listClientsController.php'; ?>
</section>
        </table>
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
                fetch('../../controllers/stakeholdersControllers/clientsControllers/delateClientController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'client_id=' + clientId  // Asegúrate de que 'clientId' es el valor correcto
                    })
                    .then(response => response.text())
                    .then(data => {
                        
                            location.reload(); // Recarga la página para reflejar los cambios en la lista de clientes
                        })
                    .catch(error => console.error('Error:', error));
                }
            }
    </script>
</body>
</html>