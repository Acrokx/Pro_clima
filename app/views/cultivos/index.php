<?php
$page_title = 'Mis Cultivos';
$page_subtitle = 'Gestiona tus cultivos agrícolas';
include __DIR__ . '/../layouts/header.php';
?>

<style>
.cultivos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.cultivo-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    overflow: hidden;
}

.cultivo-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
}

.cultivo-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #4CAF50, #45a049);
}

.cultivo-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.cultivo-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}

.cultivo-status {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    text-transform: uppercase;
}

.status-activo {
    background: rgba(76, 175, 80, 0.1);
    color: #4CAF50;
}

.status-inactivo {
    background: rgba(244, 67, 54, 0.1);
    color: #f44336;
}

.cultivo-info {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.info-item {
    display: flex;
    flex-direction: column;
}

.info-label {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 0.25rem;
}

.info-value {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
}

.cultivo-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
}

.btn-icon {
    padding: 0.5rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
}

.btn-edit {
    background: rgba(33, 150, 243, 0.1);
    color: #2196F3;
}

.btn-edit:hover {
    background: #2196F3;
    color: white;
    transform: scale(1.1);
}

.btn-delete {
    background: rgba(244, 67, 54, 0.1);
    color: #f44336;
}

.btn-delete:hover {
    background: #f44336;
    color: white;
    transform: scale(1.1);
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #666;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

@media (max-width: 768px) {
    .cultivos-grid {
        grid-template-columns: 1fr;
    }

    .cultivo-info {
        grid-template-columns: 1fr;
    }

    .cultivo-actions {
        justify-content: center;
    }
}
</style>

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="margin: 0; color: #2c3e50;">🌾 Mis Cultivos</h2>
            <p style="margin: 0.5rem 0 0 0; color: #666;">Administra tus cultivos y su estado</p>
        </div>
        <a href="index.php?route=cultivos/create" class="btn btn-success" style="display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-plus"></i>
            Agregar Cultivo
        </a>
    </div>

    <?php if (!empty($userCrops ?? [])): ?>
        <div class="cultivos-grid">
            <?php foreach ($userCrops as $crop): ?>
                <div class="cultivo-card">
                    <div class="cultivo-header">
                        <h3 class="cultivo-title"><?php echo htmlspecialchars($crop['nombre_cultivo'] ?? 'Sin nombre'); ?></h3>
                        <span class="cultivo-status status-<?php echo ($crop['estado'] ?? 'activo') === 'activo' ? 'activo' : 'inactivo'; ?>">
                            <?php echo htmlspecialchars($crop['estado'] ?? 'activo'); ?>
                        </span>
                    </div>

                    <div class="cultivo-info">
                        <div class="info-item">
                            <span class="info-label">Tipo</span>
                            <span class="info-value"><?php echo htmlspecialchars($crop['tipo_cultivo'] ?? 'N/A'); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Área (ha)</span>
                            <span class="info-value"><?php echo htmlspecialchars($crop['area_hectareas'] ?? 'N/A'); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Ubicación</span>
                            <span class="info-value"><?php echo htmlspecialchars($crop['ubicacion_parcela'] ?? 'N/A'); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Fecha Siembra</span>
                            <span class="info-value"><?php echo htmlspecialchars($crop['fecha_siembra'] ?? 'N/A'); ?></span>
                        </div>
                    </div>

                    <div class="cultivo-actions">
                        <a href="index.php?route=cultivos/edit&id=<?php echo $crop['id']; ?>" class="btn-icon btn-edit" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="index.php?route=cultivos/delete&id=<?php echo $crop['id']; ?>" class="btn-icon btn-delete" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este cultivo?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-seedling"></i>
            <h3>No tienes cultivos registrados</h3>
            <p>Comienza agregando tu primer cultivo para optimizar tu producción agrícola.</p>
            <a href="index.php?route=cultivos/create" class="btn btn-success" style="margin-top: 1rem;">
                <i class="fas fa-plus"></i> Agregar Primer Cultivo
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>