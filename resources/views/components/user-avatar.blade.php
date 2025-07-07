{{-- User Avatar Component --}}
@props([
    'user',
    'size' => 'md'
])

@php
$sizeClasses = [
    'xs' => 'w-6 h-6 text-xs',
    'sm' => 'w-8 h-8 text-sm', 
    'md' => 'w-12 h-12 text-lg',
    'lg' => 'w-16 h-16 text-xl',
    'xl' => 'w-20 h-20 text-2xl'
];

$sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<div {{ $attributes->merge(['class' => "bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0 $sizeClass"]) }}>
    {{ strtoupper(substr($user->name, 0, 1)) }}
</div>
