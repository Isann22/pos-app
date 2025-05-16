   <div class="relative flex-1 mx-16 sm:mx-4  max-w-2xl">
       <!-- Search Icon -->
       <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-orange-400">
           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                   d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
           </svg>
       </div>

       <!-- Search Input -->
       <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari produk bunga..."
           class="w-full border border-orange-200 rounded-full py-2.5 px-10 focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-transparent placeholder-orange-300">

       <!-- Clear Button -->
       <button type="button"
           class="absolute right-3 top-1/2 transform -translate-y-1/2 text-orange-400 hover:text-orange-600 hidden"
           id="clear-search">
           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
           </svg>
       </button>
   </div>
