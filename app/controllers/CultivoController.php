<?php
// app/controllers/CultivoController.php
require_once __DIR__ . '/../models/Crop.php';

class CultivoController {
    public function index() {
        $cropModel = new Crop();
        $userCrops = $cropModel->getByUser($_SESSION['user_id'] ?? null);
        include __DIR__ . '/../views/cultivos/index.php';
    }

    public function create() {
        include __DIR__ . '/../views/cultivos/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $tipo = $_POST['tipo'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            
            if ($nombre && $tipo) {
                $crop = new Crop();
                $crop->nombre = $nombre;
                $crop->tipo = $tipo;
                $crop->descripcion = $descripcion;
                $crop->save();
                header('Location: index.php?route=dashboard');
                exit;
            } else {
                $error = 'Todos los campos obligatorios deben ser completados.';
                include __DIR__ . '/../views/cultivos/create.php';
            }
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?route=dashboard');
            exit;
        }

        $cropModel = new Crop();
        $crop = $cropModel->getById($id);
        
        if (!$crop || $crop['usuario_id'] != $_SESSION['user_id']) {
            header('Location: index.php?route=dashboard');
            exit;
        }

        include __DIR__ . '/../views/cultivos/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $nombre = $_POST['nombre'] ?? '';
            $tipo = $_POST['tipo'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $usuario_id = $_SESSION['user_id'] ?? null;

            if ($id && $nombre && $tipo && $usuario_id) {
                $cropModel = new Crop();
                $crop = $cropModel->getById($id);
                
                if ($crop && $crop['usuario_id'] == $usuario_id) {
                    $cropModel->update($id, [
                        'nombre_cultivo' => $nombre,
                        'tipo_cultivo' => $tipo,
                        'descripcion' => $descripcion
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

        $cropModel = new Crop();
        $crop = $cropModel->getById($id);
        
        if (!$crop || $crop['usuario_id'] != $_SESSION['user_id']) {
            header('Location: index.php?route=dashboard');
            exit;
        }

        include __DIR__ . '/../views/cultivos/delete.php';
    }

    public function destroy() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $usuario_id = $_SESSION['user_id'] ?? null;

            if ($id && $usuario_id) {
                $cropModel = new Crop();
                $crop = $cropModel->getById($id);
                
                if ($crop && $crop['usuario_id'] == $usuario_id) {
                    $cropModel->update($id, ['activo' => 0]);
                }
            }
            
            header('Location: index.php?route=dashboard');
            exit;
        }
    }
}
