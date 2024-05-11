<?php

declare(strict_types=1);

require_once '../../model/checkdata/Checker.php';
require_once '../../exceptions/CheckException.php';


class CompanyData {
    protected int $companyId;
    protected int $workers;
    protected string $socialReason;
    protected string $companyType;

    public function __construct(int $companyId, int $workers, string $socialReason) {
        $message = "";
        if ($this->setCompanyId($companyId) != 0) {
            $message .= "-ID de compañía incorrecto<br>";
        }
        if ($this->setWorkers($workers) != 0) {
            $message .= "-Numero de trabajadores incorrecto<br>";
        }
        if ($this->setSocialReason($socialReason) != 0) {
            $message .= "-Razón social incorrecto<br>";
        }
        if (strlen($message) > 0) {
            throw new CheckException($message);
        }
    }
 
    public function getCompanyId(): int {
        return $this->companyId;
    }
    
    public function getWorkers(): int {
        return $this->workers;
    }

    public function getSocialReason(): string {
        return $this->socialReason;
    }

    public function getCompanyType(): string {
        return $this->companyType;
    }
    
    public function setCompanyId(int $companyId): int {
        $error = Checker::NumberValidator($companyId);
        if ($error == 0) {
            $this->companyId = $companyId;
        }
        return $error;
    }
    
    public function setWorkers(int $workers): int {
        $error = Checker::NumberValidator($workers);
        if ($error == 0) {
            $this->workers = $workers;
            $this->companyType = $this->determineCompanyType($workers);
        }
        return $error;
    }

    public function setSocialReason(string $socialReason): int {
        $error = Checker::StringValidator($socialReason, 2);
        if ($error == 0) {
            $this->socialReason = $socialReason;
        }
        return $error;
    }

    private function determineCompanyType(int $workers): string {
        if ($workers > 250) {
            return "Gran compañía";
        } elseif ($workers <= 50) {
            return "Compañía pequeña";
        } else {
            return "Compañía mediana";
        }
    }
}

