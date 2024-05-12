<?php

declare(strict_types=1);
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/Client.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlAdapter.php');

class MysqlClientAdapter extends MysqlAdapter {

    public function getClient(int $id): Client {
        $data = $this->readQuery("SELECT id, name, address, email, phoneNumber, clientId, membershipType, accountBalance, companyData FROM clients WHERE clientId = " . $id . ";");
        if (count($data) > 0) {
            return new Client($data[0]["name"], $data[0]["address"], $data[0]["email"], $data[0]["phoneNumber"], 
                              (int) $data[0]["clientId"], $data[0]["membershipType"], (float) $data[0]["accountBalance"], $data[0]["companyData"]);
        } else {
            throw new ServiceException("No Client found with clientId = " . $id);
        }
    }
    
    public function exists(string $email): bool {
        try {
            $id = $this->readQuery("SELECT client_id FROM clients WHERE email='" . $email . "';");
            if (count($id) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error al leer clientes -->" . $ex->getMessage());
        }
    }
    
    public function maxClientid(): int {
        try {
            $id = $this->readQuery("SELECT max(client_id) as last FROM clients;");
            return (int) $id[0]["last"];
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error al leer clientes -->" . $ex->getMessage());
        }
    }

    public function deleteClient(int $id): bool {
        try {
            return $this->writeQuery("DELETE FROM clients WHERE clientId = " . $id . ";");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error al borrar el cliente " . $id . "-->" . $ex->getMessage());
        }
    }

    public function addClient(Client $c): bool {
        try {
            $this->writeQuery("INSERT INTO clients (client_id, name, address, email, phone_number, client_type, account_balance, membership_type) VALUES (" . 
                $c->getClientId() . ", '" . $c->getName() . "', '" . $c->getAddress() . "', '" . $c->getEmail() . "', '" . 
                $c->getPhoneNumber() . "', '" . ($c->getCompanyData() ? 'empresa' : 'particular') . "', " . $c->getAccountBalance() . ", '" . 
                $c->getMembershipType() . "');");

            // Si companyData no es null, insertar en CompanyData
            if ($c->getCompanyData() !== null) {
                $this->writeQuery("INSERT INTO CompanyData (client_id, company_workers, corporate_reason) VALUES (" . 
                    $c->getClientId() . ", " . $c->getCompanyWorkers() . ", '" . $c->getCorporateReason() . "');");
            }

            return true;
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error al insertar cliente -->" . $ex->getMessage());
        }
    }

    public function updateClient(Client $c): bool {
        try {
            return $this->writeQuery("UPDATE clients SET name = \"" . $c->getName() . "\", address = \"" . $c->getAddress() . 
                    "\", email = \"" . $c->getEmail() . "\", phoneNumber = \"" . $c->getPhoneNumber() . "\", membershipType = \"" . 
                    $c->getMembershipType() . "\", accountBalance = " . $c->getAccountBalance() . ", companyData = \"" . $c->getCompanyData() . 
                    "\" WHERE clientId = " . $c->getClientId() . ";");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error al actualizar cliente -->" . $ex->getMessage());
        }
    }
}


