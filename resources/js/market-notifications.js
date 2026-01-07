// Sistema de notificaciones globales del mercado
class MarketNotifications {
    constructor() {
        this.checkInterval = null;
        this.lastMarketCheck = null;
        this.lastNotificationTime = null;
        this.notificationCooldown = 30000; // 30 segundos entre notificaciones
        this.init();
    }

    // Obtener identificadores de notificaciones ya mostradas
    getNotifiedPlayers() {
        try {
            const stored = localStorage.getItem('notified_players');
            return stored ? new Set(JSON.parse(stored)) : new Set();
        } catch (e) {
            return new Set();
        }
    }

    // Guardar identificador de notificación
    markPlayerAsNotified(playerId) {
        try {
            const notified = this.getNotifiedPlayers();
            notified.add(playerId);
            
            // Limpiar notificaciones antiguas (más de 24 horas)
            // Nota: Como el ID contiene la fecha, podríamos parsear, pero por simplicidad
            // solo mantenemos las últimas 50 notificaciones para no llenar el storage
            if (notified.size > 50) {
                const iterator = notified.values();
                notified.delete(iterator.next().value);
            }
            
            localStorage.setItem('notified_players', JSON.stringify([...notified]));
        } catch (e) {
            console.error('Error guardando notificación:', e);
        }
    }

    // Limpiar todas las notificaciones guardadas (opcional, por ejemplo al cambiar de liga)
    clearNotifiedPlayers() {
        localStorage.removeItem('notified_players');
    }

