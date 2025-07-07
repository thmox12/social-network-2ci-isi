{{-- Status Badge Component --}}
@props([
    'status' => 'info',
    'size' => 'md'
])

@php
$statusClasses = [
    'success' => 'bg-emerald-100 text-emerald-800',
    'pending' => 'bg-amber-100 text-amber-800',
    'error' => 'bg-red-100 text-red-800',
    'danger' => 'bg-red-100 text-red-800',
    'info' => 'bg-blue-100 text-blue-800',
    'ai' => 'bg-gradient-to-r from-purple-100 to-indigo-100 text-purple-800',
    'declined' => 'bg-slate-100 text-slate-800'
];

$sizeClasses = [
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-2.5 py-0.5 text-xs',
    'lg' => 'px-3 py-1 text-sm'
];

$statusClass = $statusClasses[$status] ?? $statusClasses['info'];
$sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full font-medium $statusClass $sizeClass"]) }}>
    {{ $slot }}
</span>
