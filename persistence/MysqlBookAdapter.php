<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/products/BookPhysical.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/products/BookDigital.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlAdapter.php');

class MysqlBookAdapter extends MysqlAdapter {

    public function getBook(int $bookId): Book {
        $data = $this->readQuery("SELECT product_id, name, price, quantity, author, pages, publisher, publish_date, availability_date, height, width, length, weight, fragile FROM books_physical WHERE product_id = " . $bookId . ";");
        if (count($data) > 0) {
            return new Book($data[0]["name"], (float) $data[0]["price"], (int) $data[0]["product_id"], (int) $data[0]["quantity"],
                            $data[0]["author"], (int) $data[0]["pages"], $data[0]["publisher"], 
                            $data[0]["publish_date"], $data[0]["availability_date"], $data[0]["height"], $data[0]["width"], $data[0]["length"], $data[0]["weight"], $data[0]["fragile"]);
        } else {
            throw new ServiceException("No Book found with product_id = " . $bookId);
        }
    }

    public function deleteBook(int $bookId): bool {
        try {
            return $this->writeQuery("DELETE FROM books_physical WHERE product_id = " . $bookId . ";");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error deleting the book " . $bookId . "-->" . $ex->getMessage());
        }
    }

    public function addBook(Book $b): bool {
        try {
            return $this->writeQuery("INSERT INTO books_physical (product_id, name, price, quantity, author, pages, publisher, publish_date, availability_date, height, width, length, weight, fragile) VALUES (" . 
                    $b->getBookId() . ", '" . $b->getName() . "', " . $b->getPrice() . ", " . $b->getQuantity() . ", '" . 
                    $b->getAuthor() . "', " . $b->getPages() . ", '" . $b->getPublisher() . "', '" . 
                    $b->getPublishDate() . "', '" . $b->getAvailabilityDate() . "', " . $b->getHeight() . ", " . $b->getWidth() . ", " . $b->getLength() . ", " . $b->getWeight() . ", " . ($b->isFragile() ? '1' : '0') . ");");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error inserting book -->" . $ex->getMessage());
        }
    }

    public function updateBook(Book $b): bool {
        try {
            return $this->writeQuery("UPDATE books_physical SET name = '" . $b->getName() . "', price = " . $b->getPrice() . 
                    ", quantity = " . $b->getQuantity() . ", author = '" . $b->getAuthor() . 
                    "', pages = " . $b->getPages() . ", publisher = '" . $b->getPublisher() . 
                    "', publish_date = '" . $b->getPublishDate() . "', availability_date = '" . $b->getAvailabilityDate() . 
                    "', height = " . $b->getHeight() . ", width = " . $b->getWidth() . ", length = " . $b->getLength() . ", weight = " . $b->getWeight() . ", fragile = " . ($b->isFragile() ? '1' : '0') . " WHERE product_id = " . $b->getBookId() . ";");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error updating book -->" . $ex->getMessage());
        }
    }
    
    public function fetchAllProducts() {
    try {
        $products = [];
        $query = "SELECT product_id, name, price, quantity, product_type FROM products";
        $result = $this->connection->query($query);

        if ($result == false) {
            throw new Exception("Error fetching products: " . $this->connection->error);
        }

        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return $products;
    } catch (Exception $ex) {
        throw new ServiceException("Error fetching all products -->" . $ex->getMessage());
    }
}

}
 