<?php
declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/checkdata/Checker.php');


class PhysicalData {
    protected float $height;
    protected float $width;
    protected float $length;
    protected float $weight;
    protected bool $fragile;

    public function __construct(float $height, float $width, float $length, float $weight, bool $fragile) {
        $message = "";
        if ($this->setHeight($height) != 0) {
            $message .= "-Altura incorrecta<br>";
        }
        if ($this->setWidth($width) != 0) {
            $message .= "-Anchura incorrecta<br>";
        }
        if ($this->setLength($length) != 0) {
            $message .= "-Largo incorrecto<br>";
        }
        if ($this->setWeight($weight) != 0) {
            $message .= "-Peso incorrecto<br>";
        }
        $this->fragile = $fragile;

        if (strlen($message) > 0) {
        throw new CheckException($message);
        }
    }
    
    // GETTERS
    
    public function getHeight(): float {
        return $this->height;
    }

    public function getWidth(): float {
        return $this->width;
    }

    public function getLength(): float {
        return $this->length;
    }

    public function getWeight(): float {
        return $this->weight;
    }

    public function isFragile(): bool {
        return $this->fragile;
    }

    public function getVolume(): float {
        return $this->height * $this->width * $this->length;
    }

    public function getDimensions(): string {
        return "Altura: {$this->height} cm, Ancho: {$this->width} cm, Largo: {$this->length} cm";
    }
    
    // SETTERS
    
    private function setHeight(float $height): int {
        $error = Checker::NumberValidator($height);
        if ($error == 0) {
            $this->height = $height;
        }
        return $error;
    }

    private function setWidth(float $width): int {
        $error = Checker::NumberValidator($width);
        if ($error == 0) {
            $this->width = $width;
        }
        return $error;
    }

    private function setLength(float $length): int {
        $error = Checker::NumberValidator($length);
        if ($error == 0) {
            $this->length = $length;
        }
        return $error;
    }

    private function setWeight(float $weight): int {
        $error = Checker::NumberValidator($weight);
        if ($error == 0) {
            $this->weight = $weight;
        }
        return $error;
    }
}
