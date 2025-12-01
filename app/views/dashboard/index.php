<?php
include __DIR__ . '/../layouts/header.php';
?>

<style>
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
    font-size: 3rem;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 1.1rem;
    color: #666;
    font-weight: 500;
}

.card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.card-header {
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.welcome-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    text-align: center;
}

.welcome-card h1 {
    color: white;
    margin-bottom: 0.5rem;
}

.welcome-card p {
    opacity: 0.9;
    font-size: 1.1rem;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-success {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    color: white;
}

.btn-warning {
    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
    color: white;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.8rem;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.table th,
.table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.table th {
    background: rgba(102, 126, 234, 0.1);
    font-weight: 600;
    color: #667eea;
}

.badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    text-transform: uppercase;
}

.badge-success {
    background: #4CAF50;
    color: white;
}

.badge-warning {
    background: #ff9800;
    color: white;
}

.badge-info {
    background: #2196F3;
    color: white;
}

.badge-danger {
    background: #f44336;
    color: white;
}

.alert {
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1rem;
    border-left: 4px solid;
}

.alert-danger {
    background: rgba(244, 67, 54, 0.1);
    border-left-color: #f44336;
    color: #d32f2f;
}

.alert-warning {
    background: rgba(255, 152, 0, 0.1);
    border-left-color: #ff9800;
    color: #f57c00;
}

.alert-info {
    background: rgba(33, 150, 243, 0.1);
    border-left-color: #2196F3;
    color: #1976d2;
}

.text-center {
    text-align: center;
}

.text-muted {
    color: #666;
}

.text-success {
    color: #4CAF50;
}

.mt-30 {
    margin-top: 2rem;
}

.forecast-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.forecast-card {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 15px;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: transform 0.3s ease;
}

.forecast-card:hover {
    transform: translateY(-5px);
}

.forecast-card h3 {
    color: #667eea;
    margin-bottom: 1rem;
    font-size: 1.2rem;
}

.temperature {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0.5rem 0;
}

@media (max-width: 768px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }

    .forecast-grid {
        grid-template-columns: 1fr;
    }

    .stat-value {
        font-size: 2.5rem;
    }
}
</style>

<div class="welcome card welcome-card">
    <h1>¡Bienvenido, <?php echo htmlspecialchars($username); ?>! 🌤️</h1>
    <p>Gestiona tus cultivos y recibe alertas meteorológicas personalizadas</p>
</div>

<!-- Dashboard Stats -->
<div class="dashboard-grid">
    <div class="stat-card">
        <div class="stat-value"><?php echo count($userCrops ?? []); ?></div>
        <div class="stat-label">Cultivos</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?php echo count($userAlerts ?? []); ?></div>
        <div class="stat-label">Alertas</div>
    </div>
   
</div>

<!-- Clima Actual en Tiempo Real -->
<?php if (!empty($currentWeather)): ?>
<div class="card">
    <div class="card-header">🌡️ Clima Actual - Bogotá</div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 20px;">
        <div style="text-align: center; padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; color: white;">
            <p style="font-size: 0.9rem; margin-bottom: 10px;">Temperatura Máxima</p>
            <p style="font-size: 2.5rem; font-weight: bold; margin: 0;">
                <?php echo htmlspecialchars($currentWeather['temperatura_max'] ?? '—'); ?>°C
            </p>
        </div>
        <div style="text-align: center; padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; color: white;">
            <p style="font-size: 0.9rem; margin-bottom: 10px;">Temperatura Mínima</p>
            <p style="font-size: 2.5rem; font-weight: bold; margin: 0;">
                <?php echo htmlspecialchars($currentWeather['temperatura_min'] ?? '—'); ?>°C
            </p>
        </div>
        <div style="text-align: center; padding: 20px; background: rgba(76, 175, 80, 0.2); border-radius: 12px; border: 2px solid #4CAF50;">
            <p style="font-size: 0.9rem; margin-bottom: 10px; color: #333;">Humedad</p>
            <p style="font-size: 2rem; font-weight: bold; margin: 0; color: #4CAF50;">
                💧 <?php echo htmlspecialchars($currentWeather['humedad'] ?? '—'); ?>%
            </p>
        </div>
        <div style="text-align: center; padding: 20px; background: rgba(33, 150, 243, 0.2); border-radius: 12px; border: 2px solid #2196F3;">
            <p style="font-size: 0.9rem; margin-bottom: 10px; color: #333;">Lluvia</p>
            <p style="font-size: 2rem; font-weight: bold; margin: 0; color: #2196F3;">
                🌧️ <?php echo htmlspecialchars($currentWeather['probabilidad_lluvia'] ?? '—'); ?>%
            </p>
        </div>
    </div>
