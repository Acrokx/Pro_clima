<?php
require_once __DIR__ . '/../../config/api.php';

class ApiClient {
    private $apiKey;

    public function __construct() {
        $this->apiKey = API_KEY;
    }

    public function fetchWeatherData($location) {
        // Primero, obtener coordenadas usando geocoding
        $geocodeUrl = "http://api.openweathermap.org/geo/1.0/direct?q=" . urlencode($location) . "&limit=1&appid=" . $this->apiKey;
        $geocodeResponse = $this->makeCurlRequest($geocodeUrl);

        if (!$geocodeResponse) {
            return null; // Error en geocoding
        }

        $geocodeData = json_decode($geocodeResponse, true);
        if (empty($geocodeData) || !isset($geocodeData[0]['lat'], $geocodeData[0]['lon'])) {
            return null; // No se encontraron coordenadas
        }

        $lat = $geocodeData[0]['lat'];
        $lon = $geocodeData[0]['lon'];

        // Ahora, llamar a onecall para pronóstico de 7 días
        $onecallUrl = "https://api.openweathermap.org/data/2.5/onecall?lat=" . $lat . "&lon=" . $lon . "&exclude=current,minutely,hourly,alerts&units=metric&appid=" . $this->apiKey;
        $onecallResponse = $this->makeCurlRequest($onecallUrl);

        if (!$onecallResponse) {
            return null; // Error en onecall
        }

        return json_decode($onecallResponse, true);
    }

    private function makeCurlRequest($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Timeout de 10 segundos
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || !$response) {
            return false; // Error en la solicitud
        }

        return $response;
    }
}