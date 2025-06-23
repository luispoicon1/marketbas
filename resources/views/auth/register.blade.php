<x-guest-layout>
        <!-- Cabecera con el logo -->
        <div class="bg-yellow-400 p-4 rounded-xl mx-auto mb-7 w-70 text-center">
    <img src="{{ asset('img/logobas.png') }}" alt="Logo" class="w-30 h-20 mx-auto">
</div>

        <h2 class="text-2xl font-bold text-green-700 text-center">CREAR CUENTA</h2>
            <p class="text-gray-600 mt-1 text-center">Registrate para comenzar.</p>


        <!-- Cuerpo del formulario -->
        <div class="p-8">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nombre -->
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Nombre')" class="block text-gray-700 font-medium mb-2" />
                    <x-text-input 
                        id="name" 
                        class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-200" 
                        type="text" 
                        name="name" 
                        :value="old('name')" 
                        required 
                        autofocus 
                        placeholder="Tu nombre"
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Correo Electrónico')" class="block text-gray-700 font-medium mb-2" />
                    <x-text-input 
                        id="email" 
                        class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-200" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autocomplete="username" 
                        placeholder="tu@email.com"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Teléfono -->
                <div class="mb-4">
                    <x-input-label for="telefono" :value="__('Teléfono')" class="block text-gray-700 font-medium mb-2" />
                    <input 
                        id="telefono" 
                        type="text" 
                        name="telefono" 
                        value="{{ old('telefono') }}" 
                        class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-200" 
                        placeholder="Ej: +56912345678"
                    />
                    @error('telefono')
                        <span class="mt-2 text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Contraseña')" class="block text-gray-700 font-medium mb-2" />
                    <x-text-input 
                        id="password" 
                        class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-200" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="new-password" 
                        placeholder="••••••••"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                </div>

             <!-- Departamento -->
<div class="mt-4">
    <label for="departamento" class="block text-sm font-medium text-gray-700">Departamento</label>
    <select id="departamento" name="departamento" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
        <option value="">Selecciona departamento</option>
        <option value="Ica" {{ old('departamento') == 'Ica' ? 'selected' : '' }}>Ica</option>
    </select>
</div>

<!-- Provincia -->
<div class="mt-4">
    <label for="provincia" class="block text-sm font-medium text-gray-700">Provincia</label>
    <select id="provincia" name="provincia" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
        <option value="">Selecciona provincia</option>
    </select>
</div>

<!-- Distrito -->
<div class="mt-4">
    <label for="distrito" class="block text-sm font-medium text-gray-700">Distrito</label>
    <select id="distrito" name="distrito" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
        <option value="">Selecciona distrito</option>
    </select>
</div>

<!-- Dirección libre del usuario -->
<div class="mt-4">
    <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección (ej. Mz G Lt 4 Av. Grau)</label>
    <input id="direccion" name="direccion" type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" value="{{ old('direccion') }}">
</div>


<!-- Coordenadas manuales -->
<div class="mt-4">
    <label for="coordenadas" class="block text-sm font-medium text-gray-700">Coordenadas (latitud,longitud)</label>
    <input id="coordenadas" type="text" name="coordenadas" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" placeholder="-13.41865,-76.13274" value="{{ old('coordenadas') }}">
</div>
<p class="text-sm text-blue-600 hover:underline cursor-pointer" onclick="document.getElementById('modal-ayuda').classList.remove('hidden')">
    ¿Cómo obtener mis coordenadas?
</p>




                <!-- Confirmar Contraseña -->
                <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="block text-gray-700 font-medium mb-2" />
                    <x-text-input 
                        id="password_confirmation" 
                        class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-200" 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password" 
                        placeholder="••••••••"
                    />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Botón de Registro -->
                <button 
                    type="submit" 
                    class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition duration-200 ease-in-out transform hover:-translate-y-0.5"
                >
                    {{ __('Registrarse') }}
                </button>
            </form>

            <!-- Enlace a inicio de sesión -->
            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    ¿Ya tienes una cuenta?
                    <a 
                        href="{{ route('login') }}" 
                        class="ml-1 text-red-600 font-semibold hover:text-red-800 hover:underline transition duration-200"
                    >
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>
    </div>
    <script>
    const data = {
        "Ica": {
            "Chincha": [
                "Chincha Alta",
                "Alto Larán",
                "Chavín",
                "Chincha Baja",
                "El Carmen",
                "Grocio Prado",
                "Pueblo Nuevo",
                "San Juan de Yanac",
                "San Pedro de Huacarpana",
                "Sunampe",
                "Tambo de Mora"
            ]
        }
    };

    const departamentoSelect = document.getElementById('departamento');
    const provinciaSelect = document.getElementById('provincia');
    const distritoSelect = document.getElementById('distrito');

    departamentoSelect.addEventListener('change', function () {
        const dept = this.value;
        provinciaSelect.innerHTML = '<option value="">Selecciona provincia</option>';
        distritoSelect.innerHTML = '<option value="">Selecciona distrito</option>';

        if (data[dept]) {
            Object.keys(data[dept]).forEach(function (prov) {
                const option = document.createElement('option');
                option.value = prov;
                option.text = prov;
                provinciaSelect.add(option);
            });
        }
    });

    provinciaSelect.addEventListener('change', function () {
        const dept = departamentoSelect.value;
        const prov = this.value;
        distritoSelect.innerHTML = '<option value="">Selecciona distrito</option>';

        if (data[dept] && data[dept][prov]) {
            data[dept][prov].forEach(function (dist) {
                const option = document.createElement('option');
                option.value = dist;
                option.text = dist;
                distritoSelect.add(option);
            });
        }
    });
</script>

<!-- Modal de ayuda -->
<div id="modal-ayuda" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white max-w-lg w-full rounded-lg shadow-lg overflow-y-auto max-h-[90vh] relative p-6">
        <button onclick="document.getElementById('modal-ayuda').classList.add('hidden')" class="absolute top-3 right-4 text-gray-600 hover:text-red-600 text-xl font-bold">&times;</button>
        
        <h2 class="text-xl font-bold text-green-700 mb-4">¿Cómo obtener tus coordenadas?</h2>
        
        <ol class="space-y-4 text-sm text-gray-800">
            <li>
                <strong>1.</strong> Activa tu ubicación en tu dispositivo.
                <img src="{{ asset('img/ubicacion1.png') }}" class="mt-2 rounded shadow">
            </li>
            <li>
                <strong>2.</strong> Abre <b>Google Maps</b> y deja pulsado sobre tu ubicación.
                <img src="{{ asset('img/ubicacion2.png') }}" class="mt-2 rounded shadow">
            </li>
            <li>
                <strong>3.</strong> Aparecerá una flecha roja. Allí verás tus coordenadas.
                <img src="{{ asset('img/ubicacion3.png') }}" class="mt-2 rounded shadow">
            </li>
            <li>
                <strong>4.</strong> Pulsa las coordenadas para copiarlas (ej. <i>-13.42, -76.13</i>).
                <img src="{{ asset('img/ubicacion4.png') }}" class="mt-2 rounded shadow">
            </li>
        </ol>

        <p class="mt-4 text-green-600 font-semibold text-center">¡Eso es todo, gracias! 🎉</p>
    </div>
</div>


</x-guest-layout>