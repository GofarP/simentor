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

            <div class="my-4 mx-4">
                {{ $instructions->links() }}
            </div>

            {{-- FollowupInstruction Mode --}}
        @elseif($switch === 'followupInstructionScoreMode')
            <div class="flex justify-between items-center mb-4 mt-3 px-3">
                <button wire:click="backToInstructions"
                    class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Kembali
                </button>

                @if (Auth::user()->id !== optional($followupInstructionScores->first()?->followupInstruction)->receiver_id)
                    <button wire:click="goToCreate"
                        class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Tambah Followup
                    </button>
                @endif
            </div>

            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Pengirim</th>
                        <th class="px-6 py-3">Judul Instruksi</th>
                        <th class="px-6 py-3">Deskripsi Instruksi</th>
                        <th class="px-6 py-3">Nilai</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($followupInstructionScores as $index => $score)
                        <tr>
                            <td class="px-6 py-4">{{ $followupInstructionScores->firstItem() + $index }}</td>

                            <td class="px-6 py-4">
                                {{ $score->followupInstruction->sender->name ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $score->followupInstruction->instruction->title ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {!! $score->followupInstruction->instruction->description ?? '-' !!}
                            </td>

                            <td class="px-6 py-4 font-semibold">
                                {{ $score->score ?? '-' }}
                            </td>

                            <td class="px-6 py-4 flex gap-2">
                                <a href="#" class="px-3 py-1 bg-purple-600 text-white  hover:bg-purple-700">
                                    Forward
                                </a>
                                <a href="#" class="px-3 py-1 bg-yellow-600 text-white  hover:bg-yellow-700">
                                    Edit
                                </a>
                                <a href="#" class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                    Hapus
                                </a>
                                {{-- <button wire:click="deleteScore({{ $score->id }})"
                                    class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                    Hapus
                                </button> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data nilai followup
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mb-3">
                {{ $followupInstructionScores->links() }}
            </div>
        @endif


    </div>

</div>
