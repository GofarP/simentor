<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-12 w-full mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8 w-full">
            <h2 class="text-2xl font-bold text-violet-600 mb-6">Tambahkan Penilaian Instruksi</h2>

            <form method="POST" action="{{ route('instructionscore.store') }}">
                @csrf

                {{-- Pilihan Instruksi --}}
                <div class="mb-4">
                    <label for="instruction_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Instruksi
                    </label>
                    <select name="instruction_id" id="instruction_id" class="form-control js-example-basic-single w-full"></select>
                    @error('instruction_id')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Penilaian --}}
                <div class="mb-4">
                    <label for="score" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Penilaian
                    </label>
                    <select name="score" id="score" class="form-control js-example-basic-single w-full">
                        <option value="">Pilih Penilaian</option>
                        <option value="1" {{ old('score') === '1' ? 'selected' : '' }}>Baik</option>
                        <option value="0" {{ old('score') === '0' ? 'selected' : '' }}>Buruk</option>
                    </select>
                    @error('score')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Action --}}
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('instructionscore.index') }}"
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
            $(document).ready(function() {
                // Inisialisasi Select2 dengan AJAX
                $('#instruction_id').select2({
                    placeholder: 'Cari instruksi...',
                    ajax: {
                        url: '{{ route('instructions.search') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return { search: params.term };
                        },
                        processResults: function(data) {
                            return {
                                results: data.results.map(item => ({
                                    id: item.id,
                                    text: item.title
                                }))
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 1,
                    width: '100%',
                    language: "id"
                });
            });
        </script>
    @endpush
</x-app-layout>
