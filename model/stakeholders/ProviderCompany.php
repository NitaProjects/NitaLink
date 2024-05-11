<?php

declare(strict_types=1);

require_once 'Person.php';
require_once '../../interfaces/Stakeholder.php';
require_once '../../model/checkdata/Checker.php';
require_once '../../exceptions/CheckException.php';

class ProviderCompany extends Person implements Stakeholder {
    protected int $providerId;
    protected string $productSupplied;
    protected array $deliveryDays = [];
    protected CompanyData $companyData ;

    public function __construct(string $name, string $address, string $email, string $phoneNumber, int $providerId, string $productSupplied, array $deliveryDays, int $companyId, int $workers, string $socialReason) {
        $message = "";
        try {
            parent::__construct($name, $address, $email, $phoneNumber);
        } catch (CheckException $e) {
            $message .= $e->getMessage();  
        }
        if ($this->setProviderId($providerId) != 0) {
            $message .= "-ID del proveedor incorrecto<br>";
        }
        if ($this->setProductSupplied($productSupplied) != 0) {
            $message .= "-No existe el producto suministrado<br>";
        }
        if ($this->setDeliveryDays($deliveryDays) != 0) {
            $message .= "-Días de reparto incorrectos<br>";
        }
        try {
            $this->companyData = new CompanyData($companyId, $workers, $socialReason);
        } catch (CheckException $e) {
            $message .= $e->getMessage();
        }
        if (strlen($message) > 0) {
            throw new CheckException($message);
        }
    }

    // Getters
    public function getProviderId(): int {
        return $this->providerId;
    }

    public function getProductSupplied(): string {
        return $this->productSupplied;
    }

    public function getDeliveryDays(): array {
        return $this->deliveryDays;
    }

    public function getCompanyData(): ?CompanyData {
        return $this->companyData;
    }
    
    public function getContactInfo(): string {
        return "Email: {$this->email}, Teléfono: {$this->phoneNumber}";
    }
    
    public function getDetails(): string {
        return $this->getContactData();  
    }

    public function getContactData(): string {
        return "Nombre: {$this->name}, Email: {$this->email}, ID Proveedor: {$this->providerId}, Producto: {$this->productSupplied}, "
        . "Trabajadores: " . $this->companyData->getWorkers().", Razón Social: " . $this->companyData->getSocialReason(). ", Tipo de compañía: " . $this->companyData->getCompanyType();
    }

    // Setters
    public function setProviderId(int $providerId): int {
        $error = Checker::NumberValidator($providerId);
        if ($error == 0) {
            $this->providerId = $providerId;
        }
        return $error;
    }

    public function setProductSupplied(string $productSupplied): int {
        $error = Checker::StringValidator($productSupplied, 2);
        if ($error == 0) {
            $this->productSupplied = $productSupplied; 
        }
        return $error; 
    }

    public function setDeliveryDays(array $deliveryDays): int {
        $error = Checker::DeliveryDaysValidator($deliveryDays);
        if ($error != 0) {
            return $error; 
        }
        $this->deliveryDays = $deliveryDays;
        return 0; 
    }
}

