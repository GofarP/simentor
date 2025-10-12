<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-12 w-full mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen">

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8 w-full">
            <h2 class="text-2xl font-bold text-violet-600 mb-6">Tambah Penilaian</h2>

            <form method="POST" action="{{ route('followupinstructionscore.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="followup_instruction_id"
                        class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Nama Permission</label>
                    <select class="js-example-basic-single">
                        @foreach ($followupInstructions as $followupInstruction)
                            <option value="{{ $followupInstruction->instruction->id }}" {{  $followupInstruction->instruction->id === $followupInstructionId}}>
                                {{ $followupInstruction->instruction->title }}</option>
                        @endforeach
                    </select>
                    @error('followup_instruction_id')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="score" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Nilai</label>
                    <select name="score" id="score" class="js-example-basic-single">
                        <option value="1">Baik</option>
                        <option value="0">Buruk</option>
                    </select>
                    @error('score')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="comment"
                        class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Comment</label>

                    <input id="comment" type="hidden" name="comment"
                        value="{{ old('comment', $data-> ?? '') }}">
                    <trix-editor input="comment" class="border rounded-lg"></trix-editor>

                    @error('comment')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('followupinstructionscore.index') }}"
                        class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition">Simpan</button>
                </div>
            </form>
        </div>

    </div>

</x-app-layout>
