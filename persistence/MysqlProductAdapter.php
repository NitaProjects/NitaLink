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

    public function addPhysicalBook(BookPhysical $book): bool {
        $this->connection->begin_transaction();
        try {
            $query = "INSERT INTO products (name, price, quantity, product_type) VALUES (?, ?, ?, 'Libro Físico')";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("sdi", $book->getName(), $book->getPrice(), $book->getQuantity());
            $stmt->execute();
            $productId = $stmt->insert_id;
            $stmt->close();

            $query = "INSERT INTO books_physical (product_id, author, pages, publisher, publish_date, availability_date, height, width, length, weight, fragile, isbn) 
                      VALUES (?, ?, ?, ?, STR_TO_DATE(?, '%d/%m/%Y'), STR_TO_DATE(?, '%d/%m/%Y'), ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("isisssddddis", $productId, $book->getAuthor(), $book->getPages(), $book->getPublisher(), $book->getPublishDate(), $book->getAvailabilityDate(), 
                              $book->getHeight(), $book->getWidth(), $book->getLength(), $book->getWeight(), $book->getFragile(), $book->getIsbn());
            $stmt->execute();
            $stmt->close();

            $this->connection->commit();
            return true;
        } catch (mysqli_sql_exception $ex) {
            $this->connection->rollback();
            throw new Exception("Error al agregar el libro físico: " . $ex->getMessage());
        }
    }

    public function addDigitalBook(BookDigital $book): bool {
        $this->connection->begin_transaction();
        try {
            $query = "INSERT INTO products (name, price, quantity, product_type) VALUES (?, ?, ?, 'Libro Digital')";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("sdi", $book->getName(), $book->getPrice(), $book->getQuantity());
            $stmt->execute();
            $productId = $stmt->insert_id;
            $stmt->close();

            $query = "INSERT INTO books_digital (product_id, author, pages, publisher, publish_date, availability_date, isbn) 
                      VALUES (?, ?, ?, ?, STR_TO_DATE(?, '%d/%m/%Y'), STR_TO_DATE(?, '%d/%m/%Y'), ?)";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("isisssi", $productId, $book->getAuthor(), $book->getPages(), $book->getPublisher(), $book->getPublishDate(), $book->getAvailabilityDate(), $book->getIsbn());
            $stmt->execute();
            $stmt->close();

            $this->connection->commit();
            return true;
        } catch (mysqli_sql_exception $ex) {
            $this->connection->rollback();
            throw new Exception("Error al agregar el libro digital: " . $ex->getMessage());
        }
    }

    public function addCourse(Course $course): bool {
        $this->connection->begin_transaction();
        try {
            $query = "INSERT INTO products (name, price, quantity, product_type) VALUES (?, ?, ?, 'Curso')";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("sdi", $course->getName(), $course->getPrice(), $course->getQuantity());
            $stmt->execute();
            $productId = $stmt->insert_id;
            $stmt->close();

            $query = "INSERT INTO courses (product_id, duration, instructor, language) 
                      VALUES (?, ?, ?, ?)";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("iiss", $productId, $course->getDuration(), $course->getInstructor(), $course->getLanguage());
            $stmt->execute();
            $stmt->close();

            $this->connection->commit();
            return true;
        } catch (mysqli_sql_exception $ex) {
            $this->connection->rollback();
            throw new Exception("Error al agregar el curso: " . $ex->getMessage());
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
    
    public function updatePhysicalBook(BookPhysical $book): bool {
    $this->connection->begin_transaction();

    try {
        $query = "UPDATE products SET name = ?, price = ?, quantity = ?, product_type = 'Libro Físico' WHERE product_id = ?";
        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta para products: " . $this->connection->error);
        }
        $stmt->bind_param("sdii", 
            $book->getName(), 
            $book->getPrice(), 
            $book->getQuantity(), 
            $book->getProductId());
        $stmt->execute();
        $updateSuccessful = $stmt->affected_rows > 0;
        $stmt->close();

        $query = "UPDATE books_physical SET author = ?, pages = ?, publisher = ?, publish_date = ?, availability_date = ?, height = ?, width = ?, length = ?, weight = ?, fragile = ? WHERE product_id = ?";
        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta para books_physical: " . $this->connection->error);
        }
        $stmt->bind_param("sisssddddii", 
            $book->getAuthor(), 
            $book->getPages(), 
            $book->getPublisher(), 
            $book->getPublishDate(), 
            $book->getAvailabilityDate(), 
            $book->getHeight(), 
            $book->getWidth(), 
            $book->getLength(), 
            $book->getWeight(), 
            $book->isFragile(), 
            $book->getProductId());
        $stmt->execute();
        $relatedUpdateSuccessful = $stmt->affected_rows > 0;
        $stmt->close();

        if ($updateSuccessful || $relatedUpdateSuccessful) {
            $this->connection->commit();
            return true;
        } else {
            $this->connection->rollback();
            return false;
        }
    } catch (Exception $ex) {
        $this->connection->rollback();
        throw new Exception("Error al actualizar el libro físico: " . $ex->getMessage());
    }
}


    public function updateDigitalBook(BookDigital $book): bool {
    $this->connection->begin_transaction();

    try {
        $query = "UPDATE products SET name = ?, price = ?, quantity = ?, product_type = 'Libro Digital' WHERE product_id = ?";
        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta para products: " . $this->connection->error);
        }
        $stmt->bind_param("sdii", 
            $book->getName(), 
            $book->getPrice(), 
            $book->getQuantity(), 
            $book->getProductId());
        $stmt->execute();
        $updateSuccessful = $stmt->affected_rows > 0;
        $stmt->close();

        $query = "UPDATE books_digital SET author = ?, pages = ?, publisher = ?, publish_date = ?, availability_date = ? WHERE product_id = ?";
        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta para books_digital: " . $this->connection->error);
        }
        $stmt->bind_param("sisssi", 
            $book->getAuthor(), 
            $book->getPages(), 
            $book->getPublisher(), 
            $book->getPublishDate(), 
            $book->getAvailabilityDate(), 
            $book->getProductId());
        $stmt->execute();
        $relatedUpdateSuccessful = $stmt->affected_rows > 0;
        $stmt->close();

        if ($updateSuccessful || $relatedUpdateSuccessful) {
            $this->connection->commit();
            return true;
        } else {
            $this->connection->rollback();
            return false;
        }
    } catch (Exception $ex) {
        $this->connection->rollback();
        throw new Exception("Error al actualizar el libro digital: " . $ex->getMessage());
    }
}


    public function updateCourse(Course $course): bool {
    $this->connection->begin_transaction();

    try {
        $query = "UPDATE products SET name = ?, price = ?, quantity = ?, product_type = 'Curso' WHERE product_id = ?";
        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta para products: " . $this->connection->error);
        }
        $stmt->bind_param("sdii", 
            $course->getName(), 
            $course->getPrice(), 
            $course->getQuantity(), 
            $course->getProductId());
        $stmt->execute();
        $updateSuccessful = $stmt->affected_rows > 0;
        $stmt->close();

        $query = "UPDATE courses SET duration = ?, instructor = ?, language = ? WHERE product_id = ?";
        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta para courses: " . $this->connection->error);
        }
        $stmt->bind_param("issi", 
            $course->getDuration(), 
            $course->getInstructor(), 
            $course->getLanguage(), 
            $course->getProductId());
        $stmt->execute();
        $relatedUpdateSuccessful = $stmt->affected_rows > 0;
        $stmt->close();

        if ($updateSuccessful || $relatedUpdateSuccessful) {
            $this->connection->commit();
            return true;
        } else {
            $this->connection->rollback();
            return false;
        }
    } catch (Exception $ex) {
        $this->connection->rollback();
        throw new Exception("Error al actualizar el curso: " . $ex->getMessage());
    }
}

}
