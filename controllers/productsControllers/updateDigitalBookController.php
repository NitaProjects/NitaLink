<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/persistence/MysqlProductAdapter.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/model/products/BookDigital.php');

$adapter = new MysqlProductAdapter();

// Recoger los datos del formulario usando filter_input
$product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
$author = filter_input(INPUT_POST, 'digital_author', FILTER_SANITIZE_STRING);
$pages = filter_input(INPUT_POST, 'digital_pages', FILTER_VALIDATE_INT);
$publisher = filter_input(INPUT_POST, 'digital_publisher', FILTER_SANITIZE_STRING);
$publish_date = filter_input(INPUT_POST, 'digital_publish_date', FILTER_SANITIZE_STRING);
$availability_date = filter_input(INPUT_POST, 'digital_availability_date', FILTER_SANITIZE_STRING);
$isbn = filter_input(INPUT_POST, 'digital_isbn', FILTER_SANITIZE_STRING);

try {
    $product = new BookDigital($product_id, $name, $price, $quantity, $author,
        $pages, $publisher, $publish_date, $availability_date, $isbn);
    $success = $adapter->updateDigitalBook($product);

    if ($success) {
        header("Location: ../../views/stakeholders/employees/gestionProductos.php?update=success");
        exit;
    } else {
        header("Location: ../../views/stakeholders/employees/gestionProductos.php?update=fail");
        exit;
    }
} catch (Exception $e) {
    $errorMessage = "Error al actualizar el libro digital:\n\n " . $e->getMessage();
    header('Location: ../../views\stakeholders\error.php');
    exit;
}
?>
