# 🌦️ ClimaApp - Sistema de Pronósticos Meteorológicos Agrícolas

Una aplicación web moderna para gestión agrícola con pronósticos meteorológicos integrados, desarrollada en PHP con arquitectura MVC.

## ✨ Características Principales

- **📊 Dashboard Interactivo**: Panel de control con estadísticas en tiempo real
- **🌤️ Pronósticos de 7 Días**: Integración con OpenWeatherMap API
- **🌾 Gestión de Cultivos**: Seguimiento completo del ciclo agrícola
- **⚠️ Sistema de Alertas**: Notificaciones meteorológicas inteligentes
- **🔐 Autenticación Segura**: Sistema de login/registro con sesiones
- **📱 Diseño Responsivo**: Interfaz moderna y adaptable a dispositivos

## 🚀 Inicio Rápido

### Prerrequisitos
- **XAMPP** (Apache + MySQL + PHP)
- **Navegador web** moderno
- **Conexión a internet** (para pronósticos)

### Instalación

1. **Clona o descarga** el proyecto en `C:\xampp\htdocs\Pronostico_meteo\`

2. **Inicia XAMPP** y activa Apache + MySQL

3. **Crea la base de datos**:
   ```bash
   # Desde línea de comandos o phpMyAdmin
   mysql -u root < db_schema.sql
   ```

4. **Configura la API**:
   - Ve a [OpenWeatherMap](https://openweathermap.org/api)
   - Regístrate y obtén tu API key gratuita
   - Edita `config/api.php` y reemplaza `YOUR_API_KEY_HERE`

5. **Accede a la aplicación**:
   ```
   http://localhost/Pronostico_meteo/public/
   ```

## 📁 Estructura del Proyecto

```
Pronostico_meteo/
├── app/                    # Lógica de aplicación
│   ├── controllers/        # Controladores MVC
│   ├── models/            # Modelos de datos
│   ├── views/             # Vistas y layouts
│   ├── core/              # Núcleo del sistema
│   ├── middleware/        # Middleware de autenticación
│   └── services/          # Servicios externos
├── config/                # Configuraciones
├── public/                # Archivos públicos
│   ├── index.php         # Punto de entrada
│   └── .htaccess         # Reescritura de URLs
├── db_schema.sql         # Esquema de base de datos
└── README.md            # Esta documentación
```

## 🎯 Funcionalidades

### 👤 Autenticación
- Registro de nuevos usuarios
- Inicio de sesión seguro
- Gestión de sesiones
- Roles de usuario (regular/admin)

### 📈 Dashboard
- Estadísticas de cultivos y alertas
- Pronósticos del día actual
- Resumen de recomendaciones activas
- Navegación intuitiva

### 🌦️ Pronósticos
- Pronóstico extendido de 7 días
- Búsqueda por ubicación
- Datos detallados: temperatura, humedad, precipitación
- Cache inteligente para optimizar API

### 🌱 Gestión de Cultivos
- Registro de cultivos con detalles completos
- Seguimiento de estado y ciclo agrícola
- Área de cultivo y ubicación
- Historial y gestión

### 🚨 Sistema de Alertas
- Alertas meteorológicas automáticas
- Configuración manual de alertas
- Clasificación por severidad (crítica, alta, media)
- Notificaciones y seguimiento

### 💡 Recomendaciones
- Sugerencias basadas en pronósticos
- Consejos agrícolas inteligentes
- Priorización por urgencia
- Seguimiento de acciones

## 🛠️ Tecnologías Utilizadas

- **Backend**: PHP 7.4+ (POO, MVC)
- **Base de Datos**: MySQL con PDO
- **Frontend**: HTML5, CSS3, JavaScript vanilla
- **APIs**: OpenWeatherMap
- **Estilos**: Diseño moderno con gradientes y glassmorphism
- **Arquitectura**: Patrón MVC con separación clara de responsabilidades

## 🔧 Configuración Avanzada

### Variables de Entorno
Edita `config/database.php` para configurar la conexión a BD:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'clima');
```

### API Key
En `config/api.php`:
```php
define('API_KEY', 'tu_api_key_aqui');
```

## 📊 Base de Datos

### Tablas Principales
- `usuarios`: Gestión de usuarios y autenticación
- `pronosticos`: Cache de datos meteorológicos
- `alertas`: Sistema de notificaciones
- `recomendaciones`: Sugerencias del sistema
- `cultivos`: Gestión agrícola

