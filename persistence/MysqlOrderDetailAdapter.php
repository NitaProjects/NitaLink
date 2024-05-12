<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/model/operations/OrderDetail.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/nitalink/persistence/MySQLAdapter.php');


class MysqlOrderDetailAdapter extends MysqlAdapter {

    public function getOrderDetail(int $detailId): OrderDetail {
        $data = $this->readQuery("SELECT detailId, orderId, productId, quantity, unitPrice, discount FROM order_details WHERE detailId = " . $detailId . ";");
        if (count($data) > 0) {
            return new OrderDetail((int) $data[0]["orderId"], (int) $data[0]["productId"], (int) $data[0]["quantity"], 
                                   (float) $data[0]["unitPrice"], (float) $data[0]["discount"]);
        } else {
            throw new ServiceException("No Order Detail found with detailId = " . $detailId);
        }
    }

    public function addOrderDetail(OrderDetail $od): bool {
        try {
            return $this->writeQuery("INSERT INTO order_details (orderId, productId, quantity, unitPrice, discount) VALUES (" . 
                    $od->getOrderId() . ", " . $od->getProductId() . ", " . $od->getQuantity() . ", " . 
                    $od->getUnitPrice() . ", " . $od->getDiscount() . ");");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error inserting order detail -->" . $ex->getMessage());
        }
    }

    public function updateOrderDetail(OrderDetail $od): bool {
        try {
            return $this->writeQuery("UPDATE order_details SET orderId = " . $od->getOrderId() . 
                    ", productId = " . $od->getProductId() . ", quantity = " . $od->getQuantity() . 
                    ", unitPrice = " . $od->getUnitPrice() . ", discount = " . $od->getDiscount() . 
                    " WHERE detailId = " . $od->getDetailId() . ";");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error updating order detail -->" . $ex->getMessage());
        }
    }

    public function deleteOrderDetail(int $detailId): bool {
        try {
            return $this->writeQuery("DELETE FROM order_details WHERE detailId = " . $detailId . ";");
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("Error deleting the order detail " . $detailId . "-->" . $ex->getMessage());
        }
    }
}
