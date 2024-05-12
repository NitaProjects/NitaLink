<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/products/Product.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/interfaces/Marketable.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/checkdata/Checker.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/exceptions/CheckException.php');

class Course extends Product {
    protected int $duration;
    protected string $instructor;
    protected string $language;

    public function __construct(int $productId, string $name, float $price, int $quantity, int $duration, string $instructor, string $language) {
        $message = "";
        try {
            parent::__construct($productId, $name, $price, $quantity);
        } catch (CheckException $e) {
            $message .= $e->getMessage();  
        }
        if ($this->setDuration($duration) != 0) {
            $message .= "Duración incorrecta<br>";
        }
        if ($this->setInstructor($instructor) != 0) {
            $message .= "Profesor incorrecto<br>";
        }
        if ($this->setLanguage($language) != 0) {
            $message .= "Idioma incorrecto<br>";
        }
        if (strlen($message) > 0) {
            throw new CheckException($message);
        }
    }
    
    // Getters
    public function getDuration(): int {
        return $this->duration;
    }

    public function getInstructor(): string {
        return $this->instructor;
    }

    public function getLanguage(): string {
        return $this->language;
    }

    // 
    public function setDuration(int $duration): int {
        $error = Checker::NumberValidator($duration);
        if ($error == 0) {
            $this->duration = $duration;
        }
        return $error;
    }

    public function setInstructor(string $instructor): int {
        $error = Checker::StringValidator($instructor, 2); 
        if ($error == 0) {
            $this->instructor = $instructor;
        }
        return $error;
    }

    public function setLanguage(string $language): int {
        $error = Checker::StringValidator($language, 2); 
        if ($error == 0) {
            $this->language = $language;
        }
        return $error;
    }
    
}
