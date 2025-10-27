<div class="px-4 sm:px-6 lg:px-8 py-12 w-full max-w-7xl mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen">

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div
            class="mb-4 px-4 py-3 rounded-lg bg-green-100 border border-green-300 text-green-800 dark:bg-green-800 dark:text-green-100 dark:border-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2">
        <div>
            <p class="text-3xl md:text-4xl font-extrabold text-violet-600 mb-2">Koordinasi</p>
            <p class="text-gray-700 dark:text-gray-300 text-base md:text-lg">Kelola Koordinasi.</p>
        </div>

        <div class="flex flex-col items-end gap-2 w-full sm:w-auto">
            <input type="text" name="search" wire:model.live.debounce.500ms="search" placeholder="Cari koordinasi..."
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:ring-2 focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-800 dark:text-gray-200" />

            <a href="{{ route('coordination.create', ['messageType' => $messageType]) }}"
                class="mt-3 inline-flex items-center px-4 py-2 bg-violet-600 text-white text-sm font-medium rounded-lg shadow hover:bg-violet-700 focus:outline-none w-full sm:w-auto justify-center">
                + Tambah
            </a>

            <select id="message_type" class="form-control js-example-basic-single w-full mt-2"
                wire:model.live='messageType'>
                <option value="sent">Terkirim</option>
                <option value="received">Diterima</option>
                <option value="all">Semua</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
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
                            Penerima</th>
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
                        Waktu Mulai</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Batas Waktu</th>

                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Status</th>


                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Lampiran</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Aksi</th>
                </tr>
            </thead>

            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($coordinations as $coordination)
                    <tr>
                        {{-- Index --}}
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $loop->iteration }}</td>

                        {{-- Pengirim --}}
                        @if ($messageType == 'received' || $messageType == 'all')
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                <span
                                    class="px-2 py-1 bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-100 rounded-full text-xs">
                                    {{ $coordination->senders->first()->name ?? '-' }}
                                </span>
                            </td>
                        @endif

                        {{-- Penerima --}}
                        @if ($messageType == 'sent' || $messageType == 'all')
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                @forelse ($coordination->receivers ?? [] as $receiver)
                                    <span
                                        class="px-2 py-1 bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 rounded-full text-xs inline-block mb-1">
                                        {{ $receiver->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-400">-</span>
                                @endforelse
                            </td>
                        @endif

                        {{-- Diteruskan Oleh --}}
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                            @forelse ($coordination->forwards->unique('forwarded_by') ?? [] as $forward)
                                <span
                                    class="px-2 py-1 bg-purple-100 dark:bg-purple-800 text-purple-800 dark:text-purple-100 rounded-full text-xs inline-block mb-1">
                                    {{ $forward->forwarder->name ?? '-' }}
                                </span>
                            @empty
                                <span class="text-gray-400">-</span>
                            @endforelse
                        </td>

                        {{-- Penerima Forward --}}
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                            @forelse ($coordination->forwards ?? [] as $forward)
                                <span
                                    class="px-2 py-1 bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100 rounded-full text-xs inline-block mb-1">
                                    {{ $forward->receiver->name ?? '-' }}
                                </span>
                            @empty
                                <span class="text-gray-400">-</span>
                            @endforelse
                        </td>

                        {{-- Judul & Deskripsi --}}
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $coordination->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                            <div class="truncate max-w-xs" title="{{ strip_tags($coordination->description) }}">
                                {!! $coordination->description !!}
                            </div>
                        </td>

                        {{-- Waktu --}}
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                            {{ \Carbon\Carbon::parse($coordination->start_time)->format('d-m-Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                            {{ \Carbon\Carbon::parse($coordination->end_time)->format('d-m-Y') }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-800">
                            <span @class([
                                'inline-flex items-center px-3 py-1 text-xs text-center font-medium rounded-full',
                                'text-red-800 bg-red-100 dark:bg-red-900 dark:text-red-300' => $coordination->is_expired,
                                'text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-300' => !$coordination->is_expired,
                            ])>
                                {{ $coordination->is_expired ? 'Waktu habis' : 'Berlangsung' }}
                            </span>

                            {{-- Lampiran --}}
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                            @if ($coordination->attachment)
                                <a href="{{ Storage::url($coordination->attachment) }}" target="_blank"
                                    class="text-blue-600 dark:text-blue-400 underline">Lihat</a>
                            @else
                                <span class="text-gray-400">Tidak ada</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4 text-sm flex gap-2">
                            @can('forward', $coordination)
                                @if ($coordination->is_expired)
                                    <button type="button"
                                        class="px-3 py-1 bg-gray-400 text-white rounded-lg text-sm font-medium cursor-not-allowed"
                                        disabled>
                                        Forward
                                    </button>
                                @else
                                    <a href="{{ route('forward.coordination.form', $coordination) }}"
                                        class="px-3 py-1 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition">Forward</a>

                                @endif
                            @endcan

                            <a href="{{ route('coordination.show', $coordination) }}"
                                class="px-3 py-1 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">Show</a>

                            @can('update', $coordination)
                                <a href="{{ route('coordination.edit', ['coordination' => $coordination, 'messageType' => $messageType]) }}"
                                    class="px-3 py-1 bg-yellow-600 text-white rounded-lg text-sm font-medium hover:bg-yellow-700 transition">Edit</a>
                            @endcan

                            @can('delete', $coordination)
                                <form
                                    action="{{ route('coordination.destroy', ['coordination' => $coordination, 'messageType' => $messageType]) }}"
                                    method="POST"
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
                    <tr>
                        <td colspan="11" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            Data coordination tidak ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4 flex justify-end">
        {{ $coordinations->links() }}
    </div>
</div>