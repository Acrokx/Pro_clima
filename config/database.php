<?php
/**
 * Configuración de conexión a la base de datos MySQL en XAMPP
 * Base de datos: clima
 */

// Parámetros de conexión
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // Contraseña vacía por defecto en XAMPP
define('DB_NAME', 'clima');
define('DB_PORT', 3306);  // Puerto por defecto de MySQL en XAMPP

/**
 * Función para obtener conexión a la base de datos
 * @return mysqli
 */
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Establecer charset UTF-8
    $conn->set_charset("utf8");

    return $conn;
}
?>