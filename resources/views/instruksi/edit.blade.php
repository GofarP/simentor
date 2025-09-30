<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-12 w-full mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen">

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8 w-full">
            <h2 class="text-2xl font-bold text-violet-600 mb-6">Edit Instruksi</h2>

            <form method="POST" action="{{ route('instruksi.update',$instruksi->id) }}">
                @csrf

                <div class="mb-4">
                    <label for="penerima_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Penerima
                    </label>
                    <select name="penerima_id" id="penerima_id" class="form-control js-example-basic-single w-full">
                        <option value="">Pilih Penerima</option>
                    </select>
                    @error('penerima_id')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>


                <div class="mb-4">
                    <label for="judul" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Judul</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm
                                  focus:ring-2 focus:ring-violet-500 focus:border-violet-500
                                  dark:bg-gray-800 dark:text-gray-200" required placeholder="Masukkan judul">
                    @error('judul')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="deskripsi"
                        class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Deskripsi</label>

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
    @endpush

    @push('js')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.js-example-basic-single').select2();
            })
        </script>

    @endpush

</x-app-layout>