@extends('layouts.app')

@section('title', 'Form KPI')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Form KPI</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ $form ? route('kpi.save-draft') : '#' }}" class="space-y-6">
        @csrf

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Data Cuti</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Total Cuti</label>
                    <input type="number" name="total_cuti" value="{{ old('total_cuti', $form->total_cuti ?? 0) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Hari Kerja Efektif</label>
                    <input type="number" name="hari_kerja_efektif" value="{{ old('hari_kerja_efektif', $form->hari_kerja_efektif ?? 240) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" readonly>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Simpan Draft
            </button>
            <button type="submit" name="action" value="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Submit KPI
            </button>
        </div>
    </form>
</div>
@endsection
