  // Solo un click en el boton de crear liga para evitar errores
    document.getElementById('crearLigaForm').addEventListener('submit', function () {
        const boton = document.getElementById('crearLigaBtn');
        boton.disabled = true;
        boton.classList.add('opacity-50', 'cursor-not-allowed');
        boton.textContent = 'Creando...'; 
    });

    
    function passwordPrivada(select) {
        const passwordField = document.getElementById('password-field');
        if (select.value === 'privada') {
            passwordField.classList.remove('hidden');
        } else {
            passwordField.classList.add('hidden');
        }
    }

    function unirse() {
    // Realizar la solicitud de unirse a la liga
    fetch('/ligas/unirse', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({
            liga_id: Alpine.store('modal').selectedLiga.id,
            password: Alpine.store('modal').password
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            Alpine.store('modal').error = data.message || 'Error al unirse.';
        }
    });
}

function joinLeagueModal() {
    return {
        showJoinModal: false,
        showConfirmModal: false,
        searchTerm: '',
        leagues: [],
        selectedLeague: null,
        password: '',
        error: '',
        isLoading: false,
        
        async searchLeagues() {
            this.isLoading = true;
            try {
                const url = this.searchTerm 
                    ? `/ligas/buscar?search=${encodeURIComponent(this.searchTerm)}`
                    : '/ligas/buscar';
                
                const response = await fetch(url);
                const data = await response.json();
                
                // Ordenar por número de miembros (descendente)
                this.leagues = data.sort((a, b) => b.usuarios_count - a.usuarios_count);
                
                // Auto-scroll al principio
                if (this.$refs.resultsContainer) {
                    this.$refs.resultsContainer.scrollTop = 0;
                }
            } catch (e) {
                console.error('Error buscando ligas:', e);
                this.error = 'Error al buscar ligas';
                this.leagues = [];
            } finally {
                this.isLoading = false;
            }
        },
        
        selectLeague(league) {
            this.selectedLeague = league;
            this.showConfirmModal = true;
            this.password = '';
        },
        
        async joinLeague() {
            this.error = '';
            
            try {
                const response = await fetch('/ligas/unirse', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        liga_id: this.selectedLeague.id,
                        password: this.password
                    })
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    throw new Error(data.message || 'Error al unirse a la liga');
                }
                
                if (data.success) {
                    window.location.reload();
                } else {
                    this.error = data.message;
                }
            } catch (error) {
                this.error = error.message;
            }
        }
    }
}

function confirmarSalida(ligaId, miembrosCount) {
        console.log('Intentando abandonar liga:', ligaId);

        Swal.fire({
        title: '@lang("messages.abandonar_liga")',
        html: `
            <div style="text-align:center;">
                <div style="width:100%;height:0;padding-bottom:100%;position:relative;margin-bottom:10px;">
                <img src="{{ asset('Imagenes/abejaGift.gif') }}" alt="Abeja GIF" width="100%" height="100%" style="position:absolute;">
                </div>
                <p style="color:#f3f4f6; font-family:'Press Start 2P', monospace; font-size:12px;">
                    @lang("messages.confirmar_abandonar")
                </p>
            </div>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '@lang("messages.abandonar_min")',
        cancelButtonText: '@lang("messages.cancelar")',
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        background: '#111827',
        allowOutsideClick: false,
        customClass: {
            popup: 'border-4 border-indigo-600 rounded-xl shadow-xl',
            confirmButton: 'text-white font-bold rounded-lg px-4 py-2 shadow-md',
            cancelButton: 'text-white font-bold rounded-lg px-4 py-2 shadow-md ml-2'
        }
    })
    .then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById(`abandonarLigaForm-${ligaId}`);
            if (form) {
                console.log('Enviando formulario para liga:', ligaId);
                form.submit();
            } else {
                console.error('No se encontró el formulario');
                Swal.fire('Error', 'No se pudo procesar la solicitud', 'error');
            }
        }
    });
}

//Cuando hay un "success" o "error" desaparece a los 5 segundos el mensaje
document.addEventListener('DOMContentLoaded', function () {
    const successAlert = document.getElementById('successAlert');
    const errorAlert = document.getElementById('errorAlert');

    if (successAlert) {
        setTimeout(() => {
            successAlert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
            setTimeout(() => successAlert.remove(), 500); 
        }, 5000);
    }

    if (errorAlert) {
        setTimeout(() => {
            errorAlert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
            setTimeout(() => errorAlert.remove(), 500); 
        });
    }
});
