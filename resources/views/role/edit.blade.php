<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-12 w-full mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen">

        <!-- Card Full Width -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8 w-full">
            <h2 class="text-2xl font-bold text-violet-600 mb-6">Edit Role</h2>

            <form method="POST" action="{{ route('role.update', $role->id) }}">
                @csrf
                @method('PUT')

                <!-- Nama Role -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Nama Role
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm
                               focus:ring-2 focus:ring-violet-500 focus:border-violet-500
                               dark:bg-gray-800 dark:text-gray-200"
                        placeholder="Masukkan nama role">
                    @error('name')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Permission Multi-select dengan Select2 -->
                <div class="mb-4">
                    <label for="permissions" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Permission
                    </label>

                    <select name="permissions[]" id="permissions" multiple
                        class="w-full js-select2 px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm
                               focus:ring-2 focus:ring-violet-500 focus:border-violet-500
                               dark:bg-gray-800 dark:text-gray-200">
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}"
                                {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'selected' : '' }}>
                                {{ $permission->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('permissions')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('role.index') }}"
                        class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition">
                        Simpan
                    </button>
                </div>

            </form>
        </div>

    </div>

    @push('css')
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .select2-container--default .select2-selection--multiple {
                @apply bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm;
                padding: 0.5rem;
            }
            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                @apply bg-violet-600 text-white rounded px-2 py-1 m-1;
            }
            .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
                @apply text-white ml-1 cursor-pointer;
            }
        </style>
    @endpush

    @push('js')
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.js-select2').select2({
                    placeholder: "Pilih permission...",
                    width: '100%'
                });
            });
        </script>
    @endpush

</x-app-layout>
