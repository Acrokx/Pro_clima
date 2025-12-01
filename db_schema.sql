-- Esquema de base de datos 'clima' para la aplicación de pronósticos meteorológicos

-- Crear base de datos si no existe
CREATE DATABASE IF NOT EXISTS clima;
USE clima;

-- ============================================================
-- Tabla: usuarios - Almacena agricultores, técnicos y administradores
-- ============================================================
CREATE TABLE IF NOT EXISTS usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nombre_completo VARCHAR(100),
    tipo_usuario ENUM('agricultor', 'tecnico', 'admin') DEFAULT 'agricultor',
    ubicacion VARCHAR(100),
    telefono VARCHAR(20),
    activo BOOLEAN DEFAULT TRUE,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_tipo_usuario (tipo_usuario),
    INDEX idx_email (email)
);

-- ============================================================
-- Tabla: datos_climaticos - Almacena datos meteorológicos
-- ============================================================
CREATE TABLE IF NOT EXISTS datos_climaticos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    latitud DECIMAL(10, 8) NOT NULL,
    longitud DECIMAL(11, 8) NOT NULL,
    ubicacion_nombre VARCHAR(100),
    temperatura DECIMAL(5, 2),
    temperatura_minima DECIMAL(5, 2),
    temperatura_maxima DECIMAL(5, 2),
    humedad DECIMAL(5, 2),
    velocidad_viento DECIMAL(5, 2),
    precipitacion DECIMAL(8, 2),
    condicion_clima VARCHAR(100),
    presion DECIMAL(7, 2),
    indice_uv DECIMAL(3, 1),
    registrado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_ubicacion (latitud, longitud),
    INDEX idx_fecha (registrado_en)
);

-- ============================================================
-- Tabla: pronósticos - Pronósticos diarios de clima
-- ============================================================
CREATE TABLE IF NOT EXISTS pronosticos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    location VARCHAR(100) NOT NULL,
    fecha DATE NOT NULL,
    temperatura_max DECIMAL(5, 2),
    temperatura_min DECIMAL(5, 2),
    humedad DECIMAL(5, 2),
    probabilidad_lluvia DECIMAL(5, 2),
    descripcion VARCHAR(255),
    velocidad_viento DECIMAL(5, 2),
    presion DECIMAL(7, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_location_fecha (location, fecha)
);

-- ============================================================
-- Tabla: cultivos - Información sobre tipos de cultivos
-- ============================================================
CREATE TABLE IF NOT EXISTS cultivos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    nombre_cultivo VARCHAR(100) NOT NULL,
    tipo_cultivo VARCHAR(50) NOT NULL,
    area_hectareas DECIMAL(8, 2),
    fecha_siembra DATE,
    fecha_cosecha_estimada DATE,
    ubicacion_parcela VARCHAR(100),
    latitud DECIMAL(10, 8),
    longitud DECIMAL(11, 8),
    descripcion TEXT,
    estado ENUM('semilla', 'germinacion', 'crecimiento', 'floracion', 'maduracion', 'cosecha') DEFAULT 'semilla',
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_usuario_activo (usuario_id, activo),
    INDEX idx_tipo_cultivo (tipo_cultivo)
);

-- ============================================================
-- Tabla: alertas - Alertas climáticas generadas automáticamente
-- ============================================================
CREATE TABLE IF NOT EXISTS alertas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    cultivo_id INT,
    tipo_alerta ENUM('helada', 'sequia', 'granizo', 'inundacion', 'viento_fuerte', 'plagas', 'temperatura_extrema', 'humedad_extrema') NOT NULL,
    severidad ENUM('baja', 'media', 'alta', 'critica') DEFAULT 'media',
    mensaje TEXT NOT NULL,
    ubicacion VARCHAR(100),
    fecha_inicio DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_fin DATETIME,
    activa BOOLEAN DEFAULT TRUE,
    leida BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    FOREIGN KEY (cultivo_id) REFERENCES cultivos(id) ON DELETE SET NULL,
    INDEX idx_usuario_activa (usuario_id, activa),
    INDEX idx_tipo_severidad (tipo_alerta, severidad)
);

-- ============================================================
-- Tabla: recomendaciones - ELIMINADA (funcionalidad removida)
-- ============================================================

-- ============================================================
-- Tabla: historial_clima_cultivo - Relación clima-cultivo
-- ============================================================
CREATE TABLE IF NOT EXISTS historial_clima_cultivo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    cultivo_id INT NOT NULL,
    datos_climaticos_id INT NOT NULL,
    temperatura_registrada DECIMAL(5, 2),
    humedad_registrada DECIMAL(5, 2),
    precipitacion_registrada DECIMAL(8, 2),
    observaciones TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cultivo_id) REFERENCES cultivos(id) ON DELETE CASCADE,
    FOREIGN KEY (datos_climaticos_id) REFERENCES datos_climaticos(id) ON DELETE CASCADE,
    INDEX idx_cultivo_fecha (cultivo_id, created_at)
);