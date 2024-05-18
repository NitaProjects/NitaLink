<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/stakeholders/Provider.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MysqlAdapter.php');

class MysqlProviderAdapter extends MysqlAdapter {
    public function addProvider(Provider $provider): bool {
        $this->connection->begin_transaction();
        try {
            $query = "INSERT INTO providers (name, address, email, phone_number, provider_id, product_supplied, delivery_days) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connection->prepare($query);
            $deliveryDays = implode(',', $provider->getDeliveryDays());
            $stmt->bind_param("ssssiis", 
                $provider->getName(), 
                $provider->getAddress(), 
                $provider->getEmail(), 
                $provider->getPhoneNumber(), 
                $provider->getProviderId(), 
                $provider->getProductSupplied(),
                $deliveryDays
            );
            $stmt->execute();
            $stmt->close();

            $this->connection->commit();
            return true;
        } catch (mysqli_sql_exception $ex) {
            $this->connection->rollback();
            throw new Exception("Error al agregar el proveedor: " . $ex->getMessage());
        }
    }
}
?>

}
