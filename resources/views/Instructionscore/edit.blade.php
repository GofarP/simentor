<x-app-layout>
    <div x-data="{ loading: false }"
        class="px-4 sm:px-6 lg:px-8 py-12 w-full mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8 w-full">
            <h2 class="text-2xl font-bold text-violet-600 mb-6">Edit Penilaian Instruksi</h2>


            <form method="POST" action="{{ route('instructionscore.update',$instructionscore->id) }}"
                x-on:submit="loading = true; $refs.submitBtn.disabled = true;">
                @csrf
                @Method('PUT')
                <div class="mb-4">
                    <label for="instruction_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Nama
                        Instruksi</label>
                    <select name="instruction_id" id="instruction_id"
                        class="w-full pointer-events-none bg-gray-100 border rounded-md p-2">
                        @foreach ($instructions as $instruction)
                            <option value="{{ $instruction->id }}" {{ $instruction->id === $instructionscore->instruction_id ? 'selected' : ''}}>
                                {{ $instruction->title }}</option>
                        @endforeach
                    </select>
                    @error('instruction_id')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Score --}}
                <div class="mb-4">
                    <label for="score" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Nilai</label>
                    <select name="score" id="score" class="js-example-basic-single w-full">
                        <option value="">-- Pilih Nilai --</option>
                        <option value="1" {{ $instructionscore->score == '1' ? 'selected' : '' }}>Baik</option>
                        <option value="0" {{ $instructionscore->score == '0' ? 'selected' : '' }}>Buruk</option>
                    </select>
                    @error('score')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Comment --}}
                <div class="mb-4">
                    <label for="comment"
                        class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Komentar</label>
                    <input id="comment" type="hidden" name="comment" value="{{ $instructionscore->comment }}">
                    <trix-editor input="comment"
                        class="border rounded-lg dark:bg-gray-700 dark:text-white"></trix-editor>
                    @error('comment')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('followupinstructionscore.index') }}"
                        class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">Batal</a>
                    <button x-ref="submitBtn" type="submit"
                        class="px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition flex items-center justify-center min-w-[120px]">
                        <template x-if="!loading">
                            <span>Simpan</span>
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
        <link rel="stylesheet" href="https://unpkg.com/trix@2.1.0/dist/trix.css">
    @endpush

    @push('js')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/trix@2.1.0/dist/trix.umd.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(function () {
                $('.js-example-basic-single').select2({
                    width: '100%'
                });
            });
        </script>
    @endpush
</x-app-layout>