<aside id="logo-sidebar"
    class="mt-4  fixed top-0 left-0 z-40 w-52 h-screen pt-20 transition-transform -translate-x-full bg-gradient-to-b from-orange-50 to-amber-50 sm:translate-x-0"
    aria-label="Sidebar">


    <div class="px-4 py-3 border-b border-orange-100 flex items-center bg-orange-50">
        <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
        </svg>
        <h3 class="text-orange-700 font-semibold">Filter Kategori</h3>
    </div>


    <div class="h-full px-2 pb-4 overflow-y-auto mt-2">
        <button wire:click="resetCategoryFilter"
            class="cursor-pointer p-3 text-orange-700 rounded-lg  {{ empty($selectedCategoryId) && empty($selectedCategoryIds) ? 'bg-orange-100 ' : '' }}">
            Semua Kategori
        </button>
        <ul class="space-y-1 font-medium">
            @foreach ($categories as $c)
                <li wire:key="{{ $c->id }}" wire:click="filterByCategory({{ $c->id }})">
                    <button
                        class="cursor-pointer flex items-center  p-3 px-8 text-orange-700 rounded-lg  {{ $selectedCategoryId == $c->id ? 'bg-orange-100 ' : '' }}">
                        <span class=""> {{ $c->name }}</span>
                    </button>
                </li>
            @endforeach
        </ul>

        <!-- User Profile Section -->
        <div class="absolute bottom-4 left-0 right-0 bg-white/90 border-t border-orange-100 p-3">
            <div class="flex items-center">
                <!-- Profile Trigger -->
                <div x-data="{ open: false }" class="relative" @click.outside="open = false">
                    <div @click="open = !open"
                        class="bg-gradient-to-br from-orange-500 to-amber-500 rounded-full w-9 h-9 flex items-center justify-center text-white font-bold shadow-sm cursor-pointer">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>

                    <!-- Dropup Menu -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute bottom-full left-0 mb-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50">Profile</a>

                    </div>
                </div>

                <div class="ml-3">
                    <p class="text-sm font-medium text-orange-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-amber-500">Kasir</p>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="ml-auto">
                    @csrf
                    <button type="submit"
                        class="cursor-pointer text-orange-500 hover:text-orange-700 p-1 rounded-full hover:bg-orange-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
