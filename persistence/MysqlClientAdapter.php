<?php

declare(strict_types=1);
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/Client.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlAdapter.php');

class MysqlClientAdapter extends MysqlAdapter {

    public function getClient(int $id): array {
        $query = "SELECT c.client_id, c.name, c.address, c.email, c.phone_number, c.membership_type, c.account_balance,
                  ic.dni,
                  cc.company_id, cc.workers, cc.social_reason
                  FROM Clients c
                  LEFT JOIN IndividualClients ic ON c.client_id = ic.client_id
                  LEFT JOIN CompanyClients cc ON c.client_id = cc.client_id
                  WHERE c.client_id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();

        if (!$data) {
            throw new ServiceException("No Client found with clientId = " . $id);
        }

        return $data;
    }

    
    public function exists(string $email): bool {
        $stmt = $this->connection->prepare("SELECT client_id FROM Clients WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();
        return $exists;
    }
    
    public function maxClientid(): int {
        $result = $this->connection->query("SELECT MAX(client_id) as last FROM Clients");
        $row = $result->fetch_assoc();
        return (int) $row['last'];
    }

    public function deleteClient(int $id): bool {
    $this->connection->begin_transaction();
    try {
        // Borrar registros relacionados en IndividualClients y CompanyClients
        $stmt = $this->connection->prepare("DELETE FROM IndividualClients WHERE client_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $stmt = $this->connection->prepare("DELETE FROM CompanyClients WHERE client_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Ahora borrar el cliente de la tabla Clients
        $stmt = $this->connection->prepare("DELETE FROM Clients WHERE client_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $this->connection->commit();
            return true;
        } else {
            $this->connection->rollback();
            return false;
        }
    } catch (mysqli_sql_exception $ex) {
        $this->connection->rollback();
        throw new ServiceException("Error al borrar el cliente " . $id . "-->" . $ex->getMessage());
    } finally {
        $stmt->close();
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
    
    public function listClients(): array {
    $query = "SELECT c.client_id, c.name, c.address, c.email, c.phone_number, c.membership_type, c.account_balance,
              ic.dni,
              cc.company_id, cc.workers, cc.social_reason
              FROM Clients c
              LEFT JOIN IndividualClients ic ON c.client_id = ic.client_id
              LEFT JOIN CompanyClients cc ON c.client_id = cc.client_id
              ORDER BY c.client_id ASC";
    $result = $this->connection->query($query);

    if ($result) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        throw new Exception("Error al obtener los clientes: " . $this->connection->error);
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


