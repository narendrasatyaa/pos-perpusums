<x-app-layout :title="'Order Kasir'">
    <div class="flex h-screen bg-[#f4f7fe] font-sans selection:bg-accent selection:text-primary">
        <x-sidebar />

        {{-- header --}}
        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            <header
                class="bg-white h-24 px-10 flex items-center justify-between shadow-sm z-10 rounded-b-3xl mx-4 mt-4 border border-[#eef2f9] flex-shrink-0">
                <div class="flex items-center space-x-12">
                    <h1 class="font-bold text-lg" style="padding-right: 1rem;">Order</h1>
                    @foreach ($headerLinks ?? [] as $link)
                        <a href="{{ $link->url ?? '#' }}"
                            class="text-secondary/60 hover:text-primary font-bold text-sm transition-colors">
                            {{ $link->name ?? 'Link' }}
                        </a>
                    @endforeach
                </div>

                <div class="flex items-center space-x-6">
                    <button
                        class="w-10 h-10 rounded-full bg-[#f4f7fe] text-secondary hover:text-primary flex items-center justify-center transition-colors relative">
                        <i class="fa-solid fa-bell"></i>
                        <span
                            class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    {{-- <div class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden border-2 border-white shadow-sm">
                        <img src="{{ auth()->user()->avatar_url ?? asset('img/avatar-default.png') }}"
                            onerror="this.src='https://ui-avatars.com/api/?name=User&background=ecc25c&color=fff'"
                            alt="User" class="w-full h-full object-cover">
                    </div> --}}
                </div>
            </header>

            <main class="flex-1 flex overflow-hidden p-4 pt-6 space-x-6">
                {{-- kiri --}}
                <div class="flex-1 flex flex-col overflow-hidden space-y-6">
                    <div class="bg-white rounded-3xl p-3 flex items-center justify-between shadow-sm border border-[#eef2f9] shrink-0">
                        <div class="flex items-center space-x-2 overflow-x-auto custom-scrollbar flex-1">
                            <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}"
                                class="px-6 py-2 rounded-full font-bold text-sm whitespace-nowrap transition-colors {{ !request('category') ? 'bg-accent/10 text-accent' : 'bg-transparent text-secondary/60 hover:bg-[#f4f7fe] border border-secondary/10' }}">
                                All
                            </a>
                            @foreach ($categories ?? [] as $category)
                                <a href="{{ request()->fullUrlWithQuery(['category' => $category->id]) }}"
                                    class="px-6 py-2 rounded-full font-bold text-sm whitespace-nowrap transition-colors {{ request('category') == $category->id ? 'bg-accent/10 text-accent' : 'bg-transparent text-secondary/60 hover:bg-[#f4f7fe] border border-secondary/10' }}">
                                    {{ $category->name ?? 'Category' }}
                                </a>
                            @endforeach
                        </div>

                        <form method="GET" action="{{ route('kasir.order') }}" class="relative ml-4 flex-shrink-0 w-64">
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            <div class="absolute inset-y-0 left-0 flex items-center pl-1">
                                <button type="submit" class="w-8 h-8 rounded-full bg-accent text-white flex items-center justify-center hover:bg-info transition-colors">
                                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                </button>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="bg-white border text-primary text-sm rounded-full focus:ring-accent focus:border-accent border-secondary/10 block w-full pl-12 pr-4 py-2 font-medium placeholder:text-secondary/40"
                                placeholder="Cari menu...">
                        </form>
                    </div>

                    {{-- menu --}}
                    <div class="flex-1 bg-white rounded-3xl p-6 shadow-sm border border-[#eef2f9] overflow-y-auto custom-scrollbar">
                        <h2 class="text-xl font-bold text-primary mb-4">Daftar Menu</h2>
                        
                        {{-- grid produk --}}
                        <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @forelse($products ?? [] as $product)
                                <div class="bg-white rounded-2xl p-4 shadow-sm border border-[#eef2f9] flex flex-col transition-all">
                                    <div class="w-full aspect-square bg-[#f4f7fe] rounded-xl mb-3 p-2 flex items-center justify-center relative overflow-hidden transition-colors">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name ?? 'Product' }}" class="w-full h-full object-cover rounded-lg drop-shadow-sm">
                                        @else
                                            <i class="fa-solid fa-image text-4xl text-secondary/10 transition-colors"></i>
                                        @endif
                                    </div>

                                    <h3 class="text-primary font-bold text-base mb-1 truncate">{{ $product->name ?? 'Product Name' }}</h3>

                                    {{-- harga --}}
                                    <div class="mt-auto flex flex-col pt-1">
                                        <div class="flex items-center justify-between mt-2">
                                            <p class="text-accent font-extrabold text-sm">Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}</p>
                                            
                                            <button class="w-8 h-8 rounded-lg bg-accent/10 text-accent flex items-center justify-center hover:bg-accent hover:text-white transition-colors">
                                                <i class="fa-solid fa-plus text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full h-48 flex flex-col items-center justify-center text-secondary/40 space-y-4 bg-[#f4f7fe] rounded-2xl border border-dashed border-[#eef2f9]">
                                    <i class="fa-solid fa-utensils text-4xl"></i>
                                    <p class="font-semibold text-sm">Belum ada menu yang tersedia</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- kanan --}}
                <aside class="w-[350px] bg-white rounded-3xl shadow-sm border border-[#eef2f9] flex flex-col overflow-hidden shrink-0">
                    <div class="p-6 border-b border-secondary/10">
                        <h2 class="font-bold text-xl text-primary">Detail Order</h2>
                    </div>
                    
                    {{-- order detail --}}
                    <div class="flex-1 overflow-y-auto p-6 space-y-4 custom-scrollbar">
                        {{-- item order --}}
                    </div>
                    {{-- checkut --}}
                    <div class="p-6 bg-white border-t border-secondary/10">
                        <button class="w-full bg-accent hover:bg-info text-white py-4 rounded-2xl font-bold transition-all shadow-md shadow-accent/20">
                            Proses Order
                        </button>
                    </div>
                </aside>
            </main>
        </div>
    </div>
</x-app-layout>
