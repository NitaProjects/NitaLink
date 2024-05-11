<?php
declare(strict_types=1);
require_once '../exceptions/ServiceException.php';

class MysqlAdapter {

    protected mysqli $connection;
    protected bool $connected = false;
    

    //Aprofitem el constructor per establir la connexió per defecte a la nostra BD
    public function __construct() {
        try {
             $this->connection = new mysqli("127.0.0.1", "root", "", "nitalink", 3306,'UTF8');
             $this->connected = true;
        } catch (mysqli_sql_exception $ex) {
             throw new ServiceException("DB Connection Failure: " . $ex->getMessage());
        }
    }

    public function __destruct() {
        $this->closeConnection();
    }

    public function isConnected(): bool {
        return $this->connected;
    }

    //sempre podrem reconectar-nos a altres BD's aprofitant el mateix objecte
    public function connect(string $host, string $user, string $password, string $db, int $port, ){
        if ($this->connected == true) {
            $this->closeConnection();
        }
        try {
            $this->connection = new mysqli($host, $user, $password, $db, $port);
            $this->connected = true;
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("DB Connection Failure: " . $ex->getMessage());
        }
    }
  
    public function closeConnection() {
        if ($this->connected == true) {
            $this->connection->close();
            $this->connected = false;
        }
    }

    public function readQuery(string $query): array {
        $dataset = [];
        $result = $this->connection->query($query);
        if ($result != false) {
            while ($row = $result->fetch_assoc()) {
                $dataset[] = $row;
            }
        }
        return $dataset;
    }

    public function writeQuery(string $query): bool {
        $result = $this->connection->query($query);
        return $result;
    }
}
