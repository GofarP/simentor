<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-12 w-full mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen">

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8 w-full">
            <h2 class="text-2xl font-bold text-violet-600 mb-6">Teruskan Instruksi</h2>

            <form method="POST" action="{{ route('forwardinstruction.forwardinstruction', $instruction->id) }}">
                @csrf

                {{-- Penerima --}}
                <div class="mb-4">
                    <label for="forwarded_to" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Penerima
                    </label>
                    <select name="forwarded_to[]" id="forwarded_to"
                        class="form-control js-example-basic-single w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                        multiple="true">
                        <option value="">Pilih Penerima</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @if (in_array($user->id, old('forwarded_to', $forwardInstruction ?? []))) selected @endif>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('forwarded_to')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>


                {{-- Tombol --}}
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('instruction.index') }}"
                        class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition">Teruskan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- CSS & JS tetap sama seperti form create --}}
    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://unpkg.com/trix@2.1.0/dist/trix.css">
        <style>
            .select2-container--default .select2-selection--multiple {
                @apply bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm;
                padding: 0.5rem;
            }

            .select2-container--default .select2-selection--single {
                @apply bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm;
                height: 2.5rem;
            }

            .select2-container--default .select2-selection__rendered {
                line-height: 1.5rem;
            }

            .select2-container--default .select2-selection__arrow {
                height: 2.5rem;
            }
        </style>

    @endpush

    @push('js')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#forwarded_to').select2({
                    placeholder: "Pilih Penerima",
                    allowClear: true,
                    width: '100%',
                    theme: 'classic' // atau default, bootstrap4, dll sesuai kebutuhan
                });
            });
        </script>

    @endpush
</x-app-layout>