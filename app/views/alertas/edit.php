<?php
$page_title = 'Editar Alerta';
$page_subtitle = 'Actualiza los detalles de tu alerta';
include __DIR__ . '/../layouts/header.php';
?>

<style>
.page-content {
    margin-top: 80px;
}
</style>

<div class="container page-content">
    <div class="card shadow">
        <div class="card-header-primary">
            <h2>✏️ Editar Alerta</h2>
            <p class="subtitle">Modifica los detalles de tu alerta existente</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger mt-20">
                <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?route=alertas/update" method="POST" class="form" style="padding: 25px;">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($alert['id']); ?>">

            <div class="form-group">
                <label for="tipo">🚨 Tipo de Alerta</label>
                <input type="text" class="form-control" id="tipo" name="tipo" required 
                       value="<?php echo htmlspecialchars($alert['tipo_alerta'] ?? ''); ?>"
                       placeholder="Ej: Sequía, Plagas, Enfermedad">
            </div>

            <div class="form-group">
                <label for="severidad">📊 Nivel de Severidad</label>
                <select class="form-control" id="severidad" name="severidad" required>
                    <option value="">-- Selecciona severidad --</option>
                    <option value="baja" <?php echo ($alert['severidad'] ?? '') === 'baja' ? 'selected' : ''; ?>>🟢 Baja</option>
                    <option value="media" <?php echo ($alert['severidad'] ?? '') === 'media' ? 'selected' : ''; ?>>🟡 Media</option>
                    <option value="alta" <?php echo ($alert['severidad'] ?? '') === 'alta' ? 'selected' : ''; ?>>🔴 Alta</option>
                </select>
            </div>

            <div class="form-group">
                <label for="mensaje">💬 Mensaje de Alerta</label>
                <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required 
                          placeholder="Describe el problema o situación..."><?php echo htmlspecialchars($alert['mensaje'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="id_cultivo">🌾 Cultivo Relacionado</label>
                <select class="form-control" id="id_cultivo" name="id_cultivo" required>
                    <option value="">-- Selecciona un cultivo --</option>
                    <?php foreach ($cultivos as $c): ?>
                        <option value="<?php echo htmlspecialchars($c['id']); ?>"
                                <?php echo ($alert['cultivo_id'] ?? '') == $c['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($c['nombre_cultivo']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Guardar Cambios</button>
                <a href="index.php?route=dashboard" class="btn btn-secondary">← Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
