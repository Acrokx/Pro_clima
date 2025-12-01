# 🔧 Manual Técnico - ClimaApp

## 🌦️ Sistema de Pronósticos Meteorológicos Agrícolas

Este manual proporciona información técnica completa para desarrolladores, administradores de sistemas y personal técnico encargado del mantenimiento y despliegue de **ClimaApp**.

---

## 📋 Información General del Sistema

### **Descripción del Proyecto**
ClimaApp es una aplicación web desarrollada en PHP que proporciona:
- Gestión integral de cultivos agrícolas
- Pronósticos meteorológicos en tiempo real
- Sistema inteligente de alertas climáticas
- Interfaz moderna y responsive

### **Versión Actual**
- **Versión**: 1.0.0
- **Fecha de lanzamiento**: Diciembre 2024
- **Estado**: Producción Ready

### **Arquitectura del Sistema**
- **Patrón**: MVC (Modelo-Vista-Controlador)
- **Lenguaje**: PHP 7.4+
- **Base de datos**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **APIs externas**: OpenWeatherMap
- **Servidor web**: Apache/Nginx

---

## 🏗️ Arquitectura del Sistema

### **Estructura de Directorios**
```
Pronostico_meteo/
├── app/                          # Código de aplicación
│   ├── controllers/              # Controladores MVC
│   │   ├── AuthController.php    # Autenticación
│   │   ├── DashboardController.php # Dashboard principal
│   │   ├── ForecastController.php # Pronósticos
│   │   ├── CultivoController.php # Gestión de cultivos
│   │   └── AlertaController.php  # Sistema de alertas
│   ├── models/                   # Modelos de datos
│   │   ├── User.php             # Modelo de usuarios
│   │   ├── Weather.php          # Modelo de pronósticos
│   │   ├── Crop.php             # Modelo de cultivos
│   │   └── Alert.php            # Modelo de alertas
│   ├── views/                   # Vistas del sistema
│   │   ├── layouts/            # Layouts base
│   │   ├── auth/               # Vistas de autenticación
│   │   ├── dashboard/          # Dashboard
│   │   ├── cultivos/           # Gestión de cultivos
│   │   ├── alertas/            # Sistema de alertas
│   │   └── forecast/           # Pronósticos
│   ├── core/                   # Núcleo del sistema
│   │   ├── Router.php          # Enrutamiento
│   │   ├── Database.php        # Conexión BD
│   │   └── Session.php         # Gestión de sesiones
│   ├── services/               # Servicios externos
│   │   ├── ApiClient.php       # Cliente OpenWeatherMap
│   │   └── AlertService.php    # Servicio de alertas
│   └── middleware/             # Middleware
│       └── AuthMiddleware.php  # Autenticación
├── config/                     # Configuraciones
│   ├── database.php            # Configuración BD
│   └── api.php                 # Configuración APIs
├── public/                     # Archivos públicos
│   ├── index.php              # Punto de entrada
│   └── .htaccess              # Reescritura URLs
├── db_schema.sql              # Esquema de BD
├── README.md                  # Documentación general
├── MANUAL_USUARIO.md          # Manual de usuario
└── MANUAL_TECNICO.md          # Este documento
```

### **Flujo de Datos**
```
Usuario → public/index.php → Router → Controller → Model → Database
                                      ↓
                                 View ← Controller ← Model ← API
```

---

## ⚙️ Requisitos del Sistema

### **Servidor**
- **SO**: Linux/Windows/macOS
- **Servidor Web**: Apache 2.4+ / Nginx 1.18+
- **PHP**: 7.4 o superior
- **Base de datos**: MySQL 5.7+ / MariaDB 10.3+
- **Espacio en disco**: 50MB mínimo
- **RAM**: 256MB mínimo (512MB recomendado)

### **Navegador Web**
- **Chrome**: 90+
- **Firefox**: 88+
- **Safari**: 14+
- **Edge**: 90+
- **JavaScript**: Habilitado
- **Cookies**: Habilitados

### **Dependencias Externas**
- **OpenWeatherMap API**: Clave gratuita/ premium
- **Font Awesome**: 6.0+ (CDN)
- **Google Fonts**: Inter (CDN)

---

## 🚀 Instalación y Configuración

### **Paso 1: Preparación del Entorno**

