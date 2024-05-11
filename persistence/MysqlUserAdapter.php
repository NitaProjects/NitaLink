<?php

declare(strict_types=1);

require_once '../model/stakeholders/User.php';
include 'MysqlAdapter.php';

class MysqlUserAdapter extends MysqlAdapter {

    public function getUser(int $id): User {
        $data = $this->readQuery("SELECT id, name, password, type FROM users WHERE id = " . $id . ";");
        if (count($data) > 0) {
            return new User((int) $data[0]["id"], $data[0]["name"], $data[0]["password"], $data[0]["type"]);
        } else {
            throw new ServiceException("No User found with id = " . $id);
        }
    }

    public function deleteUser(int $id): bool {
        try {
            return $this->writeQuery("DELETE FROM users WHERE id = " . $id . ";");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error al borrar al usuario " . $id . "-->" . $ex->getMessage());
        }
    }

    public function addUser(User $u): bool {
        try {
            return $this->writeQuery("INSERT INTO users (id, name, password, type) VALUES (" . 
                    $u->getId() . ", \"" . $u->getName() . "\", \"" . $u->getPassword() . "\", \"" . $u->getType() . "\");");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error al insertar usuario -->" . $ex->getMessage());
        }
    }

    public function updateUser(User $u): bool {
        try {
            return $this->writeQuery("UPDATE users SET name = \"" . $u->getName() . "\", password = \"" . $u->getPassword() . 
                    "\", type = \"" . $u->getType() . "\" WHERE id = " . $u->getId() . ";");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error al actualizar usuario -->" . $ex->getMessage());
        }
    }

    public function authentication(string $username, string $password): User {
        try {
            $id = $this->readQuery("SELECT id FROM users WHERE name='" . $username . "' and password='" . $password . "';");
            if (count($id) > 0) {
                return $this->getUser((int) $id[0]["id"]);
            } else {
                throw new ServiceException("Usuario o contraseña incorrecta --> ");
            }
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error al leer usuarios -->" . $ex->getMessage());
        }
    }
    
    public function exists(string $username): bool {
        try {
            $id = $this->readQuery("SELECT id FROM users WHERE name='" . $username . "';");
            if (count($id) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error al leer usuarios -->" . $ex->getMessage());
        }
    }

    public function maxUserid(): int {
        try {
            $id = $this->readQuery("SELECT max(id) as last FROM users;");
            return (int) $id[0]["last"];
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error al leer usuarios -->" . $ex->getMessage());
        }
    }
}
