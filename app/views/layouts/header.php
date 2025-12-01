<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? ($page_title ?? 'Pronósticos Meteorológicos'); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <?php
        // Determinar ruta base del script (ej: /Pronostico_meteo/public)
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        // En algunos entornos dirname('/') devuelve '\\', normalizar
        if ($basePath === DIRECTORY_SEPARATOR) $basePath = '';
    ?>
    <link rel="stylesheet" href="<?php echo $basePath; ?>/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="index.php?route=dashboard" class="logo">
                <i class="fas fa-cloud-sun"></i>
                Agropronostic
            </a>
            <div class="nav-links">
                <a href="index.php?route=dashboard">
                    <i class="fas fa-tachometer-alt"></i>
                    Panel
                </a>
                <a href="index.php?route=forecast">
                    <i class="fas fa-cloud-sun"></i>
                    Pronósticos
                </a>
                <a href="index.php?route=cultivos">
                    <i class="fas fa-seedling"></i>
                    Cultivos
                </a>
                <a href="index.php?route=alertas">
                    <i class="fas fa-exclamation-triangle"></i>
                    Alertas
                </a>
                <div class="user-info" style="display: flex; align-items: center; gap: 1rem; color: #666; font-weight: 500;">
                    <i class="fas fa-user"></i>
                    <?php echo htmlspecialchars($_SESSION['username'] ?? 'Usuario'); ?>
                </div>
                <form action="index.php?route=auth/logout" method="post" style="display: inline;">
                    <button type="submit" class="logout-btn" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%); color: white; border: none; padding: 0.5rem 1rem; border-radius: 25px; cursor: pointer; font-weight: 500; transition: transform 0.2s ease; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-sign-out-alt"></i>
                        Salir
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="main-content" style="margin-top: 80px; min-height: calc(100vh - 160px);">
        <div class="container page-content">
            <?php if (isset($page_title)): ?>
                <div class="page-title" style="text-align: center; margin-bottom: 2rem; color: white;">
                    <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
                        <?php echo htmlspecialchars($page_title); ?>
                    </h1>
                    <?php if (isset($page_subtitle)): ?>
                        <p style="font-size: 1.1rem; opacity: 0.9;">
                            <?php echo htmlspecialchars($page_subtitle); ?>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>