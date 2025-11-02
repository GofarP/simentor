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
                Nilai Tindak Lanjut Instruksi
            </p>
            <p class="text-gray-700 dark:text-gray-300 text-base md:text-lg">
                Kelola Nilai Tindak Lanjut Instruksi.
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
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Batas Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Jumlah Tindak
                            Lanjut
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nilai Instruksi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Komentar</th>

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
                                <td class="px-6 py-4">
                                    {{ $instruction->start_time->format('d-m-Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ optional($instruction->end_time)->format('d-m-Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($instruction->is_expired)
                                        <span
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full dark:bg-red-900 dark:text-red-300">
                                            Waktu habis
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">
                                            Berlangsung
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    {{ $instruction->sender_id === Auth::id()
                        ? $instruction->total_followups_count ?? 0
                        : $instruction->user_followups_count ?? 0 }}
                                </td>

                                @php
                                    $scoreModel = $instruction->instructionScore->first();
                                    $instructionScoreId = $scoreModel->id ?? null;
                                    $scoreValue = $scoreModel->score ?? 'Tidak Diberi Nilai';
                                    $comment = $scoreModel->comment ?? 'Tidak ada komentar';
                                @endphp

                                <td class="text-center">
                                    @if ($scoreModel && $scoreValue === 1)
                                        <img src="{{ asset('images/thumbsup.svg') }}" alt="thumbs up" class="w-6 h-6 mx-auto">
                                    @elseif($scoreModel && $scoreValue === 0)
                                        <img src="{{ asset('images/thumbsdown.svg') }}" alt="thumbs up" class="w-6 h-6 mx-auto">
                                    @else
                                        {{ $scoreValue }}
                                    @endif
                                </td>
                                <td>
                                    {!! $comment !!}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">

                                        @if ($instruction->is_expired)

                                            @if ($instruction->total_followups_count == 0)


                                                @if ($scoreModel)
                                                    <a href="{{ route('instructionscore.edit', $instructionScoreId)}}"
                                                        class="w-32 justify-center px-3 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                                                        Edit Penilaian
                                                    </a>
                                                @else
                                                    <button wire:click='giveScoreToInstruction({{ $instruction->id }})'
                                                        class="w-32 justify-center px-3 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                                                        Beri Penilaian
                                                    </button>
                                                @endif

                                            @endif
                                        @endif

                                        {{-- Tombol Detail selalu tampil --}}
                                        <button wire:click="showFollowups({{ $instruction->id }})"
                                            class="w-32 justify-center px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
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
        @elseif($switch === 'followupInstructionScoreMode')
            <div class="flex justify-between items-center mb-4 mt-3 px-3">
                <button wire:click="backToInstructions" class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Kembali
                </button>

            </div>

            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">#</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Pengirim</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Judul Instruksi</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Deskripsi Instruksi</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Komentar Penilaian</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Nilai</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                        @forelse($followupInstructions as $index => $followup)
                            @php
                                $instruction = $followup->instruction ?? null;
                                $sender = $followup->sender ?? null;
                                $scoreModel = $followup->followupInstructionScore()->latest()->first();
                                $scoreValue = optional($scoreModel)->score;
                            @endphp

                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $followupInstructions->firstItem() + $index }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $sender->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $instruction->title ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                    {!! $followup->description ?? '-' !!}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                                    {!! $scoreModel->comment ?? '-' !!}
                                </td>


                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-gray-100 text-center">
                                    @if ($scoreModel && $scoreModel->score === 1)
                                        <img src="{{ asset('images/thumbsup.svg') }}" alt="thumbs up" class="w-6 h-6 mx-auto">
                                    @elseif ($scoreModel && $scoreModel->score === 0)
                                        <img src="{{ asset('images/thumbsdown.svg') }}" alt="thumbs down" class="w-6 h-6 mx-auto">
                                    @else
                                        <p class="text-gray-500 dark:text-gray-400">Belum diberi nilai</p>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex flex-wrap sm:flex-nowrap gap-2">
                                        {{-- Tombol Show --}}
                                        <a href="{{ route('followupinstruction.show', $followup->id) }}" target="_blank"
                                            class="flex-1 sm:flex-none px-3 py-2 bg-blue-600 text-white rounded-lg text-center hover:bg-blue-700 transition">
                                            Show
                                        </a>

                                        {{-- Jika sudah ada score --}}
                                        @if ($scoreModel)
                                            @can('update',$scoreModel->followupInstruction )
                                                <a href="{{ route('followupinstructionscore.edit', $scoreModel->id) }}"
                                                    class="flex-1 sm:flex-none px-3 py-2 bg-purple-600 text-white rounded-lg text-center hover:bg-purple-700 transition">
                                                    Edit Penilaian
                                                </a>
                                            @endcan
                                        @else
                                            @can('create', $followup)
                                                <button wire:click="giveScoreToFollowupInstruction({{ $followup->id }})"
                                                    class="flex-1 sm:flex-none px-3 py-2 bg-purple-600 text-white rounded-lg text-center hover:bg-purple-700 transition">
                                                    Beri Penilaian
                                                </button>
                                            @endcan
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data nilai
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 px-3">
                {{ $followupInstructions->links() }}
            </div>
        @endif


    </div>

</div>