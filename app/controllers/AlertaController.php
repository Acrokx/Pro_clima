<?php
// app/controllers/AlertaController.php
require_once __DIR__ . '/../models/Alert.php';
require_once __DIR__ . '/../models/Crop.php';

class AlertaController {
    public function index() {
        $alertModel = new Alert();
        $userAlerts = $alertModel->getByUser($_SESSION['user_id'] ?? null);

        // Categorizar alertas por severidad
        $alertasActivas = array_filter($userAlerts, fn($a) => $a['activa'] == 1);
        $alertasCriticas = array_filter($alertasActivas, fn($a) => $a['severidad'] === 'critica');
        $alertasAltas = array_filter($alertasActivas, fn($a) => $a['severidad'] === 'alta');
        $alertasMedias = array_filter($alertasActivas, fn($a) => $a['severidad'] === 'media');

        include __DIR__ . '/../views/alertas/index.php';
    }

    public function create() {
        include __DIR__ . '/../views/alertas/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tipo = $_POST['tipo'] ?? '';
            $severidad = $_POST['severidad'] ?? '';
            $mensaje = $_POST['mensaje'] ?? '';
            $id_cultivo = $_POST['id_cultivo'] ?? '';
            $usuario_id = $_SESSION['user_id'] ?? null;
            
            if ($tipo && $severidad && $mensaje && $id_cultivo && $usuario_id) {
                $alert = new Alert();
                $alert->tipo = $tipo;
                $alert->severidad = $severidad;
                $alert->mensaje = $mensaje;
                $alert->id_cultivo = $id_cultivo;
                $alert->usuario_id = $usuario_id;
                $alert->save();
                header('Location: index.php?route=dashboard');
                exit;
            } else {
                $error = 'Todos los campos son obligatorios.';
                include __DIR__ . '/../views/alertas/create.php';
            }
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?route=dashboard');
            exit;
        }

        $alertModel = new Alert();
        $alert = $alertModel->getById($id);
        
        if (!$alert || $alert['usuario_id'] != $_SESSION['user_id']) {
            header('Location: index.php?route=dashboard');
            exit;
        }

        $cultivos = (new Crop())->getByUser($_SESSION['user_id'] ?? 0);
        include __DIR__ . '/../views/alertas/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $tipo = $_POST['tipo'] ?? '';
            $severidad = $_POST['severidad'] ?? '';
            $mensaje = $_POST['mensaje'] ?? '';
            $id_cultivo = $_POST['id_cultivo'] ?? '';
            $usuario_id = $_SESSION['user_id'] ?? null;

            if ($id && $tipo && $severidad && $mensaje && $id_cultivo && $usuario_id) {
                $alertModel = new Alert();
                $alert = $alertModel->getById($id);
                
                if ($alert && $alert['usuario_id'] == $usuario_id) {
                    $alertModel->update($id, [
                        'tipo_alerta' => $tipo,
                        'severidad' => $severidad,
                        'mensaje' => $mensaje,
                        'cultivo_id' => $id_cultivo
                    ]);
                    header('Location: index.php?route=dashboard');
                    exit;
                }
            }
            
            header('Location: index.php?route=dashboard');
            exit;
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?route=dashboard');
            exit;
        }

        $alertModel = new Alert();
        $alert = $alertModel->getById($id);
        
        if (!$alert || $alert['usuario_id'] != $_SESSION['user_id']) {
            header('Location: index.php?route=dashboard');
            exit;
        }

        include __DIR__ . '/../views/alertas/delete.php';
    }

    public function destroy() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $usuario_id = $_SESSION['user_id'] ?? null;

            if ($id && $usuario_id) {
                $alertModel = new Alert();
                $alert = $alertModel->getById($id);
                
                if ($alert && $alert['usuario_id'] == $usuario_id) {
                    $alertModel->deactivate($id);
                }
            }
            
            header('Location: index.php?route=dashboard');
            exit;
        }
    }
}
