<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/model/stakeholders/Provider.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/persistence/MysqlAdapter.php');

class MysqlProviderAdapter extends MysqlAdapter {

    public function getProvider(int $id): array {
        $query = "SELECT p.provider_id, p.name, p.address, p.email, p.phone_number, p.product_supplied,
                     ip.dni,
                     cp.company_id, cp.workers, cp.social_reason
                FROM Providers p
                LEFT JOIN IndividualProviders ip ON p.provider_id = ip.provider_id
                LEFT JOIN CompanyProviders cp ON p.provider_id = cp.provider_id
                WHERE p.provider_id = ?";
        try {
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            $stmt->close();

            if (!$data) {
                throw new ServiceException("No existe el proveedor, compruebe el id = " . $id);
            }
            return $data;
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error al obtener el proveedor: " . $ex->getMessage());
        }
    }

    public function exists(string $email): bool {
        $stmt = $this->connection->prepare("SELECT provider_id FROM Providers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    public function maxProviderId(): int {
        $result = $this->connection->query("SELECT MAX(provider_id) as last FROM Providers");
        $row = $result->fetch_assoc();
        return (int) $row['last'];
    }

    public function deleteProvider(int $id): bool {
        $this->connection->begin_transaction();
        try {
            // Borrar registros relacionados en IndividualProviders y CompanyProviders
            $stmt = $this->connection->prepare("DELETE FROM IndividualProviders WHERE provider_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $stmt = $this->connection->prepare("DELETE FROM CompanyProviders WHERE provider_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            // Ahora borrar el proveedor de la tabla Providers
            $stmt = $this->connection->prepare("DELETE FROM Providers WHERE provider_id = ?");
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
            throw new ServiceException("Error al borrar el proveedor " . $id . "-->" . $ex->getMessage());
        } finally {
            $stmt->close();
        }
    }

    public function addCompanyProvider(ProviderCompany $provider) {
        try {
            $this->connection->begin_transaction();

            // Obtener valores a partir de los métodos del objeto $provider
            $name = $provider->getName();
            $address = $provider->getAddress();
            $email = $provider->getEmail();
            $phone_number = $provider->getPhoneNumber();
            $product_supplied = $provider->getProductSupplied();
            $workers = $provider->getWorkers();
            $social_reason = $provider->getSocialReason();

            // Insertar en la tabla 'providers' los datos generales del proveedor
            $stmt = $this->connection->prepare("INSERT INTO providers (name, address, email, phone_number, product_supplied) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss",
                $name,
                $address,
                $email,
                $phone_number,
                $product_supplied);
            $stmt->execute();
            $provider_id = $this->connection->insert_id; // Obtener el ID del proveedor insertado
            // Insertar en la tabla 'CompanyProviders' los detalles específicos de la empresa
            $stmt = $this->connection->prepare("INSERT INTO companyproviders (provider_id, workers, social_reason) VALUES (?, ?, ?)");
            $stmt->bind_param("iis",
                $provider_id,
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
                throw new ServiceException("Error al insertar proveedor de empresa: Entrada duplicada para el email '" . $provider->getEmail() . "'. El email ya existe.");
            } else {
                throw new ServiceException("Error al insertar proveedor de empresa: " . $ex->getMessage());
            }
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    public function addIndividualProvider(Provider $p) {
        try {
            $this->connection->begin_transaction();

            // Obtener valores a partir de los métodos del objeto $p
            $name = $p->getName();
            $address = $p->getAddress();
            $email = $p->getEmail();
            $phone_number = $p->getPhoneNumber();
            $product_supplied = $p->getProductSupplied();
            $dni = $p->getDNI();

            // Insertar en la tabla principal 'providers'
            $stmt = $this->connection->prepare("INSERT INTO providers (name, address, email, phone_number, product_supplied) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $address, $email, $phone_number, $product_supplied);
            $stmt->execute();
            $provider_id = $this->connection->insert_id; // Obtener el ID del proveedor insertado
            // Insertar en la tabla 'IndividualProviders' el DNI y el provider_id recién creado
            $stmt = $this->connection->prepare("INSERT INTO IndividualProviders (provider_id, dni) VALUES (?, ?)");
            $stmt->bind_param("is", $provider_id, $dni);
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
                throw new ServiceException("Error al insertar proveedor individual: Entrada duplicada para el email '" . $p->getEmail() . "'. El email ya existe.");
            } else {
                throw new ServiceException("Error al insertar proveedor individual: " . $ex->getMessage());
            }
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    public function listProviders(int $page, int $providersPerPage): array {
        // Calcular el offset
        $offset = ($page - 1) * $providersPerPage;

        // Consulta SQL con paginación
        $query = "
            SELECT p.provider_id, p.name, p.address, p.email, p.phone_number, p.product_supplied,
                ip.dni, cp.workers, cp.social_reason,
                CASE
                    WHEN ip.provider_id IS NOT NULL THEN 'Particular'
                    WHEN cp.provider_id IS NOT NULL THEN 'Empresa'
                    ELSE 'Desconocido'
                END AS provider_type
            FROM Providers p
            LEFT JOIN IndividualProviders ip ON p.provider_id = ip.provider_id
            LEFT JOIN CompanyProviders cp ON p.provider_id = cp.provider_id
            ORDER BY p.provider_id ASC
            LIMIT ? OFFSET ?";

        // Preparar la declaración
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ii", $providersPerPage, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            $providers = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $providers;
        } else {
            throw new Exception("Error al obtener los proveedores: " . $this->connection->error);
        }
    }

    public function getTotalProviders(string $search = ''): int {
        // Preparar la consulta SQL con búsqueda
        $query = "SELECT COUNT(*) as total FROM Providers WHERE name LIKE ?";
        $stmt = $this->connection->prepare($query);
        $searchParam = '%' . $search . '%';
        $stmt->bind_param("s", $searchParam);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $row = $result->fetch_assoc();
            $stmt->close();
            return (int) $row['total'];
        } else {
            throw new Exception("Error al contar los proveedores: " . $this->connection->error);
        }
    }

    public function updateProvider(Provider $p): bool {
        $this->connection->begin_transaction();

        try {
            $query = "UPDATE providers SET 
                    name = ?, 
                    address = ?, 
                    email = ?, 
                    phone_number = ?, 
                    product_supplied = ? 
                WHERE provider_id = ?";
            $stmt = $this->connection->prepare($query);
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->connection->error);
            }

            $stmt->bind_param("sssssi",
                $p->getName(),
                $p->getAddress(),
                $p->getEmail(),
                $p->getPhoneNumber(),
                $p->getProductSupplied(),
                $p->getProviderId());
            $stmt->execute();
            $updateSuccessful = $stmt->affected_rows > 0;
            $stmt->close();

            $query = "UPDATE IndividualProviders SET dni = ? WHERE provider_id = ?";
            $stmt = $this->connection->prepare($query);
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta para IndividualProviders: " . $this->connection->error);
            }
            $stmt->bind_param("si", $p->getDNI(), $p->getProviderId());
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

    public function updateProviderCompany(ProviderCompany $p): bool {
        $this->connection->begin_transaction();

        try {
            $query = "UPDATE providers SET 
                    name = ?, 
                    address = ?, 
                    email = ?, 
                    phone_number = ?, 
                    product_supplied = ? 
                WHERE provider_id = ?";
            $stmt = $this->connection->prepare($query);
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->connection->error);
            }

            $stmt->bind_param("sssssi",
                $p->getName(),
                $p->getAddress(),
                $p->getEmail(),
                $p->getPhoneNumber(),
                $p->getProductSupplied(),
                $p->getProviderId());
            $stmt->execute();
            $updateSuccessful = $stmt->affected_rows > 0;
            $stmt->close();

            $query = "UPDATE CompanyProviders SET workers = ?, social_reason = ? WHERE provider_id = ?";
            $stmt = $this->connection->prepare($query);
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta para CompanyProviders: " . $this->connection->error);
            }
            $stmt->bind_param("isi", $p->getWorkers(), $p->getSocialReason(), $p->getProviderId());
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
