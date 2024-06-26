<?php
if (isset($_COOKIE['username'])) {
    $nombreUsuario = $_COOKIE['username'];
} else {
    header("Location: /nitalink/index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard Cliente - NitaLink</title>
        <link rel="stylesheet" href="../../../public/css/dashboardClient.css">
    </head>
    <body>
        <header>
            <nav>
                <ul>
                    <li><a href="productosCliente.php">Ver Productos</a></li>
                    <li><a href="cestaCompra.php">Cesta de la Compra</a></li>
                    <li><a href="devoluciones-cambios.php">Devoluciones/Cambios</a></li>
                    <li><a href="historialPedidos.php">Historial de Pedidos</a></li>
                    <li><a href="perfilUsuario.php">Mi Perfil</a></li>
                </ul>
            </nav>
            <div class="log">
                <a href="../logout.php" class="log">Cerrar sesión</a>
            </div>
        </header>
        <main>
            <video class="video" preload="auto" muted playsinline autoplay loop>
                <source type="video/mp4" src="../../../public/assets/fondoHexagonal.mp4">
            </video>
            <div class="dashboard-container">
                <section class="welcome">
                    <h1>Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?></h1>
                    <p>Esperamos que tengas una excelente experiencia de compra.</p>
                </section>
                <section class="quick-info">
                    <div class="info-card">
                        <h2>Productos en tu Cesta</h2>
                        <p>3</p>
                    </div>
                    <div class="info-card">
                        <h2>Pedidos Pendientes</h2>
                        <p>2</p>
                    </div>
                </section>
                <section class="recent-activities">
                    <h2>Actividades Recientes</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Actividad</th>
                                <th>Producto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2024-05-20</td>
                                <td>Pedido realizado</td>
                                <td>Libro XYZ</td>
                            </tr>
                            <tr>
                                <td>2024-05-19</td>
                                <td>Producto añadido a la cesta</td>
                                <td>Curso ABC</td>
                            </tr>
                        </tbody>
                    </table>
                </section>
                <section class="shortcuts">
                    <h2>Accesos Rápidos</h2>
                    <div class="buttons">
                        <button onclick="location.href = 'productosCliente.php'">Ver Productos</button>
                        <button onclick="location.href = 'cestaCompra.php'">Ver Cesta de la Compra</button>
                        <button onclick="location.href = 'devoluciones-cambios.php'">Devoluciones/Cambios</button>
                        <button onclick="location.href = 'historialPedidos.php'">Historial de Pedidos</button>
                    </div>
                </section>
                <section class="notifications">
                    <h2>Notificaciones</h2>
                    <ul>
                        <li>Tienes 3 mensajes nuevos</li>
                        <li>Tu pedido ha sido enviado</li>
                    </ul>
                </section>
            </div>
        </main>
        <footer>
            <p>&copy; 2024 NitaLink. Todos los derechos reservados.</p>
        </footer>
    </body>
</html>
