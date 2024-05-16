<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/CompanyData.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/Person.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/exceptions/CheckException.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/checkdata/Checker.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/interfaces/Stakeholder.php');

class ClientCompany extends Person implements Stakeholder {
    protected int $clientId;
    protected string $clientType;
    protected string $membershipType;
    protected float $accountBalance;
    protected CompanyData $companyData;

    public function __construct(string $name, string $address, string $email, string $phoneNumber, int $clientId, string $membershipType, float $accountBalance, int $workers, string $socialReason) {
        $message = "";
        try {
            parent::__construct($name, $address, $email, $phoneNumber);
        } catch (CheckException $e) {
            $message .= $e->getMessage();  
        }
        if ($this->setClientId($clientId) != 0) {
            $message .= "-ID cliente incorrecto <br>";
        }
        if ($this->setMembershipType($membershipType) != 0) {
            $message .= "-Membresía incorrecta<br>";
        }
        if ($this->setAccountBalance($accountBalance) != 0) {
            $message .= "-Saldo incorrecto<br>";
        }
        
        try {
            $this->companyData = new CompanyData($workers, $socialReason);
        } catch (CheckException $e) {
            $message .= $e->getMessage();
        }
           
        if (strlen($message) > 0) {
            throw new CheckException($message);
        }
    }
    
    // Getters

    public function getClientId(): int {
        return $this->clientId;
    }
    
    public function getMembershipType(): string {
        return $this->membershipType;
    }
    
    public function getAccountBalance(): float {
        return $this->accountBalance;
    }
    
    public function getCompanyData(): CompanyData {
        return $this->companyData;
    }
    
    public function getName(): string {
        return $this->name;
    }
    
    public function getWorkers(): int {
        return $this->companyData->getWorkers();
    }

    public function getSocialReason(): string {
        return $this->companyData->getSocialReason();
    }
    
    public function getContactInfo(): string {
        return "Email: {$this->email}, Teléfono: {$this->phoneNumber}";
    }
    
    public function getDetails(): string {
        return $this->getContactData();  
    }
    
    public function getContactData(): string {
        $details = "Nombre: {$this->name}, Email: {$this->email}, Cliente ID: {$this->clientId}, Membresia: {$this->membershipType}, Saldo: {$this->accountBalance}, Trabajadores: " . $this->companyData->getWorkers().", Razón Social: " . $this->companyData->getSocialReason(). ", Tipo de compañía: " . $this->companyData->getCompanyType();
        return $details;
    }   
    
    public function setClientId(int $clientId): int {
        $error = Checker::NumberValidator($clientId);
        if ($error == 0) {
            $this->clientId = $clientId;
        }
        return $error;
    }
    
    public function setMembershipType(string $membershipType): int {
        $error = Checker::MembershipTypeValidator($membershipType);
        if ($error == 0) {
            $this->membershipType = $membershipType;
        }
        return $error;
    }

    public function setAccountBalance(float $accountBalance): int {
        $error = Checker::AccountBalanceValidator($accountBalance);
        if ($error == 0) {
            $this->accountBalance = $accountBalance;
        }
        return $error;
    }
}