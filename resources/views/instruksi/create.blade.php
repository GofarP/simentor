<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-12 w-full mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen">

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8 w-full">
            <h2 class="text-2xl font-bold text-violet-600 mb-6">Tambah Instruksi</h2>

            <form method="POST" action="{{ route('instruksi.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="penerima_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Penerima
                    </label>
                    <select name="penerima_id" id="penerima_id" class="form-control js-example-basic-single w-full">
                        <option value="">Pilih Penerima</option>
                        @foreach ($users as $user )
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('penerima_id')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>


                <div class="mb-4">
                    <label for="judul" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Judul</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm
                                  focus:ring-2 focus:ring-violet-500 focus:border-violet-500
                                  dark:bg-gray-800 dark:text-gray-200"
                        required placeholder="Masukkan judul">
                    @error('judul')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div x-data="{ deskripsi: '{{ old('deskripsi', $data->deskripsi ?? '') }}' }" class="mb-4">
                    <label for="deskripsi"
                        class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Deskripsi</label>

                    <input id="deskripsi" type="hidden" name="deskripsi" x-model="deskripsi">
                    <trix-editor input="deskripsi" class="border rounded-lg"></trix-editor>

                    @error('deskripsi')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>


                <div class="mb-4">
                    <label for="waktu_mulai" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Waktu Mulai
                    </label>

                    <input type="date" name="waktu_mulai" id="waktu_mulai" value="{{ old('waktu_mulai') }}"
                        class="form-input w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">

                    @error('waktu_mulai')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>


                <div class="mb-4">
                    <label for="batas_waktu" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Batas Waktu
                    </label>

                    <input type="date" name="batas_waktu" id="waktu_mulai" value="{{ old('batas_waktu') }}"
                        class="form-input w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">

                    @error('batas_waktu')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="lampiran" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Lampiran
                    </label>

                    <input type="file" name="lampiran" id="lampiran"
                        class="form-input w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">

                    @error('lampiran')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>




                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('permission.index') }}"
                        class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition">Simpan</button>
                </div>
            </form>
        </div>

    </div>

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://unpkg.com/trix@2.1.0/dist/trix.css">
        <style>
            /* Dark mode untuk Trix */
            .dark trix-editor {
                background-color: #1f2937;
                /* bg-gray-800 */
                color: #e5e7eb;
                /* text-gray-200 */
                border-color: #374151;
                /* border-gray-700 */
            }

            .dark trix-editor:focus {
                outline: none;
                border-color: #8b5cf6;
                /* violet-500 */
                box-shadow: 0 0 0 1px #8b5cf6;
            }

            /* Toolbar Trix di dark mode */
            .dark .trix-button-group {
                background-color: #111827;
                /* bg-gray-900 */
                border-color: #374151;
            }

            .dark .trix-button {
                color: #e5e7eb;
            }

            .dark .trix-button:hover {
                background-color: #374151;
            }

            .dark .trix-button.trix-active {
                background-color: #8b5cf6;
                color: white;
            }

            /* Toolbar Trix di dark mode */
            .dark .trix-button-group {
                background-color: #1f2937;
                /* bg-gray-800 */
                border-color: #374151;
                /* border-gray-700 */
            }

            .dark .trix-button {
                background-color: #374151;
                /* bg-gray-700 */
                color: #ffffff !important;
                /* Putih */
                border: none;
            }

            .dark .trix-button:hover {
                background-color: #4b5563;
                /* bg-gray-600 */
                color: #ffffff !important;
            }

            .dark .trix-button.trix-active {
                background-color: #8b5cf6;
                /* violet-500 */
                color: #ffffff !important;
            }
        </style>
    @endpush

    @push('js')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        <script src="https://unpkg.com/trix@2.1.0/dist/trix.umd.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2({
                    width: '100%'
                });

            });
        </script>
    @endpush

</x-app-layout>
