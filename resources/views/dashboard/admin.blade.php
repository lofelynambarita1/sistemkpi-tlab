@extends('layouts.app')
@section('title', 'Admin Dashboard - KPI System')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
    <p class="text-gray-500 text-sm mt-1">Ringkasan jumlah pengguna berdasarkan role</p>
</div>

{{-- Total Users Card --}}
<div class="bg-indigo-600 text-white rounded-xl p-6 mb-6 shadow flex items-center gap-4">
    <div class="bg-indigo-500 rounded-full p-4"><i class="fa-solid fa-users text-2xl"></i></div>
    <div>
        <p class="text-indigo-200 text-sm">Total Pengguna</p>
        <p class="text-4xl font-bold">{{ $roleCounts->sum() }}</p>
    </div>
</div>

{{-- Role Cards --}}
@php
$roleConfig = [
    'admin'        => ['label' => 'Admin',        'icon' => 'fa-user-shield',    'color' => 'bg-purple-100 text-purple-700'],
    'manager'      => ['label' => 'Manager',      'icon' => 'fa-user-tie',       'color' => 'bg-blue-100 text-blue-700'],
    'lead_hr'      => ['label' => 'Lead HR',      'icon' => 'fa-people-roof',    'color' => 'bg-cyan-100 text-cyan-700'],
    'lead'         => ['label' => 'Lead',         'icon' => 'fa-star',           'color' => 'bg-yellow-100 text-yellow-700'],
    'principle'    => ['label' => 'Principle',    'icon' => 'fa-award',          'color' => 'bg-orange-100 text-orange-700'],
    'senior'       => ['label' => 'Senior',       'icon' => 'fa-user-graduate',  'color' => 'bg-green-100 text-green-700'],
    'intermediate' => ['label' => 'Intermediate', 'icon' => 'fa-user-check',     'color' => 'bg-teal-100 text-teal-700'],
    'associate'    => ['label' => 'Associate',    'icon' => 'fa-user',           'color' => 'bg-gray-100 text-gray-700'],
];
@endphp

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @foreach($roleConfig as $role => $config)
    <div class="bg-white rounded-xl shadow p-5 flex flex-col items-center gap-2 border border-gray-100 hover:shadow-md transition">
        <div class="rounded-full p-3 {{ $config['color'] }}">
            <i class="fa-solid {{ $config['icon'] }} text-xl"></i>
        </div>
        <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">{{ $config['label'] }}</p>
        <p class="text-3xl font-bold text-gray-800">{{ $roleCounts[$role] ?? 0 }}</p>
    </div>
    @endforeach
</div>
@endsection
