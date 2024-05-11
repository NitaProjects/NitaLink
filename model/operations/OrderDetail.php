<?php

require_once '../../model/checkdata/Checker.php';
require_once '../../exceptions/CheckException.php'; 

class OrderDetail {
    private int $productId;
    private int $quantity;
    private float $unitPrice;
    private float $discount;  

    public function __construct(int $productId, int $quantity, float $unitPrice, float $discount) {
        $message = "";
        if ($this->setProductId($productId) != 0) {
            $message .= "Id producto incorrecto";
        }
        if ($this->setQuantity($quantity) != 0) {
            $message .= "Cantidad incorrecta;";
        }
        if ($this->setUnitPrice($unitPrice) != 0) {
            $message .= "Precio unitario incorrecto";
        }
        if ($this->setDiscount($discount) != 0) {
            $message .= "Descuento incorrecto";
        }
        if (strlen($message) > 0) {
            throw new CheckException($message);
        }
    }

    // Getters
    public function getProductId(): int {
        return $this->productId;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function getUnitPrice(): float {
        return $this->unitPrice;
    }

    public function getDiscount(): float {
        return $this->discount;
    }

    // Setters with error handling using Checker class
    public function setProductId(int $productId): int {
        $error = Checker::NumberValidator($productId);
        if ($error == 0) {
            $this->productId = $productId;
        }
        return $error;
    }

    public function setQuantity(int $quantity): int {
        $error = Checker::NumberValidator($quantity);
        if ($error == 0) {
            $this->quantity = $quantity;
        }
        return $error;
    }

    public function setUnitPrice(float $unitPrice): int {
        $error = Checker::NumberValidator($unitPrice, 0);
        if ($error == 0) {
            $this->unitPrice = $unitPrice;
        }
        return $error;
    }

    public function setDiscount(float $discount): int {
        $error = Checker::PercentageValidator($discount);
        if ($error == 0) {
            $this->discount = $discount;
        }
        return $error;
    }
}
