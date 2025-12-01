<?php
$page_title = 'Editar Cultivo';
$page_subtitle = 'Actualiza los detalles de tu cultivo';
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
            <h2>✏️ Editar Cultivo</h2>
            <p class="subtitle">Modifica los detalles de tu cultivo existente</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger mt-20">
                <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?route=cultivos/update" method="POST" class="form" style="padding: 25px;">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($crop['id']); ?>">

            <div class="form-group">
                <label for="nombre">🌾 Nombre del Cultivo</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required 
                       value="<?php echo htmlspecialchars($crop['nombre_cultivo'] ?? ''); ?>"
                       placeholder="Ej: Maíz, Trigo, Tomate">
            </div>

            <div class="form-group">
                <label for="tipo">📋 Tipo de Cultivo</label>
                <select class="form-control" id="tipo" name="tipo" required>
                    <option value="">-- Selecciona tipo --</option>
                    <option value="cereal" <?php echo ($crop['tipo_cultivo'] ?? '') === 'cereal' ? 'selected' : ''; ?>>🌾 Cereal</option>
                    <option value="hortaliza" <?php echo ($crop['tipo_cultivo'] ?? '') === 'hortaliza' ? 'selected' : ''; ?>>🥬 Hortaliza</option>
                    <option value="fruta" <?php echo ($crop['tipo_cultivo'] ?? '') === 'fruta' ? 'selected' : ''; ?>>🍎 Fruta</option>
                    <option value="legumbre" <?php echo ($crop['tipo_cultivo'] ?? '') === 'legumbre' ? 'selected' : ''; ?>>🫘 Legumbre</option>
                    <option value="otro" <?php echo ($crop['tipo_cultivo'] ?? '') === 'otro' ? 'selected' : ''; ?>>➕ Otro</option>
                </select>
            </div>

            <div class="form-group">
                <label for="descripcion">📝 Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="4" 
                          placeholder="Describe características, variedades, etc..."><?php echo htmlspecialchars($crop['descripcion'] ?? ''); ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Guardar Cambios</button>
                <a href="index.php?route=dashboard" class="btn btn-secondary">← Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
