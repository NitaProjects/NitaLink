<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlProductAdapter.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/products/BookPhysical.php');

$adapter = new MysqlProductAdapter();

// Recoger los datos del formulario usando filter_input
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
$author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_STRING);
$pages = filter_input(INPUT_POST, 'pages', FILTER_VALIDATE_INT);
$publisher = filter_input(INPUT_POST, 'publisher', FILTER_SANITIZE_STRING);
$publish_date = filter_input(INPUT_POST, 'publish_date', FILTER_SANITIZE_STRING);
$availability_date = filter_input(INPUT_POST, 'availability_date', FILTER_SANITIZE_STRING);
$isbn = filter_input(INPUT_POST, 'isbn', FILTER_SANITIZE_STRING);
$height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_FLOAT);
$width = filter_input(INPUT_POST, 'width', FILTER_VALIDATE_FLOAT);
$length = filter_input(INPUT_POST, 'length', FILTER_VALIDATE_FLOAT);
$weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
$fragile = filter_input(INPUT_POST, 'fragile', FILTER_VALIDATE_BOOLEAN);

$lastProductId = $adapter->maxProducttid();
$productId = $lastProductId + 1;

try {
    $book = new BookPhysical($productId, $name, $price, $quantity,  $author, $pages, $publisher, $publish_date, $availability_date, $height, $width, $length, $weight, $fragile, $isbn);
    $success = $adapter->addPhysicalBook($book);

    if ($success) {
        header("Location: ../../../views/products/gestionProductos.php?add=success");
        exit;
    } else {
        header("Location: ../../../views/products/gestionProductos.php?add=fail");
        exit;
    }
} catch (Exception $e) {
    header("Location: ../../../views/products/gestionProductos.php?error=" . urlencode($e->getMessage()));
    exit;
}
?>

