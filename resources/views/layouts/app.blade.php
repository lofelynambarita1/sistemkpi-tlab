<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Sistem KPI</title>
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @stack('styles')
</head>
<body class="bg-gray-50 {{ Session::get('dark_mode', false) ? 'dark' : '' }}">
    {{-- SIDEBAR --}}
    <aside class="fixed top-0 left-0 w-64 h-screen bg-sip-sidebar text-white flex flex-col z-40 overflow-y-auto">
        <div class="flex items-center gap-3 px-5 py-4 border-b border-white/10">
            <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div>
                <div class="font-bold text-sm">Sistem KPI</div>
                <div class="text-[10px] text-white/60">Key Performance Indicator</div>
            </div>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-1">
            @auth
                @php $role = auth()->user()->role; @endphp

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('dashboard') ? 'bg-sip-sidebar-act text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>

                @if($role === 'admin')
                    <div class="text-[10px] uppercase tracking-wider text-white/40 px-3 pt-4 pb-1">Administrator</div>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('admin.users*') ? 'bg-sip-sidebar-act text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Management User
                    </a>
                    <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('admin.profile') ? 'bg-sip-sidebar-act text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profil Saya
                    </a>
                @elseif(in_array($role, ['associate','intermediate','senior','principle']))
                    <div class="text-[10px] uppercase tracking-wider text-white/40 px-3 pt-4 pb-1">Penilaian KPI</div>
                    <a href="{{ route('kpi.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('kpi.create') ? 'bg-sip-sidebar-act text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Form KPI
                    </a>
                    <a href="{{ route('kpi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('kpi.index') || request()->routeIs('kpi.show') || request()->routeIs('kpi.edit') ? 'bg-sip-sidebar-act text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        History KPI
                    </a>
                    @if($role === 'principle')
                    <a href="{{ route('kpi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Review KPI
                    </a>
                    @endif
                    <div class="text-[10px] uppercase tracking-wider text-white/40 px-3 pt-4 pb-1">Akun</div>
                    <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('profile.show') ? 'bg-sip-sidebar-act text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profil Saya
                    </a>
                @elseif($role === 'lead')
                    <div class="text-[10px] uppercase tracking-wider text-white/40 px-3 pt-4 pb-1">Penilaian KPI</div>
                    <a href="{{ route('kpi.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('kpi.create') ? 'bg-sip-sidebar-act text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Form KPI
                    </a>
                    <a href="{{ route('kpi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('kpi.index') || request()->routeIs('kpi.show') || request()->routeIs('kpi.edit') ? 'bg-sip-sidebar-act text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        History KPI
                    </a>
                    <div class="text-[10px] uppercase tracking-wider text-white/40 px-3 pt-4 pb-1">Review KPI</div>
                    <a href="{{ route('lead.review.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('review.*') || request()->routeIs('lead.review.*') ? 'bg-sip-sidebar-act text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Review Lead
                    </a>
                    <div class="text-[10px] uppercase tracking-wider text-white/40 px-3 pt-4 pb-1">Akun</div>
                    <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('profile.show') ? 'bg-sip-sidebar-act text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profil Saya
                    </a>
                @elseif($role === 'lead_hr')
                    <div class="text-[10px] uppercase tracking-wider text-white/40 px-3 pt-4 pb-1">Penilaian KPI</div>
                    <a href="{{ route('kpi.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('kpi.create') ? 'bg-sip-sidebar-act text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Form KPI
                    </a>
                    <a href="{{ route('kpi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('kpi.index') || request()->routeIs('kpi.show') || request()->routeIs('kpi.edit') ? 'bg-sip-sidebar-act text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        History KPI
                    </a>
                    <div class="text-[10px] uppercase tracking-wider text-white/40 px-3 pt-4 pb-1">Review KPI</div>
                    <a href="{{ route('leadhr.review.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('review.*') || request()->routeIs('leadhr.review.*') ? 'bg-sip-sidebar-act text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Review Lead HR
                    </a>
                    <a href="{{ route('hr.kpi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('hr.kpi*') ? 'bg-sip-sidebar-act text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        Kelola Dokumen KPI
                    </a>
                    <div class="text-[10px] uppercase tracking-wider text-white/40 px-3 pt-4 pb-1">Akun</div>
                    <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('profile.show') ? 'bg-sip-sidebar-act text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profil Saya
                    </a>
                @elseif($role === 'manager')
                    <div class="text-[10px] uppercase tracking-wider text-white/40 px-3 pt-4 pb-1">Review KPI</div>
                    <a href="{{ route('manager.review.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('review.*') || request()->routeIs('manager.review.*') ? 'bg-sip-sidebar-act text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Review Manager
                    </a>
                    <a href="{{ route('hr.kpi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('hr.kpi*') ? 'bg-sip-sidebar-act text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        Kelola Dokumen KPI
                    </a>
                    <div class="text-[10px] uppercase tracking-wider text-white/40 px-3 pt-4 pb-1">Akun</div>
                    <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('profile.show') ? 'bg-sip-sidebar-act text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profil Saya
                    </a>
                @endif

                <div class="text-[10px] uppercase tracking-wider text-white/40 px-3 pt-4 pb-1">Lainnya</div>
                <a href="{{ route('panduan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('panduan') ? 'bg-sip-sidebar-act text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Panduan
                </a>
            @endauth
        </nav>

        @auth
        <div class="px-3 py-3 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition w-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
        </div>
        @endauth
    </aside>

    {{-- TOPBAR --}}
    <header class="fixed top-0 left-64 right-0 h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-30">
        <div></div>
        <div class="flex items-center gap-4">
            <button id="darkModeToggle" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 transition" title="Mode Gelap">
                <svg class="w-5 h-5 dark-mode-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
            </button>

            @auth
            @php
                $profileRoute = auth()->user()->role === 'admin' ? 'admin.profile' : 'profile.show';
            @endphp
            <div class="relative">
                <button type="button" id="userDropdownBtn"
                        class="flex items-center gap-3 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <div class="w-9 h-9 rounded-full avatar-primary flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="hidden md:block text-right">
                        <div class="text-sm font-semibold text-gray-800 dark:text-white">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->role_label }}</div>
                    </div>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div id="userDropdownMenu"
                     class="hidden absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                        <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                        <span class="inline-block mt-2 px-2 py-0.5 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 text-xs font-medium rounded-full">
                            {{ auth()->user()->role_label }}
                        </span>
                    </div>
                    <div class="p-1">
                        <a href="{{ route($profileRoute) }}"
                           class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profil Saya
                        </a>
                        <a href="{{ route($profileRoute) }}"
                           class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Ubah Password
                        </a>
                    </div>
                    <div class="border-t border-gray-100 dark:border-gray-700 p-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md transition text-left">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endauth
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="page-main">
        {{-- ALERTS --}}
        @if(session('success'))
            <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
                <button type="button" class="ml-auto text-green-500 hover:text-green-700" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
                <button type="button" class="ml-auto text-red-500 hover:text-red-700" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif
        @if(session('info'))
            <div class="mb-4 px-4 py-3 bg-blue-50 border border-blue-200 text-blue-700 rounded-lg text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('info') }}
                <button type="button" class="ml-auto text-blue-500 hover:text-blue-700" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- DELETE MODAL --}}
    <div id="deleteConfirmModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <div class="text-center mb-4">
                <div class="w-14 h-14 bg-red-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Konfirmasi Hapus</h3>
                <p class="text-sm text-gray-600 mt-1" id="deleteModalDesc">Apakah Anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeDeleteModal()" class="btn-secondary">Batal</button>
                <form id="deleteConfirmForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm font-medium">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Delete confirmation modal
        document.querySelectorAll('[data-delete-url]').forEach(btn => {
            btn.addEventListener('click', function () {
                const url = this.dataset.deleteUrl;
                const desc = this.dataset.deleteDesc || 'Data ini akan dihapus secara permanen.';
                document.getElementById('deleteConfirmForm').action = url;
                document.getElementById('deleteModalDesc').textContent = desc;
                document.getElementById('deleteConfirmModal').classList.remove('hidden');
            });
        });

        // Dark mode toggle
        const darkToggle = document.getElementById('darkModeToggle');
        const isDark = localStorage.getItem('kpi_dark_mode') === 'true';
        if (isDark) document.body.classList.add('dark');
        darkToggle.addEventListener('click', function () {
            document.body.classList.toggle('dark');
            localStorage.setItem('kpi_dark_mode', document.body.classList.contains('dark'));
        });

        // User dropdown menu (Profil Saya / Ubah Password / Logout)
        const userDropdownBtn  = document.getElementById('userDropdownBtn');
        const userDropdownMenu = document.getElementById('userDropdownMenu');
        if (userDropdownBtn && userDropdownMenu) {
            userDropdownBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                userDropdownMenu.classList.toggle('hidden');
            });
            document.addEventListener('click', function (e) {
                if (!userDropdownMenu.contains(e.target) && !userDropdownBtn.contains(e.target)) {
                    userDropdownMenu.classList.add('hidden');
                }
            });
        }
    });
    function closeDeleteModal() {
        document.getElementById('deleteConfirmModal').classList.add('hidden');
    }
    </script>
    @stack('scripts')
</body>
</html>