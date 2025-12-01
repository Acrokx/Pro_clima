<?php
require_once __DIR__ . '/../core/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Registra un nuevo usuario
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $nombre_completo
     * @param string $tipo_usuario (agricultor, tecnico, admin)
     * @param string $role
     * @return bool
     */
    public function register($username, $email, $password, $nombre_completo = '', $tipo_usuario = 'agricultor', $role = 'user') {
        if (!$this->validateInput($username, $email, $password)) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        return $this->db->execute(
            "INSERT INTO usuarios (username, email, password, nombre_completo, tipo_usuario, role) VALUES (?, ?, ?, ?, ?, ?)",
            [$username, $email, $hashedPassword, $nombre_completo, $tipo_usuario, $role]
        );
    }

    /**
     * Verifica credenciales y retorna datos del usuario si válido
     * @param string $usernameOrEmail
     * @param string $password
     * @return array|null
     */
    public function login($usernameOrEmail, $password) {
        $user = $this->findByUsernameOrEmail($usernameOrEmail);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return null;
    }

    /**
     * Encuentra usuario por username o email
     * @param string $usernameOrEmail
     * @return array|null
     */
    private function findByUsernameOrEmail($usernameOrEmail) {
        $results = $this->db->select(
            "SELECT id, username, email, password, role, tipo_usuario, nombre_completo, ubicacion FROM usuarios WHERE username = ? OR email = ?",
            [$usernameOrEmail, $usernameOrEmail]
        );
        return $results[0] ?? null;
    }

    /**
     * Obtiene el rol de un usuario
     * @param int $userId
     * @return string|null
     */
    public function getRole($userId) {
        $results = $this->db->select("SELECT role FROM usuarios WHERE id = ?", [$userId]);
        return $results[0]['role'] ?? null;
    }

    /**
     * Obtiene el tipo de usuario
     * @param int $userId
     * @return string|null
     */
    public function getTipoUsuario($userId) {
        $results = $this->db->select("SELECT tipo_usuario FROM usuarios WHERE id = ?", [$userId]);
        return $results[0]['tipo_usuario'] ?? null;
    }

    /**
     * Obtiene todos los usuarios (solo para admin)
     * @return array
     */
    public function getAllUsers() {
        return $this->db->select("SELECT id, username, email, nombre_completo, tipo_usuario, ubicacion, activo, created_at FROM usuarios ORDER BY created_at DESC");
    }

    /**
     * Obtiene un usuario por ID
     * @param int $userId
     * @return array|null
     */
    public function getUserById($userId) {
        $results = $this->db->select(
            "SELECT id, username, email, nombre_completo, tipo_usuario, ubicacion, telefono, activo FROM usuarios WHERE id = ?",
            [$userId]
        );
        return $results[0] ?? null;
    }

    /**
     * Valida la entrada del usuario
     * @param string $username
     * @param string $email
     * @param string $password
     * @return bool
     */
    private function validateInput($username, $email, $password) {
        $username = trim($username);
        $email = trim($email);
        $password = trim($password);

        if (!preg_match('/^[a-zA-Z0-9_]{3,50}$/', $username)) {
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if (strlen($password) < 6) {
            return false;
        }

        return true;
    }
}
?>