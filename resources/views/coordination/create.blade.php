<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-12 w-full mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8 w-full">
            <h2 class="text-2xl font-bold text-violet-600 mb-6">Tambahkan Koordinasi</h2>

            <form method="POST" action="{{ route('coordination.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Penerima --}}
                <div class="mb-4">
                    <label for="receiver_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Penerima
                    </label>
                    <select name="receiver_id" id="receiver_id" class="form-control js-example-basic-single w-full">
                        <option value="">Pilih Penerima</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('receiver_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('receiver_id')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- title --}}
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Judul</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm
                               focus:ring-2 focus:ring-violet-500 focus:border-violet-500
                               dark:bg-gray-800 dark:text-gray-200"
                        required placeholder="Masukkan title">
                    @error('title')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <label for="description"
                        class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Deskripsi</label>

                    <input id="description" type="hidden" name="description"
                        value="{{ old('description', $data->deskripsi ?? '') }}">
                    <trix-editor input="description" class="border rounded-lg"></trix-editor>

                    @error('description')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Waktu Mulai --}}
                <div class="mb-4">
                    <label for="waktu_mulai" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Waktu Mulai
                    </label>
                    <input type="date" name="start_time" id="waktu_mulai" value="{{ old('start_time') }}"
                        class="form-input w-full rounded border-gray-300 dark:border-gray-600
                               dark:bg-gray-700 dark:text-gray-200">
                    @error('start_time')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Batas Waktu --}}
                <div class="mb-4">
                    <label for="batas_waktu" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Batas Waktu
                    </label>
                    <input type="date" name="end_time" id="end_time" value="{{ old('end_time') }}"
                        class="form-input w-full rounded border-gray-300 dark:border-gray-600
                               dark:bg-gray-700 dark:text-gray-200">
                    @error('end_time')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Lampiran --}}
                <div class="mb-4">
                    <label for="lampiran" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Lampiran
                    </label>
                    <input type="file" name="attachment" id="attachment"
                        class="form-input w-full rounded border-gray-300 dark:border-gray-600
                               dark:bg-gray-700 dark:text-gray-200">
                    @error('attachment')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Action --}}
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('coordination.index') }}"
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
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://unpkg.com/trix@2.1.0/dist/trix.css">

    @endpush

    @push('js')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/trix@2.1.0/dist/trix.umd.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(function() {
                $('.js-example-basic-single').select2({
                    width: '100%'
                });
            });
        </script>

    @endpush
</x-app-layout>
