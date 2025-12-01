<?php
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;
    private $session;

    public function __construct() {
        $this->userModel = new User();
        $this->session = Session::getInstance();
    }

    /**
     * Acción de registro
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'user';

            if ($this->userModel->register($username, $email, $password, $role)) {
                header('Location: index.php?route=auth/login');
                exit;
            } else {
                $error = 'Error en el registro. Verifica los datos.';
            }
        }

        // Cargar vista de registro
        require_once __DIR__ . '/../views/auth/register.php';
    }

    /**
     * Acción de login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usernameOrEmail = $_POST['usernameOrEmail'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->login($usernameOrEmail, $password);

            if ($user) {
                $this->session->login($user['id'], $user['username'], $user['role']);

                // Redirección basada en rol
                if ($user['role'] === 'admin') {
                    header('Location: index.php?route=admin/dashboard');
                } else {
                    header('Location: index.php?route=dashboard');
                }
                exit;
            } else {
                $error = 'Credenciales inválidas.';
            }
        }

        // Cargar vista de login
        require_once __DIR__ . '/../views/auth/login.php';
    }

    /**
     * Acción de logout
     */
    public function logout() {
        $this->session->logout();
        header('Location: index.php?route=auth/login');
        exit;
    }
}
?>