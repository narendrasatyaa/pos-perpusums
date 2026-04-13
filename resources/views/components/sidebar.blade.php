        <aside
            class="w-[100px] bg-white flex flex-col items-center py-6 shadow-sm border-r border-[#eef2f9] flex-shrink-0 z-20 rounded-r-3xl">
            {{-- logo --}}
            <div class="mb-10 font-extrabold text-xl text-primary text-center">
                <img src="{{ asset('img/logo-perpus.webp') }}" alt="Logo">
            </div>

            <nav class="flex-1 flex flex-col items-center space-y-4 w-full px-4 text-center">
                <a href="/kasir" @class([
                    'w-16 h-16 rounded-2xl flex flex-col items-center justify-center transition-all',
                    'bg-accent text-white shadow-lg shadow-accent/30 hover:scale-105' => request()->is(
                        'kasir'),
                    'text-secondary/50 hover:text-primary hover:bg-primary/5' => !request()->is(
                        'kasir'),
                ])>
                    <i class="fa-solid fa-house mb-1"></i>
                    <span class="text-[10px] font-bold">Home</span>
                </a>

                <a href="/kasir/order" @class([
                    'w-16 h-16 rounded-2xl flex flex-col items-center justify-center transition-all',
                    'bg-accent text-white shadow-lg shadow-accent/30 hover:scale-105' => request()->is(
                        'kasir/order*'),
                    'text-secondary/50 hover:text-primary hover:bg-primary/5' => !request()->is(
                        'kasir/order*'),
                ])>
                    <i class="fa-solid fa-cart-shopping mb-1"></i>
                    <span class="text-[10px] font-bold">Order</span>
                </a>

                <a href="/kasir/histori" @class([
                    'w-16 h-16 rounded-2xl flex flex-col items-center justify-center transition-all',
                    'bg-accent text-white shadow-lg shadow-accent/30 hover:scale-105' => request()->is(
                        'kasir/histori*'),
                    'text-secondary/50 hover:text-primary hover:bg-primary/5' => !request()->is(
                        'kasir/histori*'),
                ])>
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span class="text-[10px] font-bold">History</span>
                </a>

                @foreach ($sidebarMenus ?? [] as $menu)
                    <a href="{{ $menu->url ?? '#' }}"
                        class="w-16 h-16 rounded-2xl text-secondary/50 hover:text-primary hover:bg-primary/5 flex flex-col items-center justify-center transition-colors shrink-0">
                        <i class="fa-solid {{ $menu->icon ?? 'fa-circle' }} text-lg mb-1"></i>
                        <span class="text-[10px] font-semibold">{{ $menu->name ?? 'Menu' }}</span>
                    </a>
                @endforeach
            </nav>


            <div class="mt-auto flex flex-col items-center space-y-6 pt-4">
                <div class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden border-2 border-white shadow-sm">
                    <img src="{{ auth()->user()->avatar_url ?? asset('img/avatar-default.png') }}"
                        onerror="this.src='https://ui-avatars.com/api/?name=User&background=323986&color=fff'"
                        alt="User" class="w-full h-full object-cover">
                </div>
                <form method="POST" action="{{ route('logout') ?? '#' }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full text-secondary/50 hover:text-red-500 transition-colors flex flex-col items-center">
                        <i class="fa-solid fa-right-from-bracket text-lg mb-1"></i>
                        <span class="text-[10px] font-semibold">Logout</span>
                    </button>
                </form>
            </div>
        </aside>
