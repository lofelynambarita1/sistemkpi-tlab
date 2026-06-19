@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li class="text-gray-700 font-semibold">Dashboard</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
    <p class="text-gray-600">Ringkasan jumlah pengguna berdasarkan role</p>
</header>

<div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-600 mb-6">
    <p class="text-sm text-gray-500">Total Pengguna</p>
    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $roleCounts->sum() }}</p>
    <p class="text-sm text-gray-400">Semua role terdaftar</p>
</div>

@php
$roleLabels = [
    'admin' => 'Admin', 'manager' => 'Manager', 'lead_hr' => 'Lead HR',
    'lead' => 'Lead', 'principle' => 'Principle', 'senior' => 'Senior',
    'intermediate' => 'Intermediate', 'associate' => 'Associate',
];
$roleIcons = [
    'admin' => 'shield', 'manager' => 'briefcase', 'lead_hr' => 'users',
    'lead' => 'star', 'principle' => 'award', 'senior' => 'graduation-cap',
    'intermediate' => 'check-circle', 'associate' => 'user',
];
$roleColors = [
    'admin' => 'bg-purple-100 text-purple-700', 'manager' => 'bg-blue-100 text-blue-700',
    'lead_hr' => 'bg-cyan-100 text-cyan-700', 'lead' => 'bg-yellow-100 text-yellow-700',
    'principle' => 'bg-orange-100 text-orange-700', 'senior' => 'bg-green-100 text-green-700',
    'intermediate' => 'bg-teal-100 text-teal-700', 'associate' => 'bg-gray-100 text-gray-700',
];
@endphp

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @foreach($roleLabels as $role => $label)
    <div class="bg-white rounded-lg shadow p-5 flex flex-col items-center gap-2 border border-gray-100">
        <div class="rounded-full p-3 {{ $roleColors[$role] }}">
            <i class="fa-solid fa-{{ $roleIcons[$role] }} text-xl"></i>
        </div>
        <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">{{ $label }}</p>
        <p class="text-3xl font-bold text-gray-800">{{ $roleCounts[$role] ?? 0 }}</p>
    </div>
    @endforeach
</div>
@endsection
