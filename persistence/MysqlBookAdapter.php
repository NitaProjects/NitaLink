<?php

declare(strict_types=1);

include '../model/stakeholders/Book.php';
include 'MySQLAdapter.php';

class MysqlBookAdapter extends MysqlAdapter {

    public function getBook(int $bookId): Book {
        $data = $this->readQuery("SELECT bookId, name, price, quantity, author, pages, publisher, publishDate, availabilityDate, physicalData FROM books WHERE bookId = " . $bookId . ";");
        if (count($data) > 0) {
            return new Book($data[0]["name"], (float) $data[0]["price"], (int) $data[0]["bookId"], (int) $data[0]["quantity"],
                            $data[0]["author"], (int) $data[0]["pages"], $data[0]["publisher"], 
                            $data[0]["publishDate"], $data[0]["availabilityDate"], $data[0]["physicalData"]);
        } else {
            throw new ServiceException("No Book found with bookId = " . $bookId);
        }
    }

    public function deleteBook(int $bookId): bool {
        try {
            return $this->writeQuery("DELETE FROM books WHERE bookId = " . $bookId . ";");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error deleting the book " . $bookId . "-->" . $ex->getMessage());
        }
    }

    public function addBook(Book $b): bool {
        try {
            return $this->writeQuery("INSERT INTO books (bookId, name, price, quantity, author, pages, publisher, publishDate, availabilityDate, physicalData) VALUES (" . 
                    $b->getBookId() . ", \"" . $b->getName() . "\", " . $b->getPrice() . ", " . $b->getQuantity() . ", \"" . 
                    $b->getAuthor() . "\", " . $b->getPages() . ", \"" . $b->getPublisher() . "\", \"" . 
                    $b->getPublishDate() . "\", \"" . $b->getAvailabilityDate() . "\", \"" . $b->getPhysicalData() . "\");");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error inserting book -->" . $ex->getMessage());
        }
    }

    public function updateBook(Book $b): bool {
        try {
            return $this->writeQuery("UPDATE books SET name = \"" . $b->getName() . "\", price = " . $b->getPrice() . 
                    ", quantity = " . $b->getQuantity() . ", author = \"" . $b->getAuthor() . 
                    "\", pages = " . $b->getPages() . ", publisher = \"" . $b->getPublisher() . 
                    "\", publishDate = \"" . $b->getPublishDate() . "\", availabilityDate = \"" . $b->getAvailabilityDate() . 
                    "\", physicalData = \"" . $b->getPhysicalData() . "\" WHERE bookId = " . $b->getBookId() . ";");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error updating book -->" . $ex->getMessage());
        }
    }
}
