<x-app-layout :title="'Stok Barang'">
    <div class="flex h-screen bg-slate-50 font-sans selection:bg-accent selection:text-primary">
        <x-sidebar />

        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            {{-- Header --}}
            <header
                class="bg-white/80 backdrop-blur-md h-[72px] px-8 flex items-center justify-end shadow-sm z-20 border-b border-slate-100 flex-shrink-0 sticky top-0">
                <div class="text-right leading-tight">
                    <p class="text-sm font-bold text-primary">{{ now()->translatedFormat('l, d F Y') }}</p>
                    <p class="text-primary font-bold clock-display">{{ date('H:i:s') }} WIB</p>
                </div>
            </header>

            <div class="flex-1 overflow-auto p-8 space-y-8">

                {{-- Stats Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    {{-- Total Kategori --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                            <i class="fa-solid fa-layer-group text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-secondary/60 mb-1">Total Kategori</p>
                            <h3 class="text-2xl font-extrabold text-primary">{{ $categories->count() }}</h3>
                        </div>
                    </div>

                    {{-- Total Produk --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full bg-accent/10 flex items-center justify-center text-accent">
                            <i class="fa-solid fa-box text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-secondary/60 mb-1">Total Produk</p>
                            <h3 class="text-2xl font-extrabold text-primary">{{ $totalProducts }}</h3>
                        </div>
                    </div>

                    {{-- Tersedia --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-4">
                        <div
                            class="w-14 h-14 rounded-full bg-green-500/10 flex items-center justify-center text-green-500">
                            <i class="fa-solid fa-check-circle text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-secondary/60 mb-1">Tersedia</p>
                            <h3 class="text-2xl font-extrabold text-primary">{{ $availableProducts }}</h3>
                        </div>
                    </div>

                    {{-- Habis --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full bg-red-500/10 flex items-center justify-center text-red-500">
                            <i class="fa-solid fa-times-circle text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-secondary/60 mb-1">Tidak Tersedia</p>
                            <h3 class="text-2xl font-extrabold text-primary">{{ $unavailableProducts }}</h3>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Kategori Filter --}}
                    <div
                        class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
                        <div class="p-6 border-b border-slate-100 flex items-center justify-between gap-3">
                            <h2 class="text-lg font-bold text-primary">Filter Kategori</h2>
                            <a href="{{ route('kasir.stok') }}"
                                class="text-xs font-bold text-primary hover:text-secondary transition-colors">Reset</a>
                        </div>
                        <div class="p-4 overflow-auto flex-1 space-y-2">
                            <a href="{{ route('kasir.stok') }}"
                                class="flex items-center justify-between rounded-xl border px-4 py-3 text-sm font-bold transition-colors {{ blank($selectedCategoryId) ? 'border-primary bg-primary text-white' : 'border-slate-200 bg-white text-primary hover:bg-slate-50' }}">
                                <span>Semua Kategori</span>
                                <span class="text-xs">{{ $totalProducts }}</span>
                            </a>

                            @forelse ($categories as $category)
                                <a href="{{ route('kasir.stok', ['category' => $category->id]) }}"
                                    class="flex items-center justify-between rounded-xl border px-4 py-3 text-sm font-bold transition-colors {{ (string) $selectedCategoryId === (string) $category->id ? 'border-primary bg-primary text-white' : 'border-slate-200 bg-white text-primary hover:bg-slate-50' }}">
                                    <div class="flex items-center gap-2">
                                        <span>{{ $category->name }}</span>
                                        @if (!($category->is_active ?? true))
                                            <span class="rounded-full bg-red-100 px-2 py-0.5 text-[10px] font-bold text-red-700">Nonaktif</span>
                                        @endif
                                    </div>
                                    <span class="text-xs">{{ $category->products_count }}</span>
                                </a>
                            @empty
                                <p class="py-6 text-center text-sm text-secondary/50">Belum ada kategori.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Produk Table --}}
                    <div
                        class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
                        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                            <h2 class="text-lg font-bold text-primary">Data Stok Produk</h2>
                            <p class="text-xs font-semibold text-secondary/60">
                                Menampilkan {{ $products->count() }} dari {{ $products->total() }} produk
                            </p>
                        </div>
                        <div class="p-0 overflow-auto flex-1">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-50 text-secondary/70 text-sm">
                                    <tr>
                                        <th class="py-3 px-6 font-semibold">Produk</th>
                                        <th class="py-3 px-6 font-semibold">Kategori</th>
                                        <th class="py-3 px-6 font-semibold">Harga</th>
                                        <th class="py-3 px-6 font-semibold">Stok</th>
                                        <th class="py-3 px-6 font-semibold text-center">Status Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                            <td class="py-4 px-6">
                                                <div class="flex items-center gap-3">
                                                    @if ($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}"
                                                            class="w-10 h-10 rounded-lg object-cover bg-slate-50">
                                                    @else
                                                        <div
                                                            class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                                                            <i class="fa-solid fa-box"></i>
                                                        </div>
                                                    @endif
                                                    <span class="font-bold text-primary">{{ $product->name }}</span>
                                                </div>
                                            </td>
                                            <td class="py-4 px-6 text-sm font-semibold text-secondary/70">
                                                {{ $product->category->name ?? '-' }}
                                            </td>
                                            <td class="py-4 px-6 font-bold text-primary">
                                                Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="py-4 px-6 font-bold text-primary">
                                                {{ $product->stock }}
                                            </td>
                                            <td class="py-4 px-6 text-center">
                                                <button type="button" onclick="toggleStock({{ $product->id }}, this)"
                                                    class="px-3 py-1 rounded-full text-xs font-bold w-24 transition-colors {{ $product->is_available ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }}">
                                                    {{ $product->is_available ? 'Tersedia' : 'Habis' }}
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-6 text-center text-secondary/50">Belum ada
                                                produk.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-6 py-4 border-t border-slate-100">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const clockElements = document.querySelectorAll('.clock-display');
            const updateTime = () => {
                const now = new Date();
                const formattedTime = now.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
                clockElements.forEach(el => {
                    el.textContent = `${formattedTime} WIB`;
                });
            };
            updateTime();
            setInterval(updateTime, 1000);
        });

        function toggleStock(productId, btn) {
            btn.disabled = true;
            const originalText = btn.innerText;
            btn.innerText = '...';

            fetch(`/kasir/stok/${productId}/toggle`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    btn.disabled = false;
                    if (data.success) {
                        if (data.is_available) {
                            btn.className =
                                'px-3 py-1 rounded-full text-xs font-bold w-24 transition-colors bg-green-100 text-green-700 hover:bg-green-200';
                            btn.innerText = 'Tersedia';
                        } else {
                            btn.className =
                                'px-3 py-1 rounded-full text-xs font-bold w-24 transition-colors bg-red-100 text-red-700 hover:bg-red-200';
                            btn.innerText = 'Habis';
                        }
                    }
                })
                .catch(err => {
                    console.error(err);
                    btn.disabled = false;
                    btn.innerText = originalText;
                    alert('Terjadi kesalahan jaringan.');
                });
        }
    </script>
</x-app-layout>
