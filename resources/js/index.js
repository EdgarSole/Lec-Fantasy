
function carousel() {   
    return {
        currentSlide: 0,
        slides: [
            '{{ asset('imagenes/fondo.jpg') }}',
            '{{ asset('imagenes/fondo2-estadio.jpg') }}',
            '{{ asset('imagenes/fondo3-estadio.jpg') }}',
            '{{ asset('imagenes/fondo2-arena.jpg') }}',
            '{{ asset('imagenes/fondo5-estadio.jpg') }}'
        ],
        interval: null,

        init() {
            this.startAutoPlay();
        },

        startAutoPlay() {
            this.stopAutoPlay(); // Asegura que no haya múltiples intervalos activos
            this.interval = setInterval(() => {
                this.next(false);
            }, 5000);
        },

        stopAutoPlay() {
            if (this.interval) {
                clearInterval(this.interval);
                this.interval = null;
            }
        },

        next(manual = true) {
            this.currentSlide = (this.currentSlide + 1) % this.slides.length;
            if (manual) this.startAutoPlay(); // Reinicia el intervalo si fue una acción manual
        },

        prev() {
            this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
            this.startAutoPlay(); // También reinicia el temporizador
        },

        goTo(index) {
            this.currentSlide = index;
            this.startAutoPlay(); // Reinicia al seleccionar manualmente
        }
    }
}