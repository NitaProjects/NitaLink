<?php

declare(strict_types=1);

require_once '../../model/checkdata/Checker.php';
require_once '../../exceptions/CheckException.php';

abstract class Operation {
    protected int $operationId;
    protected DateTime $date;
    protected string $customerName;
    protected string $operationType;  

    public function __construct(int $operationId, string $customerName, string $operationType) {
        $message = "";
        if ($this->setOperationId($operationId) != 0) {
            $message .= "Id operacion incorrecta";
        }
        if ($this->setCustomerName($customerName) != 0) {
            $message .= "Nombre cliente incorrecto";
        }
        if ($this->setOperationType($operationType) != 0) {
            $message .= "Tipo de operacón incorrecta";
        }
        $this->date = new DateTime(); 

        if (strlen($message) > 0) {
            throw new CheckException($message);
        }
    }

    // Getters
    public function getOperationId(): int {
        return $this->operationId;
    }
    
    public function getDate(): string {
        return $this->date->format('d-m-Y H:i:s');
    }
    
    public function getCustomerName(): string {
        return $this->customerName;
    }

    public function getOperationType(): string {
        return $this->operationType;
    }
    
      // Setters using Checker for validation
    public function setOperationId(int $operationId): int {
        $error = Checker::NumberValidator($operationId, 1);
        if ($error == 0) {
            $this->operationId = $operationId;
        }
        return $error;
    }

    public function setCustomerName(string $customerName): int {
        $error = Checker::StringValidator($customerName, 2);
        if ($error == 0) {
            $this->customerName = $customerName;
        }
        return $error;
    }
    
    public function setOperationType(string $operationType): int {
        $error = Checker::OperationTypeValidator($operationType);
        if ($error == 0) {
            $this->operationType = $operationType;
        }
        return $error;
    }
}