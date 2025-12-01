<?php
// app/views/alertas/create.php
require_once __DIR__ . '/../../models/Crop.php';
$cultivos = (new Crop())->getByUser($_SESSION['user_id'] ?? 0);

// Variables para el layout global
$page_title = 'Crear Nueva Alerta';
$page_subtitle = 'Registra un aviso importante para tus cultivos';

require_once __DIR__ . '/../layouts/header.php';
?>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-exclamation-triangle"></i>
            Crear Nueva Alerta
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?route=alertas/store" method="POST">
            <div class="form-group">
                <label for="tipo">🚨 Tipo de Alerta</label>
                <input type="text" id="tipo" name="tipo" placeholder="Ej: Sequía, Plagas, Enfermedad" required>
            </div>

            <div class="form-group">
                <label for="severidad">📊 Nivel de Severidad</label>
                <select id="severidad" name="severidad" required>
                    <option value="">-- Selecciona severidad --</option>
                    <option value="baja">🟢 Baja</option>
                    <option value="media">🟡 Media</option>
                    <option value="alta">🔴 Alta</option>
                </select>
            </div>

            <div class="form-group">
                <label for="mensaje">💬 Mensaje de Alerta</label>
                <textarea id="mensaje" name="mensaje" rows="4" required placeholder="Describe el problema o situación..."></textarea>
            </div>

            <div class="form-group">
                <label for="id_cultivo">🌾 Cultivo Relacionado</label>
                <select id="id_cultivo" name="id_cultivo" required>
                    <option value="">-- Selecciona un cultivo --</option>
                    <?php foreach ($cultivos as $c): ?>
                        <option value="<?php echo htmlspecialchars($c['id']); ?>"><?php echo htmlspecialchars($c['nombre_cultivo']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="display:flex;gap:1rem;margin-top:1rem;">
                <button type="submit" class="btn btn-primary">💾 Guardar</button>
                <a href="index.php?route=alertas" class="btn btn-secondary">← Cancelar</a>
            </div>
        </form>
    </div>

<?php
require_once __DIR__ . '/../layouts/footer.php';

