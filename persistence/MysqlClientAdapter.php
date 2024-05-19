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
        try {
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            $stmt->close();

            if (!$data) {
                throw new ServiceException("No existe el cliente, compruebe el id = " . $id);
            }
            return $data;
        }catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error al obtener el cliente: " . $ex->getMessage());
        } 
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

            // Obtener valores a partir de los métodos del objeto $client
            $name = $client->getName();
            $address = $client->getAddress();
            $email = $client->getEmail();
            $phone_number = $client->getPhoneNumber();
            $membership_type = $client->getMembershipType();
            $account_balance = $client->getAccountBalance();
            $workers = $client->getWorkers();
            $social_reason = $client->getSocialReason();

            // Insertar en la tabla 'clients' los datos generales del cliente
            $stmt = $this->connection->prepare("INSERT INTO clients (name, address, email, phone_number, membership_type, account_balance) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssd", 
                $name, 
                $address, 
                $email, 
                $phone_number, 
                $membership_type, 
                $account_balance);
            $stmt->execute();
            $client_id = $this->connection->insert_id; // Obtener el ID del cliente insertado

            // Insertar en la tabla 'CompanyClients' los detalles específicos de la empresa
            $stmt = $this->connection->prepare("INSERT INTO companyclients (client_id, workers, social_reason) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", 
                $client_id, 
                $workers, 
                $social_reason);
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
            if ($ex->getCode() == 1062) { // Código de error de MySQL para entrada duplicada
            throw new ServiceException("Error al insertar cliente de empresa: Entrada duplicada para el email '".$client->getEmail()."'. El email ya existe.");
        } else {
            throw new ServiceException("Error al insertar cliente de empresa: " . $ex->getMessage());
        }
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    
    public function addIndividualClient(Client $c) {
        try {
            $this->connection->begin_transaction();
        
            // Obtener valores a partir de los métodos del objeto $c
            $name = $c->getName();
            $address = $c->getAddress();
            $email = $c->getEmail();
            $phone_number = $c->getPhoneNumber();
            $membership_type = $c->getMembershipType();
            $account_balance = $c->getAccountBalance();
            $dni = $c->getDNI();

            // Insertar en la tabla principal 'clients'
            $stmt = $this->connection->prepare("INSERT INTO clients (name, address, email, phone_number, membership_type, account_balance) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssd", $name, $address, $email, $phone_number, $membership_type, $account_balance);
            $stmt->execute();
            $client_id = $this->connection->insert_id; // Obtener el ID del cliente insertado

            // Insertar en la tabla 'IndividualClients' el DNI y el client_id recién creado
            $stmt = $this->connection->prepare("INSERT INTO IndividualClients (client_id, dni) VALUES (?, ?)");
            $stmt->bind_param("is", $client_id, $dni);
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
            if ($ex->getCode() == 1062) { // Código de error de MySQL para entrada duplicada
            throw new ServiceException("Error al insertar cliente de empresa: Entrada duplicada para el email '".$c->getEmail()."'. El email ya existe.");
            } else {
                throw new ServiceException("Error al insertar cliente de empresa: " . $ex->getMessage());
            }
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }


    
    public function listClients(int $page, int $clientsPerPage): array {
        // Calcular el offset
        $offset = ($page - 1) * $clientsPerPage;

        // Consulta SQL con paginación
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
            ORDER BY c.client_id ASC
            LIMIT ? OFFSET ?";
    
        // Preparar la declaración
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ii", $clientsPerPage, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            $clients = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $clients;
        } else {
            throw new Exception("Error al obtener los clientes: " . $this->connection->error);
        }
    }

    public function getTotalClients(): int {
        $query = "SELECT COUNT(*) as total FROM Clients";
        $result = $this->connection->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return (int)$row['total'];
        } else {
            throw new Exception("Error al contar los clientes: " . $this->connection->error);
        }
    }

    public function updateClient(Client $c): bool {
        $this->connection->begin_transaction();

        try {
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

            $stmt->bind_param("sssssdi", 
                $c->getName(), 
                $c->getAddress(), 
                $c->getEmail(), 
                $c->getPhoneNumber(), 
                $c->getMembershipType(), 
                $c->getAccountBalance(),
                $c->getClientId());
            $stmt->execute();
            $updateSuccessful = $stmt->affected_rows > 0;
            $stmt->close();

            $query = "UPDATE IndividualClients SET dni = ? WHERE client_id = ?";
            $stmt = $this->connection->prepare($query);
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta para IndividualClients: " . $this->connection->error);
            }
            $stmt->bind_param("si", $c->getDNI(), $c->getClientId());
            $stmt->execute();
            $relatedUpdateSuccessful = $stmt->affected_rows > 0;
            $stmt->close();

            if ($updateSuccessful || $relatedUpdateSuccessful) {
                $this->connection->commit();
                return true;
            } else {
                $this->connection->rollback();
                return false;
            }
        } catch (Exception $e) {
            $this->connection->rollback();
            throw $e;
        }
    }

    public function updateClientCompany(ClientCompany $c): bool {
        $this->connection->begin_transaction();

        try {
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

            $stmt->bind_param("sssssdi", 
                $c->getName(), 
                $c->getAddress(), 
                $c->getEmail(), 
                $c->getPhoneNumber(), 
                $c->getMembershipType(), 
                $c->getAccountBalance(),
                $c->getClientId());
            $stmt->execute();
            $updateSuccessful = $stmt->affected_rows > 0;
            $stmt->close();

            $query = "UPDATE CompanyClients SET workers = ?, social_reason = ? WHERE client_id = ?";
            $stmt = $this->connection->prepare($query);
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta para CompanyClients: " . $this->connection->error);
            }
            $stmt->bind_param("isi", $c->getWorkers(), $c->getSocialReason(), $c->getClientId());
            $stmt->execute();
            $relatedUpdateSuccessful = $stmt->affected_rows > 0;
            $stmt->close();

            if ($updateSuccessful || $relatedUpdateSuccessful) {
                $this->connection->commit();
                return true;
            } else {
                $this->connection->rollback();
                return false;
            }
        } catch (Exception $e) {
            $this->connection->rollback();
            throw $e;
        }
    }
}


