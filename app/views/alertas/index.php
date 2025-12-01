<?php
$page_title = 'Sistema de Alertas';
$page_subtitle = 'Monitorea alertas meteorológicas y agrícolas';
include __DIR__ . '/../layouts/header.php';
?>

<style>
.alertas-container {
    display: grid;
    gap: 1.5rem;
}

.alerta-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-left: 4px solid;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    overflow: hidden;
}

.alerta-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
}

.alerta-card.critica {
    border-left-color: #f44336;
}

.alerta-card.critica::before {
    background: linear-gradient(135deg, #f44336, #d32f2f);
}

.alerta-card.alta {
    border-left-color: #ff9800;
}

.alerta-card.alta::before {
    background: linear-gradient(135deg, #ff9800, #f57c00);
}

.alerta-card.media {
    border-left-color: #2196F3;
}

.alerta-card.media::before {
    background: linear-gradient(135deg, #2196F3, #1976d2);
}

.alerta-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
}

.alerta-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.alerta-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.alerta-severidad {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    text-transform: uppercase;
}

.severidad-critica {
    background: rgba(244, 67, 54, 0.1);
    color: #f44336;
}

.severidad-alta {
    background: rgba(255, 152, 0, 0.1);
    color: #ff9800;
}

.severidad-media {
    background: rgba(33, 150, 243, 0.1);
    color: #2196F3;
}

.alerta-content {
    margin-bottom: 1.5rem;
}

.alerta-mensaje {
    font-size: 1rem;
    line-height: 1.6;
    color: #34495e;
    margin-bottom: 1rem;
}

.alerta-meta {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    font-size: 0.9rem;
    color: #666;
}

.meta-item {
    display: flex;
    flex-direction: column;
}

.meta-label {
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.meta-value {
    color: #2c3e50;
}

.alerta-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
}

.btn-outline {
    padding: 0.5rem 1rem;
    border: 2px solid;
    border-radius: 8px;
    background: transparent;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-outline-primary {
    border-color: #2196F3;
    color: #2196F3;
}

.btn-outline-primary:hover {
    background: #2196F3;
    color: white;
}

.btn-outline-success {
    border-color: #4CAF50;
    color: #4CAF50;
}

.btn-outline-success:hover {
    background: #4CAF50;
    color: white;
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

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 1rem;
    color: #666;
    font-weight: 500;
}

@media (max-width: 768px) {
    .alerta-meta {
        grid-template-columns: 1fr;
    }

    .alerta-actions {
        justify-content: center;
        flex-wrap: wrap;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value"><?php echo count($alertasActivas ?? []); ?></div>
        <div class="stat-label">Alertas Activas</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?php echo count($alertasCriticas ?? []); ?></div>
        <div class="stat-label">Críticas</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?php echo count($alertasAltas ?? []); ?></div>
        <div class="stat-label">Altas</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?php echo count($alertasMedias ?? []); ?></div>
        <div class="stat-label">Medias</div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="margin: 0; color: #2c3e50;">⚠️ Sistema de Alertas</h2>
            <p style="margin: 0.5rem 0 0 0; color: #666;">Monitorea condiciones meteorológicas y recibe notificaciones</p>
        </div>
        <a href="index.php?route=alertas/create" class="btn btn-warning" style="display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-plus"></i>
            Nueva Alerta
        </a>
    </div>

    <?php if (!empty($userAlerts ?? [])): ?>
        <div class="alertas-container">
            <?php foreach ($userAlerts as $alert): ?>
                <div class="alerta-card <?php echo htmlspecialchars($alert['severidad'] ?? 'media'); ?>">
                    <div class="alerta-header">
                        <h3 class="alerta-title">
                            <i class="fas fa-exclamation-triangle"></i>
                            <?php echo htmlspecialchars($alert['tipo_alerta'] ?? 'Alerta'); ?>
                        </h3>
                        <span class="alerta-severidad severidad-<?php echo htmlspecialchars($alert['severidad'] ?? 'media'); ?>">
                            <?php echo htmlspecialchars($alert['severidad'] ?? 'media'); ?>
                        </span>
                    </div>

                    <div class="alerta-content">
                        <div class="alerta-mensaje">
                            <?php echo htmlspecialchars($alert['mensaje'] ?? 'Sin descripción'); ?>
                        </div>

                        <div class="alerta-meta">
                            <div class="meta-item">
                                <span class="meta-label">Ubicación</span>
                                <span class="meta-value"><?php echo htmlspecialchars($alert['ubicacion'] ?? 'General'); ?></span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Fecha Inicio</span>
                                <span class="meta-value"><?php echo htmlspecialchars($alert['fecha_inicio'] ?? 'N/A'); ?></span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Fecha Fin</span>
                                <span class="meta-value"><?php echo htmlspecialchars($alert['fecha_fin'] ?? 'N/A'); ?></span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Estado</span>
                                <span class="meta-value"><?php echo ($alert['activa'] ?? 1) ? 'Activa' : 'Inactiva'; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="alerta-actions">
                        <a href="index.php?route=alertas/edit&id=<?php echo $alert['id']; ?>" class="btn-outline btn-outline-primary">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="index.php?route=alertas/delete&id=<?php echo $alert['id']; ?>" class="btn-outline btn-outline-success" onclick="return confirm('¿Marcar como resuelta esta alerta?')">
                            <i class="fas fa-check"></i> Resolver
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-shield-alt"></i>
            <h3>No hay alertas activas</h3>
            <p>¡Excelente! Todas las condiciones están bajo control.</p>
            <a href="index.php?route=alertas/create" class="btn btn-warning" style="margin-top: 1rem;">
                <i class="fas fa-plus"></i> Configurar Nueva Alerta
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>