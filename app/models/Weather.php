<?php
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../services/ApiClient.php';

class Weather {
    private $db;
    private $apiClient;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->apiClient = new ApiClient();
    }

    public function saveForecast($location, $data) {
        if (!isset($data['daily']) || !is_array($data['daily'])) {
            return false; // Datos inválidos
        }

        foreach ($data['daily'] as $day) {
            $fecha = date('Y-m-d', $day['dt']);
            $tempMax = $day['temp']['max'] ?? null;
            $tempMin = $day['temp']['min'] ?? null;
            $humedad = $day['humidity'] ?? null;
            $probLluvia = ($day['pop'] ?? 0) * 100; // pop es fracción, convertir a porcentaje
            $descripcion = $day['weather'][0]['description'] ?? '';

            $this->db->execute("INSERT INTO pronosticos (location, fecha, temperatura_max, temperatura_min, humedad, probabilidad_lluvia, descripcion) VALUES (?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE temperatura_max = VALUES(temperatura_max), temperatura_min = VALUES(temperatura_min), humedad = VALUES(humedad), probabilidad_lluvia = VALUES(probabilidad_lluvia), descripcion = VALUES(descripcion)", [$location, $fecha, $tempMax, $tempMin, $humedad, $probLluvia, $descripcion]);
        }

        return true;
    }

    public function getForecast($location, $date) {
        $results = $this->db->select("SELECT * FROM pronosticos WHERE location = ? AND fecha = ?", [$location, $date]);
        return $results[0] ?? null;
    }

    public function getForecastsForWeek($location) {
        $forecasts = [];
        $today = date('Y-m-d');
        $missingData = false;

        for ($i = 0; $i < 7; $i++) {
            $date = date('Y-m-d', strtotime($today . " +$i days"));
            $forecast = $this->getForecast($location, $date);
            if ($forecast) {
                $forecasts[] = $forecast;
            } else {
                $missingData = true;
                break; // Si falta uno, fetch toda la semana
            }
        }

        if ($missingData) {
            $data = $this->apiClient->fetchWeatherData($location);
            if ($data) {
                $this->saveForecast($location, $data);
                // Recargar los pronósticos después de guardar
                $forecasts = [];
                for ($i = 0; $i < 7; $i++) {
                    $date = date('Y-m-d', strtotime($today . " +$i days"));
                    $forecast = $this->getForecast($location, $date);
                    $forecasts[] = $forecast;
                }
            }
        }

        return $forecasts;
    }
}