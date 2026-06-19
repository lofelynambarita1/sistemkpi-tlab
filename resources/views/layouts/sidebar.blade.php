<nav class="flex-1 px-3 space-y-1 mt-2">
    @php $role = auth()->user()->role; @endphp

    @if($role === 'admin')
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('dashboard') ? 'bg-sip-sidebar-act text-white' : '' }}">
            <i class="fa-solid fa-gauge w-5 text-center"></i> Dashboard
        </a>
        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('admin.users*') ? 'bg-sip-sidebar-act text-white' : '' }}">
            <i class="fa-solid fa-users w-5 text-center"></i> Manajemen User
        </a>
        <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('admin.profile') ? 'bg-sip-sidebar-act text-white' : '' }}">
            <i class="fa-solid fa-user w-5 text-center"></i> Profil Saya
        </a>
    @elseif(in_array($role, ['lead', 'lead_hr', 'manager']))
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('dashboard') ? 'bg-sip-sidebar-act text-white' : '' }}">
            <i class="fa-solid fa-gauge w-5 text-center"></i> Dashboard
        </a>
        @php
            $isReviewRoute = request()->routeIs('review*') || request()->routeIs('lead.review*') || request()->routeIs('leadhr.review*') || request()->routeIs('manager.review*');
            $reviewRoute = match($role) {
                'lead' => 'lead.review.index',
                'lead_hr' => 'leadhr.review.index',
                'manager' => 'manager.review.index',
                default => 'review.index'
            };
        @endphp
        <a href="{{ route($reviewRoute) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ $isReviewRoute ? 'bg-sip-sidebar-act text-white' : '' }}">
            <i class="fa-solid fa-clipboard-check w-5 text-center"></i> Review KPI
        </a>
        @if($role === 'lead')
        <a href="{{ route('kpi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('kpi*') ? 'bg-sip-sidebar-act text-white' : '' }}">
            <i class="fa-solid fa-file-alt w-5 text-center"></i> Form KPI
        </a>
        @endif
        <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('profile.show') ? 'bg-sip-sidebar-act text-white' : '' }}">
            <i class="fa-solid fa-user w-5 text-center"></i> Profil Saya
        </a>
    @elseif($role === 'hr')
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('dashboard') ? 'bg-sip-sidebar-act text-white' : '' }}">
            <i class="fa-solid fa-gauge w-5 text-center"></i> Dashboard
        </a>
        <a href="{{ route('hr.kpi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('hr.kpi*') ? 'bg-sip-sidebar-act text-white' : '' }}">
            <i class="fa-solid fa-file-contract w-5 text-center"></i> Kelola Dokumen KPI
        </a>
        <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('profile.show') ? 'bg-sip-sidebar-act text-white' : '' }}">
            <i class="fa-solid fa-user w-5 text-center"></i> Profil Saya
        </a>
    @else
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('dashboard') ? 'bg-sip-sidebar-act text-white' : '' }}">
            <i class="fa-solid fa-gauge w-5 text-center"></i> Dashboard
        </a>
        <a href="{{ route('kpi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('kpi*') ? 'bg-sip-sidebar-act text-white' : '' }}">
            <i class="fa-solid fa-file-alt w-5 text-center"></i> Form KPI
        </a>
        <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('profile.show') ? 'bg-sip-sidebar-act text-white' : '' }}">
            <i class="fa-solid fa-user w-5 text-center"></i> Profil Saya
        </a>
    @endif

    <a href="{{ route('panduan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/80 hover:bg-sip-sidebar-sec hover:text-white transition {{ request()->routeIs('panduan') ? 'bg-sip-sidebar-act text-white' : '' }}">
        <i class="fa-solid fa-book w-5 text-center"></i> Panduan
    </a>
</nav>
