<?php
/**
 * Modelo WeatherData
 * Gestiona los datos climáticos almacenados en la base de datos
 */

require_once __DIR__ . '/../core/Database.php';

class WeatherData {
    private $db;
    private $table = 'datos_climaticos';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Crea un nuevo registro de datos climáticos
     * @param array $data Datos climáticos
     * @return int|false ID del registro creado o false si falla
     */
    public static function create($data) {
        $instance = new self();
        
        $query = "INSERT INTO " . $instance->table . " 
                  (latitud, longitud, ubicacion_nombre, temperatura, temperatura_minima, 
                   temperatura_maxima, humedad, velocidad_viento, precipitacion, 
                   condicion_clima, presion, indice_uv) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $data['latitude'] ?? $data['latitud'] ?? null,
            $data['longitude'] ?? $data['longitud'] ?? null,
            $data['location_name'] ?? $data['ubicacion_nombre'] ?? null,
            $data['temperature'] ?? null,
            $data['min_temperature'] ?? $data['temperatura_minima'] ?? null,
            $data['max_temperature'] ?? $data['temperatura_maxima'] ?? null,
            $data['humidity'] ?? null,
            $data['wind_speed'] ?? $data['velocidad_viento'] ?? null,
            $data['precipitation'] ?? null,
            $data['weather_condition'] ?? $data['condicion_clima'] ?? null,
            $data['pressure'] ?? $data['presion'] ?? null,
            $data['uv_index'] ?? $data['indice_uv'] ?? null
        ];

        if ($instance->db->execute($query, $params)) {
            return $instance->db->getLastInsertId();
        }
        return false;
    }

    /**
     * Obtiene todos los registros climáticos
     * @return array
     */
    public function getAll() {
        return $this->db->select("SELECT * FROM {$this->table} ORDER BY registrado_en DESC LIMIT 100");
    }

    /**
     * Obtiene un registro por ID
     * @param int $id
     * @return array|null
     */
    public function getById($id) {
        $results = $this->db->select("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
        return $results[0] ?? null;
    }

    /**
     * Obtiene datos climáticos por ubicación
     * @param float $latitude
     * @param float $longitude
     * @param int $limit
     * @return array
     */
    public function getByLocation($latitude, $longitude, $limit = 30) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE latitud = ? AND longitud = ? 
                  ORDER BY registrado_en DESC 
                  LIMIT ?";
        
        // Nota: mysqli bind_param no acepta directamente LIMIT
        return $this->db->select($query, [$latitude, $longitude]);
    }

    /**
     * Obtiene datos climáticos recientes (últimas 24 horas)
     * @return array
     */
    public function getRecent() {
        $query = "SELECT * FROM {$this->table} 
                  WHERE registrado_en >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
                  ORDER BY registrado_en DESC";
        
        return $this->db->select($query);
    }

    /**
     * Obtiene datos climáticos de un rango de fechas
     * @param string $dateFrom (Y-m-d)
     * @param string $dateTo (Y-m-d)
     * @return array
     */
    public function getByDateRange($dateFrom, $dateTo) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE DATE(registrado_en) BETWEEN ? AND ? 
                  ORDER BY registrado_en DESC";
        
        return $this->db->select($query, [$dateFrom, $dateTo]);
    }

    /**
     * Obtiene promedio de temperatura de un período
     * @param string $dateFrom
     * @param string $dateTo
     * @return float|null
     */
    public function getAverageTemperature($dateFrom, $dateTo) {
        $query = "SELECT AVG(temperatura) as promedio FROM {$this->table} 
                  WHERE DATE(registrado_en) BETWEEN ? AND ?";
        
        $results = $this->db->select($query, [$dateFrom, $dateTo]);
        return $results[0]['promedio'] ?? null;
    }

    /**
     * Actualiza un registro climático
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data) {
        $updates = [];
        $params = [];
        
        $allowedFields = ['temperatura', 'temperatura_minima', 'temperatura_maxima', 
                         'humedad', 'velocidad_viento', 'precipitacion', 
                         'condicion_clima', 'presion', 'indice_uv'];
        
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
     * Elimina un registro climático
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        return $this->db->execute("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }

    /**
     * Obtiene estadísticas generales
     * @return array
     */
    public function getStatistics() {
        $query = "SELECT 
                    COUNT(*) as total_registros,
                    AVG(temperatura) as temp_promedio,
                    MAX(temperatura) as temp_maxima,
                    MIN(temperatura) as temp_minima,
                    AVG(humedad) as humedad_promedio,
                    AVG(precipitacion) as precipitacion_promedio
                  FROM {$this->table}";
        
        $results = $this->db->select($query);
        return $results[0] ?? [];
    }
}
?>
