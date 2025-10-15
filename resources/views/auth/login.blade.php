<x-authentication-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">

            <!-- Header -->
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-violet-600">SIMENTOR</h1>
                <p class="text-gray-600 dark:text-gray-300 mt-1 text-sm" style="font-family: 'Poppins', sans-serif;">
                    Aplikasi Manajemen Tugas Kantor Bawaslu Batam
                </p>
            </div>

            <!-- Status -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 text-center">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <x-label for="email" value="{{ __('Email') }}" class="text-gray-700 dark:text-gray-200" />
                    <x-input id="email" type="email" name="email" :value="old('email')" required autofocus
                        class="mt-1 block w-full rounded-md border-gray-300 focus:border-violet-500 focus:ring focus:ring-violet-200 focus:ring-opacity-50" />
                </div>

                <div>
                    <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 dark:text-gray-200" />
                    <x-input id="password" type="password" name="password" required autocomplete="current-password"
                        class="mt-1 block w-full rounded-md border-gray-300 focus:border-violet-500 focus:ring focus:ring-violet-200 focus:ring-opacity-50" />
                </div>

                <div class="flex items-center justify-between">
                  

                    <x-button class="!bg-violet-600 !hover:bg-violet-700 !text-white w-full sm:w-auto">
                        {{ __('Sign in') }}
                    </x-button>



                </div>

                <x-validation-errors class="mt-4" />
            </form>



        </div>
    </div>

</x-authentication-layout>