@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-orange-400 focus:ring-orange-400 rounded-md shadow-sm']) !!}>
