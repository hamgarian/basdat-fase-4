@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-700 bg-slate-900 text-slate-100 placeholder-slate-500 focus:border-blue-400 focus:ring-blue-400 rounded-md shadow-sm']) }}>
