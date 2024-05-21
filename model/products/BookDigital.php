<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/model/products/Product.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/model/products/PhysicalData.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/interfaces/Storable.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/interfaces/Marketable.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/model/checkdata/Checker.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/exceptions/DateException.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/exceptions/BuildException.php');

class BookDigital extends Product {

    protected string $author;
    protected int $pages;
    protected string $publisher;
    protected DateTime $publishDate;
    protected DateTime $availabilityDate;
    protected string $isbn;

    public function __construct(int $productId, string $name, float $price, int $quantity, string $author, int $pages, string $publisher, string $publishDate, string $availabilityDate, string $isbn) {
        $message = "";
        try {
            parent::__construct($productId, $name, $price, $quantity,);
        } catch (BuildException $e) {
            $message .= $e->getMessage();
        }
        if ($this->setAuthor($author) != 0) {
            $message .= "-Escritor/a/e incorrecto.\n";
        }
        if ($this->setPages($pages) != 0) {
            $message .= "-Paginas incorrectas.\n";
        }
        if ($this->setPublisher($publisher) != 0) {
            $message .= "-Editorial incorrecto.\n";
        }
        if ($this->setPublishDate($publishDate) != 0) {
            $message .= "-Fecha de publicación incorrecto.\n";
        }
        if ($this->setAvailabilityDate($availabilityDate) != 0) {
            $message .= "-Fecha disponibilidad incorrecta.\n";
        }
        if ($this->setIsbn($isbn) != 0) {
            $message .= "-ISBN incorrecto.\n";
        }
        if (strlen($message) > 0) {
            throw new BuildException($message);
        }
    }

    // Método para obtener el tiempo transcurrido entre la publicación y la disponibilidad
    public function getPeriod(): string {
        $interval = $this->publishDate->diff($this->availabilityDate);
        return $interval->format('%d días, %m meses, %Y años');
    }

    // Método para obtener intervalos fijos de días entre la fecha de disponibilidad y la fecha actual
    public function getIntervals(int $days): array {
        $interval = new DateInterval('P' . $days . 'D');
        $period = new DatePeriod($this->availabilityDate, $interval, new DateTime());

        // Generar una lista de fechas
        $dates = [];
        foreach ($period as $date) {
            $dates[] = $date->format('d/m/Y H:i:s');
        }
        return $dates;
    }

    // Getters para las fechas con el formato requerido
    public function getPublishDate(): string {
        return $this->publishDate->format('d/m/Y');
    }

    public function getAvailabilityDate(): string {
        return $this->availabilityDate->format('d/m/Y H:i:s');
    }

    // Getters

    public function getAuthor(): string {
        return $this->author;
    }

    public function getPages(): int {
        return $this->pages;
    }

    public function getPublisher(): string {
        return $this->publisher;
    }

    public function getIsbn(): string {
        return $this->isbn;
    }

    public function setAuthor(string $author): int {
        $error = Checker::StringValidator($author, 2);
        if ($error == 0) {
            $this->author = $author;
        }
        return $error;
    }

    public function setPages(int $pages): int {
        $error = Checker::NumberValidator($pages, 0);
        if ($error == 0) {
            $this->pages = $pages;
        }
        return $error;
    }

    public function setPublisher(string $publisher): int {
        $error = Checker::StringValidator($publisher, 2);
        if ($error == 0) {
            $this->publisher = $publisher;
        }
        return $error;
    }

    public function setPublishDate(string $date): int {
        $error = Checker::checkDate($date);
        if ($error == 0) {
            $publishDate = DateTime::createFromFormat('d/m/Y', $date);
            if ($publishDate === false) {
                return -1;
            }
            $this->publishDate = $publishDate;
        }
        return $error;
    }
    
    public function setAvailabilityDate(string $date): int {
        $error = Checker::checkDateTimeLarga($date);
        if ($error == 0) {
            $availabilityDate = DateTime::createFromFormat('d/m/Y H:i:s', $date);
            if ($availabilityDate === false) {
                return -1;
            }
            if ($availabilityDate < $this->publishDate) {
                return -2;
            }
            $this->availabilityDate = $availabilityDate;
        }
        return $error;
    }

    private function setIsbn(string $isbn): int {
        $error = Checker::checkISBN($isbn);
        if ($error == 0) {
            $this->isbn = $isbn;
        }
        return $error;
    }

    public function getDetails(): string {
        $details = "Libro: {$this->name}, ISBN: {$this->isbn}, Autor: {$this->author}, Páginas: {$this->pages}, Editorial: {$this->publisher}, Precio: {$this->price}€";
        if ($this->publishDate) {
            $details .= ", Fecha de publicación: " . $this->publishDate->format('d/m/Y');
        }
        if ($this->availabilityDate) {
            $details .= ", Fecha disponibilidad: " . $this->availabilityDate->format('d/m/Y');
        }
        return $details;
    }
}
