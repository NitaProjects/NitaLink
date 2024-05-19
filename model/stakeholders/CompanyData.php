<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/exceptions/BuildException.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/checkdata/Checker.php');


class CompanyData {
    protected int $workers;
    protected string $socialReason;
    protected string $companyType;

    public function __construct( int $workers, string $socialReason) {
        $message = "";
        if ($this->setWorkers($workers) != 0) {
            $message .= "-Numero de trabajadores incorrecto.\n";
        }
        if ($this->setSocialReason($socialReason) != 0) {
            $message .= "-Razón social incorrecto.\n";
        }
        if (strlen($message) > 0) {
            throw new BuildException($message);
        }
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