</div>
<?php endif; ?>

        <!-- Mis Cultivos Section -->
        <div class="card">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <span>🌾 Mis Cultivos</span>
                <a href="index.php?route=cultivos/create" class="btn btn-success btn-sm">+ Agregar Cultivo</a>
            </div>
            <?php if (!empty($userCrops)): ?>
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Área (ha)</th>
                                <th>Estado</th>
                                <th>Ubicación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($userCrops as $crop): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($crop['nombre_cultivo'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($crop['tipo_cultivo'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($crop['area_hectareas'] ?? 'N/A'); ?></td>
                                    <td>
                                        <span class="badge badge-<?php 
                                            $estado = $crop['estado'] ?? '';
                                            echo $estado === 'cosecha' ? 'success' : ($estado === 'maduracion' ? 'warning' : 'info');
                                        ?>">
                                            <?php echo htmlspecialchars($estado); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($crop['ubicacion_parcela'] ?? 'N/A'); ?></td>
                                    <td>
                                        <div style="display: flex; gap: 8px;">
                                            <a href="index.php?route=cultivos/edit&id=<?php echo $crop['id']; ?>" 
                                               class="btn btn-info btn-sm" title="Editar">
                                                ✏️
                                            </a>
                                            <a href="index.php?route=cultivos/delete&id=<?php echo $crop['id']; ?>" 
                                               class="btn btn-danger btn-sm" title="Eliminar">
                                                🗑️
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted">No tienes cultivos registrados aún.</p>
            <?php endif; ?>
        </div>

        <!-- Alertas Activas -->
        <div class="card">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <span>⚠️ Alertas Activas</span>
                <a href="index.php?route=alertas/create" class="btn btn-warning btn-sm">+ Nueva Alerta</a>
            </div>
            <?php if (!empty($userAlerts)): ?>
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Severidad</th>
                                <th>Mensaje</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($userAlerts as $alert): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($alert['tipo_alerta'] ?? 'N/A'); ?></td>
                                    <td>
                                        <span class="badge badge-<?php 
                                            $severidad = $alert['severidad'] ?? 'media';
                                            echo $severidad === 'alta' ? 'danger' : ($severidad === 'media' ? 'warning' : 'info');
                                        ?>">
                                            <?php echo htmlspecialchars($severidad); ?>
                                        </span>
                                    </td>
                                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                        <?php echo htmlspecialchars($alert['mensaje'] ?? 'Sin descripción'); ?>
                                    </td>
                                    <td style="font-size: 0.9rem;">
                                        <?php 
                                            $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $alert['fecha_inicio']);
                                            echo $fecha ? $fecha->format('d/m/Y') : 'N/A';
                                        ?>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 8px;">
                                            <a href="index.php?route=alertas/edit&id=<?php echo $alert['id']; ?>" 
                                               class="btn btn-info btn-sm" title="Editar">
                                                ✏️
                                            </a>
                                            <a href="index.php?route=alertas/delete&id=<?php echo $alert['id']; ?>" 
                                               class="btn btn-danger btn-sm" title="Eliminar">
                                                🗑️
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-success">✓ No hay alertas activas. Todo está bien.</p>
            <?php endif; ?>
        </div>

        

        <!-- Pronósticos -->
        <div class="card">
            <div class="card-header">📅 Próximos Días</div>
            <?php if (!empty($upcomingForecasts)): ?>
                <div class="forecast-grid">
                    <?php foreach ($upcomingForecasts as $forecast): ?>
                        <div class="forecast-card">
                            <h3><?php 
                                $date = DateTime::createFromFormat('Y-m-d', $forecast['fecha']);
                                echo $date ? $date->format('d/m (D)') : $forecast['fecha'];
                            ?></h3>
                            
                            <div style="display: flex; justify-content: space-between; margin: 15px 0;">
                                <div>
                                    <p><strong>Máx:</strong></p>
                                    <p class="temperature"><?php echo htmlspecialchars($forecast['temperatura_max'] ?? 'N/A'); ?>°C</p>
                                </div>
                                <div>
                                    <p><strong>Mín:</strong></p>
                                    <p class="temperature" style="color: #3498db;"><?php echo htmlspecialchars($forecast['temperatura_min'] ?? 'N/A'); ?>°C</p>
                                </div>
                            </div>

                            <p>💧 <?php echo htmlspecialchars($forecast['humedad'] ?? 'N/A'); ?>%</p>
                            <p>🌧️ <?php echo htmlspecialchars($forecast['probabilidad_lluvia'] ?? 'N/A'); ?>%</p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="text-center mt-30">
                    <a href="index.php?route=forecast&location=Bogota,CO" class="btn btn-primary">Ver 7 Días Completos</a>
                </div>
            <?php else: ?>
                <p class="text-muted">Pronósticos no disponibles.</p>
            <?php endif; ?>
        </div>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
