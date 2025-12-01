<?php
/**
 * Clase Session para gestionar sesiones de usuario
 * Proporciona métodos seguros para manejar datos de sesión
 */

class Session {
    private static $instance = null;

    private function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Obtiene la instancia singleton de Session
     * @return Session
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Inicia sesión para un usuario
     * @param int $userId
     * @param string $username
     * @param string $role
     */
    public function login($userId, $username, $role) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        $_SESSION['login_time'] = time();
    }

    /**
     * Cierra la sesión del usuario
     */
    public function logout() {
        session_unset();
        session_destroy();
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }

    /**
     * Verifica si hay un usuario autenticado
     * @return bool
     */
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    /**
     * Obtiene el ID del usuario actual
     * @return int|null
     */
    public function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Obtiene el nombre de usuario actual
     * @return string|null
     */
    public function getUsername() {
        return $_SESSION['username'] ?? null;
    }

    /**
     * Obtiene el rol del usuario actual
     * @return string|null
     */
    public function getRole() {
        return $_SESSION['role'] ?? null;
    }

    /**
     * Verifica si el usuario tiene un rol específico
     * @param string $role
     * @return bool
     */
    public function hasRole($role) {
        return $this->getRole() === $role;
    }

    /**
     * Regenera el ID de sesión por seguridad
     */
    public function regenerateId() {
        session_regenerate_id(true);
    }

    /**
     * Establece un valor en la sesión
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * Obtiene un valor de la sesión
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Elimina un valor de la sesión
     * @param string $key
     */
    public function remove($key) {
        unset($_SESSION[$key]);
    }

    /**
     * Verifica si la sesión ha expirado (ejemplo: 24 horas)
     * @param int $maxLifetime Segundos
     * @return bool
     */
    public function isExpired($maxLifetime = 86400) {
        $loginTime = $this->get('login_time');
        if (!$loginTime) {
            return true;
        }
        return (time() - $loginTime) > $maxLifetime;
    }
}