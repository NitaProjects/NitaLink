<?php

declare(strict_types=1);

require_once '../../model/checkdata/Checker.php';
require_once '../../interfaces/Marketable.php';
require_once '../../exceptions/CheckException.php';

class Product implements Marketable {
    protected int $productId;
    protected string $name;
    protected float $price;
    protected int $quantity;
    protected string $isbn;

    public function __construct(int $productId, string $name, float $price, int $quantity, string $isbn) {
        $message = "";
        if ($this->setProductId($productId) != 0) {
            $message .= "-ID producto incorrecto <br>";
        }
        if ($this->setName($name) != 0) {
            $message .= "-Nombre producto incorrecto <br>";
        }
        if ($this->setPrice($price) != 0) {
            $message .= "-Precio producto incorrecto <br>";
        }
        if ($this->setQuantity($quantity) != 0) {
            $message .= "-Cantidad producto incorrecto <br>";
        }
        if ($this->setIsbn($isbn) != 0) {
            $message .= "-ISBN incorrecto <br>";
        }
        if (strlen($message) > 0) {
            throw new CheckException($message);
        }
    }
    
    // Implementación de los métodos de Marketable
    public function buy(): void {
        if ($this->increaseStock(1) != 0) {
            echo "Error al comprar el producto: {$this->name}\n";
        } else {
            echo "Producto comprado: {$this->name} por {$this->price}€\n";
        }
    }

    public function sell(): void {
        if ($this->decreaseStock(1) != 0) {
            echo "Error al vender el producto: {$this->name}\n";
        } else {
            echo "Producto vendido: {$this->name} por {$this->price}€\n";
        }
    }   

    public function applyDiscount(int $percentage): void {
        $error = Checker::PercentageValidator($percentage);
        if ($error != 0) {
            echo "Error al aplicar el descuento: Porcentaje fuera de rango.\n";
        } else if (!$this->isDiscountApplied) {
            $this->originalPrice = $this->price;
            $this->isDiscountApplied = true;
            $discountAmount = ($this->price * $percentage) / 100;
            $this->price -= $discountAmount;
        }
    }

    public function removeDiscount(): void {
        $this->price = $this->originalPrice;
        $this->isDiscountApplied = false;
    }

    public function increaseStock(int $amount): int {
        if ($amount < 0) {
            return -1; // Error code for negative amount
        }
        $this->quantity += $amount;
        return 0; // No error
    }

    public function decreaseStock(int $amount): int {
        if ($amount < 0 || $amount > $this->quantity) {
            return -1; // Error code for invalid or insufficient amount
        }
        $this->quantity -= $amount;
        return 0; // No error
    }


    // Getters
    public function getProductId(): int {
        return $this->productId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    // Setters
    private function setProductId(int $productId): int {
        $error = Checker::NumberValidator($productId);
        if ($error == 0) {
            $this->productId = $productId;
        }
        return $error;
    }

    private function setName(string $name): int {
        $error = Checker::StringValidator($name, 2);
        if ($error == 0) {
            $this->name = $name;
        }
        return $error;
    }

    private function setPrice(float $price): int {
        $error = Checker::NumberValidator($price, 0.01);
        if ($error == 0) {
            $this->price = $price;
        }
        return $error;
    }

    private function setQuantity(int $quantity): int {
        $error = Checker::NumberValidator($quantity, 0);
        if ($error == 0) {
            $this->quantity = $quantity;
        }
        return $error;
    }
    
    private function setIsbn(string $isbn): int {
        $error = Checker::checkISBN($isbn);
        if($error == 0){
            $this->isbn = $isbn;
        }
        return $error;
    }

}
