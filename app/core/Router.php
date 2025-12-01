<?php
/**
 * Clase Router para manejar el enrutamiento de la aplicación
 * Mapea URLs a controladores y acciones
 */

class Router {
    private $routes = [];

    public function __construct() {
        $this->defineRoutes();
    }

    /**
     * Define las rutas de la aplicación
     */
    private function defineRoutes() {
        // Rutas de alertas
        $this->routes['GET']['/alertas'] = ['AlertaController', 'index'];
        $this->routes['GET']['/alertas/create'] = ['AlertaController', 'create'];
        $this->routes['POST']['/alertas/store'] = ['AlertaController', 'store'];
        $this->routes['GET']['/alertas/edit'] = ['AlertaController', 'edit'];
        $this->routes['POST']['/alertas/update'] = ['AlertaController', 'update'];
        $this->routes['GET']['/alertas/delete'] = ['AlertaController', 'delete'];
        $this->routes['POST']['/alertas/destroy'] = ['AlertaController', 'destroy'];

        // Rutas de cultivos
        $this->routes['GET']['/cultivos'] = ['CultivoController', 'index'];
        $this->routes['GET']['/cultivos/create'] = ['CultivoController', 'create'];
        $this->routes['POST']['/cultivos/store'] = ['CultivoController', 'store'];
        $this->routes['GET']['/cultivos/edit'] = ['CultivoController', 'edit'];
        $this->routes['POST']['/cultivos/update'] = ['CultivoController', 'update'];
        $this->routes['GET']['/cultivos/delete'] = ['CultivoController', 'delete'];
        $this->routes['POST']['/cultivos/destroy'] = ['CultivoController', 'destroy'];

        // Rutas de autenticación
        $this->routes['GET']['/auth/login'] = ['AuthController', 'login'];
        $this->routes['POST']['/auth/login'] = ['AuthController', 'login'];
        $this->routes['GET']['/auth/register'] = ['AuthController', 'register'];
        $this->routes['POST']['/auth/register'] = ['AuthController', 'register'];
        $this->routes['GET']['/auth/logout'] = ['AuthController', 'logout'];
        $this->routes['POST']['/auth/logout'] = ['AuthController', 'logout'];

        // Rutas del dashboard
        $this->routes['GET']['/dashboard'] = ['DashboardController', 'index'];
        $this->routes['GET']['/admin/dashboard'] = ['DashboardController', 'index'];

        // Rutas de pronósticos
        $this->routes['GET']['/forecast'] = ['ForecastController', 'index'];

        // Ruta raíz - redirigir a login si no autenticado, dashboard si sí
        $this->routes['GET']['/'] = function() {
            if (isset($_SESSION['user_id'])) {
                header('Location: index.php?route=dashboard');
            } else {
                header('Location: index.php?route=auth/login');
            }
            exit;
        };
    }

    /**
     * Despacha la solicitud a la ruta correspondiente
     */
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $route = $_GET['route'] ?? '';
        $uri = $route ? '/' . $route : '/';

        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];

            if (is_callable($handler)) {
                $handler();
            } else {
                $this->callController($handler, $uri);
            }
        } else {
            // Ruta no encontrada
            http_response_code(404);
            echo "Página no encontrada";
        }
    }

    /**
     * Llama al controlador y método correspondiente
     * @param array $handler [ControllerClass, method]
     * @param string $uri
     */
    private function callController($handler, $uri) {
        list($controllerName, $method) = $handler;

        $controllerFile = "../app/controllers/{$controllerName}.php";
        if (!file_exists($controllerFile)) {
            throw new Exception("Controlador no encontrado: {$controllerName}");
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            throw new Exception("Clase del controlador no encontrada: {$controllerName}");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $method)) {
            throw new Exception("Método no encontrado: {$method} en {$controllerName}");
        }

        // Pasar parámetros de la URL si es necesario
        $params = $this->getParams($uri);
        call_user_func_array([$controller, $method], $params);
    }

    /**
     * Extrae parámetros de la URL
     * @param string $uri
     * @return array
     */
    private function getParams($uri) {
        $params = [];

        // Pronósticos - usar valor por defecto si no se especifica
        if ($uri === '/forecast') {
            $params[] = $_GET['location'] ?? 'Bogota,CO';
        }

        // Alertas y cultivos con ID
        if (preg_match('/\/(alertas|cultivos)\/(edit|delete)/', $uri, $matches) && isset($_GET['id'])) {
            $params[] = $_GET['id'];
        }

        return $params;
    }
}