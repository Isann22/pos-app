<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-amber-500 border border-transparent rounded-xl font-medium text-sm text-white uppercase tracking-wide hover:from-orange-600 hover:to-amber-600 focus:outline-none focus:ring-2 focus:ring-orange-300 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg']) }}>
    {{ $slot }}
</button>
