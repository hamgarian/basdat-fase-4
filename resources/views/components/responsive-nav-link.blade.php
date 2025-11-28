@props(['active'])

@php
$classes = ($active ?? false)
                ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-blue-400 text-start text-base font-medium text-blue-200 bg-slate-900 focus:outline-none focus:text-blue-200 focus:bg-slate-900 focus:border-blue-500 transition duration-150 ease-in-out'
                : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-slate-300 hover:text-slate-50 hover:bg-slate-900 hover:border-slate-500 focus:outline-none focus:text-slate-50 focus:bg-slate-900 focus:border-slate-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
