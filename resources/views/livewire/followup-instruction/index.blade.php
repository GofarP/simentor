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
                    Tindak Lanjut Instruksi
                </p>
                <p class="text-gray-700 dark:text-gray-300 text-base md:text-lg">
                    Kelola Tindak Lanjut Instruksi.
                </p>
            </div>

            <div class="flex flex-col items-end gap-2">
                <input type="text" name="search" wire:model.live.debounce.500ms="search" placeholder="cari..."
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm
              focus:ring-2 focus:ring-violet-500 focus:border-violet-500
              dark:bg-gray-800 dark:text-gray-200" />

                <a href="{{ route('followupinstruction.create') }}"
                    class=" mt-3 inline-flex items-center px-4 py-2 bg-violet-600 text-white text-sm font-medium rounded-lg shadow hover:bg-violet-700 focus:outline-none w-full sm:w-auto justify-center">
                    + Tambah
                </a>

                @if($switch === 'followupInstructionMode')
                <div>
                    <select id="message_type" class="form-control js-example-basic-single w-full"
                        wire:model.live='messageType'>
                        <option value="sent">Terkirim</option>
                        <option value="received">Diterima</option>
                        <option value="all">Semua</option>
                    </select>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-x-auto">
        @if($switch === 'instructionMode')
            <!-- STATE 1: Instruction summary -->
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Jumlah Followup</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Detail</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($instructions as $index => $instruction)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $instruction->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ Str::limit(strip_tags($instruction->description), 50) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $instruction->followups_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                <button wire:click="switchClick({{ $instruction->id }})" 
                                    class="px-3 py-1 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Data instruction tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4 flex justify-end">
                {{ $instructions->links('vendor.pagination.tailwind') }}
            </div>
        @else
            <!-- STATE 2: Followup instruction detail -->
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th>#</th>
                        @if ($messageType == 'received' || $messageType == 'all')<th>Pengirim</th>@endif
                        @if ($messageType == 'sent' || $messageType == 'all')<th>Penerima Asli</th>@endif
                        <th>Diteruskan Oleh</th>
                        <th>Penerima Forward</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Waktu Mulai</th>
                        <th>Batas Waktu</th>
                        <th>Lampiran</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($followupInstructions as $index => $followupInstruction)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            @if ($messageType == 'received' || $messageType == 'all')
                                <td>{{ $followupInstruction->sender->name }}</td>
                            @endif
                            @if ($messageType == 'sent' || $messageType == 'all')
                                <td>{{ $followupInstruction->receiver->name }}</td>
                            @endif
                            <td>
                                @foreach($followupInstruction->forwards->unique('forwarded_by') as $forward)
                                    {{ $forward->forwarder->name ?? '-' }}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach($followupInstruction->forwards as $forward)
                                    {{ $forward->receiver->name ?? '-' }}<br>
                                @endforeach
                            </td>
                            <td>{{ $followupInstruction->instruction->title }}</td>
                            <td>{{ Str::limit(strip_tags($followupInstruction->description), 50) }}</td>
                            <td>{{ \Carbon\Carbon::parse($followupInstruction->instruction->start_time)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($followupInstruction->instruction->end_time)->format('d-m-Y') }}</td>
                            <td>
                                @if($followupInstruction->attachment)
                                    <a href="{{ Storage::url($followupInstruction->attachment) }}" target="_blank" class="text-blue-600 dark:text-blue-400 underline">Lihat Lampiran</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($followupInstruction->proof)
                                    <a href="{{ Storage::url($followupInstruction->proof) }}" target="_blank" class="text-blue-600 dark:text-blue-400 underline">Lihat Bukti</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('followupinstruction.show', $followupInstruction) }}" class="px-2 py-1 bg-blue-600 text-white rounded">Show</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">Data followup instruction tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4 flex justify-end">
                {{ $followupInstructions->withQueryString()->links('vendor.pagination.tailwind') }}
            </div>
            <div class="mt-4">
                <button wire:click="switchClick" class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700">Kembali</button>
            </div>
        @endif
    </div>
</div>
