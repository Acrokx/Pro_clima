<?php
/**
 * Modelo Alert (Alerta)
 * Gestiona alertas climáticas generadas automáticamente
 */

require_once __DIR__ . '/../core/Database.php';

class Alert {

        /**
         * Guarda la alerta actual (para uso con propiedades públicas)
         * @return int|false
         */
        public function save() {
            $usuario_id = $this->usuario_id ?? ($_SESSION['user_id'] ?? null);
            $cultivo_id = $this->id_cultivo ?? $this->cultivo_id ?? null;
            $tipo_alerta = $this->tipo ?? $this->tipo_alerta ?? '';
            $severidad = $this->severidad ?? '';
            $mensaje = $this->mensaje ?? '';
            $ubicacion = $this->ubicacion ?? null;
            if ($usuario_id && $cultivo_id && $tipo_alerta && $severidad && $mensaje) {
                return self::create($usuario_id, $cultivo_id, $tipo_alerta, $severidad, $mensaje, $ubicacion);
            }
            return false;
        }
    private $db;
    private $table = 'alertas';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Crea una nueva alerta
     * @param int $usuario_id
     * @param int $cultivo_id
     * @param string $tipo_alerta
     * @param string $severidad
     * @param string $mensaje
     * @param string $ubicacion
     * @return int|false
     */
    public static function create($usuario_id, $cultivo_id, $tipo_alerta, $severidad, $mensaje, $ubicacion) {
        $instance = new self();
        
        $query = "INSERT INTO alertas 
                  (usuario_id, cultivo_id, tipo_alerta, severidad, mensaje, ubicacion, activa) 
                  VALUES (?, ?, ?, ?, ?, ?, 1)";
        
        if ($instance->db->execute($query, [$usuario_id, $cultivo_id, $tipo_alerta, $severidad, $mensaje, $ubicacion])) {
            return $instance->db->getLastInsertId();
        }
        return false;
    }

    /**
     * Obtiene alertas de un usuario
     * @param int $usuario_id
     * @param bool $solo_activas
     * @return array
     */
    public function getByUser($usuario_id, $solo_activas = true) {
        $query = "SELECT * FROM {$this->table} WHERE usuario_id = ?";
        if ($solo_activas) {
            $query .= " AND activa = 1";
        }
        $query .= " ORDER BY FIELD(severidad, 'critica', 'alta', 'media', 'baja'), fecha_inicio DESC";
        
        return $this->db->select($query, [$usuario_id]);
    }

    /**
     * Obtiene alertas de un cultivo
     * @param int $cultivo_id
     * @return array
     */
    public function getByCrop($cultivo_id) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE cultivo_id = ? AND activa = 1
                  ORDER BY FIELD(severidad, 'critica', 'alta', 'media', 'baja')";
        
