<?php
if (isset($_COOKIE['username'])) {
    $nombreUsuario = $_COOKIE['username'];
} else {
    header("Location: /nitalink/index.html");
    exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/persistence/MysqlProductAdapter.php');

$adapter = new MysqlProductAdapter();

try {
    $products = $adapter->getProducts();
} catch (Exception $e) {
    echo "Error al obtener los productos: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ver Productos - NitaLink</title>
        <link rel="stylesheet" href="../../../public/css/productos.css">
        <style>

        </style>
    </head>
    <body>
        <header>
            <h1>Productos</h1>
            <nav>
                <ul>
                    <li><a href="dashboardClient.php">Inicio</a></li>
                    <li><a href="cestaCompra.php">Cesta de la Compra</a></li>
                    <li><a href="devoluciones-cambios.php">Devoluciones/Cambios</a></li>     
                    <li><a href="historialPedidos.php">Historial de Pedidos</a></li>
                    <li><a href="perfilUsuario.php">Mi Perfil</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <video class="video" preload="auto" muted playsinline autoplay loop>
                <source type="video/mp4" src="../../../public/assets/fondoHexagonal.mp4">
            </video>
            <div class="gallery">
                <?php foreach ($products as $product): ?>
                    <div class="gallery-item">
                        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                        <p>Precio:<?php echo htmlspecialchars($product['price']); ?> €</p>
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <button onclick="addToCart(<?php echo htmlspecialchars($product['product_id']); ?>)">Añadir</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>    
        <footer>
            <p>&copy; 2024 NitaLink. Todos los derechos reservados.</p>
        </footer>
        <script>
            function addToCart(productId) {
                // Lógica para añadir el producto a la cesta
                console.log('Producto añadido a la cesta:', productId);
            }
        </script>
    </body>
</html>


