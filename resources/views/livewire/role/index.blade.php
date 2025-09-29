<div class="px-4 sm:px-6 lg:px-8 py-12 w-full max-w-7xl mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen">

    <!-- Flash Message -->
    @if (session('success'))
        <div
            class="mb-4 px-4 py-3 rounded-lg bg-green-100 border border-green-300 text-green-800 dark:bg-green-800 dark:text-green-100 dark:border-green-700">
            {{ session('success') }}
        </div>
    @endif

    <!-- Header + tombol + search -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2">
            <!-- Judul -->
            <div>
                <p class="text-3xl md:text-4xl font-extrabold text-violet-600 mb-2">
                    Role
                </p>
                <p class="text-gray-700 dark:text-gray-300 text-base md:text-lg">
                    Kelola role pengguna.
                </p>
            </div>

            <!-- Tombol + Search -->
            <div class="flex flex-col items-end gap-2">
                <!-- Search di bawah tombol -->
                <input type="text" name="search" wire:model.live.debounce.500ms="search" value="{{ request('search') }}"
                    placeholder="Cari role..." class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm
                              focus:ring-2 focus:ring-violet-500 focus:border-violet-500
                              dark:bg-gray-800 dark:text-gray-200" />

                <!-- Tombol Tambah -->
                <a href="{{ route('role.create') }}"
                    class=" mt-3 inline-flex items-center px-4 py-2 bg-violet-600 text-white text-sm font-medium rounded-lg shadow hover:bg-violet-700 focus:outline-none w-full sm:w-auto justify-center">
                    + Tambah Role
                </a>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        #</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Nama Role</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Permission</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($roles as $index => $role)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            {{ $role->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-normal text-sm text-gray-800 dark:text-gray-200">
                            @if($role->permissions->isNotEmpty())
                                <div class="grid grid-cols-5 gap-1">
                                    @foreach($role->permissions as $permission)
                                        <span class="px-2 py-1 text-xs font-medium text-center text-white bg-violet-500 rounded-full truncate">
                                            {{ $permission->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-400 dark:text-gray-500">Tidak ada permission</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm flex gap-2">
                            <a href="{{ route('role.edit', $role) }}"
                                class="px-3 py-1 bg-yellow-600 text-white rounded-lg text-sm font-medium hover:bg-yellow-700 transition">
                                Edit
                            </a>
                            <form action="{{ route('role.destroy', $role) }}" method="POST">
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
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            Data role tidak ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 flex justify-end">
        {{ $roles->withQueryString()->links('vendor.pagination.tailwind') }}
    </div>

</div>