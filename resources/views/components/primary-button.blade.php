<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-green-400 text-gray-950 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-green-300 focus:outline-none focus:ring-2 focus:ring-green-300 focus:ring-offset-2 focus:ring-offset-gray-950 active:bg-green-500 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
