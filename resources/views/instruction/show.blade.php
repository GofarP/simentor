<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-12 w-full mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen">

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8 w-full">
            <h2 class="text-2xl font-bold text-violet-600 mb-6">Detail Instruksi</h2>

            {{-- Penerima --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Penerima</label>
                <p class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                    {{ $instruction->receiver?->name ?? '-' }}
                </p>
            </div>

            {{-- Judul --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Judul</label>
                <p class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                    {{ $instruction->title }}
                </p>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Deskripsi</label>
                <div class="px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 trix-content prose prose-violet max-w-none">
                    {!! $instruction->description !!}
                </div>
            </div>

            {{-- Waktu Mulai --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Waktu Mulai</label>
                <p class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                    {{ $instruction->start_time ? \Carbon\Carbon::parse($instruction->start_time)->translatedFormat('d M Y') : '-' }}
                </p>
            </div>

            {{-- Batas Waktu --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Batas Waktu</label>
                <p class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                    {{ $instruction->end_time ? \Carbon\Carbon::parse($instruction->end_time)->translatedFormat('d M Y') : '-' }}
                </p>
            </div>

            {{-- Lampiran --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Lampiran</label>
                @if ($instruction->attachment)
                    <a href="{{ Storage::url($instruction->attachment) }}" target="_blank"
                        class="px-4 py-2 inline-block bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition">
                        Lihat Lampiran
                    </a>
                    <p class="text-md text-white mt-3">
                        Nama File {{ basename($instruction->attachment) }}
                    </p>
                @else
                    <p class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                        Tidak ada lampiran
                    </p>
                @endif
            </div>

            {{-- Tombol --}}
            <div class="mt-6 flex justify-end">
                <a href="{{ route('instruction.index') }}"
                    class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
                    Kembali
                </a>
            </div>
        </div>
    </div>

    @push('css')
        <link rel="stylesheet" href="https://unpkg.com/trix@2.1.0/dist/trix.css">
        <style>
            .trix-content ul {
                list-style-type: disc !important;
                margin-left: 1.5rem;
            }

            .trix-content ol {
                list-style-type: decimal !important;
                margin-left: 1.5rem;
            }

            .trix-content h1 {
                font-size: 1.25rem;
                font-weight: bold;
                margin: 1rem 0;
            }

            .trix-content blockquote {
                border-left: 4px solid #8b5cf6;
                padding-left: 1rem;
                color: #6b7280;
                font-style: italic;
                margin: 1rem 0;
            }

            .trix-content pre {
                background: #1e1e2e;
                color: #f8f8f2;
                padding: 0.5rem;
                border-radius: 6px;
                font-family: monospace;
                overflow-x: auto;
            }
        </style>
    @endpush
</x-app-layout>
