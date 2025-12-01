# 📖 Manual de Usuario - ClimaApp

## 🌦️ Sistema de Pronósticos Meteorológicos Agrícolas

Bienvenido a **ClimaApp**, tu asistente agrícola inteligente para la gestión de cultivos y pronósticos meteorológicos. Esta guía te ayudará a aprovechar al máximo todas las funcionalidades de la aplicación.

---

## 🚀 Primeros Pasos

### 1. Acceso a la Aplicación
- Abre tu navegador web
- Ve a: `http://localhost/Pronostico_meteo/public/`
- La aplicación te redirigirá automáticamente a la página de inicio de sesión

### 2. Registro de Usuario
Si es tu primera vez:
1. Haz clic en **"Regístrate"**
2. Completa el formulario:
   - **Username**: Nombre de usuario único
   - **Email**: Correo electrónico válido
   - **Password**: Contraseña de al menos 6 caracteres
   - **Rol**: Selecciona "Usuario" o "Administrador"
3. Haz clic en **"Registrarse"**
4. Serás redirigido al inicio de sesión

### 3. Inicio de Sesión
1. Ingresa tu **username** o **email**
2. Escribe tu **contraseña**
3. Haz clic en **"Iniciar Sesión"**
4. Accederás al dashboard principal

---

## 📊 Dashboard Principal

### Información General
El dashboard es tu centro de control donde encontrarás:
- **Estadísticas generales** de tus cultivos y alertas
- **Clima actual** de tu ubicación
- **Resumen de cultivos** activos
- **Alertas activas** del sistema
- **Recomendaciones** personalizadas
- **Pronósticos** de los próximos días

### Navegación
En la parte superior encontrarás el menú principal:
- **Dashboard**: Vista general (página actual)
- **Pronósticos**: Consulta el clima detallado
- **Cultivos**: Gestiona tus cultivos
- **Alertas**: Revisa notificaciones del sistema
- **Recomendaciones**: Sugerencias del sistema

---

## 🌾 Gestión de Cultivos

### Agregar un Nuevo Cultivo
1. Ve al menú **"Cultivos"**
2. Haz clic en **"+ Agregar Cultivo"**
3. Completa la información:
   - **Nombre del cultivo**
   - **Tipo de cultivo** (maíz, papa, café, etc.)
   - **Área en hectáreas**
   - **Fecha de siembra**
   - **Ubicación de la parcela**
   - **Descripción** (opcional)
4. Haz clic en **"Guardar"**

### Ver y Gestionar Cultivos
En la vista de cultivos podrás:
- **Ver todos tus cultivos** en una tabla organizada
- **Editar información** haciendo clic en el ícono ✏️
- **Eliminar cultivos** con el ícono 🗑️
- **Ver estado actual** de cada cultivo

### Estados de Cultivo
Los cultivos pueden tener diferentes estados:
- **Semilla**: Recién sembrado
- **Germinación**: Comenzando a crecer
- **Crecimiento**: Desarrollo activo
- **Floración**: Produciendo flores
- **Maduración**: Frutos desarrollándose
- **Cosecha**: Listo para cosechar

---

## ⚠️ Sistema de Alertas

### Tipos de Alertas
ClimaApp te informa sobre:
- **Helada**: Temperaturas bajo cero
- **Sequía**: Falta de lluvia prolongada
- **Granizo**: Posible caída de granizo
- **Inundación**: Riesgo de inundaciones
- **Viento fuerte**: Vientos intensos
- **Plagas**: Condiciones favorables para plagas
- **Temperatura extrema**: Calor o frío intenso
- **Humedad extrema**: Niveles críticos de humedad

### Severidad de Alertas
- **Crítica** 🔴: Requiere acción inmediata
- **Alta** 🟠: Atención prioritaria
- **Media** 🟡: Monitorear situación
- **Baja** 🔵: Información general

### Gestionar Alertas
1. Ve al menú **"Alertas"**
2. **Crear nueva alerta** con el botón "+ Nueva Alerta"
3. **Editar alertas** existentes
4. **Marcar como resueltas** las alertas atendidas

---


## 🌤️ Pronósticos Meteorológicos

### Ver Pronósticos
1. Ve al menú **"Pronósticos"**
2. Selecciona una **ubicación** (ej: "Bogota,CO")
3. Haz clic en **"Buscar"**
4. Visualiza el pronóstico de **7 días**

### Información Disponible
Para cada día encontrarás:
- **Temperatura máxima y mínima**
- **Humedad relativa**
- **Probabilidad de lluvia**
- **Descripción del clima**
- **Íconos representativos**

### Ubicaciones Soportadas
Puedes buscar pronósticos para:
- Ciudades colombianas
- Cualquier ubicación del mundo
- Formato: "Ciudad,País" (ej: "Medellín,CO", "Madrid,ES")

---

## 🔧 Configuración y Preferencias

### Cambiar Información Personal
Actualmente, la edición de perfil de usuario no está disponible en la interfaz. Contacta al administrador del sistema para cambios.

### Cerrar Sesión
1. Haz clic en el botón **"Salir"** en la esquina superior derecha
2. Confirmarás el cierre de sesión
3. Serás redirigido a la página de inicio de sesión

---

## ❓ Solución de Problemas

### No Puedo Iniciar Sesión
- Verifica que tu **username/email** y **contraseña** sean correctos
- Asegúrate de que las mayúsculas/minúsculas sean correctas
- Si olvidaste tu contraseña, contacta al administrador

### No Se Muestran Pronósticos
- Verifica tu conexión a internet
- Comprueba que la ubicación esté escrita correctamente
- La API de pronósticos puede tener límites diarios

### Alertas No Aparecen
- Las alertas se generan automáticamente basadas en pronósticos
- Si no hay condiciones de riesgo, no se mostrarán alertas
- Puedes crear alertas manuales desde el menú "Alertas"

### Problemas de Rendimiento
- Cierra otras pestañas del navegador
- Limpia el caché del navegador
- Reinicia el navegador

---

## 📞 Soporte Técnico

### Contacto
Si encuentras problemas o tienes preguntas:
- Revisa esta documentación completa
- Verifica los logs de error en la consola del navegador (F12)
- Contacta al equipo de desarrollo

### Información del Sistema
- **Versión**: 1.0.0
- **Tecnologías**: PHP 7.4+, MySQL, JavaScript
- **Navegadores compatibles**: Chrome, Firefox, Safari, Edge

---

## 🎯 Consejos para un Mejor Uso

### Gestión Eficiente
1. **Registra todos tus cultivos** al inicio de cada temporada
2. **Revisa diariamente** las alertas y pronósticos
3. **Actúa rápidamente** en alertas críticas
4. **Sigue las recomendaciones** del sistema para optimizar rendimientos

### Monitoreo Continuo
- Configura recordatorios para revisar la aplicación diariamente
- Mantén actualizada la información de tus cultivos
- Utiliza las recomendaciones para mejorar tus prácticas agrícolas

### Planificación Estratégica
- Usa los pronósticos para planificar actividades agrícolas
- Anticipa riesgos climáticos con las alertas del sistema
- Optimiza el uso de recursos basado en recomendaciones

---

¡Gracias por usar **ClimaApp**! Tu herramienta inteligente para una agricultura más eficiente y sostenible. 🌱✨

*Desarrollado con ❤️ para agricultores colombianos*