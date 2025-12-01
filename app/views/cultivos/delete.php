<?php
$page_title = 'Eliminar Cultivo';
$page_subtitle = 'Confirma la eliminación del cultivo';
include __DIR__ . '/../layouts/header.php';
?>

<style>
.page-content {
    margin-top: 80px;
}
.confirm-delete {
    text-align: center;
    padding: 40px;
}
.alert-info-box {
    background: rgba(33, 150, 243, 0.1);
    border: 2px solid #2196F3;
    border-radius: 12px;
    padding: 20px;
    margin: 20px 0;
}
</style>

<div class="container page-content">
    <div class="card shadow">
        <div class="card-header-primary" style="background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);">
            <h2>⚠️ Eliminar Cultivo</h2>
            <p class="subtitle">Esta acción no se puede deshacer</p>
        </div>

        <div class="confirm-delete">
            <div class="alert-info-box">
                <h3 style="color: #1976d2; margin-bottom: 15px;">¿Estás seguro?</h3>
                <p style="font-size: 1.1rem; margin-bottom: 20px;">
                    Estás a punto de eliminar el siguiente cultivo:
                </p>
                
                <div style="background: white; padding: 20px; border-radius: 8px; text-align: left; margin: 20px 0;">
                    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($crop['nombre_cultivo'] ?? 'N/A'); ?></p>
                    <p><strong>Tipo:</strong> <?php echo htmlspecialchars($crop['tipo_cultivo'] ?? 'N/A'); ?></p>
                    <p><strong>Estado:</strong> 
                        <span class="badge badge-<?php 
                            $estado = $crop['estado'] ?? 'semilla';
                            echo $estado === 'cosecha' ? 'success' : ($estado === 'maduracion' ? 'warning' : 'info');
                        ?>">
                            <?php echo htmlspecialchars($estado); ?>
                        </span>
                    </p>
                    <?php if (!empty($crop['descripcion'])): ?>
                        <p><strong>Descripción:</strong> <?php echo htmlspecialchars($crop['descripcion']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="alert alert-warning" style="text-align: left;">
                    <strong>⚠️ Advertencia:</strong> Esto marcará el cultivo como inactivo. También se pueden perder las alertas asociadas.
                </div>
            </div>

            <div class="form-actions" style="justify-content: center; gap: 15px; margin-top: 30px;">
                <form action="index.php?route=cultivos/destroy" method="POST" style="display: inline;">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($crop['id']); ?>">
                    <button type="submit" class="btn btn-danger">🗑️ Sí, Eliminar</button>
                </form>
                <a href="index.php?route=dashboard" class="btn btn-secondary">← Cancelar</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
