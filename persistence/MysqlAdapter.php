<?php

declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'] . '/nitalink/exceptions/ServiceException.php');

class MysqlAdapter {

    protected mysqli $connection;
    protected bool $connected = false;

    //Aprofitem el constructor per establir la connexió per defecte a la nostra BD
    public function __construct() {
        try {
            $this->connection = new mysqli("localhost", "root", "", "nitalink", 3306);
            $this->connected = true;
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("No se pudo conectar a la base de datos: " . $ex->getMessage());
        }
    }

    public function __destruct() {
        $this->closeConnection();
    }

    public function isConnected(): bool {
        return $this->connected;
    }

    //sempre podrem reconectar-nos a altres BD's aprofitant el mateix objecte
    public function connect(string $host, string $user, string $password, string $db, int $port,) {
        if ($this->connected == true) {
            $this->closeConnection();
        }
        try {
            $this->connection = new mysqli($host, $user, $password, $db, $port);
            $this->connected = true;
        } catch (mysqli_sql_exception $ex) {
            throw new ServiceException("No se pudo conectar a la base de datos: " . $ex->getMessage());
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

    public static function transformDateToISO(string $fecha): string {
        // Primero, dividimos la fecha en día, mes y año
        $partesFecha = explode("/", $fecha);

        // Si la fecha no tiene el formato esperado, lanzamos una excepción o manejamos el error de otra forma
        if (count($partesFecha) != 3) {
            throw new Exception("El formato de la fecha no es válido.");
        }

        // Reorganizamos las partes de la fecha en el formato ISO (año-mes-día)
        $fechaISO = $partesFecha[2] . "-" . $partesFecha[1] . "-" . $partesFecha[0];

        return $fechaISO;
    }

    public static function transformDateTimeToISO(string $fechaHora): string {
        // Dividimos la fecha y la hora utilizando el espacio como separador
        $partesFechaHora = explode(" ", $fechaHora);

        // Si no hay dos partes (fecha y hora), lanzamos una excepción o manejamos el error de otra forma
        if (count($partesFechaHora) !== 2) {
            throw new Exception("El formato de la fecha y hora no es válido.");
        }

        // Transformamos la fecha
        $partesFecha = explode("/", $partesFechaHora[0]);
        if (count($partesFecha) !== 3) {
            throw new Exception("El formato de la fecha no es válido.");
        }
        $fechaISO = $partesFecha[2] . "-" . $partesFecha[1] . "-" . $partesFecha[0];

        // Concatenamos la fecha y la hora en el formato ISO completo
        $fechaHoraISO = $fechaISO . " " . $partesFechaHora[1];

        return $fechaHoraISO;
    }

    public static function transformDateFromISO(string $fechaISO): string {
        $partesFecha = explode("-", $fechaISO);
        if (count($partesFecha) != 3) {
            throw new Exception("El formato de la fecha no es válido.");
        }
        return $partesFecha[2] . "/" . $partesFecha[1] . "/" . $partesFecha[0];
    }

    public static function transformDateTimeFromISO(string $fechaHoraISO): string {
        $partesFechaHora = explode(" ", $fechaHoraISO);
        if (count($partesFechaHora) !== 2) {
            throw new Exception("El formato de la fecha y hora no es válido.");
        }
        $partesFecha = explode("-", $partesFechaHora[0]);
        if (count($partesFecha) !== 3) {
            throw new Exception("El formato de la fecha no es válido.");
        }
        $fecha = $partesFecha[2] . "/" . $partesFecha[1] . "/" . $partesFecha[0];
        return $fecha . " " . $partesFechaHora[1];
    }
}
