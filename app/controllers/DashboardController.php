<?php
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../models/Weather.php';
require_once __DIR__ . '/../models/Crop.php';
require_once __DIR__ . '/../models/Alert.php';
require_once __DIR__ . '/../services/ApiClient.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

class DashboardController {
    private $weatherModel;
    private $cropModel;
    private $alertModel;
    private $session;

    public function __construct() {
        $this->weatherModel = new Weather();
        $this->cropModel = new Crop();
        $this->alertModel = new Alert();
        $this->session = Session::getInstance();
    }

    /**
     * Acción principal del dashboard
     */
    public function index() {
        AuthMiddleware::checkAuth();

        $userId = $this->session->getUserId();
        $username = $this->session->hasRole('admin') ? 'Administrador' : $this->session->getUsername();

        // Obtener pronósticos recientes (ejemplo: para Bogotá)
        $location = 'Bogota,CO'; // Ubicación por defecto
        $forecasts = $this->weatherModel->getForecastsForWeek($location);

        // Limitar a los próximos 3 días para el dashboard
        $upcomingForecasts = array_slice($forecasts, 0, 3);

        // Cargar datos reales del usuario
        $cropModel = new Crop();
        $userCrops = $cropModel->getByUser($userId);
        
        $alertModel = new Alert();
        $userAlerts = $alertModel->getByUser($userId, true);
        

        // Obtener clima actual en tiempo real
        $apiClient = new \ApiClient();
        $currentWeather = null;
        if (!empty($forecasts)) {
            // Usar el primer forecast como clima actual
            $currentWeather = $forecasts[0];
        }

        // Cargar vista
        require_once __DIR__ . '/../views/dashboard/index.php';
    }
}