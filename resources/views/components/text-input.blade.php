@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-300 focus:border-blue-600 focus:ring-4 focus:ring-blue-500/15 rounded-xl shadow-xs text-sm font-semibold bg-slate-50']) }}>
