<?php

require_once '../model/products/Book.php';
require_once '../model/products/PhysicalData.php';

// Ejemplo de prueba
$physicalData = new PhysicalData(20.5, 13.5, 2.0, 0.8, false);
$book = new Book(
    "Effective Java",  // name
    45.99,             // price
    1001,              // productId
    10,                // quantity
    "Joshua Bloch",    // author
    416,               // pages
    "Prentice Hall",   // publisher
    "2018-05-08",      // publishDate
    "2018-06-01",      // availabilityDate
    $physicalData      // physicalData
);

$serializer = new JsonBookSerializer();
$json = $serializer->serialize($book);
$bookBack = $serializer->unserialize($json);

// Afirmaciones para verificar la consistencia
assert($bookBack->getName() === "Effective Java"); // Y otras afirmaciones necesarias

echo "JSON Serializado: " . $json . "<br>";
echo "Libro Deserializado: " . $bookBack->getDetails() . "<br>";

echo "Nombre del libro: " . $bookBack->getName() . "<br>";
echo "Precio del libro: " . $bookBack->getPrice() . "<br>";
echo "Autor del libro: " . $bookBack->getAuthor() . "<br>";