#### **Instalación de XAMPP (Windows)**
1. Descarga XAMPP desde [apachefriends.org](https://www.apachefriends.org)
2. Instala con componentes: Apache, MySQL, PHP
3. Inicia los servicios Apache y MySQL desde el panel de control

#### **Instalación Manual (Linux)**
```bash
# Instalar Apache, PHP y MySQL
sudo apt update
sudo apt install apache2 php mysql-server php-mysql php-curl

# Iniciar servicios
sudo systemctl start apache2
sudo systemctl start mysql
```

### **Paso 2: Despliegue de la Aplicación**

#### **Ubicación de Archivos**
```bash
# Copiar archivos al directorio web
sudo cp -r Pronostico_meteo /var/www/html/
# O en XAMPP: copiar a C:\xampp\htdocs\Pronostico_meteo
```

#### **Permisos de Archivos**
```bash
# Establecer permisos correctos
sudo chown -R www-data:www-data /var/www/html/Pronostico_meteo
sudo chmod -R 755 /var/www/html/Pronostico_meteo
sudo chmod -R 777 /var/www/html/Pronostico_meteo/app/views/  # Para cache si es necesario
```

### **Paso 3: Configuración de Base de Datos**

#### **Crear Base de Datos**
```sql
-- Ejecutar desde phpMyAdmin o línea de comandos
mysql -u root -p < db_schema.sql
```

#### **Configuración de Conexión**
Editar `config/database.php`:
```php
<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_contraseña');
define('DB_NAME', 'clima');
define('DB_PORT', 3306);
```

### **Paso 4: Configuración de APIs**

#### **OpenWeatherMap API**
1. Regístrate en [openweathermap.org](https://openweathermap.org/api)
2. Obtén tu API key gratuita
3. Edita `config/api.php`:
```php
<?php
define('API_KEY', 'tu_api_key_aqui');
```

### **Paso 5: Configuración del Servidor Web**

#### **Apache (.htaccess ya incluido)**
Asegúrate de que `mod_rewrite` esté habilitado:
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### **Nginx (configuración manual)**
```nginx
server {
    listen 80;
    server_name localhost;
    root /var/www/html/Pronostico_meteo/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

### **Paso 6: Verificación de Instalación**

#### **Acceso a la Aplicación**
- URL: `http://localhost/Pronostico_meteo/public/`
- Debería redirigir a la página de login

#### **Pruebas Básicas**
1. **Registro de usuario**: Crear cuenta nueva
2. **Inicio de sesión**: Acceder con credenciales
3. **Dashboard**: Ver estadísticas principales
4. **Pronósticos**: Consultar clima de una ciudad
5. **Cultivos**: Agregar un cultivo de prueba

---

## 🔧 Configuración Avanzada

### **Variables de Entorno**
Crear archivo `.env` en la raíz (opcional):
```env
APP_ENV=production
APP_DEBUG=false
DB_HOST=localhost
DB_USER=usuario
DB_PASS=contraseña
DB_NAME=clima
API_KEY=tu_clave_api
```

### **Configuración de Logs**
Los logs de error se guardan en:
- **PHP**: `/var/log/apache2/error.log`
- **Aplicación**: Implementar logging personalizado si es necesario

### **Optimización de Rendimiento**

#### **PHP**
```ini
# php.ini
memory_limit = 256M
max_execution_time = 30
upload_max_filesize = 10M
post_max_size = 10M
```

#### **MySQL**
```sql
-- Optimizaciones de BD
SET GLOBAL innodb_buffer_pool_size = 134217728; -- 128MB
SET GLOBAL max_connections = 100;
```

#### **Cache de Pronósticos**
Los pronósticos se almacenan en BD para evitar llamadas excesivas a la API.

---

## 🗄️ Base de Datos

### **Esquema de Tablas**

#### **usuarios**
```sql
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### **cultivos**
```sql
CREATE TABLE cultivos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    nombre_cultivo VARCHAR(100) NOT NULL,
    tipo_cultivo VARCHAR(50),
    area_hectareas DECIMAL(8,2),
    fecha_siembra DATE,
    fecha_cosecha_estimada DATE,
    ubicacion_parcela VARCHAR(255),
    latitud DECIMAL(10,8),
    longitud DECIMAL(11,8),
    descripcion TEXT,
    estado ENUM('semilla', 'germinacion', 'crecimiento', 'floracion', 'maduracion', 'cosecha') DEFAULT 'semilla',
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);
```

#### **alertas**
```sql
CREATE TABLE alertas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    cultivo_id INT,
    tipo_alerta ENUM('helada', 'sequia', 'granizo', 'inundacion', 'viento_fuerte', 'plagas', 'temperatura_extrema', 'humedad_extrema'),
    severidad ENUM('critica', 'alta', 'media', 'baja') DEFAULT 'media',
    mensaje TEXT NOT NULL,
    ubicacion VARCHAR(255),
    fecha_inicio DATE,
    fecha_fin DATE,
    activa BOOLEAN DEFAULT TRUE,
    leida BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (cultivo_id) REFERENCES cultivos(id) ON DELETE SET NULL
);
```

#### **pronosticos**
```sql
CREATE TABLE pronosticos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    location VARCHAR(100) NOT NULL,
    fecha DATE NOT NULL,
    temperatura_max DECIMAL(5,2),
    temperatura_min DECIMAL(5,2),
    humedad DECIMAL(5,2),
    probabilidad_lluvia DECIMAL(5,2),
    descripcion VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_location_fecha (location, fecha)
);
```


### **Índices y Optimizaciones**
```sql
-- Índices adicionales recomendados
CREATE INDEX idx_alertas_usuario_activa ON alertas (usuario_id, activa);
CREATE INDEX idx_alertas_severidad ON alertas (severidad);
CREATE INDEX idx_cultivos_usuario_activo ON cultivos (usuario_id, activo);
CREATE INDEX idx_cultivos_estado ON cultivos (estado);
CREATE INDEX idx_pronosticos_fecha ON pronosticos (fecha);
```

---

## 🔐 Seguridad

### **Medidas Implementadas**

#### **Autenticación**
- **Hashing de contraseñas**: bcrypt (PASSWORD_DEFAULT)
- **Sesiones seguras**: regeneración automática de IDs
- **Validación de entrada**: sanitización en servidor y cliente
- **Protección CSRF**: tokens en formularios críticos

#### **Base de Datos**
- **Prepared statements**: Prevención SQL injection
- **Validación de datos**: En modelos y controladores
- **Foreign keys**: Integridad referencial
- **Transacciones**: Para operaciones críticas

#### **API Externa**
- **Rate limiting**: Control de llamadas a OpenWeatherMap
- **Cache inteligente**: Almacenamiento local de pronósticos
- **Validación de respuestas**: Manejo de errores de API

### **Recomendaciones de Seguridad Adicionales**

#### **Configuración del Servidor**
```apache
# .htaccess adicional
<Files "config/*.php">
    Order deny,allow
    Deny from all
