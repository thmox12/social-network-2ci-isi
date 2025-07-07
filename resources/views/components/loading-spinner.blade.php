{{-- Loading Spinner Component --}}
@props([
    'size' => 'md',
    'color' => 'indigo'
])

@php
$sizeClasses = [
    'sm' => 'h-4 w-4',
    'md' => 'h-6 w-6',
    'lg' => 'h-8 w-8',
    'xl' => 'h-12 w-12'
];

$colorClasses = [
    'indigo' => 'border-indigo-600',
    'white' => 'border-white',
    'slate' => 'border-slate-600',
    'purple' => 'border-purple-600'
];

$sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
$colorClass = $colorClasses[$color] ?? $colorClasses['indigo'];
@endphp

<div {{ $attributes->merge(['class' => "animate-spin rounded-full border-b-2 $sizeClass $colorClass"]) }}></div>
