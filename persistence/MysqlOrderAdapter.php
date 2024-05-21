<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/model/operations/Order.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/persistence/MysqlAdapter.php');

class MysqlOrderAdapter extends MysqlAdapter {

    public function getOrder(int $orderId): Order {
        $data = $this->readQuery("SELECT orderId, operationId, customerName, operationType FROM orders WHERE orderId = " . $orderId . ";");
        if (count(data) > 0) {
            return new Order((int) $data[0]["operationId"], $data[0]["customerName"], $data[0]["operationType"]);
        } else {
            throw new ServiceException("No Order found with orderId = " . $orderId);
        }
    }

    public function deleteOrder(int $orderId): bool {
        try {
            return $this->writeQuery("DELETE FROM orders WHERE orderId = " . $orderId . ";");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error deleting the order " . $orderId . "-->" . $ex->getMessage());
        }
    }

    public function addOrder(Order $o): bool {
        try {
            return $this->writeQuery("INSERT INTO orders (orderId, operationId, customerName, operationType) VALUES (" .
                    $o->getOperationId() . ", \"" . $o->getCustomerName() . "\", \"" . $o->getOperationType() . "\");");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error inserting order -->" . $ex->getMessage());
        }
    }

    public function updateOrder(Order $o): bool {
        try {
            return $this->writeQuery("UPDATE orders SET operationId = " . $o->getOperationId() .
                    ", customerName = \"" . $o->getCustomerName() . "\", operationType = \"" . $o->getOperationType() .
                    "\" WHERE orderId = " . $o->getOrderId() . ";");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error updating order -->" . $ex->getMessage());
        }
    }
}
