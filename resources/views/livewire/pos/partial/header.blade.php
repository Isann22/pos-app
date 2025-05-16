   <nav class="fixed navbar top-0 z-50 navbar-container bg-gradient-to-r from-orange-50 to-amber-50 sh">
       <div class="px-3 py-3 lg:px-5 lg:pl-3">
           <div class="flex items-center justify-between">
               <div class="flex items-center justify-start rtl:justify-end">
                   <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                       type="button"
                       class="inline-flex items-center p-2 text-sm text-orange-600 rounded-lg sm:hidden hover:bg-orange-100  focus:outline-none focus:ring-2 focus:ring-orange-500 ">
                       <span class="sr-only">Open sidebar</span>
                       <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                           xmlns="http://www.w3.org/2000/svg">
                           <path clip-rule="evenodd" fill-rule="evenodd"
                               d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                           </path>
                       </svg>
                   </button>
                   <a href="/dashboard" wire:navigate
                       class="flex items-center p-2 rounded-lg text-orange-700 hover:bg-orange-100 transition-colors mb-1">
                       <div class="flex-1 ms-6">
                           <h1 class="text-xl hidden sm:block font-bold text-orange-600 font-serif">Khalisa Florist</h1>
                           <p class="text-xs  hidden sm:block text-amber-600">{{ now()->translatedFormat('l, d F Y') }}
                           </p>
                       </div>
                   </a>
               </div>
               <div class="flex items-center">
                   @include('livewire.pos.partial.search')
                   <button id="toggle-right-sidebar"
                       class="iinline-flex items-center p-2 text-sm text-orange-600 rounded-lg sm:hidden hover:bg-orange-100 focus:outline-none focus:ring-2 focus:ring-orange-500 ml-2">
                       <span class="sr-only">Open cart</span>
                       <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                               d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                       </svg>
                   </button>
               </div>
           </div>
       </div>
   </nav>
