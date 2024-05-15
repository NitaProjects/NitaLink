<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Productos</title>
    <link rel="stylesheet" href="../../../public/css/tabla.css">
</head>
<body>
    <h1>Listado de Productos</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID Producto</th>
                <th>Nombre</th>
                <th>Precio</th> 
                <th>Cantidad</th>
                <th>Descuento</th>
                <th>Tipo de Producto</th>
                <th>Autor/Libro</th>
                <th>Páginas/Libro</th>
                <th>Editorial/Libro</th>
                <th>Duración/Curso</th>
                <th>Instructor/Curso</th>
                <th>Idioma/Curso</th>
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
</body>
</html>



