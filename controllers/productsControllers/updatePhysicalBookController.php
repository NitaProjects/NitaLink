<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/persistence/MysqlProductAdapter.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/model/products/BookPhysical.php');

$adapter = new MysqlProductAdapter();

// Recoger los datos del formulario usando filter_input
$product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
$author = filter_input(INPUT_POST, 'physical_author', FILTER_SANITIZE_STRING) ?? '';
$pages = filter_input(INPUT_POST, 'physical_pages', FILTER_VALIDATE_INT) ?? 0;
$publisher = filter_input(INPUT_POST, 'physical_publisher', FILTER_SANITIZE_STRING) ?? '';
$publish_date = filter_input(INPUT_POST, 'physical_publish_date', FILTER_SANITIZE_STRING) ?? '';
$availability_date = filter_input(INPUT_POST, 'physical_availability_date', FILTER_SANITIZE_STRING) ?? '';
$isbn = filter_input(INPUT_POST, 'physical_isbn', FILTER_SANITIZE_STRING) ?? '';
$height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_FLOAT) ?? 0.0;
$width = filter_input(INPUT_POST, 'width', FILTER_VALIDATE_FLOAT) ?? 0.0;
$length = filter_input(INPUT_POST, 'length', FILTER_VALIDATE_FLOAT) ?? 0.0;
$weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT) ?? 0.0;
$fragile = filter_input(INPUT_POST, 'fragile', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false;

try {
    $book = new BookPhysical($product_id, $name, $price, $quantity, $author, $pages, $publisher, $publish_date, $availability_date, $isbn, $height, $width, $length, $weight, $fragile);
    $success = $adapter->updatePhysicalBook($book);

    if ($success) {
        header("Location: ../../views/stakeholders/employees/gestionProductos.php?update=success");
        exit;
    } else {
        header("Location: ../../views/stakeholders/employees/gestionProductos.php?update=fail");
        exit;
    }
} catch (Exception $e) {
    $errorMessage = "Error al actualizar el libro físico:\n\n " . $e->getMessage();
    include '../../views\stakeholders\error.php';
    exit;
}
?>
