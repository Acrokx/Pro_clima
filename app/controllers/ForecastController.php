<?php
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../models/Weather.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

class ForecastController {
    private $weatherModel;
    private $session;

    public function __construct() {
        $this->weatherModel = new Weather();
        $this->session = Session::getInstance();
    }

    /**
     * Acción para mostrar pronóstico extendido de 7 días
     */
    public function index($location) {
        AuthMiddleware::checkAuth();

        $forecasts = $this->weatherModel->getForecastsForWeek($location);

        // Cargar vista
        require_once __DIR__ . '/../views/forecast/index.php';
    }
}
?>