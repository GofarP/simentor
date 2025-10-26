<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-12 w-full mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen">

        <div x-data="{ loading: false }" class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8 w-full">
            <h2 class="text-2xl font-bold text-violet-600 mb-6">Edit Instruksi</h2>

            <form
                action="{{ route('instruction.update', ['instruction' => $instruction, 'messageType' => request('messageType')]) }}"
                method="POST" enctype="multipart/form-data"
                x-on:submit="loading = true; $refs.submitBtn.disabled = true;">

                @csrf
                @method('PUT')

                {{-- Penerima --}}
                <div class="mb-4">
                    <label for="receiver_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Penerima
                    </label>
                    <select name="receiver_id[]" id="receiver_id" class="form-control js-example-basic-single w-full"
                        multiple>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ in_array($user->id, old('receiver_id', $instruction->receivers->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('receiver_id')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Judul --}}
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('judul', $instruction->title) }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm
                               focus:ring-2 focus:ring-violet-500 focus:border-violet-500
                               dark:bg-gray-800 dark:text-gray-200"
                        required placeholder="Masukkan judul">
                    @error('judul')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div x-data="{ description: '{{ old('description', $instruction->description) }}' }" class="mb-4">
                    <label for="description"
                        class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Deskripsi</label>
                    <input id="description" type="hidden" name="description"
                        value="{{ old('deskripsi', $instruction->description) }}">

                    <trix-editor input="description" class="border rounded-lg"></trix-editor>

                    @error('deskripsi')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Waktu Mulai --}}
                <div class="mb-4">
                    <label for="start_time" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Start time
                    </label>
                    <input type="date" name="start_time" id="start_time"
                        value="{{ old('start_time', $instruction->start_time ? \Carbon\Carbon::parse($instruction->start_time)->format('Y-m-d') : '') }}"
                        class="form-input w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    @error('start_time')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Batas Waktu --}}
                <div class="mb-4">
                    <label for="end_time" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        End Time
                    </label>
                    <input type="date" name="end_time" id="end_time"
                        value="{{ old('end_time', isset($instruction->end_time) ? \Carbon\Carbon::parse($instruction->end_time)->format('Y-m-d') : '') }}"
                        class="form-input w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    @error('end_time')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- attachment --}}
                <div class="mb-4">
                    <label for="attachment" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Lampiran
                    </label>
                    <input type="file" name="attachment" id="attachment"
                        class="form-input w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">

                    @if ($instruction->attachment)
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            File lama:
                            <a href="{{ Storage::url($instruction->attachment) }}" target="_blank"
                                class="text-violet-600 underline">
                                Lihat Lampiran
                            </a>
                        </p>
                    @endif

                    @error('attachment')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('instruction.index') }}"
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
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
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

    {{-- CSS & JS tetap sama seperti form create --}}
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
