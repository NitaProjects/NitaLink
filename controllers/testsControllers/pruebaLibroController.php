<?php

require_once '../../model/products/BookDigital.php';
require_once '../../model/products/BookPhysical.php';
require_once '../../model/checkdata/Checker.php';
require_once '../../model/products/PhysicalData.php'; 

// Captura y saneamiento de datos del formulario
$name = filter_input(INPUT_POST, 'title');
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$quantity = filter_input(INPUT_POST, 'quantity');
$author = filter_input(INPUT_POST, 'author');
$pages = filter_input(INPUT_POST, 'pages', FILTER_VALIDATE_INT);
$publisher = filter_input(INPUT_POST, 'publisher');
$publishDate = filter_input(INPUT_POST, 'publishDate');
$availabilityDate = filter_input(INPUT_POST, 'availabilityDate');
if ($quantity == false) {
    $quantity = -3; 
}
// Verifica si se han proporcionado datos físicos
$physicalData = filter_input(INPUT_POST, 'hasPhysicalData');
$height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_FLOAT);
$width = filter_input(INPUT_POST, 'width', FILTER_VALIDATE_FLOAT);
$length = filter_input(INPUT_POST, 'length', FILTER_VALIDATE_FLOAT);
$weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
$isFragile = filter_input(INPUT_POST, 'isFragile') === "on" ? true : false;

if ($physicalData){
    try {
    $book = new BookPhysical(1, $name, $price, $quantity, $author, $pages, $publisher, $publishDate, $availabilityDate, $height, $width, $length, $weight, $isFragile);
    echo "Libro registrado con éxito.<br>";
    echo "Libro registrado con éxito.<br>";
    echo "Fecha de publicación: " . $book->getPublishDate() . "<br>";
    echo "Fecha de disponibilidad: " . $book->getAvailabilityDate() . "<br>";
    echo "Periodo transcurrido: " . $book->getPeriod() . "<br>";

    // Obtener intervalos de fechas con un valor de ejemplo para `days`
    $days = 500;
    $intervals = $book->getIntervals($days);

    echo "Intervalos de $days días entre la disponibilidad y ahora:<br>";
    echo implode('<br>', $intervals);
}catch (CheckException $ex) {
    // Captura solo el mensaje de error, sin traza
    echo "Error al registrar el libro: <br>" . $ex->getMessage();
 }
}
else {
    try {
    $book = new BookDigital(1, $name, $price, $quantity, $author, $pages, $publisher, $publishDate, $availabilityDate);
    echo "Libro registrado con éxito.<br>";
    echo "Fecha de publicación: " . $book->getPublishDate() . "<br>";
    echo "Fecha de disponibilidad: " . $book->getAvailabilityDate() . "<br>";
    echo "Periodo transcurrido: " . $book->getPeriod() . "<br>";

    // Obtener intervalos de fechas con un valor de ejemplo para `days`
    $days = 500;
    $intervals = $book->getIntervals($days);

    echo "Intervalos de $days días entre la disponibilidad y ahora:<br>";
    echo implode('<br>', $intervals);

} catch (CheckException $ex) {
    // Captura solo el mensaje de error
    echo "Error al registrar el libro: <br>" . $ex->getMessage();
}
}