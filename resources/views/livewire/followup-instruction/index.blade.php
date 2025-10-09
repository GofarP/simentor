<div class="px-4 sm:px-6 lg:px-8 py-12 w-full max-w-7xl mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen">

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
            <input type="text" placeholder="Cari..." wire:model.debounce.500ms="search"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-violet-500 dark:bg-gray-800 dark:text-gray-200">

            @if ($switch === 'followupInstructionMode')
                <select wire:model="messageType" wire:change="showFollowups({{ $selectedInstructionId }})"
                    class="form-control w-full mt-2">
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
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Jumlah Followup
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($instructions as $index => $instruction)
                        <tr>
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $instruction->title }}</td>
                            <td class="px-6 py-4">
                                <div class="truncate max-w-xs" title="{{ strip_tags($instruction->description) }}">
                                    {!! $instruction->description !!}
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $instruction->followups_count }}</td>
                            <td class="px-6 py-4">
                                <button wire:click="showFollowups({{ $instruction->id }})"
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
        @elseif($switch === 'followupInstructionMode')
            <button wire:click="backToInstructions"
                class="mb-4 px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700">Kembali</button>

            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Pengirim</th>
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
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $f->sender->name ?? '-' }}</td>
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
                                    <a href="{{ Storage::url($f->attachment) }}" target="_blank">Lihat Lampiran</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($f->proof)
                                    <a href="{{ Storage::url($f->proof) }}" target="_blank">Lihat Bukti</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                @can('forward', $f)
                                    <a href="{{ route('forward.followupinstruction.form', $f) }}"
                                        class="px-3 py-1 bg-purple-600 text-white rounded-lg hover:bg-purple-700">Forward</a>
                                @endcan
                                <a href="{{ route('followupinstruction.show', $f) }}"
                                    class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Show</a>
                                @can('update', $f)
                                    <a href="{{ route('followupinstruction.edit', $f) }}"
                                        class="px-3 py-1 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">Edit</a>
                                @endcan
                                @can('delete', $f)
                                    <form action="{{ route('followupinstruction.destroy', $f) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus instruction ini?')">
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
        @endif
    </div>

</div>
