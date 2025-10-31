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
                Tindak Lanjut Instruksi
            </p>
            <p class="text-gray-700 dark:text-gray-300 text-base md:text-lg">
                Kelola Tindak Lanjut Instruksi.
            </p>
        </div>

        <div class="flex flex-col items-end gap-2">
            <input type="text" placeholder="Cari..." wire:model.live.debounce.500ms="search"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-violet-500 dark:bg-gray-800 dark:text-gray-200">
            @if ($switch === 'followupInstructionMode')
                <select wire:model.live="messageType" class="form-control w-full mt-2">
                    <option value="sent">Terkirim</option>
                    <option value="received">Diterima</option>
                    <option value="all">Semua</option>
                </select>
            @endif
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-x-auto">

        {{-- Instruction Mode --}}
        @if ($switch === 'instructionMode')
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Waktu Mulai</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Waktu Selesai
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Jumlah Tindak
                            Lanjut
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($instructions as $index => $instruction)
                        <tr>
                            <td class="px-6 py-4">{{ $instructions->firstItem() + $index }}</td>
                            <td class="px-6 py-4">{{ $instruction->title }}</td>
                            <td class="px-6 py-4">
                                <div class="truncate max-w-xs" title="{{ strip_tags($instruction->description) }}">
                                    {!! $instruction->description !!}
                                </div>
                            </td>
                            <td>
                                {{ optional($instruction)->start_time ? \Carbon\Carbon::parse($instruction->start_time)->format('d-m-Y') : '-' }}
                            </td>
                            <td>
                                {{ optional($instruction)->end_time ? \Carbon\Carbon::parse($instruction->end_time)->format('d-m-Y') : '-' }}
                            </td>
                            <td class="text-center align-middle">

                                @if ($instruction->is_expired)
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">
                                        Waktu habis
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                                        Berlangsung
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $instruction->is_sender || Auth::user()->roles->first()?->name === 'kasubbag'
                                    ? $instruction->total_followups_count ?? 0
                                    : $instruction->user_followups_count ?? 0 }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">

                                    @if ($instruction->is_expired && $instruction->is_sender)
                                        <a href="{{ route('instruction.edit', $instruction->id) }}"
                                            class="px-3 py-1 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">Edit</a>
                                    @endif
                                    <button wire:click="showFollowups({{ $instruction->id }})"
                                        class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                        Detail
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="my-4 mx-4">
                {{ $instructions->links() }}
            </div>

            {{-- FollowupInstruction Mode --}}
        @elseif($switch === 'followupInstructionMode')
            <div class="flex justify-between items-center mb-4 mt-3 px-3">
                <button wire:click="backToInstructions"
                    class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Kembali
                </button>


                <div class="flex gap-2">
                    @if (Auth::id() === $instruction->instruction_sender_id && $instruction->is_expired)
                        <a href="{{ route('instruction.edit', $instruction->id) }}"
                            class="px-3 py-1 bg-yellow-400 text-white rounded-lg">
                            Perpanjang Waktu
                        </a>
                    @endif

                    @if (Auth::id() !== $receiverId && !in_array(Auth::id(), $forwardedTo))
                        @if ($instruction->is_expired)
                            <button class="px-3 py-1 bg-gray-400 text-white rounded-lg cursor-not-allowed" disabled>
                                Waktu habis
                            </button>
                        @else
                            <button wire:click="goToCreate"
                                class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
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

                        @if ($messageType == 'received' || $messageType == 'all')
                            <th class="px-6 py-3">Pengirim</th>
                        @endif
                        @if ($messageType == 'sent' || $messageType == 'all')
                            <th class="px-6 py-3">Penerima</th>
                        @endif

                        <th class="px-6 py-3">Diteruskan Oleh</th>
                        <th class="px-6 py-3">Penerima Forward</th>
                        <th class="px-6 py-3">Judul</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">Waktu Mulai</th>
                        <th class="px-6 py-3">Batas Waktu</th>
                        <th class="px-6 py-3">Lampiran</th>
                        <th class="px-6 py-3">Bukti</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($followupInstructions as $index => $f)
                        <tr>
                            <td class="px-6 py-4">{{ $followupInstructions->firstItem() + $index }}</td>

                            {{-- Tampilkan kolom dinamis berdasarkan jenis pesan --}}
                            @if ($messageType === 'received' || $messageType == 'all')
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-100 rounded-full text-xs inline-block mb-1">
                                        {{ $f->sender->name ?? '-' }}
                                    </span>
                                </td>
                            @endif
                            @if ($messageType === 'sent' || $messageType == 'all')
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 rounded-full text-xs inline-block mb-1">
                                        {{ $f->receiver->name ?? '-' }}
                                    </span>
                                </td>
                            @endif

                            <td class="px-6 py-4">
                                @if ($f->forwards->isNotEmpty())
                                    <span
                                        class="px-2 py-1 bg-purple-100 dark:bg-purple-800 text-purple-800 dark:text-purple-100 rounded-full text-xs inline-block mb-1">
                                        {{ $f->forwards->unique('forwarded_by')->pluck('forwarder.name')->join(', ') }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if ($f->forwards->isNotEmpty())
                                    <span
                                        class="px-2 py-1 bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100 rounded-full text-xs inline-block mb-1">
                                        {{ $f->forwards->pluck('receiver.name')->join(', ') }}
                                    </span>
                                @endif
                            </td>


                            <td class="px-6 py-4">{{ $f->instruction->title ?? '-' }}</td>
                            <td class="px-6 py-4">{!! $f->description !!}</td>

                            <td class="px-6 py-4">
                                {{ optional($f->instruction)->start_time ? \Carbon\Carbon::parse($f->instruction->start_time)->format('d-m-Y') : '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ optional($f->instruction)->end_time ? \Carbon\Carbon::parse($f->instruction->end_time)->format('d-m-Y') : '-' }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($f->attachment)
                                    <a class="text-blue-600 text-underline" href="{{ Storage::url($f->attachment) }}"
                                        target="_blank">Lihat
                                        Lampiran</a>
                                @else
                                    Tidak ada lampiran
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if ($f->proof)
                                    <a class="text-blue-600 text-underline" href="{{ Storage::url($f->proof) }}"
                                        target="_blank">Lihat Bukti</a>
                                @else
                                    Tidak ada bukti
                                @endif
                            </td>

                            <td class="px-6 py-4 flex gap-2">
                                @can('forward', $f)
                                    <a href="{{ route('forward.followupinstruction.form', $f) }}"
                                        class="px-3 py-1 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                                        Forward
                                    </a>
                                @endcan
                                @can('view', $f)
                                    <a href="{{ route('followupinstruction.show', $f) }}"
                                        class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                        Show
                                    </a>
                                @endcan
                                @can('update', $f)
                                    <a href="{{ route('followupinstruction.edit', $f) }}"
                                        class="px-3 py-1 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                                        Edit
                                    </a>
                                @endcan
                                @can('delete', $f)
                                    <form action="{{ route('followupinstruction.destroy', $f) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus followup ini?')">
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
                            <td colspan="11" class="px-6 py-4 text-center text-gray-500">Tidak ada data followup
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mb-3">
                {{ $followupInstructions->links() }}
            </div>
        @endif
    </div>

</div>
