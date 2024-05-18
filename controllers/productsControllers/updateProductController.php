<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlProductAdapter.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/products/BookPhysical.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/products/BookDigital.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/products/Course.php');

$adapter = new MysqlProductAdapter();

// Recoger los datos del formulario usando filter_input
$product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
$product_type = filter_input(INPUT_POST, 'product_type', FILTER_SANITIZE_STRING);

try {
    if ($product_type == 'Libro Físico') {
        $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_STRING);
        $pages = filter_input(INPUT_POST, 'pages', FILTER_VALIDATE_INT);
        $publisher = filter_input(INPUT_POST, 'publisher', FILTER_SANITIZE_STRING);
        $publish_date = filter_input(INPUT_POST, 'publish_date', FILTER_SANITIZE_STRING);
        $availability_date = filter_input(INPUT_POST, 'availability_date', FILTER_SANITIZE_STRING);
        $height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_FLOAT);
        $width = filter_input(INPUT_POST, 'width', FILTER_VALIDATE_FLOAT);
        $length = filter_input(INPUT_POST, 'length', FILTER_VALIDATE_FLOAT);
        $weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
        $fragile = filter_input(INPUT_POST, 'fragile', FILTER_VALIDATE_BOOLEAN);
        $isbn = filter_input(INPUT_POST, 'isbn', FILTER_SANITIZE_STRING);

        $product = new BookPhysical($product_id, $name, $price, $quantity, $author, $pages, $publisher, $publish_date, $availability_date, $isbn, $height, $width, $length, $weight, $fragile);
        $success = $adapter->updatePhysicalBook($product);
    } elseif ($product_type == 'Libro Digital') {
        $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_STRING);
        $pages = filter_input(INPUT_POST, 'pages', FILTER_VALIDATE_INT);
        $publisher = filter_input(INPUT_POST, 'publisher', FILTER_SANITIZE_STRING);
        $publish_date = filter_input(INPUT_POST, 'publish_date', FILTER_SANITIZE_STRING);
        $availability_date = filter_input(INPUT_POST, 'availability_date', FILTER_SANITIZE_STRING);
        $isbn = filter_input(INPUT_POST, 'isbn', FILTER_SANITIZE_STRING);

        $product = new BookDigital($product_id, $name, $price, $quantity, $author, $pages, $publisher, $publish_date, $availability_date, $isbn);
        $success = $adapter->updateDigitalBook($product);
    } elseif ($product_type == 'Curso') {
        $duration = filter_input(INPUT_POST, 'duration', FILTER_VALIDATE_INT);
        $instructor = filter_input(INPUT_POST, 'instructor', FILTER_SANITIZE_STRING);
        $language = filter_input(INPUT_POST, 'language', FILTER_SANITIZE_STRING);

        $product = new Course($product_id, $name, $price, $quantity, $duration, $instructor, $language);
        $success = $adapter->updateCourse($product);
    } else {
        throw new Exception("Tipo de producto desconocido.");
    }

    if ($success) {
        // Redirección con mensaje de éxito
        header("Location: ../../views/stakeholders/employees/gestionProductos.php?update=success");
        exit;
    } else {
        // Redirección con mensaje de error si no hubo cambios
        header("Location: ../../views/stakeholders/employees/gestionProductos.php?update=success");
        exit;
    }
} catch (Exception $e) {
    // Redirección con mensaje de error en caso de excepción
    header("Location: ../../../views/products/listProducts.php?error=" . urlencode($e->getMessage()));
    exit;
}
?>



