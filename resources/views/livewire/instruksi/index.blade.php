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
                    Instruksi
                </p>
                <p class="text-gray-700 dark:text-gray-300 text-base md:text-lg">
                    Kelola Instruksi.
                </p>
            </div>

            <div class="flex flex-col items-end gap-2">

                <input type="text" name="search" wire:model.live.debounce.500ms="search"
                    placeholder="Cari permission..."
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm
              focus:ring-2 focus:ring-violet-500 focus:border-violet-500
              dark:bg-gray-800 dark:text-gray-200" />

                <a href="{{ route('instruksi.create') }}"
                    class=" mt-3 inline-flex items-center px-4 py-2 bg-violet-600 text-white text-sm font-medium rounded-lg shadow hover:bg-violet-700 focus:outline-none w-full sm:w-auto justify-center">
                    + Tambah
                </a>

                <div>
                    <select id="jenis_pesan" class="form-control js-example-basic-single w-full" wire:model.live='jenisPesan'>
                        <option value="semua">Semua</option>
                        <option value="dikirim">Dikirim</option>
                        <option value="diterima">Diterima</option>
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
                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Pengirim</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Penerima</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Judul
                    </th>

                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Deskripsi
                    </th>

                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Waktu mulai
                    </th>

                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Batas waktu
                    </th>


                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Lampiran
                    </th>

                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Aksi
                    </th>


                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($instruksis as $index => $instruksi)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            {{ $instruksi->pengirim->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            {{ $instruksi->penerima->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            {{ $instruksi->judul }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            {!! $instruksi->deskripsi !!}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            {{ \Carbon\Carbon::parse($instruksi->waktu_mulai)->format('d-m-Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            {{ \Carbon\Carbon::parse($instruksi->batas_waktu)->format('d-m-Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            @if ($instruksi->lampiran != '')
                                <p>Ada lampiran</p>
                            @else
                                <p>Tidak Ada Lampiran</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm flex gap-2">
                            <a href="{{ route('instruksi.edit', $instruksi) }}"
                                class="px-3 py-1 bg-yellow-600 text-white rounded-lg text-sm font-medium hover:bg-yellow-700 transition">
                                Edit
                            </a>
                            <form action="{{ route('instruksi.destroy', $instruksi) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus instruksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            Data instruksi tidak ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 flex justify-end">
        {{ $instruksis->withQueryString()->links('vendor.pagination.tailwind') }}
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
