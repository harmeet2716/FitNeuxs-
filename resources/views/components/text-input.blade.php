@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border border-gray-700 bg-gray-900 text-gray-100 placeholder-gray-500 focus:border-green-400 focus:ring-green-400 rounded-md shadow-sm']) }}>
