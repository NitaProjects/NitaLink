<?php

declare(strict_types=1);
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/Client.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlAdapter.php');

class MysqlProductAdapter extends MysqlAdapter {
   
    public function listProducts(): array {
        $query = "
            SELECT p.product_id, p.name, p.price, p.quantity, p.product_type,
                   bd.isbn AS digital_isbn, bd.author AS digital_author, bd.pages AS digital_pages, 
                   bd.publisher AS digital_publisher, bd.publish_date AS digital_publish_date, 
                   bd.availability_date AS digital_availability_date, 
                   bp.isbn AS physical_isbn, bp.author AS physical_author, bp.pages AS physical_pages, 
                   bp.publisher AS physical_publisher, bp.publish_date AS physical_publish_date, 
                   bp.availability_date AS physical_availability_date,
                   bp.height, bp.width, bp.length, bp.weight, bp.fragile,
                   c.duration, c.instructor, c.language,
                   CASE
                       WHEN bd.product_id IS NOT NULL THEN 'Libro Digital'
                       WHEN bp.product_id IS NOT NULL THEN 'Libro Físico'
                       WHEN c.product_id IS NOT NULL THEN 'Curso'
                       ELSE 'Desconocido'
                   END AS product_type
            FROM products p
            LEFT JOIN books_digital bd ON p.product_id = bd.product_id
            LEFT JOIN books_physical bp ON p.product_id = bp.product_id
            LEFT JOIN courses c ON p.product_id = c.product_id
            ORDER BY p.product_id ASC";
        
        $result = $this->connection->query($query);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            throw new Exception("Error al obtener los productos: " . $this->connection->error);
        }
    }

    public function addProduct(array $productData): bool {
        $this->connection->begin_transaction();
        try {
            $query = "INSERT INTO products (name, price, quantity, product_type) VALUES (?, ?, ?, ?)";
            $stmt = $this->connection->prepare($query);
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->connection->error);
            }

            $stmt->bind_param("sdiss", 
                $productData['name'], 
                $productData['price'], 
                $productData['quantity'], 
                $productData['product_type']);
            $stmt->execute();

            $product_id = $stmt->insert_id;
            $stmt->close();

            // Insertar datos específicos según el tipo de producto
            if ($productData['product_type'] == 'Libro Digital') {
                $query = "INSERT INTO books_digital (product_id, isbn, author, pages, publisher, publish_date, availability_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->connection->prepare($query);
                $stmt->bind_param("issssss", 
                    $product_id, 
                    $productData['isbn'], 
                    $productData['author'], 
                    $productData['pages'], 
                    $productData['publisher'], 
                    $productData['publish_date'], 
                    $productData['availability_date']);
            } elseif ($productData['product_type'] == 'Libro Físico') {
                $query = "INSERT INTO books_physical (product_id, isbn, author, pages, publisher, publish_date, availability_date, height, width, length, weight, fragile) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->connection->prepare($query);
                $stmt->bind_param("isssssssssss", 
                    $product_id, 
                    $productData['isbn'], 
                    $productData['author'], 
                    $productData['pages'], 
                    $productData['publisher'], 
                    $productData['publish_date'], 
                    $productData['availability_date'],
                    $productData['height'],
                    $productData['width'],
                    $productData['length'],
                    $productData['weight'],
                    $productData['fragile']);
            } elseif ($productData['product_type'] == 'Curso') {
                $query = "INSERT INTO courses (product_id, duration, instructor, language) VALUES (?, ?, ?, ?)";
                $stmt = $this->connection->prepare($query);
                $stmt->bind_param("iiss", 
                    $product_id, 
                    $productData['duration'], 
                    $productData['instructor'], 
                    $productData['language']);
            }

            $stmt->execute();
            $stmt->close();

            $this->connection->commit();
            return true;
        } catch (Exception $e) {
            $this->connection->rollback();
            throw $e;
        }
    }

    public function deleteProduct(int $id): bool {
    $this->connection->begin_transaction();
    try {
        // Borrar registros relacionados en books_digital, books_physical, y courses
        $stmt = $this->connection->prepare("DELETE FROM books_digital WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        $stmt = $this->connection->prepare("DELETE FROM books_physical WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        $stmt = $this->connection->prepare("DELETE FROM courses WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        // Ahora borrar el producto de la tabla products
        $stmt = $this->connection->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $this->connection->commit();
            return true;
        } else {
            $this->connection->rollback();
            return false;
        }
    } catch (mysqli_sql_exception $ex) {
        $this->connection->rollback();
        throw new ServiceException("Error al borrar el producto " . $id . "-->" . $ex->getMessage());
    } finally {
        $stmt->close();
    }
}


    public function updateProduct(array $productData): bool {
        $this->connection->begin_transaction();
        try {
            $query = "UPDATE products SET name = ?, price = ?, quantity = ?, product_type = ? WHERE product_id = ?";
            $stmt = $this->connection->prepare($query);
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->connection->error);
            }
            $stmt->bind_param("sdisi", 
                $productData['name'], 
                $productData['price'], 
                $productData['quantity'], 
                $productData['product_type'],
                $productData['product_id']);
            $stmt->execute();
            $stmt->close();

            // Actualizar datos específicos según el tipo de producto
            if ($productData['product_type'] == 'Libro Digital') {
                $query = "UPDATE books_digital SET isbn = ?, author = ?, pages = ?, publisher = ?, publish_date = ?, availability_date = ? WHERE product_id = ?";
                $stmt = $this->connection->prepare($query);
                $stmt->bind_param("ssssssi", 
                    $productData['isbn'], 
                    $productData['author'], 
                    $productData['pages'], 
                    $productData['publisher'], 
                    $productData['publish_date'], 
                    $productData['availability_date'],
                    $productData['product_id']);
            } elseif ($productData['product_type'] == 'Libro Físico') {
                $query = "UPDATE books_physical SET isbn = ?, author = ?, pages = ?, publisher = ?, publish_date = ?, availability_date = ?, height = ?, width = ?, length = ?, weight = ?, fragile = ? WHERE product_id = ?";
                $stmt = $this->connection->prepare($query);
                $stmt->bind_param("sssssssssssi", 
                    $productData['isbn'], 
                    $productData['author'], 
                    $productData['pages'], 
                    $productData['publisher'], 
                    $productData['publish_date'], 
                    $productData['availability_date'],
                    $productData['height'],
                    $productData['width'],
                    $productData['length'],
                    $productData['weight'],
                    $productData['fragile'],
                    $productData['product_id']);
            } elseif ($productData['product_type'] == 'Curso') {
                $query = "UPDATE courses SET duration = ?, instructor = ?, language = ? WHERE product_id = ?";
                $stmt = $this->connection->prepare($query);
                $stmt->bind_param("issi", 
                    $productData['duration'], 
                    $productData['instructor'], 
                    $productData['language'],
                    $productData['product_id']);
            }

            $stmt->execute();
            $stmt->close();

            $this->connection->commit();
            return true;
        } catch (Exception $e) {
            $this->connection->rollback();
            throw $e;
        }
    }
}
