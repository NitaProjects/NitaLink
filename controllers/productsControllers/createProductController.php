<?php
// Recolectar los datos del formulario
$name = filter_input(INPUT_POST, 'name');
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
$productType = filter_input(INPUT_POST, 'productType');
$author = filter_input(INPUT_POST, 'author');
$pages = filter_input(INPUT_POST, 'pages', FILTER_VALIDATE_INT);
$publisher = filter_input(INPUT_POST, 'publisher');
$duration = filter_input(INPUT_POST, 'duration', FILTER_VALIDATE_INT);
$instructor = filter_input(INPUT_POST, 'instructor');
$language = filter_input(INPUT_POST, 'language');

try {
    $db = new PDO("mysql:host=localhost;dbname=nitalink", 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insert the base product
    $stmt = $db->prepare("INSERT INTO products (name, price, quantity, product_type) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $price, $quantity, $productType]);

    // Get the last inserted product's ID
    $productId = $db->lastInsertId();

    // Depending on the product type, insert the additional data
    if ($productType === 'book') {
        $stmt = $db->prepare("INSERT INTO books (product_id, author, pages, publisher) VALUES (?, ?, ?, ?)");
        $stmt->execute([$productId, $author, $pages, $publisher]);
    } elseif ($productType === 'course') {
        $stmt = $db->prepare("INSERT INTO courses (product_id, duration, instructor, language) VALUES (?, ?, ?, ?)");
        $stmt->execute([$productId, $duration, $instructor, $language]);
    }

    echo "Producto añadido con éxito.";
} catch (PDOException $e) {
    echo "Error al añadir producto: " . $e->getMessage();
}
?>