</Files>

<Files "*.sql">
    Order deny,allow
    Deny from all
</Files>
```

#### **Certificado SSL**
```bash
# Let's Encrypt para HTTPS
sudo certbot --apache -d tudominio.com
```

#### **Firewall**
```bash
# UFW básico
sudo ufw allow 22
sudo ufw allow 80
sudo ufw allow 443
sudo ufw enable
```

---

## 🔍 Monitoreo y Mantenimiento

### **Logs del Sistema**
- **PHP Errors**: `/var/log/apache2/error.log`
- **MySQL Slow Queries**: `/var/log/mysql/mysql-slow.log`
- **Aplicación**: Implementar logging personalizado

### **Métricas a Monitorear**
- **Uptime del servidor**
- **Uso de CPU/RAM**
- **Conexiones a BD activas**
- **Llamadas a API externa**
- **Tiempo de respuesta**
- **Errores 500/404**

### **Tareas de Mantenimiento**

#### **Diario**
```bash
# Backup de BD
mysqldump -u usuario -p clima > backup_$(date +%Y%m%d).sql

# Limpiar pronósticos antiguos (más de 30 días)
mysql -u usuario -p clima -e "DELETE FROM pronosticos WHERE created_at < DATE_SUB(NOW(), INTERVAL 30 DAY);"
```

#### **Semanal**
- Revisar logs de error
- Actualizar dependencias
- Verificar espacio en disco
- Optimizar tablas de BD

#### **Mensual**
- Análisis de rendimiento
- Revisión de seguridad
- Backup completo del sistema
- Actualización de versiones

---

## 🚨 Solución de Problemas

### **Problemas Comunes**

#### **Error 500 - Internal Server Error**
```bash
# Verificar logs de Apache
sudo tail -f /var/log/apache2/error.log

# Verificar sintaxis PHP
php -l app/controllers/AuthController.php

# Verificar permisos
ls -la /var/www/html/Pronostico_meteo
```

#### **Error de Conexión a BD**
```bash
# Verificar servicio MySQL
sudo systemctl status mysql

# Probar conexión
mysql -u usuario -p -e "SELECT 1;"

# Verificar configuración
php -r "require 'config/database.php'; echo 'Conexión OK';"
```

#### **API de Pronósticos No Funciona**
```bash
# Verificar clave API
grep API_KEY config/api.php

