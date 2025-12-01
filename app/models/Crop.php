<?php
/**
 * Modelo Crop (Cultivo)
 * Gestiona información sobre cultivos y sus características
 */

require_once __DIR__ . '/../core/Database.php';

class Crop {

        /**
         * Guarda el cultivo actual (para uso con propiedades públicas)
         * @return int|false
         */
        public function save() {
            // Obtener usuario_id de la sesión
            $usuario_id = $_SESSION['user_id'] ?? null;
            if (!$usuario_id) return false;
            $data = [
                'nombre_cultivo' => $this->nombre ?? $this->name ?? 'Sin nombre',
                'tipo_cultivo' => $this->tipo ?? $this->type ?? 'general',
                'descripcion' => $this->descripcion ?? $this->description ?? null,
            ];
            return self::create($usuario_id, $data);
        }
    private $db;
    private $table = 'cultivos';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Crea un nuevo cultivo
     * @param int $usuario_id
     * @param array $data Datos del cultivo
     * @return int|false ID del cultivo creado
     */
    public static function create($usuario_id, $data) {
        $instance = new self();
        
        $query = "INSERT INTO cultivos 
                  (usuario_id, nombre_cultivo, tipo_cultivo, area_hectareas, fecha_siembra, 
                   fecha_cosecha_estimada, ubicacion_parcela, latitud, longitud, descripcion, estado) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $usuario_id,
            $data['nombre_cultivo'] ?? $data['name'] ?? 'Sin nombre',
            $data['tipo_cultivo'] ?? $data['type'] ?? 'general',
            $data['area_hectareas'] ?? $data['area'] ?? 0,
            $data['fecha_siembra'] ?? $data['planting_date'] ?? null,
            $data['fecha_cosecha_estimada'] ?? $data['estimated_harvest_date'] ?? null,
            $data['ubicacion_parcela'] ?? $data['location'] ?? null,
            $data['latitud'] ?? $data['latitude'] ?? null,
            $data['longitud'] ?? $data['longitude'] ?? null,
            $data['descripcion'] ?? $data['description'] ?? null,
            $data['estado'] ?? 'semilla'
        ];

        if ($instance->db->execute($query, $params)) {
            return $instance->db->getLastInsertId();
        }
        return false;
    }

    /**
     * Obtiene todos los cultivos de un usuario
     * @param int $usuario_id
     * @param bool $activos Solo cultivos activos
     * @return array
     */
    public function getByUser($usuario_id, $activos = true) {
        $query = "SELECT * FROM {$this->table} WHERE usuario_id = ?";
        if ($activos) {
            $query .= " AND activo = 1";
        }
        $query .= " ORDER BY created_at DESC";
        
        return $this->db->select($query, [$usuario_id]);
    }

    /**
     * Obtiene un cultivo por ID
     * @param int $id
     * @return array|null
     */
    public function getById($id) {
        $results = $this->db->select("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
        return $results[0] ?? null;
    }

    /**
     * Obtiene cultivos por tipo
     * @param string $tipo_cultivo
     * @return array
     */
    public function getByType($tipo_cultivo) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE tipo_cultivo = ? AND activo = 1 
                  ORDER BY nombre_cultivo";
        
        return $this->db->select($query, [$tipo_cultivo]);
    }

    /**
     * Obtiene cultivos por estado
     * @param string $estado
     * @return array
     */
    public function getByState($estado) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE estado = ? AND activo = 1 
                  ORDER BY fecha_siembra DESC";
        
        return $this->db->select($query, [$estado]);
    }

    /**
     * Obtiene cultivos que necesitan cosecha pronto
     * @param int $dias Próximos N días
     * @return array
     */
    public function getCropsNeedingHarvest($dias = 7) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE activo = 1 
                  AND fecha_cosecha_estimada BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL ? DAY)
                  ORDER BY fecha_cosecha_estimada ASC";
        
        return $this->db->select($query, [$dias]);
    }

    /**
     * Actualiza un cultivo
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data) {
        $updates = [];
        $params = [];
        
        $allowedFields = ['nombre_cultivo', 'tipo_cultivo', 'area_hectareas', 'fecha_siembra',
                         'fecha_cosecha_estimada', 'ubicacion_parcela', 'latitud', 'longitud',
                         'descripcion', 'estado', 'activo'];
        
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
        $query = "UPDATE {$this->table} SET " . implode(", ", $updates) . " WHERE id = ?";
        
        return $this->db->execute($query, $params);
    }

    /**
     * Cambia el estado de un cultivo
     * @param int $id
     * @param string $nuevo_estado
     * @return bool
     */
    public function updateState($id, $nuevo_estado) {
        $estados_validos = ['semilla', 'germinacion', 'crecimiento', 'floracion', 'maduracion', 'cosecha'];
        
        if (!in_array($nuevo_estado, $estados_validos)) {
            return false;
        }
        
        return $this->db->execute(
            "UPDATE {$this->table} SET estado = ? WHERE id = ?",
            [$nuevo_estado, $id]
        );
    }

    /**
     * Desactiva un cultivo
     * @param int $id
     * @return bool
     */
    public function deactivate($id) {
        return $this->db->execute(
            "UPDATE {$this->table} SET activo = 0 WHERE id = ?",
            [$id]
        );
    }

    /**
     * Obtiene estadísticas de cultivos de un usuario
     * @param int $usuario_id
     * @return array
     */
    public function getUserStatistics($usuario_id) {
        $query = "SELECT 
                    COUNT(*) as total_cultivos,
                    COUNT(CASE WHEN activo = 1 THEN 1 END) as cultivos_activos,
                    SUM(area_hectareas) as area_total,
                    COUNT(DISTINCT tipo_cultivo) as tipos_cultivos
                  FROM {$this->table}
                  WHERE usuario_id = ?";
        
        $results = $this->db->select($query, [$usuario_id]);
        return $results[0] ?? [];
    }

    /**
     * Obtiene cultivos cercanos a una ubicación
     * @param float $latitud
     * @param float $longitud
     * @param float $rango_km Rango en kilómetros
     * @return array
     */
    public function getNearby($latitud, $longitud, $rango_km = 10) {
        // Fórmula de Haversine aproximada (simplificada)
        $query = "SELECT *, 
                    (6371 * acos(cos(radians(?)) * cos(radians(latitud)) * cos(radians(longitud) - radians(?)) + sin(radians(?)) * sin(radians(latitud)))) AS distancia
                  FROM {$this->table}
                  WHERE activo = 1
                  HAVING distancia <= ?
                  ORDER BY distancia";
        
        return $this->db->select($query, [$latitud, $longitud, $latitud, $rango_km]);
    }

    /**
     * Obtiene tipos de cultivos disponibles
     * @return array
     */
    public static function getCropTypes() {
        return [
            'maiz' => 'Maíz',
            'papa' => 'Papa',
            'cafe' => 'Café',
            'platano' => 'Plátano',
            'tomate' => 'Tomate',
            'cebolla' => 'Cebolla',
            'lechuga' => 'Lechuga',
            'zanahoria' => 'Zanahoria',
            'arroz' => 'Arroz',
            'trigo' => 'Trigo',
            'frijol' => 'Frijol',
            'yuca' => 'Yuca',
            'otro' => 'Otro'
        ];
    }

    /**
     * Obtiene estados de cultivo
     * @return array
     */
    public static function getCropStates() {
        return [
            'semilla' => 'Semilla',
            'germinacion' => 'Germinación',
            'crecimiento' => 'Crecimiento',
            'floracion' => 'Floración',
            'maduracion' => 'Maduración',
            'cosecha' => 'Cosecha'
        ];
    }
}
?>
