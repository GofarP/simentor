<x-app-layout>
    <div x-data="{ loading: false }"
        class="px-4 sm:px-6 lg:px-8 py-12 w-full mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen">

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8 w-full">
            <h2 class="text-2xl font-bold text-violet-600 mb-6">Edit User</h2>

            <form method="POST" action="{{ route('user.update', $user->id) }}"
                x-on:submit="loading = true; $refs.submitBtn.disabled = true;">

                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Nama</label>
                    <input type="text" name="name" id="name" value="{{ $user->name }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm
                                  focus:ring-2 focus:ring-violet-500 focus:border-violet-500
                                  dark:bg-gray-800 dark:text-gray-200" placeholder="Masukkan nama user">
                    @error('name')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ $user->email }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm
                                  focus:ring-2 focus:ring-violet-500 focus:border-violet-500
                                  dark:bg-gray-800 dark:text-gray-200" placeholder="Masukkan Email">
                    @error('email')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="telp" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Telp</label>
                    <input type="number" name="telp" id="telp" value="{{ $user->telp }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm
                                  focus:ring-2 focus:ring-violet-500 focus:border-violet-500
                                  dark:bg-gray-800 dark:text-gray-200" placeholder="Masukkan Telp">
                    @error('telp')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="role_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Role</label>
                    <select name="role_id" id="role_id" class="form-control js-example-basic-single">
                        <option value="">Pilih Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->roles->first() && $user->roles->first()->id == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>


                <div class="mb-4">
                    <label for="password"
                        class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Password</label>
                    <input type="password" name="password" id="password" value="{{ old('password') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm
                              focus:ring-2 focus:ring-violet-500 focus:border-violet-500
                              dark:bg-gray-800 dark:text-gray-200" placeholder="Masukkan Password">

                    @error('password')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>


                <div class="mb-4">
                    <label for="password_confirmation"
                        class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        value="{{ old('password_confirmation') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm
                              focus:ring-2 focus:ring-violet-500 focus:border-violet-500
                              dark:bg-gray-800 dark:text-gray-200" placeholder="Masukkan Konfirmasi Password">

                    @error('password_confirmation')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>


                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{url()->previous() }}"
                        class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">Batal</a>
                    <button x-ref="submitBtn" type="submit"
                        class="px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition flex items-center justify-center min-w-[120px]">
                        <template x-if="!loading">
                            <span>Update</span>
                        </template>

                        <template x-if="loading">
                            <div class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 100 16v-4l3 3-3 3v-4a8 8 0 01-8-8z">
                                    </path>
                                </svg>
                                <span>Proses...</span>
                            </div>
                        </template>
                    </button>
                </div>
            </form>
        </div>

    </div>

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush


    @push('js')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function () {
                $('.js-example-basic-single').select2({
                    placeholder: 'Pilih...',
                    allowClear: true,
                    width: '100%'
                });
            });
        </script>
    @endpush

</x-app-layout>