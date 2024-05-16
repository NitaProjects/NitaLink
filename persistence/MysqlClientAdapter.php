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

    public function addCompanyClient(ClientCompany $client) {
    try {
        $this->connection->begin_transaction();
        
        // Insertar en la tabla 'clients' los datos generales del cliente
        $stmt = $this->connection->prepare("INSERT INTO clients (name, address, email, phone_number, membership_type, account_balance) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssd", 
            $client->getName(), 
            $client->getAddress(), 
            $client->getEmail(), 
            $client->getPhoneNumber(), 
            $client->getMembershipType(), 
            $client->getAccountBalance());
        $stmt->execute();
        $client_id = $this->connection->insert_id; // Obtener el ID del cliente insertado

        // Insertar en la tabla 'CompanyClients' los detalles específicos de la empresa
        $workers = $client->getWorkers();
        $socialReason = $client->getSocialReason();
        $stmt = $this->connection->prepare("INSERT INTO companyclients (client_id, workers, social_reason) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", 
            $client_id, 
            $workers, 
            $socialReason);
        $stmt->execute();

        // Verificar si las inserciones fueron exitosas
        if ($stmt->affected_rows > 0) {
            $this->connection->commit();
            return true;
        } else {
            $this->connection->rollback();
            return false;
        }
    } catch (mysqli_sql_exception $ex) {
        $this->connection->rollback();
        throw new ServiceException("Error al insertar cliente de empresa: " . $ex->getMessage());
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}






public function addIndividualClient(Client $c) {
    try {
        $this->connection->begin_transaction();
        
        // Insertar en la tabla principal 'clients'
        $stmt = $this->connection->prepare("INSERT INTO clients (name, address, email, phone_number, membership_type, account_balance) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssd", $c->getName(), $c->getAddress(), $c->getEmail(), $c->getPhoneNumber(), $c->getMembershipType(), $c->getAccountBalance());
        $stmt->execute();
        $client_id = $this->connection->insert_id; // Obtener el ID del cliente insertado

        // Insertar en la tabla 'IndividualClients' el DNI y el client_id recién creado
        $stmt = $this->connection->prepare("INSERT INTO IndividualClients (client_id, dni) VALUES (?, ?)");
        $stmt->bind_param("is", $client_id, $c->getDNI());
        $stmt->execute();

        // Comprobar si todo ha salido bien y hacer commit de la transacción
        if ($stmt->affected_rows > 0) {
            $this->connection->commit();
            return true;
        } else {
            $this->connection->rollback();
            return false;
        }
    } catch (mysqli_sql_exception $ex) {
        $this->connection->rollback();
        throw new ServiceException("Error al insertar cliente individual: " . $ex->getMessage());
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}






    
    public function listClients(): array {
    $query = "
        SELECT c.client_id, c.name, c.address, c.email, c.phone_number, c.account_balance, c.membership_type,
               ic.dni, cc.workers, cc.social_reason,
               CASE
                   WHEN ic.client_id IS NOT NULL THEN 'Particular'
                   WHEN cc.client_id IS NOT NULL THEN 'Empresa'
                   ELSE 'Desconocido'
               END AS client_type
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
    // Iniciar la transacción para asegurar que todas las operaciones son atómicas
    $this->connection->begin_transaction();

    try {
        // Primera actualización en la tabla 'clients'
        $query = "UPDATE clients SET 
                    name = ?, 
                    address = ?, 
                    email = ?, 
                    phone_number = ?, 
                    membership_type = ?, 
                    account_balance = ? 
                  WHERE client_id = ?";
        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->connection->error);
        }

        // Asignar las propiedades de la clase Client a variables locales
        $name = $c->getName();
        $address = $c->getAddress();
        $email = $c->getEmail();
        $phoneNumber = $c->getPhoneNumber();
        $membershipType = $c->getMembershipType();
        $accountBalance = $c->getAccountBalance();
        $clientId = $c->getClientId();

        // Vincular los parámetros para la consulta
        $stmt->bind_param("sssssdi", 
            $name, 
            $address, 
            $email, 
            $phoneNumber, 
            $membershipType, 
            $accountBalance,
            $clientId);
        $stmt->execute();
        $updateSuccessful = $stmt->affected_rows > 0;
        $stmt->close();

        // Determinar si es una instancia de ClientCompany para actualizar CompanyClients
        if ($c instanceof ClientCompany) {
            $query = "UPDATE CompanyClients SET workers = ?, corporate_reason = ? WHERE client_id = ?";
            $stmt = $this->connection->prepare($query);
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta para CompanyClients: " . $this->connection->error);
            }
            $workers = $c->getWorkers();
            $corporateReason = $c->getCorporateReason();
            $stmt->bind_param("isi", $workers, $corporateReason, $clientId);
        } else {
            // Actualizar IndividualClients si es un cliente individual
            $query = "UPDATE IndividualClients SET dni = ? WHERE client_id = ?";
            $stmt = $this->connection->prepare($query);
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta para IndividualClients: " . $this->connection->error);
            }
            $dni = $c->getDNI();
            $stmt->bind_param("si", $dni, $clientId);
        }

        // Ejecutar la actualización específica del tipo de cliente
        $stmt->execute();
        $relatedUpdateSuccessful = $stmt->affected_rows > 0;
        $stmt->close();

        // Completar la transacción basada en el éxito de las operaciones
        if ($updateSuccessful || $relatedUpdateSuccessful) {
            $this->connection->commit();
            return true; // Retornar verdadero si alguna de las actualizaciones fue exitosa
        } else {
            $this->connection->rollback();
            return false; // Retornar falso si no se afectaron filas en ninguna de las operaciones
        }
    } catch (Exception $e) {
        // Revertir todas las operaciones si ocurre un error
        $this->connection->rollback();
        throw $e; // Relanzar la excepción para manejarla en niveles superiores
    }
}


}


