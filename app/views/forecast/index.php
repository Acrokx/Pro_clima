<?php
$page_title = 'Pronóstico Extendido';
$page_subtitle = 'Pronóstico meteorológico de 7 días';
include __DIR__ . '/../layouts/header.php';
?>

<style>
.forecast-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.forecast-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.forecast-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
}

.forecast-card h3 {
    color: #667eea;
    margin-bottom: 1.5rem;
    font-size: 1.3rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.temperature {
    font-size: 2rem;
    font-weight: 700;
    margin: 0.5rem 0;
}

.search-form {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.search-form .form-group {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.search-form input {
    flex: 1;
    padding: 1rem;
    border: 2px solid rgba(102, 126, 234, 0.2);
    border-radius: 25px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.search-form input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.9);
    color: #667eea;
    border: 2px solid #667eea;
}

.btn-secondary:hover {
    background: #667eea;
    color: white;
}

@media (max-width: 768px) {
    .forecast-grid {
        grid-template-columns: 1fr;
    }

    .search-form .form-group {
        flex-direction: column;
    }

    .forecast-card {
        padding: 1.5rem;
    }
}
</style>

<div class="card">
    <div class="card-header">📅 Pronóstico Extendido de 7 Días</div>

    <!-- Search Form -->
    <div class="search-form">
        <form action="index.php?route=forecast" method="get">
            <div class="form-group">
                <input type="hidden" name="route" value="forecast">
                <input type="text" name="location" placeholder="Buscar ubicación (ej: Bogota, Medellín)" value="<?php echo htmlspecialchars($_GET['location'] ?? 'Bogota,CO'); ?>" required>
                <button type="submit" class="btn btn-primary">🔍 Buscar</button>
            </div>
        </form>
    </div>
        <div class="card">
            <div class="card-header">📅 Pronóstico Extendido de 7 Días</div>

            <!-- Search Form -->
            <form action="index.php?route=forecast" method="get" style="margin-bottom: 30px;">
                <div style="display: flex; gap: 10px;">
                    <input type="hidden" name="route" value="forecast">
                    <input type="text" name="location" placeholder="Buscar ubicación (ej: Bogota, Medellín)" value="<?php echo htmlspecialchars($_GET['location'] ?? 'Bogota,CO'); ?>" required style="flex: 1;">
                    <button type="submit" class="btn btn-primary">🔍 Buscar</button>
                </div>
            </form>

            <!-- Results -->
            <?php if (isset($forecasts) && !empty($forecasts)): ?>
                <div class="forecast-grid">
                    <?php foreach ($forecasts as $forecast): ?>
                        <div class="forecast-card">
                            <h3>
                                📅 <?php 
                                    $date = DateTime::createFromFormat('Y-m-d', $forecast['fecha']);
                                    echo $date ? $date->format('d/m/Y (l)') : $forecast['fecha'];
                                ?>
                            </h3>
                            
                            <div style="display: flex; justify-content: space-between; margin: 15px 0; gap: 20px;">
                                <div style="flex: 1;">
                                    <p><strong>🌡️ Temperatura Máxima</strong></p>
                                    <p class="temperature"><?php echo htmlspecialchars($forecast['temperatura_max'] ?? 'N/A'); ?></p>
                                    <p style="font-size: 12px; color: #999;">°C</p>
                                </div>
                                <div style="flex: 1;">
                                    <p><strong>❄️ Temperatura Mínima</strong></p>
                                    <p class="temperature" style="color: #3498db;"><?php echo htmlspecialchars($forecast['temperatura_min'] ?? 'N/A'); ?></p>
                                    <p style="font-size: 12px; color: #999;">°C</p>
                                </div>
                            </div>

                            <hr style="margin: 15px 0; border: none; border-top: 1px solid #eee;">

                            <p>💧 <strong>Humedad:</strong> <?php echo htmlspecialchars($forecast['humedad'] ?? 'N/A'); ?>%</p>
                            <p>🌧️ <strong>Probabilidad de Lluvia:</strong> <?php echo htmlspecialchars($forecast['probabilidad_lluvia'] ?? 'N/A'); ?>%</p>
                            <p>📝 <strong>Descripción:</strong> <?php echo htmlspecialchars($forecast['descripcion'] ?? 'No disponible'); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php elseif (isset($location)): ?>
                <div class="alert alert-warning">
                    <strong>Aviso:</strong> No se encontraron pronósticos para la ubicación especificada: <strong><?php echo htmlspecialchars($location); ?></strong>
                    <br>Intenta con otro nombre de ciudad.
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <strong>Información:</strong> Ingresa una ubicación para ver el pronóstico.
                </div>
            <?php endif; ?>

    <div style="margin-top: 2rem; text-align: center;">
        <a href="index.php?route=dashboard" class="btn btn-secondary">← Volver al Dashboard</a>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>