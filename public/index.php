<?php
/**
 * Punto de entrada de la aplicación web de pronósticos meteorológicos
 * Inicia el enrutador y maneja las solicitudes HTTP
 */

// Mostrar errores para debug (comentar en producción)
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Iniciar sesión
session_start();

// Incluir el autoloader si existe (para Composer), o cargar manualmente
if (file_exists('../vendor/autoload.php')) {
    require_once '../vendor/autoload.php';
}

// Incluir archivos core
require_once '../app/core/Router.php';
require_once '../app/core/Database.php';
require_once '../app/core/Session.php';

// Iniciar la aplicación
try {
    $router = new Router();
    $router->dispatch();
} catch (Exception $e) {
    // Manejo básico de errores
    http_response_code(500);
    echo "Error interno del servidor: " . $e->getMessage();
}