    init() {
        // Solicitar permisos de notificación
        this.requestNotificationPermission();
        
        // Iniciar verificación cada 30 segundos
        this.startMarketCheck();
        
        // Verificar cuando la página se vuelve visible
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) {
                this.checkMarketStatus();
            }
        });
    }

    async requestNotificationPermission() {
        if ('Notification' in window && Notification.permission === 'default') {
            try {
                const permission = await Notification.requestPermission();
                if (permission === 'granted') {
                    this.showVisualNotification('success', '<i class="fas fa-bell"></i> Notificaciones del mercado activadas');
                }
            } catch (error) {
                // Error silencioso
            }
        }
    }

    startMarketCheck() {
        // Verificar inmediatamente
        this.checkMarketStatus();
        
        // Verificar cada 30 segundos
        this.checkInterval = setInterval(() => {
            this.checkMarketStatus();
        }, 30000);
    }

    async checkMarketStatus() {
        try {
            // Obtener la liga actual de la URL
            const currentPath = window.location.pathname;
            const ligaMatch = currentPath.match(/\/liga\/(\d+)/);
            
            if (!ligaMatch) {
                return; // No estamos en una página de liga
            }
            
            const ligaId = ligaMatch[1];
            const url = `/liga/${ligaId}/mercado/status`;
            
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                const data = await response.json();
                this.handleMarketStatus(data);
            }
        } catch (error) {
            // Error silencioso
        }
    }

    handleMarketStatus(data) {
        // Verificar jugadores ganados
        if (data.jugadores_ganados && data.jugadores_ganados.length > 0) {
            const notifiedPlayers = this.getNotifiedPlayers();
            
            data.jugadores_ganados.forEach(jugador => {
                const playerId = `${jugador.nombre}_${jugador.cantidad}_${jugador.created_at}`;
                
                if (!notifiedPlayers.has(playerId)) {
                    this.markPlayerAsNotified(playerId);
                    const precio = new Intl.NumberFormat('es-ES').format(jugador.cantidad);
                    this.showPlayerWonNotification(jugador.nombre, precio);
                }
            });
        }

        // Si el mercado ha cambiado desde la última verificación
        if (this.lastMarketCheck && this.lastMarketCheck !== data.market_id) {
            // No limpiamos notificaciones aquí para mantener la persistencia
            this.showMarketNotification('<i class="fas fa-store"></i> ¡Nuevo mercado disponible!', 'Hay nuevos jugadores en subasta', 'info');
        }

        // Si el mercado está por terminar (menos de 1 minuto y 20 segundos)
        if (data.time_remaining <= 80 && data.time_remaining > 0 && this.shouldShowNotification()) {
            const segundos = Math.floor(data.time_remaining);
            const timeFormatted = this.formatTime(segundos);
            this.showMarketNotification('<i class="fas fa-clock"></i> ¡Mercado terminando!', `Quedan ${timeFormatted}`, 'warning');
        }

        // Si el mercado acaba de terminar
        if (data.time_remaining <= 0 && this.lastMarketCheck && data.market_id === this.lastMarketCheck) {
            this.showMarketNotification('<i class="fas fa-flag-checkered"></i> ¡Mercado finalizado!', 'Las pujas están siendo procesadas', 'info');
        }

        this.lastMarketCheck = data.market_id;
    }

    formatTime(seconds) {
        if (seconds >= 60) {
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = seconds % 60;
            if (remainingSeconds === 0) {
                return `${minutes} minuto${minutes > 1 ? 's' : ''}`;
            } else {
                return `${minutes} minuto${minutes > 1 ? 's' : ''} y ${remainingSeconds} segundo${remainingSeconds > 1 ? 's' : ''}`;
            }
        } else {
            return `${seconds} segundo${seconds > 1 ? 's' : ''}`;
        }
    }

    shouldShowNotification() {
        const now = Date.now();
        if (!this.lastNotificationTime || (now - this.lastNotificationTime) >= this.notificationCooldown) {
            this.lastNotificationTime = now;
            return true;
        }
        return false;
    }

    showPlayerWonNotification(playerName, price) {
        // Notificación del navegador
        if (Notification.permission === 'granted') {
            const notification = new Notification('¡Jugador ganado!', {
                body: `Has ganado a ${playerName} por ${price}€`,
                icon: '/favicon.ico',
                badge: '/favicon.ico',
                tag: 'player-won',
                requireInteraction: true
            });

            // Auto cerrar después de 10 segundos
            setTimeout(() => {
                notification.close();
            }, 10000);
        }

        // Notificación visual especial para jugador ganado
        this.showEnhancedNotification('success', '<i class="fas fa-trophy"></i> ¡Felicidades!', `Has ganado a ${playerName} por ${price}€`);
    }

    showMarketNotification(title, message, type = 'info') {
        // Notificación del navegador
        if (Notification.permission === 'granted') {
            const notification = new Notification(title, {
                body: message,
                icon: '/favicon.ico',
                badge: '/favicon.ico',
                tag: 'market-update',
                requireInteraction: false
            });

            // Auto cerrar después de 5 segundos
            setTimeout(() => {
                notification.close();
            }, 5000);
        }

        // Notificación visual en la página
        this.showVisualNotification(type, `${title} ${message}`);
    }

    showVisualNotification(type, message) {
        // Remover notificaciones anteriores del mismo tipo
        const existingNotifications = document.querySelectorAll('.market-notification');
        existingNotifications.forEach(notif => notif.remove());

        const notification = document.createElement('div');
        notification.className = `market-notification fixed top-4 right-4 px-6 py-4 rounded-xl shadow-2xl text-white z-[10000] flex items-center gap-3 border-2 backdrop-blur-lg max-w-sm`;
        
        // Estilos según el tipo
        let iconClass = '';
        switch(type) {
            case 'success':
                notification.className += ' bg-gradient-to-r from-green-500 to-emerald-600 border-green-400';
                iconClass = 'fas fa-check-circle';
                break;
            case 'info':
                notification.className += ' bg-gradient-to-r from-blue-500 to-cyan-600 border-blue-400';
                iconClass = 'fas fa-info-circle';
                break;
            case 'warning':
                notification.className += ' bg-gradient-to-r from-yellow-500 to-orange-600 border-yellow-400';
                iconClass = 'fas fa-exclamation-triangle';
                break;
            default:
                notification.className += ' bg-gradient-to-r from-gray-500 to-gray-600 border-gray-400';
                iconClass = 'fas fa-info-circle';
        }

        notification.innerHTML = `
            <div class="flex-shrink-0">
                <i class="${iconClass}"></i>
            </div>
            <span class="text-sm font-medium">${message}</span>
            <button onclick="this.parentElement.remove()" class="flex-shrink-0 ml-2 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        `;

        document.body.appendChild(notification);

        // Animación de entrada
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
            notification.style.transition = 'transform 0.3s ease-out';
        }, 100);

        // Auto remover después de 8 segundos
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }
        }, 8000);
    }

    showEnhancedNotification(type, title, message) {
        // Remover notificaciones anteriores
        const existingNotifications = document.querySelectorAll('.enhanced-notification');
        existingNotifications.forEach(notif => notif.remove());

        const notification = document.createElement('div');
        // Aumentado z-index a 10000 para asegurar que esté por encima de todo
        notification.className = `enhanced-notification fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-[10000] max-w-md w-full mx-4`;
        
        notification.innerHTML = `
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-6 shadow-2xl border-2 border-green-400 backdrop-blur-lg relative">
                <div class="text-center">
                    <div class="text-4xl mb-3 animate-bounce">
                        <i class="fas fa-trophy text-yellow-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">${title}</h3>
                    <p class="text-green-100 text-lg mb-4">${message}</p>
                    <button onclick="this.closest('.enhanced-notification').remove()" 
                            class="bg-white/20 hover:bg-white/30 text-white px-6 py-2 rounded-lg font-bold transition-all duration-200 flex items-center gap-2 mx-auto cursor-pointer">
                        <i class="fas fa-thumbs-up"></i>
                        ¡Genial!
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(notification);

        // Animación de entrada
        notification.style.opacity = '0';
        notification.style.transform = 'translate(-50%, -50%) scale(0.8)';
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translate(-50%, -50%) scale(1)';
            notification.style.transition = 'all 0.3s ease-out';
        }, 100);

        // Auto remover después de 15 segundos
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.opacity = '0';
                notification.style.transform = 'translate(-50%, -50%) scale(0.8)';
                setTimeout(() => notification.remove(), 300);
            }
        }, 15000);
    }

    destroy() {
        if (this.checkInterval) {
            clearInterval(this.checkInterval);
        }
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    // Solo inicializar si estamos en una página de liga
    if (window.location.pathname.includes('/liga/')) {
        window.marketNotifications = new MarketNotifications();
    }
});

// Limpiar al salir de la página
window.addEventListener('beforeunload', () => {
    if (window.marketNotifications) {
        window.marketNotifications.destroy();
    }
});
