<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestión de Productos - NitaLink</title>
        <link rel="stylesheet" href="../../../public/css/pruebaDashboardClientes.css">
    </head>
    <body>
        <header>
            <h1>Gestión de Productos</h1>
            <nav>
                <ul>
                    <li><a href="dashboardEmployee.php">Inicio</a></li>
                    <li><a href="../../products/createProduct.php">Añadir Producto</a></li>
                    <li><a href="gestionClientes.php">Gestión de Clientes</a></li>
                    <li><a href="gestionProveedores.php">Gestión de Proveedores</a></li>
                    <li><a href="reportes.php">Reportes</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <video class="video" preload="auto" muted playsinline autoplay loop>
                <source type="video/mp4" src="../../../public/assets/bosqueOtoño.mp4">
            </video>
            <section id="listadoProductos">
                <?php include '../../../controllers/productsControllers/listProductsController.php'; ?>
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
