<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/exceptions/BuildException.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/checkdata/Checker.php');

abstract class Person {
    protected string $name;
    protected string $address;
    protected string $email;
    protected string $phoneNumber;

    public function __construct(string $name, string $address, string $email, string $phoneNumber) {
        $message = "";
        if ($this->setName($name) != 0) {
            $message .= "-Nombre incorrecto.\n";
        }
        if ($this->setAddress($address) != 0) {
            $message .= "-Dirección incorrecta.\n";
        }
        if ($this->setEmail($email) != 0) {
            $message .= "-Email incorrecto.\n";
        }
        if ($this->setPhoneNumber($phoneNumber) != 0) {
            $message .= "-Numero de teléfono incorrecto.\n";
        }
        if (strlen($message) > 0) {
            throw new BuildException($message);
        }
    }

    public function getName(): string {
        return $this->name;
    }

    public function getAddress(): string {
        return $this->address;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPhoneNumber(): string {
        return $this->phoneNumber;
    }

    public function setName(string $name): int {
        $error = Checker::StringValidator($name, 2);
        if ($error == 0) {
            $this->name = $name;
        }
        return $error;
    }

    public function setAddress(string $address): int {
        $error = Checker::StringValidator($address, 2);
        if ($error == 0) {
            $this->address = $address;
        }
        return $error;
    }

    public function setEmail(string $email): int {
        $error = Checker::EmailValidator($email); 
        if ($error == 0) {
            $this->email = $email;
        }
        return $error;
    }

    public function setPhoneNumber(string $phoneNumber): int {
        $error = Checker::PhoneNumberValidator($phoneNumber); 
        if ($error == 0) {
            $this->phoneNumber = $phoneNumber;
        }
        return $error;
    }

    abstract public function getContactData(): string;

}
