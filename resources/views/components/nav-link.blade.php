@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#c21313] text-sm font-medium leading-5 text-[#c21313] focus:outline-none focus:border-[#a11010] transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-[#c21313] hover:border-[#c21313] focus:outline-none focus:text-[#c21313] focus:border-[#c21313] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
