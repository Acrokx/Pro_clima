<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Pronósticos Meteorológicos</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <div class="container auth-container">
        <div class="auth-form">
            <h1>📝 Crear Cuenta</h1>
            <p>Regístrate para acceder a los pronósticos</p>

            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="index.php?route=auth/register" method="post">
                <div class="form-group">
                    <label for="username">👤 Usuario</label>
                    <input type="text" id="username" name="username" required placeholder="Mínimo 3 caracteres" pattern="[a-zA-Z0-9_]{3,50}">
                </div>

                <div class="form-group">
                    <label for="email">📧 Email</label>
                    <input type="email" id="email" name="email" required placeholder="ejemplo@email.com">
                </div>

                <div class="form-group">
                    <label for="password">🔒 Contraseña</label>
                    <input type="password" id="password" name="password" required placeholder="Mínimo 6 caracteres" minlength="6">
                </div>

                <div class="form-group">
                    <label for="role">👥 Tipo de Usuario</label>
                    <select id="role" name="role">
                        <option value="user">Usuario Regular</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Registrarse</button>
            </form>

            <div class="auth-links">
                <p>¿Ya tienes cuenta? <a href="index.php?route=auth/login">Inicia sesión</a></p>
            </div>
        </div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>