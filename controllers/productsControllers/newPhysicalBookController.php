<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/persistence/MysqlProductAdapter.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/model/products/BookPhysical.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/model/checkdata/Checker.php');

$adapter = new MysqlProductAdapter();

// Recoger los datos del formulario usando filter_input
$name = filter_input(INPUT_POST, 'name');
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$quantity = filter_input(INPUT_POST, 'quantity');
$author = filter_input(INPUT_POST, 'author');
$pages = filter_input(INPUT_POST, 'pages', FILTER_VALIDATE_INT);
$publisher = filter_input(INPUT_POST, 'publisher');
$publish_date = filter_input(INPUT_POST, 'publish_date');
$availability_date = filter_input(INPUT_POST, 'availability_date');
$isbn = filter_input(INPUT_POST, 'isbn');
$height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_FLOAT);
$width = filter_input(INPUT_POST, 'width', FILTER_VALIDATE_FLOAT);
$length = filter_input(INPUT_POST, 'length', FILTER_VALIDATE_FLOAT);
$weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
$fragile = filter_input(INPUT_POST, 'fragile', FILTER_VALIDATE_BOOLEAN);

$lastProductId = $adapter->maxProductid();
$productId = $lastProductId + 1;

try {
    $book = new BookPhysical($productId, $name, $price, $quantity, $author, $pages, $publisher, $publish_date, $availability_date, $isbn, $height, $width, $length, $weight, $fragile);
    $success = $adapter->addPhysicalBook($book);

    if ($success) {
        header("Location: ../../views/stakeholders/employees/gestionProductos.php?add=success");
        exit;
    } else {
        header("Location: ../../views/stakeholders/employees/gestionProductos.php?add=fail");
        exit;
    }
} catch (Exception $e) {
    $errorMessage = "Error al registrar el libro fisico:\n\n " . $e->getMessage();
    include '../../public/css/error.php';
    exit;
}
?>

