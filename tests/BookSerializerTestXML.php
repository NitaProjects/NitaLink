<?php

require_once '../model/appservice/XmlBookSerializer.php';
require_once '../model/products/Book.php';
require_once '../model/products/PhysicalData.php';

// Crear un objeto Book con datos de prueba
$physicalData = new PhysicalData(20.5, 13.5, 2.0, 0.8, false);
$book = new Book(
    "Effective Java",   // Nombre del libro
    45.99,              // Precio
    1001,               // ID del producto
    10,                 // Cantidad
    "Joshua Bloch",     // Autor
    416,                // Páginas
    "Prentice Hall",    // Editorial
    "2018-05-08",       // Fecha de publicación
    "2018-06-01",       // Fecha de disponibilidad
    $physicalData       // Datos físicos
);

// Serializar el libro a XML
$serializer = new XmlBookSerializer();
$xml = $serializer->serialize($book);
echo "XML Serialized:<br>" . htmlentities($xml) . "<br>";

// Deserializar el XML de vuelta a un objeto Book
$bookBack = $serializer->unserialize($xml);
echo "Book Deserialized:<br>";
echo "Name: " . $bookBack->getName() . "<br>";
echo "Price: " . $bookBack->getPrice() . "<br>";
echo "Author: " . $bookBack->getAuthor() . "<br>";
echo "Pages: " . $bookBack->getPages() . "<br>";

// Verificar que el objeto deserializado coincide con el original
assert($book->getName() === $bookBack->getName(), 'Name should match');
assert($book->getPrice() === $bookBack->getPrice(), 'Price should match');
assert($book->getAuthor() === $bookBack->getAuthor(), 'Author should match');
assert($book->getPages() === $bookBack->getPages(), 'Pages should match');

// Imprimir resultados de las pruebas
echo "All tests passed successfully.<br>";

