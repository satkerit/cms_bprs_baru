@php
    $isActive = request()->routeIs($menu->route . '*') || request()->routeIs(str_replace('.index', '.*', $menu->route));
    $icon = $icons[$menu->key] ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>';
    $badgeCount = $badgeCounts[$menu->key] ?? 0;

    try {
        $href = route($menu->route);
    } catch (\Symfony\Component\Routing\Exception\RouteNotFoundException $e) {
        $href = route('admin.dashboard');
    }

    $itemClasses = 'admin-sidebar-link ' . ($isActive ? 'admin-sidebar-link-active' : 'admin-sidebar-link-inactive');

    $iconClasses = 'admin-sidebar-icon ' . ($isActive ? 'admin-sidebar-icon-active' : 'admin-sidebar-icon-inactive');

    $badgeColor = $menu->key === 'complaints' ? 'bg-red-500' : 'bg-amber-500';
@endphp

<a @click="closeSidebarOnMobile()" href="{{ $href }}"
   class="{{ $itemClasses }}"
   @if($isActive) aria-current="page" @endif>
    {{-- Active indicator bar --}}
    @if($isActive)
        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-5 rounded-full bg-gradient-to-b from-emerald-400 to-emerald-500 shadow-sm shadow-emerald-500/40"></div>
    @endif

    <div class="{{ $iconClasses }}">
        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            {!! $icon !!}
        </svg>
        @if($badgeCount > 0)
            <span class="absolute -top-1.5 -right-1.5 flex items-center justify-center min-w-[18px] h-[18px] px-1 text-[9px] font-bold text-white {{ $badgeColor }} rounded-full leading-none ring-2 ring-[#0b1120] shadow-sm">
                {{ $badgeCount > 9 ? '9+' : $badgeCount }}
            </span>
        @endif
    </div>
    <span class="whitespace-nowrap">{{ $menu->name }}</span>
    @if($isActive)
        <div class="ml-auto w-1.5 h-1.5 rounded-full bg-emerald-400/60 shrink-0"></div>
    @endif
</a>
