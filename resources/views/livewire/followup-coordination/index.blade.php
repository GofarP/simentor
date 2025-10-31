<div class="px-4 sm:px-6 lg:px-8 py-12 w-full max-w-7xl mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen">
    @if (session('success'))
        <div
            class="mb-4 px-4 py-3 rounded-lg bg-green-100 border border-green-300 text-green-800 dark:bg-green-800 dark:text-green-100 dark:border-green-700">
            {{ session('success') }}
        </div>
    @endif
    {{-- Header --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2">
        <div>
            <p class="text-3xl md:text-4xl font-extrabold text-violet-600 mb-2">
                Tindak Lanjut Koordinasi
            </p>
            <p class="text-gray-700 dark:text-gray-300 text-base md:text-lg">
                Kelola Tindak Lanjut Koordinasi.
            </p>
        </div>

        <div class="flex flex-col items-end gap-2">
            <input type="text" placeholder="Cari..." wire:model.live.debounce.500ms="search"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-violet-500 dark:bg-gray-800 dark:text-gray-200">
            @if ($switch === 'followupCoordinationMode')
                <select wire:model.live="messageType" class="form-control w-full mt-2">
                    <option value="sent">Terkirim</option>
                    <option value="received">Diterima</option>
                    <option value="all">Semua</option>
                </select>
            @endif
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-x-auto">

        {{-- Coordinatioin Mode --}}
        @if ($switch === 'coordinationMode')
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Jumlah Tindak
                            Lanjut
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($coordinations as $index => $coordination)
                            <tr>
                                <td class="px-6 py-4">{{ $coordinations->firstItem() + $index }}</td>
                                <td class="px-6 py-4">{{ $coordination->title }}</td>
                                <td class="px-6 py-4">
                                    <div class="truncate max-w-xs" title="{{ strip_tags($coordination->description) }}">
                                        {!! $coordination->description !!}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $coordination->is_sender || Auth::user()->roles->first()?->name === 'kasubbag'
                        ? $coordination->total_followups_count ?? 0
                        : $coordination->user_followups_count ?? 0 }}
                                </td>

                                <td class="px-6 py-4">
                                    <button wire:click="showFollowups({{ $coordination->id }})"
                                        class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="my-4 mx-4">
                {{ $coordinations->links() }}
            </div>

            {{-- FollowupCoordination Mode --}}
        @elseif($switch === 'followupCoordinationMode')
            <div class="flex justify-between items-center mb-4 mt-3 px-3">
                <!-- Tombol kiri -->
                <button wire:click="backToCoordinations"
                    class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Kembali
                </button>
                <div class="flex gap-2">
                    @if (Auth::id() === $coordination->coordination_sender_id && $coordination->is_expired)
                        <a href="{{ route('coordination.edit', $coordination->id) }}"
                            class="px-3 py-1 bg-yellow-400 text-white rounded-lg">
                            Perpanjang Waktu
                        </a>
                    @endif

                    @if (Auth::id() !== $receiverId && !in_array(Auth::id(), $forwardedTo))
                        @if ($coordination->is_expired)
                            <button class="px-3 py-1 bg-gray-400 text-white rounded-lg cursor-not-allowed" disabled>
                                Waktu habis
                            </button>
                        @else
                            <button wire:click="goToCreate" class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Tambah Aksi
                            </button>
                        @endif
                    @endif
                </div>
            </div>

            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3">#</th>

                        {{-- THEAD Anda (Sudah Benar) --}}
                        @if ($messageType === 'received' || $messageType === 'all')
                            <th class="px-6 py-3">Pengirim</th>
                        @endif
                        @if ($messageType === 'sent' || $messageType === 'all')
                            <th class="px-6 py-3">Penerima</th>
                        @endif

                        <th class="px-6 py-3">Diteruskan Oleh</th>
                        <th class="px-6 py-3">Penerima Forward</th>
                        <th class="px-6 py-3">Judul</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">Waktu Mulai</th>
                        <th class="px-6 py-3">Batas Waktu</th>
                        <th class="px-6 py-3">Lampiran</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($followupCoordinations as $index => $f)
                        <tr>
                            <td class="px-6 py-4">{{ $followupCoordinations->firstItem() + $index }}</td>

                            @if ($messageType === 'received' || $messageType === 'all')
                                <td class="px-6 py-4">{{ $f->sender->name ?? '-' }}</td>
                            @endif
                            @if ($messageType === 'sent' || $messageType === 'all')
                                <td class="px-6 py-4">{{ $f->receiver->name ?? '-' }}</td>
                            @endif

                            <td class="px-6 py-4">
                                @foreach ($f->forwards->unique('forwarded_by') as $forward)
                                    {{ $forward->forwarder->name ?? '-' }}
                                @endforeach
                            </td>

                            <td class="px-6 py-4">
                                @foreach ($f->forwards as $forward)
                                    {{ $forward->receiver->name ?? '-' }}
                                @endforeach
                            </td>

                            <td class="px-6 py-4">{{ $f->coordination->title ?? '-' }}</td>
                            <td class="px-6 py-4">{!! $f->description !!}</td>
                            <td class="px-6 py-4">
                                {{ optional($f->coordination)->start_time ? \Carbon\Carbon::parse($f->coordination->start_time)->format('d-m-Y') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ optional($f->coordination)->end_time ? \Carbon\Carbon::parse($f->coordination->end_time)->format('d-m-Y') : '-' }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($f->attachment)
                                    <a class="text-blue-600 text-underline" href="{{ Storage::url($f->attachment) }}"
                                        target="_blank">Lihat Lampiran</a>
                                @else
                                    Tidak ada lampiran
                                @endif
                            </td>

                            <td class="px-6 py-4 flex gap-2">
                                {{-- Tombol Aksi Anda (sudah benar) --}}
                                @can('forward', $f)
                                    <a href="{{ route('forward.followupcoordination.form', $f) }}"
                                        class="px-3 py-1 bg-purple-600 text-white rounded-lg hover:bg-purple-700">Forward</a>
                                @endcan
                                @can('view', $f)
                                    <a href="{{ route('followupcoordination.show', $f) }}"
                                        class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Show</a>
                                @endcan
                                @can('update', $f)
                                    <a href="{{ route('followupcoordination.edit', $f) }}"
                                        class="px-3 py-1 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">Edit</a>
                                @endcan
                                @can('delete', $f)
                                    <form action="{{ route('followupcoordination.destroy', $f) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus coordination ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700">Hapus</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-6 py-4 text-center text-gray-500">Tidak ada data followup</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>


            <div class="mb-3">
                {{ $followupCoordinations->links() }}
            </div>
        @endif
    </div>

</div>