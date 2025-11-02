<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-12 w-full mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen">

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8 w-full">
            <h2 class="text-2xl font-bold text-violet-600 mb-6">Detail Tindak Lanjut Instruksi</h2>

            {{-- Instruksi --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Instruksi</label>
                <p class="text-gray-900 dark:text-gray-100">
                    {{ $followupinstruction->instruction->title ?? '-' }}
                </p>
            </div>

            {{-- Proof --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Bukti</label>
                @if ($followupinstruction->proof)
                    <a href="{{ Storage::url($followupinstruction->proof) }}" target="_blank"
                        class="text-violet-600 underline">Lihat File</a>
                @else
                    <p class="text-gray-500">Tidak ada file</p>
                @endif
            </div>

            {{-- Attachment --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Lampiran</label>
                @if ($followupinstruction->attachment)
                    <a href="{{ Storage::url($followupinstruction->attachment) }}" target="_blank"
                        class="text-violet-600 underline">Lihat File</a>
                @else
                    <p class="text-gray-500">Tidak ada file</p>
                @endif
            </div>

            {{-- Deskripsi pakai Trix (readonly) --}}
            <div class="mb-4">
                <label for="description" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Deskripsi</label>
                <input id="description" type="hidden" value="{{ $followupinstruction->description }}">
                <trix-editor input="description" class="border rounded-lg" contenteditable="false"></trix-editor>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ url()->previous() }}"
                    class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">Kembali</a>
            </div>
        </div>
    </div>

    @push('css')
        <link rel="stylesheet" href="https://unpkg.com/trix@2.1.0/dist/trix.css">
        <style>
            /* Hide toolbar biar rapi di mode show */
            trix-toolbar {
                display: none !important;
            }
        </style>
    @endpush

    @push('js')
        <script src="https://unpkg.com/trix@2.1.0/dist/trix.umd.min.js"></script>
    @endpush
</x-app-layout>
