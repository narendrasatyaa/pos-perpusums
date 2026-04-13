<x-app-layout :title="'Dashboard Kasir'">
    <div class="flex h-screen bg-[#f4f7fe] font-sans selection:bg-accent selection:text-primary">
        <x-sidebar />

        {{-- header --}}
        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            <header
                class="bg-white h-24 px-10 flex items-center justify-between shadow-sm z-10 rounded-b-3xl mx-4 mt-4 border border-[#eef2f9] flex-shrink-0">
                <div class="flex items-center space-x-12">
                    <h1 class="font-bold text-lg" style="padding-right: 1rem;">Dashboard Kasir</h1>
                    @foreach ($headerLinks ?? [] as $link)
                        <a href="{{ $link->url ?? '#' }}"
                            class="text-secondary/60 hover:text-primary font-bold text-sm transition-colors">
                            {{ $link->name ?? 'Link' }}
                        </a>
                    @endforeach
                </div>

                <div class="flex items-center space-x-6">

                    <a href="kasir/order"
                        class="bg-accent hover:bg-info text-white px-6 py-2.5 rounded-full font-bold text-sm transition-all shadow-md shadow-accent/20">
                        New Request Order
                    </a>
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

            <div class="flex-1 overflow-hidden flex flex-col p-4 pt-6">
                {{-- produk --}}
                <div class="flex-1 overflow-y-auto custom-scrollbar pr-2 pb-4">
                    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6">
                        @forelse($products ?? [] as $product)
                            <div
                                class="bg-white rounded-3xl p-5 shadow-sm border border-[#eef2f9] flex flex-col transition-all hover:shadow-lg group">
                                <!-- Product Image Area -->
                                <div
                                    class="w-full aspect-square bg-[#f4f7fe] rounded-2xl mb-4 p-4 flex items-center justify-center relative overflow-hidden group-hover:bg-accent/5 transition-colors">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name ?? 'Product' }}"
                                            class="w-full h-full object-cover rounded-xl drop-shadow-md ">
                                    @else
                                        <i
                                            class="fa-solid fa-image text-5xl text-secondary/10 group-hover:text-accent/30 transition-colors"></i>
                                    @endif
                                </div>

                                <h3 class="text-primary font-bold text-lg mb-1 truncate">
                                    {{ $product->name ?? 'Product Name' }}</h3>

                                <div class="mt-auto flex flex-col pt-2">
                                    <p class="text-secondary/50 text-xs font-semibold mb-2">Price</p>
                                    <div class="flex items-center justify-between">
                                        <p class="text-accent font-extrabold text-base">Rp
                                            {{ number_format($product->price ?? 0, 0, ',', '.') }}</p>

                                        <div
                                            class="flex items-center bg-white border border-secondary/10 rounded-lg p-1 shadow-sm">
                                            <button
                                                class="w-6 h-6 rounded bg-transparent text-secondary flex items-center justify-center hover:bg-secondary/5 transition-colors">
                                                <i class="fa-solid fa-minus text-[10px]"></i>
                                            </button>
                                            <span
                                                class="w-6 text-center text-xs font-bold text-primary">{{ $product->cart_quantity ?? 1 }}</span>
                                            <button
                                                class="w-6 h-6 rounded bg-accent/10 text-accent flex items-center justify-center hover:bg-accent/20 transition-colors">
                                                <i class="fa-solid fa-plus text-[10px]"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div
                                class="col-span-full h-64 flex flex-col items-center justify-center text-secondary/40 space-y-4 bg-white rounded-3xl border border-[#eef2f9]">
                                <i class="fa-solid fa-utensils text-5xl"></i>
                                <p class="font-bold text-lg">Belum ada menu yang tersedia</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
