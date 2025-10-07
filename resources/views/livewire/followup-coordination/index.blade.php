<div class="px-4 sm:px-6 lg:px-8 py-12 w-full max-w-7xl mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen">
    @if (session('success'))
        <div
            class="mb-4 px-4 py-3 rounded-lg bg-green-100 border border-green-300 text-green-800 dark:bg-green-800 dark:text-green-100 dark:border-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2">
            <div>
                <p class="text-3xl md:text-4xl font-extrabold text-violet-600 mb-2">
                    Tindak Lanjut Koordinasi
                </p>
                <p class="text-gray-700 dark:text-gray-300 text-base md:text-lg">
                    Kelola Tindak Lanjut Koordinasi.
                </p>
            </div>

            <div class="flex flex-col items-end gap-2">

                <input type="text" name="search" wire:model.live.debounce.500ms="search" placeholder="cari..." class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm
              focus:ring-2 focus:ring-violet-500 focus:border-violet-500
              dark:bg-gray-800 dark:text-gray-200" />

                <a href="{{ route('followupcoordination.create') }}"
                    class=" mt-3 inline-flex items-center px-4 py-2 bg-violet-600 text-white text-sm font-medium rounded-lg shadow hover:bg-violet-700 focus:outline-none w-full sm:w-auto justify-center">
                    + Tambah
                </a>

                <div>
                    <select id="message_type" class="form-control js-example-basic-single w-full"
                        wire:model.live='messageType'>
                        <option value="sent">Terkirim</option>
                        <option value="received">Diterima</option>
                        <option value="all">Semua</option>
                    </select>
                </div>

            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        #</th>

                    @if ($messageType == 'received' || $messageType == 'all')
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            Pengirim</th>
                    @endif

                    @if ($messageType == 'sent' || $messageType == 'all')
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            Penerima Asli</th>
                    @endif

                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Diteruskan Oleh</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Penerima Forward</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Judul</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Deskripsi</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Waktu mulai</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Batas waktu</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Lampiran</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Bukti</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Aksi</th>
                </tr>
            </thead>

            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($followupCoordinations as $index => $followupCoordination)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            {{ $index + 1 }}
                        </td>

                        @if ($messageType == 'received' || $messageType == 'all')
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                <span
                                    class="px-2 py-1 bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-100 rounded-full text-xs">{{ $followupCoordination->sender->name }}</span>
                            </td>
                        @endif

                        @if ($messageType == 'sent' || $messageType == 'all')
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                <span
                                    class="px-2 py-1 bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 rounded-full text-xs">{{ $followupCoordination->receiver->name }}</span>
                            </td>
                        @endif

                        <!-- Diteruskan Oleh -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            @if ($followupCoordination->forwards->isNotEmpty())
                                @foreach ($followupCoordination->forwards->unique('forwarded_by') as $forward)
                                    <span
                                        class="px-2 py-1 bg-purple-100 dark:bg-purple-800 text-purple-800 dark:text-purple-100 rounded-full text-xs inline-block mb-1">{{ $forward->forwarder->name ?? '-' }}</span>
                                @endforeach
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <!-- Penerima Forward -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            @if ($followupCoordination->forwards->isNotEmpty())
                                @foreach ($followupCoordination->forwards as $forward)
                                    <span
                                        class="px-2 py-1 bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100 rounded-full text-xs inline-block mb-1">{{ $forward->receiver->name ?? '-' }}</span>
                                @endforeach
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            {{ $followupCoordination->coordination->title }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            <div class="truncate max-w-xs" title="{{ strip_tags($followupCoordination->description) }}">
                                {!! $followupCoordination->description !!}
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            {{ \Carbon\Carbon::parse($followupCoordination->coordination->start_time)->format('d-m-Y') }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            {{ \Carbon\Carbon::parse($followupCoordination->coordination->end_time)->format('d-m-Y') }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            @if ($followupCoordination->attachment)
                                <a href="{{ Storage::url($followupCoordination->attachment) }}" target="_blank"
                                    class="text-blue-600 dark:text-blue-400 underline">Lihat Lampiran</a>
                            @else
                                <span class="text-gray-400">Tidak Ada Lampiran</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            @if ($followupCoordination->proof)
                                <a href="{{ Storage::url($followupCoordination->proof) }}" target="_blank"
                                    class="text-blue-600 dark:text-blue-400 underline">Lihat Bukti</a>
                            @else
                                <span class="text-gray-400">Tidak Ada Bukti</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm flex gap-2">
                            @can('forward', $followupCoordination)
                                <a href="{{ route('forward.followupcoordination.form', $followupCoordination) }}"
                                    class="px-3 py-1 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition">
                                    Forward
                                </a>
                            @endcan

                            <a href="{{ route('followupcoordination.show', $followupCoordination) }}"
                                class="px-3 py-1 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">Show</a>

                            @can('update', $followupCoordination)
                                <a href="{{ route('followupcoordination.edit', $followupCoordination) }}"
                                    class="px-3 py-1 bg-yellow-600 text-white rounded-lg text-sm font-medium hover:bg-yellow-700 transition">Edit</a>
                            @endcan

                            @can('delete', $followupCoordination)
                                <form action="{{ route('followupcoordination.destroy', $followupCoordination) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus coordination ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition">Hapus</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    @php
                        $colspanNumber = $messageType == 'sent' || $messageType == 'received' ? 10 : 8;
                    @endphp
                    <tr>
                        <td colspan="{{ $colspanNumber }}" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            Data tindak lanjut koordinasi tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <!-- Pagination -->
    <div class="mt-4 flex justify-end">
        {{ $followupCoordinations->withQueryString()->links('vendor.pagination.tailwind') }}
    </div>
    @push('css')
        <style>
            td ol {
                list-style: decimal;
                padding-left: 1.5rem;
                /* biar agak masuk ke dalam */
            }

            td ul {
                list-style: disc;
                padding-left: 1.5rem;
            }
        </style>
    @endpush

</div>