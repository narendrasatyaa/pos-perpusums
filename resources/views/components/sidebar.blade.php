@php
    $menus = [
        [
            'label'  => 'Home',
            'route'  => '/kasir',
            'active' => 'kasir',
            'icon'   => 'home'
        ],
        [
            'label'  => 'Order',
            'route'  => '/kasir/order',
            'active' => 'kasir/order*',
            'icon'   => 'order'
        ],
        [
            'label'  => 'Stok',
            'route'  => '/kasir/stok',
            'active' => 'kasir/stok*',
            'icon'   => 'stok'
        ],
        [
            'label'  => 'History',
            'route'  => '/kasir/histori',
            'active' => 'kasir/histori*',
            'icon'   => 'history'
        ],
    ];
@endphp

<header class="w-full bg-white border-b border-slate-100 flex-shrink-0 z-30">
    <div class="w-full px-6 sm:px-8 h-[72px] flex items-center justify-between">
        
        {{-- Logo & Brand (Style Ecomora) --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('kasir.dashboard') }}">
                <img src="{{ asset('img/logo-perpus.webp') }}" alt="Logo" class="h-16 w-auto flex-shrink-0">
                {{-- <span class="text-base font-semibold text-slate-900 tracking-tight hidden sm:inline-block">Library Cafe</span> --}}
            </a>
        </div>

        {{-- Menus (Style Ecomora: thin fonts and outline icons) --}}
        <nav class="flex items-center gap-1 sm:gap-2 h-full">
            @foreach ($menus as $menu)
                @php
                    $isActive = request()->is($menu['active']);
                @endphp
                <a href="{{ $menu['route'] }}"
                   class="relative flex items-center gap-2 px-3 sm:px-4 h-[72px] transition-all duration-200 text-xs sm:text-sm font-medium tracking-wide {{ $isActive ? 'text-slate-950 font-semibold border-b-2 border-slate-950' : 'text-slate-500 hover:text-slate-800' }}">
                    
                    {{-- Thin Outline SVGs to match the mockup exactly --}}
                    @if ($menu['icon'] === 'home')
                        <svg class="w-4.5 h-4.5 text-current" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                    @elseif ($menu['icon'] === 'order')
                        <svg class="w-4.5 h-4.5 text-current" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.116 60.116 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                    @elseif ($menu['icon'] === 'stok')
                        <svg class="w-4.5 h-4.5 text-current" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25"></path>
                        </svg>
                    @elseif ($menu['icon'] === 'history')
                        <svg class="w-4.5 h-4.5 text-current" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    @endif

                    <span>{{ $menu['label'] }}</span>
                </a>
            @endforeach

            {{-- Dynamic menus --}}
            @foreach ($sidebarMenus ?? [] as $menu)
                @php
                    $isDynamicActive = !empty($menu->url) && request()->is(trim($menu->url, '/'));
                @endphp
                <a href="{{ $menu->url ?? '#' }}"
                   class="relative flex items-center gap-2 px-3 sm:px-4 h-[72px] transition-all duration-200 text-xs sm:text-sm font-medium tracking-wide {{ $isDynamicActive ? 'text-slate-950 font-semibold border-b-2 border-slate-950' : 'text-slate-500 hover:text-slate-800' }}">
                    <i class="fa-regular {{ $menu->icon ?? 'fa-circle' }} text-xs"></i>
                    <span>{{ $menu->name ?? 'Menu' }}</span>
                </a>
            @endforeach
        </nav>

        {{-- Right Column (Clock, Profile dropdown, Logout button) --}}
        <div class="flex items-center gap-4 sm:gap-6">
            {{-- Clock (Clean Ecomora design) --}}
            <div class="text-right leading-tight hidden lg:block pr-4 border-r border-slate-100">
                <p class="text-[11px] font-medium text-slate-400">{{ now()->translatedFormat('l, d F Y') }}</p>
                <p id="live-clock" class="text-sm font-semibold text-slate-800"></p>
            </div>

            {{-- Profile Dropdown --}}
            <a href="{{ route('kasir.profile') }}"
               class="flex items-center gap-2.5 p-1.5 rounded-xl hover:bg-slate-50 transition-all duration-200">
                <span class="w-8 h-8 rounded-full overflow-hidden border border-slate-200 shadow-sm flex-shrink-0">
                    <img src="{{ auth()->user()->avatar_url ?? asset('img/avatar-default.png') }}"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=f1f5f9&color=0f172a'"
                         alt="User" class="w-full h-full object-cover">
                </span>
                <span class="text-xs font-semibold text-slate-800 hidden md:inline-block">{{ auth()->user()->name ?? 'User' }}</span>
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 hidden md:inline-block"></i>
            </a>

            {{-- Logout Button --}}
            <form method="POST" action="{{ route('logout') }}" class="flex items-center">
                @csrf
                <button type="submit"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-medium text-slate-400 hover:text-red-500 transition-all hover:bg-red-50/50">
                    <i class="fa-solid fa-right-from-bracket text-xs"></i>
                    <span class="hidden sm:inline">Logout</span>
                </button>
            </form>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const clockEl = document.getElementById('live-clock');
        const updateClock = () => {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            if (clockEl) clockEl.textContent = `${timeString} WIB`;
        };
        updateClock();
        setInterval(updateClock, 1000);
    });
</script>
