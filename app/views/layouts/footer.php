        </div>
    </main>

    <footer style="
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        padding: 2rem 0;
        margin-top: 4rem;
        color: white;
    ">
        <div class="container" style="text-align: center;">
            <div style="display: flex; justify-content: center; gap: 2rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <a href="index.php?route=dashboard" style="color: white; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-home"></i> Inicio
                </a>
                <a href="index.php?route=forecast" style="color: white; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-cloud-sun"></i> Pronósticos
                </a>
                <a href="#" style="color: white; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-info-circle"></i> Acerca de
                </a>
            </div>
            <p style="opacity: 0.8; font-size: 0.9rem;">
                &copy; 2025 AgroPronostic - Pronósticos Meteorológicos. Todos los derechos reservados.
            </p>
            <p style="opacity: 0.6; font-size: 0.8rem; margin-top: 0.5rem;">
                Datos proporcionados por OpenWeatherMap
            </p>
        </div>
    </footer>

    <script>
        // Animaciones y efectos de carga
        document.addEventListener('DOMContentLoaded', function() {
            // Efecto de fade-in para elementos
            const elements = document.querySelectorAll('.forecast-card, .alert, .welcome');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Loading states para formularios
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
                        submitBtn.disabled = true;
                    }
                });
            });

            // Notificaciones toast
            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.style.cssText = `
                    position: fixed;
                    top: 100px;
                    right: 20px;
                    background: ${type === 'success' ? '#4CAF50' : '#f44336'};
                    color: white;
                    padding: 1rem 1.5rem;
                    border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
                    z-index: 10000;
                    transform: translateX(400px);
                    transition: transform 0.3s ease;
                    font-weight: 500;
                `;
                toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle"></i> ${message}`;

                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.style.transform = 'translateX(0)';
                }, 100);

                setTimeout(() => {
                    toast.style.transform = 'translateX(400px)';
                    setTimeout(() => {
                        document.body.removeChild(toast);
                    }, 300);
                }, 3000);
            }

            // Mostrar toast si hay mensajes de error o éxito
            <?php if (isset($error)): ?>
                showToast('<?php echo addslashes($error); ?>', 'error');
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
                showToast('Operación completada exitosamente', 'success');
            <?php endif; ?>
        });

        // Función para actualizar pronósticos en tiempo real
        function updateWeather() {
            // Esta función se puede expandir para actualizar datos en tiempo real
            console.log('Actualizando datos meteorológicos...');
        }

        // Actualizar cada 5 minutos
        setInterval(updateWeather, 300000);
    </script>
</body>
</html>