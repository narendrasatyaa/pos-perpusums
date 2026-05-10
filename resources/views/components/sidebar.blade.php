@php
    $menus = [
        [
            'label'  => 'Home',
            'icon'   => 'fa-house',
            'route'  => '/kasir',
            'active' => 'kasir',
        ],
        [
            'label'  => 'Order',
            'icon'   => 'fa-cart-shopping',
            'route'  => '/kasir/order',
            'active' => 'kasir/order*',
        ],
        [
            'label'  => 'Stok',
            'icon'   => 'fa-box',
            'route'  => '/kasir/stok',
            'active' => 'kasir/stok*',
        ],
        [
            'label'  => 'History',
            'icon'   => 'fa-clock-rotate-left',
            'route'  => '/kasir/histori',
            'active' => 'kasir/histori*',
        ],
    ];
@endphp

<aside class="w-[220px] bg-white flex flex-col py-6 shadow-sm border-r border-[#eef2f9] flex-shrink-0 z-20 rounded-r-3xl">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-5 mb-8">
        <img src="{{ asset('img/logo-perpus.webp') }}" alt="Logo" class="w-auto h-auto flex-shrink-0">
        <div class="leading-tight">
            {{-- <p class="text-[11px] font-bold text-primary tracking-wide uppercase">Library Cafe POS</p> --}}
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 flex flex-col px-3 space-y-1">

        {{-- Section Label --}}
        {{-- <p class="text-[9px] font-bold uppercase tracking-widest text-secondary/30 px-3 mb-2">Menu Utama</p> --}}

        @foreach ($menus as $menu)
            <a href="{{ $menu['route'] }}"
               @class([
                   'flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group',
                   'bg-primary text-white shadow-md shadow-primary/20 font-semibold' => request()->is($menu['active']),
                   'text-secondary/60 hover:bg-primary/5 hover:text-primary font-medium' => !request()->is($menu['active']),
               ])>
                <span @class([
                    'w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 transition-all',
                    'bg-white/20' => request()->is($menu['active']),
                    'bg-primary/8 group-hover:bg-primary/10' => !request()->is($menu['active']),
                ])>
                    <i class="fa-solid {{ $menu['icon'] }} text-sm"></i>
                </span>
                <span class="text-sm">{{ $menu['label'] }}</span>
            </a>
        @endforeach

        {{-- Dynamic menus from controller --}}
        @foreach ($sidebarMenus ?? [] as $menu)
            <a href="{{ $menu->url ?? '#' }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 text-secondary/60 hover:bg-primary/5 hover:text-primary font-medium group">
                <span class="w-8 h-8 rounded-lg bg-primary/8 group-hover:bg-primary/10 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid {{ $menu->icon ?? 'fa-circle' }} text-sm"></i>
                </span>
                <span class="text-sm">{{ $menu->name ?? 'Menu' }}</span>
            </a>
        @endforeach

    </nav>

    {{-- Divider --}}
    <div class="mx-5 my-4 border-t border-[#eef2f9]"></div>

    {{-- User & Logout --}}
    <div class="px-3 space-y-1">
        <a href="{{ route('kasir.profile') }}"
           @class([
               'flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group',
               'bg-primary/5 text-primary font-semibold' => request()->is('kasir/profile*'),
               'text-secondary/60 hover:bg-primary/5 hover:text-primary font-medium' => !request()->is('kasir/profile*'),
           ])>
            <span class="w-8 h-8 rounded-full overflow-hidden border-2 border-white shadow-sm flex-shrink-0">
                <img src="{{ auth()->user()->avatar_url ?? asset('img/avatar-default.png') }}"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=323986&color=fff'"
                     alt="User" class="w-full h-full object-cover">
            </span>
            <div class="leading-tight min-w-0">
                <p class="text-sm truncate">{{ auth()->user()->name ?? 'User' }}</p>
                <p class="text-[10px] text-secondary/40 truncate">{{ auth()->user()->email ?? '' }}</p>
            </div>
        </a>

        <form method="POST" action="{{ route('logout') ?? '#' }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 text-secondary/50 hover:bg-red-50 hover:text-red-500 font-medium group">
                <span class="w-8 h-8 rounded-lg bg-red-50 group-hover:bg-red-100 flex items-center justify-center flex-shrink-0 transition-all">
                    <i class="fa-solid fa-right-from-bracket text-sm"></i>
                </span>
                <span class="text-sm">Logout</span>
            </button>
        </form>
    </div>

</aside>