        return $this->db->select($query, [$cultivo_id]);
    }

    /**
     * Obtiene una alerta por ID
     * @param int $id
     * @return array|null
     */
    public function getById($id) {
        $results = $this->db->select("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
        return $results[0] ?? null;
    }

    /**
     * Obtiene alertas activas por severidad
     * @param string $severidad
     * @return array
     */
    public function getBySeverity($severidad) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE severidad = ? AND activa = 1
                  ORDER BY fecha_inicio DESC";
        
        return $this->db->select($query, [$severidad]);
    }

    /**
     * Obtiene alertas de un tipo específico
     * @param string $tipo_alerta
     * @return array
     */
    public function getByType($tipo_alerta) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE tipo_alerta = ? AND activa = 1
                  ORDER BY FIELD(severidad, 'critica', 'alta', 'media', 'baja')";
        
        return $this->db->select($query, [$tipo_alerta]);
    }

    /**
     * Obtiene todas las alertas activas
     * @return array
     */
    public function getActiveAlerts() {
        $query = "SELECT * FROM {$this->table} 
                  WHERE activa = 1 
                  ORDER BY FIELD(severidad, 'critica', 'alta', 'media', 'baja'), fecha_inicio DESC";
        
        return $this->db->select($query);
    }

    /**
     * Actualiza una alerta
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data) {
        $updates = [];
        $params = [];
        
        $allowedFields = ['tipo_alerta', 'severidad', 'mensaje', 'cultivo_id', 'ubicacion', 'activa'];
        
        foreach ($data as $field => $value) {
            if (in_array($field, $allowedFields)) {
                $updates[] = "{$field} = ?";
                $params[] = $value;
            }
        }
        
        if (empty($updates)) {
            return false;
        }
        
        $params[] = $id;
        $query = "UPDATE {$this->table} SET " . implode(', ', $updates) . " WHERE id = ?";
        
        return $this->db->execute($query, $params);
    }

    /**
     * Desactiva una alerta
     * @param int $id
     * @return bool
     */
    public function deactivate($id) {
        return $this->db->execute(
            "UPDATE {$this->table} SET activa = 0, fecha_fin = NOW() WHERE id = ?",
            [$id]
        );
    }

    /**
     * Marca una alerta como leída
     * @param int $id
     * @return bool
     */
    public function markAsRead($id) {
        return $this->db->execute(
            "UPDATE {$this->table} SET leida = 1 WHERE id = ?",
            [$id]
        );
    }

    /**
     * Obtiene alertas no leídas de un usuario
     * @param int $usuario_id
     * @return array
     */
    public function getUnreadByUser($usuario_id) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE usuario_id = ? AND leida = 0 AND activa = 1
                  ORDER BY FIELD(severidad, 'critica', 'alta', 'media', 'baja')";
        
        return $this->db->select($query, [$usuario_id]);
    }

    /**
     * Cuenta alertas no leídas de un usuario
     * @param int $usuario_id
     * @return int
     */
    public function countUnreadByUser($usuario_id) {
        $results = $this->db->select(
            "SELECT COUNT(*) as count FROM {$this->table} 
             WHERE usuario_id = ? AND leida = 0 AND activa = 1",
            [$usuario_id]
        );
        return $results[0]['count'] ?? 0;
    }

    /**
     * Obtiene estadísticas de alertas
     * @param int $usuario_id Opcional
     * @return array
     */
    public function getStatistics($usuario_id = null) {
        if ($usuario_id) {
            $query = "SELECT 
                        COUNT(*) as total_alertas,
                        SUM(CASE WHEN activa = 1 THEN 1 ELSE 0 END) as alertas_activas,
                        SUM(CASE WHEN severidad = 'critica' THEN 1 ELSE 0 END) as criticas,
                        SUM(CASE WHEN severidad = 'alta' THEN 1 ELSE 0 END) as altas,
                        SUM(CASE WHEN leida = 0 THEN 1 ELSE 0 END) as no_leidas
                      FROM {$this->table}
                      WHERE usuario_id = ?";
            
            $results = $this->db->select($query, [$usuario_id]);
        } else {
            $query = "SELECT 
                        COUNT(*) as total_alertas,
                        SUM(CASE WHEN activa = 1 THEN 1 ELSE 0 END) as alertas_activas,
                        SUM(CASE WHEN severidad = 'critica' THEN 1 ELSE 0 END) as criticas,
                        SUM(CASE WHEN severidad = 'alta' THEN 1 ELSE 0 END) as altas
                      FROM {$this->table}";
            
            $results = $this->db->select($query);
        }
        
        return $results[0] ?? [];
    }

    /**
     * Obtiene tipos de alertas disponibles
     * @return array
     */
    public static function getAlertTypes() {
        return [
            'helada' => 'Helada',
            'sequia' => 'Sequía',
            'granizo' => 'Granizo',
            'inundacion' => 'Inundación',
            'viento_fuerte' => 'Viento Fuerte',
            'plagas' => 'Plagas',
            'temperatura_extrema' => 'Temperatura Extrema',
            'humedad_extrema' => 'Humedad Extrema'
        ];
    }

    /**
     * Obtiene niveles de severidad
     * @return array
     */
    public static function getSeverityLevels() {
        return [
            'baja' => 'Baja',
            'media' => 'Media',
            'alta' => 'Alta',
            'critica' => 'Crítica'
        ];
    }
}
?>
