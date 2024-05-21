<?php
if (isset($_COOKIE['username'])) {
    $nombreUsuario = $_COOKIE['username'];
} else {
    // Si no hay un nombre de usuario en las cookies, redirige al usuario a la página de inicio de sesión
    header("Location: /nitalink/index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Empleado - NitaLink</title>
    <link rel="stylesheet" href="../../../public/css/dashboardEmployee.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="gestionClientes.php">Gestión de Clientes</a></li>
                <li><a href="gestionProductos.php">Gestión de Productos</a></li>
                <li><a href="gestionProveedores.php">Gestión de Proveedores</a></li>
                <li><a href="gestionPedidos.php">Gestión de Pedidos</a></li>
                <li><a href="reportes.html">Reportes</a></li>
            </ul>
        </nav>
        <div class="log">
            <a href="../logout.php" class="log">Cerrar sesión</a>
        </div>
    </header>
    <main>
        <video class="video" preload="auto" muted playsinline autoplay loop>
            <source type="video/mp4" src="../../../public/assets/cascadaBosque.mp4">
        </video>
        <div class="dashboard-container">
            <section class="welcome">
                <h1>Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?></h1>
                <p>Esperamos que tengas un excelente día de trabajo.</p>
            </section>
            <section class="quick-info">
                <div class="info-card">
                    <h2>Clientes</h2>
                    <p>150</p>
                </div>
                <div class="info-card">
                    <h2>Productos</h2>
                    <p>300</p>
                </div>
                <div class="info-card">
                    <h2>Proveedores</h2>
                    <p>20</p>
                </div>
                <div class="info-card">
                    <h2>Pedidos</h2>
                    <p>75</p>
                </div>
            </section>
            <section class="recent-activities">
                <h2>Actividades Recientes</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Actividad</th>
                            <th>Empleado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2024-05-20</td>
                            <td>Nuevo cliente agregado</td>
                            <td>Juan Pérez</td>
                        </tr>
                        <tr>
                            <td>2024-05-19</td>
                            <td>Pedido completado</td>
                            <td>María Gómez</td>
                        </tr>
                    </tbody>
                </table>
            </section>
            <section class="shortcuts">
                <h2>Accesos Rápidos</h2>
                <div class="buttons">
                    <button onclick="location.href='createClient.php'">Agregar Cliente</button>
                    <button onclick="location.href='../../products/createProduct.php'">Agregar Producto</button>
                    <button onclick="location.href='createProvider.php'">Agregar Proveedor</button>
                    <button onclick="location.href='gestionPedidos.php'">Agregar Pedido</button>
                </div>
            </section>
            <section class="notifications">
                <h2>Notificaciones</h2>
                <ul>
                    <li>Tienes 3 mensajes nuevos</li>
                    <li>Actualización de sistema programada para mañana</li>
                </ul>
            </section>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 NitaLink. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
