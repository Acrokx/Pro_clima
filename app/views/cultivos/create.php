<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cultivo - Pronósticos Meteorológicos</title>
    <link rel="stylesheet" href="../../public/css/style.css">

    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f1f5fb;
            margin: 0;
            padding: 0;
        }

        .header {
            background: #0066cc;
            padding: 18px 0;
            color: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }

        .container {
            max-width: 850px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header-content {
            text-align: center;
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .nav-links a {
            color: white;
            margin-left: 12px;
            font-weight: 600;
            text-decoration: none;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        .card {
            background: white;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 5px 16px rgba(0,0,0,0.08);
            animation: fade-in 0.4s ease;
        }

        @keyframes fade-in {
            from {opacity:0; transform: translateY(6px);}
            to {opacity:1; transform: translateY(0);}
        }

        .card-header {
            font-size: 24px;
            font-weight: bold;
            color: #0066cc;
            border-bottom: 2px solid #e3e8f1;
            padding-bottom: 12px;
            margin-bottom: 25px;
            text-align: center;
        }

        label {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
            color: #1f1f1f;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #bfc9d6;
            font-size: 15px;
            transition: all 0.25s;
        }

        .form-control:focus {
            border-color: #0066cc;
            box-shadow: 0 0 6px rgba(0,102,204,0.3);
            outline: none;
        }

        textarea {
            resize: none;
        }

        .btn {
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            transition: 0.25s;
        }

        .btn-primary {
            background: #0066cc;
            color: white;
        }

        .btn-primary:hover {
            background: #004f9a;
        }

        .btn-secondary {
            background: #e3e8f1;
            color: #333;
        }

        .btn-secondary:hover {
            background: #c9d4e3;
        }

        .alert-error {
            padding: 14px;
            background: #ffefef;
            border-left: 5px solid #cc0000;
            color: #7a0000;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            padding: 15px;
            color: #555;
        }
    </style>
</head>

<body>

<!-- Header -->
<div class="header">
    <div class="header-content">
        <div class="logo">🌍 AGRO PRONOSTIC</div>
        <div class="nav-links">
            <a href="index.php?route=dashboard">Dashboard</a>
            <a href="index.php?route=auth/logout">Cerrar Sesión</a>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container">
    <div class="card">
        <div class="card-header">🌾 Agregar Nuevo Cultivo</div>

        <?php if (isset($error)): ?>
            <div class="alert-error">
                <strong>Error:</strong> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="index.php?route=cultivos/store" method="POST">
            <div class="form-group">
                <label for="nombre">📝 Nombre del Cultivo</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="tipo">🏷️ Tipo de Cultivo</label>
                <input type="text" id="tipo" name="tipo" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="descripcion">📄 Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4" class="form-control"></textarea>
            </div>

            <div style="display:flex; gap:15px; justify-content:center; margin-top:25px;">
                <button type="submit" class="btn btn-primary">💾 Guardar Cultivo</button>
                <a href="index.php?route=dashboard" class="btn btn-secondary">← Cancelar</a>
            </div>
        </form>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    &copy; 2025 Sistema de Pronósticos Meteorológicos
</div>

</body>
</html>
