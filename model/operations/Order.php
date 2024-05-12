<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/operations/Operation.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/operations/OrderDetail.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/checkdata/Checker.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/exceptions/CheckException.php');

class Order extends Operation {
    private array $orderDetails = [];

    public function __construct(int $operationId, string $customerName, string $operationType) {
        parent::__construct($operationId, $customerName, $operationType);
    }

    public function addDetail(int $productId, int $quantity, float $unitPrice, float $discount = 0): void {
        $message = "";
        if (Checker::NumberValidator($productId, 1) != 0) {
            $message .= "Id producto incorrecto";
        }
        if (Checker::NumberValidator($quantity, 1) != 0) {
            $message .= "cantidad incorrecta";
        }
        if (Checker::NumberValidator($unitPrice, 0.01) != 0) {
            $message .= "Precio unitario incorrecto";
        }
        if (Checker::PercentageValidator($discount) != 0) {
            $message .= "Descuento incorrecto";
        }
        if (strlen($message) > 0) {
            throw new CheckException($message);
        }

        $detail = new OrderDetail($productId, $quantity, $unitPrice, $discount);
        $this->orderDetails[] = $detail;
        $this->calculateTotalAmount();
    }

    protected function calculateTotalAmount(): void {
        $this->totalAmount = 0.0;
        foreach ($this->orderDetails as $detail) {
            $this->totalAmount += ($detail->getUnitPrice() * $detail->getQuantity() * ((100 - $detail->getDiscount()) / 100));
        }
    }

    public function getTotalAmount(): float {
        return $this->totalAmount;
    }

    public function updateDetail(int $pos, array $updates): void {
        $message = "";
        if (!isset($this->orderDetails[$pos])) {
            throw new CheckException("Posicion incorrecta para actualizar.");
        }

        $detail = $this->orderDetails[$pos];
        if (isset($updates['productId']) && Checker::NumberValidator($updates['productId'], 1) != 0) {
            $message .= "ID producto incorrecto;";
        }
        if (isset($updates['quantity']) && Checker::NumberValidator($updates['quantity'], 1) != 0) {
            $message .= "cantidad incorrecta";
        }
        if (isset($updates['unitPrice']) && Checker::NumberValidator($updates['unitPrice'], 0.01) != 0) {
            $message .= "Precio unitario incorrecto";
        }
        if (isset($updates['discount']) && Checker::PercentageValidator($updates['discount']) != 0) {
            $message .= "Descuento incorrecto";
        }

        if (strlen($message) > 0) {
            throw new CheckException($message);
        }

        $this->orderDetails[$pos] = new OrderDetail($updates['productId'], $updates['quantity'], $updates['unitPrice'], $updates['discount']);
        $this->calculateTotalAmount();
    }

    public function deleteDetail(int $pos): void {
        if (!isset($this->orderDetails[$pos])) {
            throw new CheckException("Posicón incorecta para eliminar.");
        }

        array_splice($this->orderDetails, $pos, 1);
        $this->calculateTotalAmount();
    }
}
