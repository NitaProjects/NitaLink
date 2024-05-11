<?php

declare(strict_types=1);

require_once 'Product.php';  
require_once 'PhysicalData.php';
require_once '../../interfaces/Storable.php';
require_once '../../interfaces/Marketable.php';
require_once '../../model/checkdata/Checker.php';
require_once '../../exceptions/DateException.php';
require_once '../../exceptions/CheckException.php';

class BookPhysical extends Product implements Storable {
    protected string $author;
    protected int $pages;
    protected string $publisher;
    protected DateTime $publishDate;
    protected DateTime $availabilityDate;
    protected PhysicalData $physicalData;

    public function __construct(int $productId, string $name, float $price, int $quantity, string $author, int $pages, string $publisher, string $publishDate, string $availabilityDate, float $height, float $width, float $length, float $weight, bool $fragile) {
        $message = "";
        try {
            parent::__construct($productId, $name, $price, $quantity);
        } catch (CheckException $e) {
            $message .= $e->getMessage();  
        }
        if ($this->setAuthor($author) != 0) {
            $message .= "-Escritor/a/e incorrecto<br>";
        }
        if ($this->setPages($pages) != 0) {
            $message .= "-Paginas incorrectas<br>";
        }
        if ($this->setPublisher($publisher) != 0) {
            $message .= "-Editorial incorrecto<br>";
        }
        if ($this->setPublishDate($publishDate) != 0) {
            $message .= "-Fecha de publicación incorrecto<br>";
        }
        if ($this->setAvailabilityDate($availabilityDate) != 0) {
            $message .= "-Fecha disponibilidad incorrecta<br>";
        }
        try {
            $this->physicalData = new PhysicalData($height, $width, $length, $weight, $fragile);
        } catch (CheckException $e) {
            $message .= $e->getMessage();
        }
        
        if (strlen($message) > 0) {
            throw new CheckException($message);
        }
    }

    // Método para obtener el tiempo transcurrido entre la publicación y la disponibilidad
    public function getPeriod(): string {
        $interval = $this->publishDate->diff($this->availabilityDate);
        return $interval->format('%y años, %m meses, %d días');
    }

    // Método para obtener intervalos fijos de días entre la fecha de disponibilidad y la fecha actual
    public function getIntervals(int $days): array {
        $interval = new DateInterval('P' . $days . 'D');
        $period = new DatePeriod($this->availabilityDate, $interval, new DateTime());

        // Generar una lista de fechas
        $dates = [];
        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d H:i:s');
        }
        return $dates;
    }

    // Getters para las fechas con el formato requerido
    public function getPublishDate(): string {
        return $this->publishDate->format('Y-m-d');
    }

    public function getAvailabilityDate(): string {
        return $this->availabilityDate->format('Y-m-d H:i:s');
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

    // Implementación de métodos de Storable
    
    public function getHeight(): ?float {
        return $this->physicalData ? $this->physicalData->getHeight() : null;
    }

    public function getWidth(): ?float {
        return $this->physicalData ? $this->physicalData->getWidth() : null;
    }

    public function getLength(): ?float {
        return $this->physicalData ? $this->physicalData->getLength() : null;
    }

    public function getWeight(): ?float {
        return $this->physicalData ? $this->physicalData->getWeight() : null;
    }

    public function isFragile(): ?bool {
        return $this->physicalData ? $this->physicalData->isFragile() : null;
    }

    public function getVolume(): ?float {
        return $this->physicalData ? $this->physicalData->getVolume() : null;
    }

    public function getDimensions(): ?string {
        return $this->physicalData ? $this->physicalData->getDimensions() : null;
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
            $this->publishDate = DateTime::createFromFormat('d/m/Y', $date);
        }
        return $error;
    }

    public function setAvailabilityDate(string $date): int {
        $error = Checker::checkDate($date);
        if ($error == 0) {
            $this->availabilityDate = DateTime::createFromFormat('d/m/Y', $date);
            if ($this->availabilityDate > $this->publishDate){
                return $error;
            }   
        }
        return $error;
    }

    public function getDetails(): string {
        $details = "Libro: {$this->name}, Autor: {$this->author}, Páginas: {$this->pages}, Editorial: {$this->publisher}, Precio: {$this->price}€";
        if ($this->publishDate) {
            $details .= ", Fecha de publicación: " . $this->publishDate->format('Y-m-d');
        }
        if ($this->availabilityDate) {
            $details .= ", Fecha disponibilidad: " . $this->availabilityDate->format('Y-m-d');
        }
        if ($this->physicalData) {
            $details .= ", Detalles Físicos: " . $this->physicalData->getDimensions();
        }
        return $details;
    }
}



   