@php $role = auth()->user()->role; @endphp

@php
$menus = match($role) {
    'admin' => [
        ['icon' => 'fa-gauge', 'label' => 'Dashboard', 'route' => 'admin.dashboard'],
        ['icon' => 'fa-users', 'label' => 'Manajemen User', 'route' => 'admin.users.index'],
        ['icon' => 'fa-user-circle', 'label' => 'Profil', 'route' => 'admin.profile'],
    ],
    'manager' => [
        ['icon' => 'fa-gauge', 'label' => 'Dashboard', 'route' => 'manager.dashboard'],
        ['icon' => 'fa-clipboard-check', 'label' => 'Review KPI', 'route' => 'manager.review.index'],
        ['icon' => 'fa-clock-rotate-left', 'label' => 'History', 'route' => 'manager.history'],
        ['icon' => 'fa-user-circle', 'label' => 'Profil', 'route' => 'manager.profile'],
    ],
    'lead_hr' => [
        ['icon' => 'fa-gauge', 'label' => 'Dashboard', 'route' => 'leadhr.dashboard'],
        ['icon' => 'fa-file-pen', 'label' => 'Form KPI', 'route' => 'leadhr.kpi.index'],
        ['icon' => 'fa-clipboard-check', 'label' => 'Review KPI', 'route' => 'leadhr.review.index'],
        ['icon' => 'fa-clock-rotate-left', 'label' => 'History', 'route' => 'leadhr.history'],
        ['icon' => 'fa-user-circle', 'label' => 'Profil', 'route' => 'leadhr.profile'],
    ],
    'lead' => [
        ['icon' => 'fa-gauge', 'label' => 'Dashboard', 'route' => 'lead.dashboard'],
        ['icon' => 'fa-file-pen', 'label' => 'Form KPI', 'route' => 'lead.kpi.index'],
        ['icon' => 'fa-clipboard-check', 'label' => 'Review KPI', 'route' => 'lead.review.index'],
        ['icon' => 'fa-clock-rotate-left', 'label' => 'History', 'route' => 'lead.history'],
        ['icon' => 'fa-user-circle', 'label' => 'Profil', 'route' => 'lead.profile'],
    ],
    'principle' => [
        ['icon' => 'fa-gauge', 'label' => 'Dashboard', 'route' => 'principle.dashboard'],
        ['icon' => 'fa-file-pen', 'label' => 'Form KPI', 'route' => 'principle.kpi.index'],
        ['icon' => 'fa-clock-rotate-left', 'label' => 'History', 'route' => 'principle.history'],
        ['icon' => 'fa-user-circle', 'label' => 'Profil', 'route' => 'principle.profile'],
    ],
    default => [ // associate, intermediate, senior
        ['icon' => 'fa-gauge', 'label' => 'Dashboard', 'route' => 'employee.dashboard'],
        ['icon' => 'fa-file-pen', 'label' => 'Form KPI', 'route' => 'employee.kpi.index'],
        ['icon' => 'fa-clock-rotate-left', 'label' => 'History', 'route' => 'employee.history'],
        ['icon' => 'fa-user-circle', 'label' => 'Profil', 'route' => 'employee.profile'],
    ],
};
@endphp

@foreach($menus as $menu)
    <a href="{{ route($menu['route']) }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1 text-sm font-medium transition
              {{ request()->routeIs($menu['route']) ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fa-solid {{ $menu['icon'] }} w-4 text-center"></i>
        {{ $menu['label'] }}
    </a>
@endforeach