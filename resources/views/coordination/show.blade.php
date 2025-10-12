<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-12 w-full mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8 w-full">
            <h2 class="text-2xl font-bold text-violet-600 mb-6">Detail Koordinasi</h2>

            {{-- Penerima --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                    Penerima
                </label>
                <input type="text" value="{{ $coordination->receiver->name ?? '-' }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-200"
                    readonly>
            </div>

            {{-- Judul --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Judul</label>
                <input type="text" value="{{ $coordination->title }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-200"
                    readonly>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Deskripsi</label>
                <input id="description" type="hidden" value="{{ $coordination->description }}">
                <trix-editor input="description" class="border rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-200"></trix-editor>
            </div>

            {{-- Waktu Mulai --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Waktu Mulai</label>
                <input type="text" value="{{ \Carbon\Carbon::parse($coordination->start_time)->format('d M Y') }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-200"
                    readonly>
            </div>

            {{-- Batas Waktu --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Batas Waktu</label>
                <input type="text" value="{{ \Carbon\Carbon::parse($coordination->end_time)->format('d M Y') }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-200"
                    readonly>
            </div>

            {{-- Lampiran --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Lampiran</label>
                @if ($coordination->attachment)
                    <a href="{{ asset('storage/' . $coordination->attachment) }}" target="_blank"
                        class="text-violet-600 hover:underline">Lihat Lampiran</a>
                @else
                    <span class="text-gray-500">Tidak ada lampiran</span>
                @endif
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-6 flex justify-end">
                <a href="{{ route('coordination.index') }}"
                    class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
                    Kembali
                </a>
            </div>
        </div>
    </div>

    @push('css')
        <link rel="stylesheet" href="https://unpkg.com/trix@2.1.0/dist/trix.css">
    @endpush

    @push('js')
        <script src="https://unpkg.com/trix@2.1.0/dist/trix.umd.min.js"></script>
        <script>
            document.addEventListener("trix-initialize", function(e) {
                e.target.setAttribute("contenteditable", false); // Biar tidak bisa diketik
            });
        </script>
    @endpush
</x-app-layout>
