<?php

declare(strict_types=1);
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/model/stakeholders/Client.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/persistence/MysqlAdapter.php');

class MysqlProductAdapter extends MysqlAdapter {

    public function getProducts(): array {
        $query = "SELECT product_id, name, price, image_url FROM products";
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            $products = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $products;
        } catch (mysqli_sql_exception $ex) {
            throw new Exception("Error al obtener los productos: " . $ex->getMessage());
        }
    }

    public function maxProductid(): int {
        $result = $this->connection->query("SELECT max(product_id) as last FROM products");
        $row = $result->fetch_assoc();
        return (int) $row['last'];
    }

    public function listProducts(int $page, int $productsPerPage): array {
        // Calcular el offset
        $offset = ($page - 1) * $productsPerPage;

        // Preparar la consulta SQL con búsqueda
        $query = "
        SELECT p.product_id, p.name, p.price, p.quantity, p.product_type,
            bd.author AS digital_author, bd.pages AS digital_pages, bd.publisher AS digital_publisher,
            bd.publish_date AS digital_publish_date, bd.availability_date AS digital_availability_date,
            bd.isbn AS digital_isbn,
            bp.author AS physical_author, bp.pages AS physical_pages, bp.publisher AS physical_publisher,
            bp.publish_date AS physical_publish_date, bp.availability_date AS physical_availability_date,
            bp.isbn AS physical_isbn, bp.height, bp.width, bp.length, bp.weight, bp.fragile,
            c.duration, c.instructor, c.language
        FROM Products p
        LEFT JOIN books_digital bd ON p.product_id = bd.product_id
        LEFT JOIN books_physical bp ON p.product_id = bp.product_id
        LEFT JOIN courses c ON p.product_id = c.product_id
        ORDER BY p.product_id ASC
        LIMIT ? OFFSET ?";

        // Preparar la declaración
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ii", $productsPerPage, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            $products = $result->fetch_all(MYSQLI_ASSOC);

            // Transformar fechas a formato dd/mm/yyyy
            foreach ($products as &$product) {
                if (!empty($product['digital_publish_date'])) {
                    $product['digital_publish_date'] = MysqlAdapter::transformDateFromISO($product['digital_publish_date']);
                }
                if (!empty($product['digital_availability_date'])) {
                    $product['digital_availability_date'] = MysqlAdapter::transformDateTimeFromISO($product['digital_availability_date']);
                }
                if (!empty($product['physical_publish_date'])) {
                    $product['physical_publish_date'] = MysqlAdapter::transformDateFromISO($product['physical_publish_date']);
                }
                if (!empty($product['physical_availability_date'])) {
                    $product['physical_availability_date'] = MysqlAdapter::transformDateTimeFromISO($product['physical_availability_date']);
                }
            }

            $stmt->close();
            return $products;
        } else {
            throw new Exception("Error al obtener los productos: " . $this->connection->error);
        }
    }

    public function getTotalProducts(string $search = ''): int {
        // Preparar la consulta SQL con búsqueda
        $query = "SELECT COUNT(*) as total FROM Products WHERE name LIKE ?";
        $stmt = $this->connection->prepare($query);
        $searchParam = '%' . $search . '%';
        $stmt->bind_param("s", $searchParam);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $row = $result->fetch_assoc();
            $stmt->close();
            return (int) $row['total'];
        } else {
            throw new Exception("Error al contar los productos: " . $this->connection->error);
        }
    }

    public function addPhysicalBook(BookPhysical $book): bool {
        $this->connection->begin_transaction();
        try {
            // Insertar en la tabla products
            $query = "INSERT INTO products (name, price, quantity, product_type) VALUES (?, ?, ?, 'Libro Físico')";
            $stmt = $this->connection->prepare($query);

            // Asignar valores a variables
            $name = $book->getName();
            $price = $book->getPrice();
            $quantity = $book->getQuantity();

            // Pasar variables a bind_param
            $stmt->bind_param("sdi", $name, $price, $quantity);
            $stmt->execute();
            $productId = $stmt->insert_id;
            $stmt->close();

            // Insertar en la tabla books_physical
            $query = "INSERT INTO books_physical (product_id, author, pages, publisher, publish_date, availability_date, height, width, length, weight, fragile, isbn) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connection->prepare($query);

            // Asignar valores a variables
            $author = $book->getAuthor();
            $pages = $book->getPages();
            $publisher = $book->getPublisher() ?: 1;
            $publishDate = $book->getPublishDate();
            $publishDateSQL = MysqlAdapter::transformDateToISO($publishDate);
            $availabilityDate = $book->getAvailabilityDate();
            $availabilityDateSQL = MysqlAdapter::transformDateTimeToISO($availabilityDate);
            $height = $book->getHeight();
            $width = $book->getWidth();
            $length = $book->getLength();
            $weight = $book->getWeight();
            $fragile = $book->isFragile();
            $isbn = $book->getIsbn();

            // Pasar variables a bind_param
            $stmt->bind_param("isisssddddis", $productId, $author, $pages, $publisher, $publishDateSQL, $availabilityDateSQL, $height, $width, $length, $weight, $fragile, $isbn);
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
            // Insertar en la tabla products
            $query = "INSERT INTO products (name, price, quantity, product_type) VALUES (?, ?, ?, 'Libro Digital')";
            $stmt = $this->connection->prepare($query);

            // Asignar valores a variables
            $name = $book->getName();
            $price = $book->getPrice();
            $quantity = $book->getQuantity();

            // Pasar variables a bind_param
            $stmt->bind_param("sdi", $name, $price, $quantity);
            $stmt->execute();
            $productId = $stmt->insert_id;
            $stmt->close();

            // Insertar en la tabla books_digital
            $query = "INSERT INTO books_digital (product_id, author, pages, publisher, publish_date, availability_date, isbn) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connection->prepare($query);

            // Asignar valores a variables
            $author = $book->getAuthor();
            $pages = $book->getPages();
            $publisher = $book->getPublisher();
            $publishDate = $book->getPublishDate();
            $publishDateSQL = MysqlAdapter::transformDateToISO($publishDate);
            $availabilityDate = $book->getAvailabilityDate();
            $availabilityDateSQL = MysqlAdapter::transformDateTimeToISO($availabilityDate);
            $isbn = $book->getIsbn();

            // Pasar variables a bind_param
            $stmt->bind_param("isisssi", $productId, $author, $pages, $publisher, $publishDateSQL, $availabilityDateSQL, $isbn);
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
            // Actualizar la tabla products
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

            // Transformar fechas al formato ISO
            $publishDateSQL = MysqlAdapter::transformDateToISO($book->getPublishDate());
            $availabilityDateSQL = MysqlAdapter::transformDateTimeToISO($book->getAvailabilityDate());

            // Actualizar la tabla books_physical
            $query = "UPDATE books_physical SET author = ?, pages = ?, publisher = ?, publish_date = ?, availability_date = ?, height = ?, width = ?, length = ?, weight = ?, fragile = ? WHERE product_id = ?";
            $stmt = $this->connection->prepare($query);
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta para books_physical: " . $this->connection->error);
            }
            $stmt->bind_param("sisssddddii",
                $book->getAuthor(),
                $book->getPages(),
                $book->getPublisher(),
                $publishDateSQL,
                $availabilityDateSQL,
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
            // Actualizar la tabla products
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

            // Transformar fechas al formato ISO
            $publishDateSQL = MysqlAdapter::transformDateToISO($book->getPublishDate());
            $availabilityDateSQL = MysqlAdapter::transformDateTimeToISO($book->getAvailabilityDate());

            // Actualizar la tabla books_digital
            $query = "UPDATE books_digital SET author = ?, pages = ?, publisher = ?, publish_date = ?, availability_date = ?, isbn = ? WHERE product_id = ?";
            $stmt = $this->connection->prepare($query);
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta para books_digital: " . $this->connection->error);
            }
            $stmt->bind_param("sissssi",
                $book->getAuthor(),
                $book->getPages(),
                $book->getPublisher(),
                $publishDateSQL,
                $availabilityDateSQL,
                $book->getIsbn(),
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
            // Actualizar la tabla products
            $query = "UPDATE products SET 
                    name = ?, 
                    price = ?, 
                    quantity = ?, 
                    product_type = 'Curso' 
                WHERE product_id = ?";
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

            // Actualizar la tabla courses
            $query = "UPDATE courses SET 
                    duration = ?, 
                    instructor = ?, 
                    language = ? 
                WHERE product_id = ?";
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

            // Confirmar o revertir la transacción
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
