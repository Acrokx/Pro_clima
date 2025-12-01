<?php
require_once __DIR__ . '/../core/Session.php';

class AuthMiddleware {
    private static $session;

    private static function getSession() {
        if (self::$session === null) {
            self::$session = Session::getInstance();
        }
        return self::$session;
    }

    /**
     * Verifica si el usuario está autenticado
     * @param string|null $requiredRole Rol requerido (opcional)
     * @return bool
     */
    public static function checkAuth($requiredRole = null) {
        $session = self::getSession();
        if (!$session->isLoggedIn()) {
            header('Location: index.php?route=auth/login');
            exit;
        }

        if ($requiredRole && !$session->hasRole($requiredRole)) {
            // Acceso denegado, redirigir o mostrar error
            header('Location: index.php?route=auth/login');
            exit;
        }

        return true;
    }

    /**
     * Obtiene el ID del usuario actual
     * @return int|null
     */
    public static function getCurrentUserId() {
        return self::getSession()->getUserId();
    }

    /**
     * Obtiene el rol del usuario actual
     * @return string|null
     */
    public static function getCurrentUserRole() {
        return self::getSession()->getRole();
    }
}
?>