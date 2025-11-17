<x-guest-layout>
        <div class="w-full max-w-md px-8 py-10 bg-white dark:bg-gray-900/90 rounded-2xl shadow-xl border border-gray-200/70 dark:border-gray-800/70 ring-1 ring-white/10 backdrop-blur-sm">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100"> @lang('messages.unete_a')<span class="text-blue-600"> LEC Fantasy</span></h2>
                <p class="mt-2 text-gray-600 dark:text-gray-300"> @lang('messages.crea_y_empieza')</p>
            </div>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- Nombre de usuario -->
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">@lang('messages.nombre_user')</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                             <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="nombre" name="nombre" type="text" value="{{ old('nombre') }}" required autofocus
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 transition duration-150"
                            placeholder="{{ __('messages.tu_nombre') }}">

                    </div>
                    @error('nombre')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                        </div>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 transition duration-150"
                            placeholder="tucorreo@ejemplo.com">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">@lang('messages.contraseña')</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="password" name="password" type="password" required
                            class="block w-full pl-10 pr-10 py-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 transition duration-150"
                            placeholder="••••••••">
                        <button type="button" aria-label="Mostrar contraseña" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300" onclick="(function(){const i=document.getElementById('password'); i.type = i.type==='password' ? 'text' : 'password';})();">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">@lang('messages.confirma_contraseña')</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="block w-full pl-10 pr-10 py-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 transition duration-150"
                            placeholder="••••••••">
                        <button type="button" aria-label="Mostrar contraseña" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300" onclick="(function(){const i=document.getElementById('password_confirmation'); i.type = i.type==='password' ? 'text' : 'password';})();">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Foto de Perfil -->
                <div class="pt-2">
                    <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">@lang('messages.foto_perfil_op')</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="foto" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500">
                                    <span class="font-semibold">@lang('messages.clic_subir')</span>  @lang('messages.arrastra')
                                </p>
                                <p class="text-xs text-gray-500">PNG, JPG (MAX. 2MB)</p>
                            </div>
                            <input id="foto" name="foto" type="file" class="hidden" accept="image/*">
                        </label>
                    </div>
                    @error('foto')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <div id="preview" class="mt-2 flex justify-center hidden">
                        <img id="previewImage" class="h-20 w-20 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700">
                    </div>
                </div>

                <!-- Botón de Registro -->
                <div class="pt-2">
                    <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 transform hover:scale-105 btn-shimmer btn-icon">
                         <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                         @lang('messages.register')
                    </button>
                    <br>
                </div>

                <!-- Enlace a Login -->
                <div class="text-center text-sm text-gray-600 dark:text-gray-400">
                    <p>  @lang('messages.ya_cuenta')
                        <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 transition duration-150">
                            @lang('messages.inicia_aqui')
                        </a>
                    </p>
                </div>
            </form>
        </div>

    <!-- Script para previsualizar la imagen -->
    <script>
        document.getElementById('foto').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                const preview = document.getElementById('preview');
                const previewImage = document.getElementById('previewImage');
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                
                reader.readAsDataURL(file);
            }
        });
    </script>
    <style>
      .btn-icon svg { transition: transform .18s ease; }
      .btn-icon:hover svg { transform: translateX(2px); }
      .btn-shimmer { position: relative; overflow: hidden; }
      .btn-shimmer::after { content:""; position:absolute; inset:0; transform:translateX(-120%); background:linear-gradient(120deg,transparent 0%,rgba(255,255,255,.2) 30%,rgba(255,255,255,.35) 45%,transparent 60%); }
      .btn-shimmer:hover::after { transform:translateX(120%); transition: transform .6s ease; }
      @media (prefers-reduced-motion: reduce) { .btn-icon svg, .btn-shimmer::after { animation:none !important; transition:none !important; } }
    </style>
    <script>
    (function(){
      document.addEventListener('click', (e)=>{
        const btn = e.target.closest('.btn-shimmer');
        if(!btn) return;
        const rect = btn.getBoundingClientRect();
        const spot = document.createElement('span');
        spot.style.position='absolute'; spot.style.borderRadius='9999px'; spot.style.pointerEvents='none'; spot.style.transform='translate(-50%, -50%) scale(0)'; spot.style.opacity='.35'; spot.style.background='currentColor';
        const size = Math.max(rect.width, rect.height) * 0.9; spot.style.width=spot.style.height=size+'px';
        spot.style.left=(e.clientX-rect.left)+'px'; spot.style.top=(e.clientY-rect.top)+'px';
        btn.style.position = getComputedStyle(btn).position==='static' ? 'relative' : getComputedStyle(btn).position;
        btn.appendChild(spot);
        spot.animate([{transform:'translate(-50%, -50%) scale(0)',opacity:.35},{transform:'translate(-50%, -50%) scale(1)',opacity:0}],{duration:500,easing:'ease-out',fill:'forwards'});
        setTimeout(()=> spot.remove(), 520);
      });
    })();
    </script>
</x-guest-layout>