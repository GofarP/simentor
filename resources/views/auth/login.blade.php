<x-authentication-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
        <div class="w-full max-w-xl bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-10">

            <!-- Header -->
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-violet-600">SIMENTOR</h1>
                <p class="text-gray-600 dark:text-gray-300 mt-1 text-sm" style="font-family: 'Poppins', sans-serif;">
                    Sistem Manajemen Tugas Kantor
                </p>
            </div>

            <!-- Status -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 text-center">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ loading: false }" @submit="loading = true">
                @csrf

                <!-- Email -->
                <div>
                    <x-label for="email" value="{{ __('Email') }}" class="text-gray-700 dark:text-gray-200" />
                    <x-input id="email" type="email" name="email" :value="old('email')" required autofocus
                        class="mt-1 block w-full rounded-md border-gray-300 focus:border-violet-500 focus:ring focus:ring-violet-200 focus:ring-opacity-50" />
                </div>

                <!-- Password -->
                <div>
                    <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 dark:text-gray-200" />
                    <x-input id="password" type="password" name="password" required autocomplete="current-password"
                        class="mt-1 block w-full rounded-md border-gray-300 focus:border-violet-500 focus:ring focus:ring-violet-200 focus:ring-opacity-50" />
                </div>

                <!-- Button -->
                <div>
                    <x-button 
                        type="submit"
                        x-bind:disabled="loading"
                        class="!bg-violet-600 !hover:bg-violet-700 !text-white w-full flex items-center justify-center gap-2"
                    >
                        <template x-if="!loading">
                            <span>{{ __('Login') }}</span>
                        </template>

                        <template x-if="loading">
                            <span class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                                <span>{{ __('Logging in...') }}</span>
                            </span>
                        </template>
                    </x-button>
                </div>

                <!-- Validation Errors -->
                <x-validation-errors class="mt-4" />
            </form>

        </div>
    </div>
</x-authentication-layout>