## 🎨 Interfaz de Usuario

### Diseño Moderno
- **Gradientes dinámicos** con colores azul-violeta
- **Efectos glassmorphism** en tarjetas y elementos
- **Animaciones suaves** de entrada y hover
- **Tipografía moderna** (Inter font)
- **Iconografía** consistente con Font Awesome

### Responsive Design
- **Mobile-first** approach
- **Breakpoints** optimizados para todos los dispositivos
- **Grid layouts** adaptativos
- **Touch-friendly** elementos interactivos

### UX Optimizada
- **Estados de carga** con indicadores visuales
- **Notificaciones toast** para feedback
- **Validación en tiempo real** de formularios
- **Navegación intuitiva** con breadcrumbs

## 🔒 Seguridad

- **Hashing de contraseñas** con bcrypt
- **Protección CSRF** en formularios
- **Validación de entrada** en todos los campos
- **Sesiones seguras** con regeneración de IDs
- **Prevención de SQL injection** con prepared statements

## 🚀 Despliegue

### Producción
1. Configura un servidor web (Apache/Nginx)
2. Sube los archivos al directorio público
3. Configura la base de datos MySQL
4. Establece la API key de OpenWeatherMap
5. Configura HTTPS para seguridad

### Optimizaciones
- **Cache de pronósticos** para reducir llamadas API
- **Compresión GZIP** para assets
- **CDN** para librerías externas
- **Minificación** de CSS/JS en producción

## 📚 Documentación

### 📖 Manuales Disponibles
- **[MANUAL_USUARIO.md](MANUAL_USUARIO.md)**: Guía completa para usuarios finales
- **[MANUAL_TECNICO.md](MANUAL_TECNICO.md)**: Documentación técnica para desarrolladores
- **[README.md](README.md)**: Información general del proyecto (este archivo)

### 📋 Contenido de los Manuales

#### Manual de Usuario
- 🚀 Primeros pasos y registro
- 📊 Uso del dashboard
- 🌾 Gestión de cultivos
- ⚠️ Sistema de alertas
- 💡 Recomendaciones
- 🌤️ Pronósticos meteorológicos
- ❓ Solución de problemas

#### Manual Técnico
- 🏗️ Arquitectura del sistema
- ⚙️ Requisitos e instalación
- 🔧 Configuración avanzada
- 🗄️ Base de datos
- 🔐 Seguridad
- 🔍 Monitoreo y mantenimiento
- 🚨 Solución de problemas
- 📈 Escalabilidad

## 📞 Soporte

Para soporte técnico o reportar issues:
- 📖 **Lee los manuales** completos antes de contactar
- 🔍 **Revisa la documentación** técnica para instalación
- 🐛 **Verifica logs de error** de PHP/MySQL
- ⚙️ **Asegúrate** de que XAMPP esté correctamente configurado
- 💬 **Comunidad**: Issues en repositorio Git

## 📄 Licencia

Este proyecto es de código abierto y está disponible bajo la licencia MIT.

---

## 🎯 Estado del Proyecto

### ✅ **Completamente Funcional**
- **Interfaz Premium**: Diseño moderno con glassmorphism y animaciones
- **Funcionalidad Completa**: MVC, autenticación, pronósticos, cultivos, alertas
- **Base de Datos**: MySQL optimizada con todas las tablas
- **API Integration**: OpenWeatherMap completamente integrada
- **Seguridad**: Hashing, validación, sesiones seguras
- **Responsive**: Funciona en desktop, tablet y móvil
- **Documentación**: Manuales completos de usuario y técnico

### 🚀 **Listo para Producción**
- Arquitectura escalable y mantenible
- Código limpio y bien documentado
- Optimizaciones de rendimiento implementadas
- Manejo robusto de errores
- Logging y monitoreo preparados

### 📊 **Características Destacadas**
- **Dashboard Interactivo** con estadísticas en tiempo real
- **Pronósticos de 7 Días** con cache inteligente
- **Sistema de Alertas** con severidades y tipos
- **Gestión Completa de Cultivos** con estados y seguimiento
- **Sistema de Alertas** con severidades y tipos
- **Interfaz Premium** con UX excepcional

---

**Desarrollado con ❤️ para la agricultura inteligente en Colombia** 🇨🇴🌱

*ClimaApp v1.0.0 - Sistema completo de gestión agrícola meteorológica*

# Pro_clima
