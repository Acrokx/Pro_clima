<?php
/**
 * Clase Database para gestionar conexiones a la base de datos
 * Proporciona una interfaz unificada para operaciones de BD
 */

require_once __DIR__ . '/../../config/database.php';

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $this->connection = getDBConnection();
    }

    /**
     * Obtiene la instancia singleton de la base de datos
     * @return Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Obtiene la conexión mysqli
     * @return mysqli
     */
    public function getConnection() {
        return $this->connection;
    }

    /**
     * Ejecuta una consulta preparada
     * @param string $query
     * @param array $params
     * @return mysqli_stmt
     */
    public function prepare($query, $params = []) {
        $stmt = $this->connection->prepare($query);
        if ($stmt === false) {
            throw new Exception("Error al preparar consulta: " . $this->connection->error);
        }

        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
            }
            $stmt->bind_param($types, ...$params);
        }

        return $stmt;
    }

    /**
     * Ejecuta una consulta SELECT y retorna resultados
     * @param string $query
     * @param array $params
     * @return array
     */
    public function select($query, $params = []) {
        $stmt = $this->prepare($query, $params);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $data;
    }

    /**
     * Ejecuta una consulta INSERT, UPDATE o DELETE
     * @param string $query
     * @param array $params
     * @return bool
     */
    public function execute($query, $params = []) {
        $stmt = $this->prepare($query, $params);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Obtiene el último ID insertado
     * @return int
     */
    public function getLastInsertId() {
        return $this->connection->insert_id;
    }

    /**
     * Escapa una cadena para uso seguro en consultas
     * @param string $string
     * @return string
     */
    public function escape($string) {
        return $this->connection->real_escape_string($string);
    }

    /**
     * Inicia una transacción
     */
    public function beginTransaction() {
        $this->connection->begin_transaction();
    }

    /**
     * Confirma una transacción
     */
    public function commit() {
        $this->connection->commit();
    }

    /**
     * Revierte una transacción
     */
    public function rollback() {
        $this->connection->rollback();
    }
}