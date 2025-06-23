<x-guest-layout>
        <!-- Cabecera con el logo -->
        <div class="bg-yellow-400 p-4 rounded-xl mx-auto mb-4 w-70 text-center">
    <img src="{{ asset('img/logobas.png') }}" alt="Logo" class="w-30 h-20 mx-auto">
</div>

        <h2 class="text-2xl font-bold text-green-700 text-center">INICIAR SESIÓN</h2>
            <p class="text-gray-600 mt-1 text-center">Ingrese sus credenciales</p>

        <!-- Cuerpo del formulario -->
        <div class="p-8">
            <form method="POST" action="{{ route('login') }}">
                @csrf

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
                        autofocus 
                        placeholder="user@ejemplo.com"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
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
                        placeholder="••••••••"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Recordar sesión -->
                <div class="flex items-center justify-between mb-6">
                    <label for="remember_me" class="flex items-center">
                        <input 
                            id="remember_me" 
                            type="checkbox" 
                            class="rounded h-5 w-5 text-green-600 focus:ring-green-400 border-gray-300" 
                            name="remember"
                        >
                        <span class="ml-2 text-gray-600">{{ __('Recuérdame') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a 
                            href="{{ route('password.request') }}" 
                            class="text-sm text-green-600 hover:text-green-800 hover:underline transition duration-200"
                        >
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    @endif
                </div>

                <!-- Botón de login -->
                <button 
                    type="submit" 
                    class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition duration-200 ease-in-out transform hover:-translate-y-0.5"
                >
                    {{ __('Iniciar sesión') }}
                </button>
            </form>

            <!-- Enlace a registro -->
            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    ¿No tienes una cuenta?
                    <a 
                        href="{{ route('register') }}" 
                        class="ml-1 text-red-600 font-semibold hover:text-red-800 hover:underline transition duration-200"
                    >
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>