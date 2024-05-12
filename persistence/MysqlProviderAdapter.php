<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/Provider.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MySQLAdapter.php');

class MysqlProviderAdapter extends MysqlAdapter {

    public function getProvider(int $providerId): Provider {
        $data = $this->readQuery("SELECT providerId, name, address, email, phoneNumber, productSupplied, deliveryDays, companyData FROM providers WHERE providerId = " . $providerId . ";");
        if (count($data) > 0) {
            return new Provider($data[0]["name"], $data[0]["address"], $data[0]["email"], $data[0]["phoneNumber"],
                                (int) $data[0]["providerId"], $data[0]["productSupplied"], $data[0]["deliveryDays"], $data[0]["companyData"]);
        } else {
            throw new ServiceException("No Provider found with providerId = " . $providerId);
        }
    }

    public function deleteProvider(int $providerId): bool {
        try {
            return $this->writeQuery("DELETE FROM providers WHERE providerId = " . $providerId . ";");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error al borrar al proveedor " . $providerId . "-->" . $ex->getMessage());
        }
    }

    public function addProvider(Provider $p): bool {
        try {
            return $this->writeQuery("INSERT INTO providers (providerId, name, address, email, phoneNumber, productSupplied, deliveryDays, companyData) VALUES (" . 
                    $p->getProviderId() . ", \"" . $p->getName() . "\", \"" . $p->getAddress() . "\", \"" . $p->getEmail() . "\", \"" . 
                    $p->getPhoneNumber() . "\", \"" . $p->getProductSupplied() . "\", \"" . $p->getDeliveryDays() . "\", \"" . $p->getCompanyData() . "\");");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error al insertar proveedor -->" . $ex->getMessage());
        }
    }

    public function updateProvider(Provider $p): bool {
        try {
            return $this->writeQuery("UPDATE providers SET name = \"" . $p->getName() . "\", address = \"" . $p->getAddress() . 
                    "\", email = \"" . $p->getEmail() . "\", phoneNumber = \"" . $p->getPhoneNumber() . "\", productSupplied = \"" . 
                    $p->getProductSupplied() . "\", deliveryDays = \"" . $p->getDeliveryDays() . "\", companyData = \"" . $p->getCompanyData() . 
                    "\" WHERE providerId = " . $p->getProviderId() . ";");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error al actualizar proveedor -->" . $ex->getMessage());
        }
    }
}
