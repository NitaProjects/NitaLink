<?php

declare(strict_types=1);
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/checkdata/Checker.php');

class User {

    protected int $id;
    protected string $name;
    protected string $password;
    protected string $type;

    public function __construct(int $id, string $name, string $password, string $type) {
        $message = "";
        if ($this->setName($name) != 0) {
            $message .= "Nombre incorrecto, ";
        }
        if ($this->setId($id) != 0) {
            $message .= "ID incorrecto, ";
        }
        if ($this->setPassword($password) != 0) {
            $message .= "Password incorrecto, ";
        }
        if ($this->setType($type) != 0) {
            $message .= "no existe este tipo de usuario, ";
        }
        if (strlen($message) > 0) {
            throw new CheckException($message);
        }
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPassword(): string {
        return $this->password;
    }
    
    public function getType(): string {
        return $this->type;
    }
    
    public function setId(int $id): int {
        $error = Checker::NumberValidator($id);
        if ($error == 0) {
            $this->id = $id;
        }
        return $error;
    }

    public function setName(string $name): int {
        $error = Checker::StringValidator($name, 3);
        if ($error == 0) {
            $this->name = $name;
        }
        return $error;
    }

    public function setPassword(string $password): int {
        $error = Checker::StringValidator($password, 3);
        if ($error == 0) {
            $this->password = $password;
        }
        return $error;
    }
    
    public function setType(string $type): int {
        $error = Checker::UserTypeValidator($type);
        if ($error == 0) {
            $this->type = $type;
        }
        return $error;
    }


}
