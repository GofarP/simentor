<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-12 w-full mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen">

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8 w-full">
            <h2 class="text-2xl font-bold text-violet-600 mb-6">Tambah Tindak Lanjut Koordinasi</h2>

            <form method="POST" action="{{ route('followupcoordination.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="coordination_id"
                        class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Koordinasi</label>
                    @php
                    $oldCoordination = old('coordination_id')
                    ? \App\Models\Coordination::find(old('instruction_id'))
                    : null;
                    @endphp
                    <select name="coordination_id" id="coordination_id" class="w-full">
                        @if ($oldCoordination)
                        <option value="{{ $oldCoordination->id }}" selected>
                            {{ $oldCoordination->title }}
                        </option>
                        @endif
                    </select>
                    @error('coordination_id')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="proof" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Bukti
                    </label>
                    <input type="file" name="proof" id="proof"
                        class="form-input w-full rounded border-gray-300 dark:border-gray-600
                               dark:bg-gray-700 dark:text-gray-200">
                    @error('proof')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="attachment" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Lampiran
                    </label>
                    <input type="file" name="attachment" id="attachment"
                        class="form-input w-full runded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    @error('attachment')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

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
    @endpush

    @push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/trix@2.1.0/dist/trix.umd.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#coordination_id').select2({
                placeholder: 'Cari Koordinasi...',
                ajax: {
                    url: '{{ route('coordinations.search') }}',
                    dataType: 'json',
                    delay: 250,
                    data: params => ({
                        search: params.term
                    }),
                    processResults: data => ({
                        results: data.results.map(item => ({
                            id: item.id,
                            text: item.is_expired ?
                                `${item.title} (Tenggat waktu habis)` :
                                item.title,
                            disabled: item.is_expired
                        }))
                    }),
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