# Probar API manualmente
curl "http://api.openweathermap.org/data/2.5/weather?q=Bogota&appid=TU_CLAVE"

# Verificar límites de API
# Free tier: 1000 llamadas/día
```

#### **Archivos No Cargan (404)**
```bash
# Verificar mod_rewrite
sudo apache2ctl -M | grep rewrite

# Verificar .htaccess
cat public/.htaccess

# Reiniciar Apache
sudo systemctl restart apache2
```

### **Debugging Avanzado**

#### **Habilitar Modo Debug**
```php
// En config/database.php o crear config/app.php
define('APP_DEBUG', true);

// Mostrar errores en pantalla
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

#### **Herramientas de Debug**
- **Chrome DevTools**: Network, Console
- **PHP Logs**: `tail -f /var/log/apache2/error.log`
- **MySQL Logs**: `tail -f /var/log/mysql/error.log`
- **Postman**: Para probar APIs

---

## 📈 Escalabilidad y Optimizaciones

### **Optimizaciones de Rendimiento**

#### **Base de Datos**
```sql
-- Optimización de consultas
EXPLAIN SELECT * FROM cultivos WHERE usuario_id = 1;

-- Crear índices adicionales según uso
CREATE INDEX idx_alertas_fecha ON alertas (fecha_inicio);
```

#### **Cache de Aplicación**
```php
// Implementar cache de pronósticos
$cache_key = 'forecast_' . md5($location . $date);
$forecast = $cache->get($cache_key);
if (!$forecast) {
    $forecast = $this->fetchFromAPI($location);
    $cache->set($cache_key, $forecast, 3600); // 1 hora
}
```

#### **CDN y Assets**
```html
<!-- Usar CDN para librerías -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
```

### **Escalabilidad Horizontal**

#### **Balanceo de Carga**
```nginx
upstream backend {
    server app1.example.com;
    server app2.example.com;
}

server {
    listen 80;
    location / {
        proxy_pass http://backend;
    }
}
```

#### **Base de Datos Distribuida**
- Considerar réplicas de lectura para consultas
- Sharding por región geográfica
- Cache distribuido (Redis/Memcached)

---

## 📞 Soporte y Contacto

### **Recursos de Soporte**
- **Documentación**: README.md, MANUAL_USUARIO.md
- **Código fuente**: Comentarios detallados en archivos
- **Logs del sistema**: Para diagnóstico de problemas
- **Comunidad**: Issues en repositorio Git

### **Información de Versión**
```php
// Versión actual
define('APP_VERSION', '1.0.0');
define('APP_BUILD', '20241201');
define('PHP_MIN_VERSION', '7.4.0');
```

### **Política de Actualizaciones**
- **Versiones menores**: Corrección de bugs, mejoras menores
- **Versiones mayores**: Nuevas funcionalidades, cambios breaking
- **Parches de seguridad**: Liberación inmediata

---

## 🎯 Mejores Prácticas de Desarrollo

### **Estándares de Código**
- **PSR-4**: Autoloading de clases
- **PSR-12**: Estándares de codificación PHP
- **SOLID**: Principios de diseño orientado a objetos
- **DRY**: Don't Repeat Yourself

### **Control de Versiones**
```bash
# Estructura de commits
git commit -m "feat: agregar sistema de alertas"
git commit -m "fix: corregir validación de formularios"
git commit -m "docs: actualizar manual técnico"
```

### **Testing**
```bash
# Ejecutar pruebas (si se implementan)
./vendor/bin/phpunit

# Pruebas de carga
ab -n 1000 -c 10 http://localhost/Pronostico_meteo/public/
```

---

## 📋 Checklist de Despliegue

### **Pre-Despliegue**
- [ ] Entorno de servidor configurado
- [ ] Base de datos creada y poblada
- [ ] Archivos copiados al directorio web
- [ ] Permisos de archivos configurados
- [ ] API keys configuradas
- [ ] Certificado SSL instalado

### **Post-Despliegue**
- [ ] Acceso a aplicación verificado
- [ ] Funcionalidades básicas probadas
- [ ] Logs de error revisados
- [ ] Backup inicial realizado
- [ ] Monitoreo configurado

### **Mantenimiento**
- [ ] Backups automáticos configurados
- [ ] Monitoreo de uptime implementado
- [ ] Alertas de error configuradas
- [ ] Plan de contingencia documentado

---

¡**ClimaApp** está listo para producción! Esta documentación técnica asegura un despliegue exitoso y mantenimiento eficiente del sistema. 🌱✨

*Manual técnico versión 1.0.0 - Diciembre 2024*