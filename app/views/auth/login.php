<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Pronósticos Meteorológicos</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <div class="container auth-container">
        <div class="auth-form">
            <h1>🌤️ Iniciar Sesión</h1>
            <p>Accede a tu cuenta de pronósticos meteorológicos</p>

            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="index.php?route=auth/login" method="post">
                <div class="form-group">
                    <label for="usernameOrEmail">📧 Usuario o Email</label>
                    <input type="text" id="usernameOrEmail" name="usernameOrEmail" required placeholder="Ingresa tu usuario o email">
                </div>

                <div class="form-group">
                    <label for="password">🔒 Contraseña</label>
                    <input type="password" id="password" name="password" required placeholder="Ingresa tu contraseña">
                </div>

                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            </form>

            <div class="auth-links">
                <p>¿No tienes cuenta? <a href="index.php?route=auth/register">Regístrate aquí</a></p>
            </div>
        </div>
<?php include __DIR__ . '/../layouts/footer.php'; ?>