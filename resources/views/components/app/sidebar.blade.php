<div class="min-w-fit">
    <!-- Sidebar backdrop (mobile only) -->
    <div class="fixed inset-0 bg-gray-900/30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>

    <!-- Sidebar -->
    <div id="sidebar"
        class="flex lg:flex! flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-[100dvh] overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:w-64! shrink-0 bg-white dark:bg-gray-800 p-4 transition-all duration-200 ease-in-out {{ $variant === 'v2' ? 'border-r border-gray-200 dark:border-gray-700/60' : 'rounded-r-2xl shadow-xs' }}"
        :class="sidebarOpen ? 'max-lg:translate-x-0' : 'max-lg:-translate-x-64'" @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false">

        <!-- Sidebar header -->
        <div class="flex justify-between mb-10 pr-3 sm:px-2">
            <!-- Close button -->
            <button class="lg:hidden text-gray-500 hover:text-gray-400" @click.stop="sidebarOpen = !sidebarOpen"
                aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <!-- Logo -->
            <a class="block" href="{{ route('dashboard') }}">
                <svg class="fill-violet-500" xmlns="http://www.w3.org/2000/svg" width="32" height="32">
                    <path
                        d="M31.956 14.8C31.372 6.92 25.08.628 17.2.044V5.76a9.04 9.04 0 0 0 9.04 9.04h5.716ZM14.8 26.24v5.716C6.92 31.372.63 25.08.044 17.2H5.76a9.04 9.04 0 0 1 9.04 9.04Zm11.44-9.04h5.716c-.584 7.88-6.876 14.172-14.756 14.756V26.24a9.04 9.04 0 0 1 9.04-9.04ZM.044 14.8C.63 6.92 6.92.628 14.8.044V5.76a9.04 9.04 0 0 1-9.04 9.04H.044Z" />
                </svg>
            </a>
        </div>

        <!-- Links -->
        <div class="space-y-8">
            <!-- Pages group -->
            <div>
                <h3 class="text-xs uppercase text-gray-400 dark:text-gray-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                        aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Pages</span>
                </h3>
                <ul class="mt-3">
                    <!-- Dashboard -->
                    <li
                        class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(1), ['inbox'])) {{ 'from-violet-500/[0.12] dark:from-violet-500/[0.24] to-violet-500/[0.04]' }} @endif">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['inbox'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                            href="{{ route('dashboard') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current @if (in_array(Request::segment(1), ['dashboard'])) {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M5.936.278A7.983 7.983 0 0 1 8 0a8 8 0 1 1-8 8c0-.722.104-1.413.278-2.064a1 1 0 1 1 1.932.516A5.99 5.99 0 0 0 2 8a6 6 0 1 0 6-6c-.53 0-1.045.076-1.548.21A1 1 0 1 1 5.936.278Z" />
                                    <path
                                        d="M6.068 7.482A2.003 2.003 0 0 0 8 10a2 2 0 1 0-.518-3.932L3.707 2.293a1 1 0 0 0-1.414 1.414l3.775 3.775Z" />
                                </svg>
                                <span
                                    class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dashboard</span>
                            </div>
                        </a>
                    </li>

                    <!-- Coordination -->
                    @can('view.coordination')
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(1), ['coordination'])) {{ 'from-violet-500/[0.12] dark:from-violet-500/[0.24] to-violet-500/[0.04]' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['koordinasi']) ? 1 : 0 }} }">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['coordination'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="#0" @click.prevent="open = !open; sidebarExpanded = true">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0 fill-current" width="16"
                                            height="16" viewBox="0 0 24 24">
                                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3
                                                                1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34
                                                                2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3
                                                                3zm0 2c-2.33 0-7 1.17-7
                                                                3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8
                                                                0c-.29 0-.62.02-.97.05 1.16.84 1.97
                                                                2.06 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                                        </svg>

                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Koordinasi</span>
                                    </div>
                                    <!-- Icon -->
                                    <div
                                        class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500 @if (in_array(Request::segment(1), ['koordinasi'])) {{ 'rotate-180' }} @endif"
                                            :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1 @if (!in_array(Request::segment(1), ['koordinasi'])) {{ 'hidden' }} @endif"
                                    :class="open ? 'block!' : 'hidden'">
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate "
                                            href="{{ route('coordination.index') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                Koordinasi
                                            </span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                    @endcan

                    @can('view.instruction')
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r
                        @if (in_array(Request::segment(1), ['instruction'])) from-violet-500/[0.12] dark:from-violet-500/[0.24] to-violet-500/[0.04] @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['instruction']) ? 'true' : 'false' }} }">

                            <!-- Parent link -->
                            <a href="#0" @click.prevent="open = !open; sidebarExpanded = true"
                                class="block text-gray-800 dark:text-gray-100 truncate transition
                                @if (!in_array(Request::segment(1), ['instruction'])) hover:text-gray-900 dark:hover:text-white @endif">
                                <div class="flex items-center justify-between">
                                    <!-- Icon + label -->
                                    <div class="flex items-center">
                                        <!-- Ikon pensil -->
                                        <svg class="shrink-0 stroke-current
                                            @if (in_array(Request::segment(1), ['instruction'])) text-violet-500
                                            @else
                                                text-gray-400 dark:text-gray-500 @endif"
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9" />
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Instruksi
                                        </span>
                                    </div>

                                    <!-- Chevron -->
                                    <div
                                        class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500 transition-transform"
                                            :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>

                            <!-- Submenu -->
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1" :class="open ? 'block' : 'hidden'">
                                    <li class="mb-1 last:mb-0">
                                        <a href="{{ route('instruction.index') }}"
                                            class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                Instruksi
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r
                        @if (in_array(Request::segment(1), ['respon'])) from-violet-500/[0.12] dark:from-violet-500/[0.24] to-violet-500/[0.04] @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['respon']) ? 'true' : 'false' }} }">

                            <!-- Parent link -->
                            <a href="#0" @click.prevent="open = !open; sidebarExpanded = true"
                                class="block text-gray-800 dark:text-gray-100 truncate transition
                        @if (!in_array(Request::segment(1), ['respon'])) hover:text-gray-900 dark:hover:text-white @endif">
                                <div class="flex items-center justify-between">
                                    <!-- Icon + label -->
                                    <div class="flex items-center">
                                        <!-- Ikon panah melingkar -->
                                        <svg class="shrink-0 stroke-current
                                    @if (in_array(Request::segment(1), ['respon'])) text-violet-500
                                    @else
                                        text-gray-400 dark:text-gray-500 @endif"
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="23 4 23 10 17 10" />
                                            <polyline points="1 20 1 14 7 14" />
                                            <path
                                                d="M3.51 9a9 9 0 0 1 14.13-3.36L23 10M1 14l5.36 5.36A9 9 0 0 0 20.49 15" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Respon Tindak Lanjut
                                        </span>
                                    </div>

                                    <!-- Chevron -->
                                    <div
                                        class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500 transition-transform"
                                            :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>

                            <!-- Submenu -->
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1" :class="open ? 'block' : 'hidden'">
                                    <li class="mb-1 last:mb-0">
                                        <a href="{{ route('followupinstruction.index') }}"
                                            class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                Tindak Lanjut Instruksi
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1" :class="open ? 'block' : 'hidden'">
                                    <li class="mb-1 last:mb-0">
                                        <a href="{{ route('followupcoordination.index') }}"
                                            class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                Tindak Lanjut koordinasi
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endcan

                    @can('view.followup-instruction-score')
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r
                        @if (in_array(Request::segment(1), ['penilaian'])) from-violet-500/[0.12] dark:from-violet-500/[0.24] to-violet-500/[0.04] @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['penilaian']) ? 'true' : 'false' }} }">

                            <!-- Parent link -->
                            <a href="#0" @click.prevent="open = !open; sidebarExpanded = true"
                                class="block text-gray-800 dark:text-gray-100 truncate transition
                            @if (!in_array(Request::segment(1), ['penilaian'])) hover:text-gray-900 dark:hover:text-white @endif">
                                <div class="flex items-center justify-between">
                                    <!-- Icon + label -->
                                    <div class="flex items-center">
                                        <!-- Ikon bintang -->
                                        <svg class="shrink-0 stroke-current
                                    @if (in_array(Request::segment(1), ['penilaian'])) text-violet-500
                                    @else
                                        text-gray-400 dark:text-gray-500 @endif"
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polygon
                                                points="12 2 15.09 8.26 22 9.27 17 14.14
                                     18.18 21.02 12 17.77 5.82 21.02
                                     7 14.14 2 9.27 8.91 8.26 12 2" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Penilaian
                                        </span>
                                    </div>

                                    <!-- Chevron -->
                                    <div
                                        class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500 transition-transform"
                                            :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>

                            <!-- Submenu -->
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1" :class="open ? 'block' : 'hidden'">
                                    <li class="mb-1 last:mb-0">
                                        <a href="{{ route('followupinstructionscore.index') }}"
                                            class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                Penilaian
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endcan


                    @canany(['view.permission', 'view.role'])
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r
                        @if (in_array(Request::segment(1), ['role', 'permission'])) from-violet-500/[0.12] dark:from-violet-500/[0.24] to-violet-500/[0.04] @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['role', 'permission']) ? 1 : 0 }} }">

                            <a class="block text-gray-800 dark:text-gray-100 truncate transition" href="#0"
                                @click.prevent="open = !open; sidebarExpanded = true">

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500"
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67
                                                    0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                        </svg>
                                        <span class="text-sm font-medium ml-4">Manajemen Akses</span>
                                    </div>
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </a>

                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1" :class="open ? 'block!' : 'hidden'">
                                    @can('view.role')
                                        <li class="mb-1">
                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate"
                                                href="{{ route('role.index') }}">
                                                <span class="text-sm font-medium">Role</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view.permission')
                                        <li class="mb-1">
                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate"
                                                href="{{ route('permission.index') }}">
                                                <span class="text-sm font-medium">Permission</span>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </div>
                        </li>
                    @endcan

                    @can('view.user')
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0
                            bg-linear-to-r @if (in_array(Request::segment(1), ['user', 'user-role'])) from-green-500/[0.12] dark:from-green-500/[0.24] to-green-500/[0.04] @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['user', 'user-role']) ? 1 : 0 }} }">

                            <a class="block text-gray-800 dark:text-gray-100 truncate transition" href="#0"
                                @click.prevent="open = !open; sidebarExpanded = true">

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500"
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67
                                               0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                        </svg>
                                        <span class="text-sm font-medium ml-4">Manajemen User</span>
                                    </div>
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </a>

                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1" :class="open ? 'block!' : 'hidden'">
                                    <li class="mb-1">
                                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate"
                                            href="{{ route('user.index') }}">
                                            <span class="text-sm font-medium">User</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                    @endcan




                </ul>
            </div>
            <!-- More group -->

        </div>

        <!-- Expand / collapse button -->
        <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
            <div class="w-12 pl-4 pr-3 py-2">
                <button
                    class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 transition-colors"
                    @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500 sidebar-expanded:rotate-180"
                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path
                            d="M15 16a1 1 0 0 1-1-1V1a1 1 0 1 1 2 0v14a1 1 0 0 1-1 1ZM8.586 7H1a1 1 0 1 0 0 2h7.586l-2.793 2.793a1 1 0 1 0 1.414 1.414l4.5-4.5A.997.997 0 0 0 12 8.01M11.924 7.617a.997.997 0 0 0-.217-.324l-4.5-4.5a1 1 0 0 0-1.414 1.414L8.586 7M12 7.99a.996.996 0 0 0-.076-.373Z" />
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>
