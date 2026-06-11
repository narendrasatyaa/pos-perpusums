<x-app-layout :title="'Order Kasir'">
    <div class="flex h-screen bg-slate-50 font-sans selection:bg-accent selection:text-primary overflow-hidden">
        <x-sidebar />

        <main class="flex-1 flex flex-col h-screen overflow-y-auto lg:overflow-hidden">
            <!-- HEADER -->
            <header class="bg-white/80 backdrop-blur-md min-h-[72px] py-4 px-4 sm:px-8 flex flex-col sm:flex-row items-center justify-between sm:justify-end shadow-sm z-20 border-b border-slate-100 flex-shrink-0 sticky top-0 gap-4">
                <div class="flex items-center gap-5 w-full sm:w-auto">
                    <form method="GET" action="{{ route('kasir.order') }}" class="relative w-full sm:w-64 flex-shrink-0">
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <div class="absolute inset-y-0 left-0 flex items-center pl-1">
                            <button type="submit" class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center hover:bg-info transition-colors">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </button>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="bg-white border text-primary text-sm rounded-full focus:ring-accent focus:border-accent border-secondary/10 block w-full pl-12 pr-4 py-2 font-medium placeholder:text-secondary/40"
                            placeholder="Cari menu...">
                    </form>
                    <div class="text-right leading-tight hidden sm:block">
                        <p class="text-sm font-bold text-primary">{{ now()->translatedFormat('l, d F Y') }}</p>
                        <p id="live-clock" class="text-primary font-bold"></p>
                    </div>
                </div>
            </header>

            <div class="flex-1 flex flex-col lg:flex-row p-4 sm:p-6 gap-6 lg:overflow-hidden">
                <section class="flex-1 flex flex-col gap-5 lg:overflow-hidden">
                    
                    <!-- Categories -->
                    <div class="bg-white rounded-[28px] p-3 shadow-sm border border-slate-200 shrink-0 w-full overflow-x-auto custom-scrollbar">
                        <div class="flex items-center gap-2 pb-1 w-max">
                            <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}"
                                class="inline-flex items-center rounded-full border px-4 py-2.5 text-sm font-bold whitespace-nowrap transition-colors {{ !request('category') ? 'border-primary bg-primary text-white' : 'border-secondary/10 bg-white text-secondary/70 hover:bg-slate-100 hover:text-primary' }}">
                                All Menu
                            </a>
                            @foreach ($categories ?? [] as $category)
                                <a href="{{ request()->fullUrlWithQuery(['category' => $category->id]) }}"
                                    class="inline-flex items-center rounded-full border px-4 py-2.5 text-sm font-bold whitespace-nowrap transition-colors {{ request('category') == $category->id ? 'border-primary bg-primary text-white' : 'border-secondary/10 bg-white text-secondary/70 hover:bg-slate-100 hover:text-primary' }}">
                                    {{ $category->name ?? 'Category' }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Product Grid - Kecil & Minimalis -->
                    <div class="flex-1 bg-white rounded-[28px] p-4 sm:p-6 shadow-sm border border-slate-200 lg:overflow-y-auto custom-scrollbar">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                            <div>
                                <h2 class="text-xl sm:text-2xl font-black text-primary">Daftar Menu</h2>
                                <p class="text-sm text-secondary/60 mt-1">Pilih produk dari daftar berikut</p>
                            </div>
                            <div class="inline-flex items-center self-start sm:self-center rounded-2xl bg-slate-100 px-4 py-2 text-xs font-black text-primary border border-slate-200">
                                {{ count($products ?? []) }} Items
                            </div>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
                            @forelse($products ?? [] as $product)
                                @php
                                    $words = explode(' ', $product->name);
                                    $initials = count($words) >= 2 
                                        ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1))
                                        : strtoupper(substr($product->name, 0, 2));
                                @endphp

                                <button type="button"
                                    class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-md hover:border-primary/30 transition-all duration-200 {{ $product->stock == 0 ? 'opacity-60 cursor-not-allowed grayscale' : 'cursor-pointer' }}"
                                    @if ($product->stock > 0) data-add-to-cart @else disabled @endif
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name }}"
                                    data-product-price="{{ $product->price }}"
                                    data-product-stock="{{ $product->stock }}">

                                    <!-- Image Area - Kecil -->
                                    <div class="relative h-32 bg-slate-100 flex items-center justify-center overflow-hidden">
                                        @if (!empty($product->image))
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <span class="text-4xl font-black text-primary/70">
                                                {{ $initials }}
                                            </span>
                                        @endif

                                        @if ($product->stock == 0)
                                            <div class="absolute top-2 right-2 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded">Habis</div>
                                        @elseif ($product->stock <= 10)
                                            <div class="absolute top-2 right-2 bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded">Sisa {{ $product->stock }}</div>
                                        @endif
                                    </div>

                                    <!-- Info -->
                                    <div class="p-3">
                                        <h3 class="font-semibold text-xs leading-tight line-clamp-2 mb-1 text-primary">
                                            {{ $product->name }}
                                        </h3>
                                        <p class="text-base font-bold text-accent">
                                            Rp{{ number_format($product->price, 0, ',', '.') }}
                                        </p>
                                        <p class="text-[10px] text-slate-500 mt-1">
                                            Stok: {{ $product->stock }}
                                        </p>
                                    </div>
                                </button>
                            @empty
                                <div class="col-span-full h-48 flex flex-col items-center justify-center text-secondary/40">
                                    <i class="fa-solid fa-utensils text-4xl mb-3"></i>
                                    <p class="font-medium">Belum ada menu tersedia</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </section>

                <!-- CART SIDEBAR -->
                <aside class="w-full lg:max-w-[360px] bg-white rounded-[28px] shadow-sm border border-slate-200 flex flex-col overflow-hidden shrink-0 h-[500px] lg:h-auto mt-4 lg:mt-0">
                    <div class="p-4 sm:p-6 border-b border-secondary/10 flex items-center justify-between gap-4">
                        <h2 class="font-black text-xl sm:text-2xl text-primary">Current Order</h2>
                        <button type="button" id="clear-cart" class="text-xs sm:text-sm font-bold text-red-500 hover:text-red-600 transition-colors">
                            Clear All
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto p-4 sm:p-6 custom-scrollbar space-y-3 sm:space-y-4" data-cart-items></div>

                    <div class="border-t border-slate-200 p-4 sm:p-6 space-y-4">
                        <div class="space-y-2 sm:space-y-3 text-xs sm:text-sm">
                            <div class="flex items-center justify-between text-secondary/60 font-medium">
                                <span>Subtotal</span>
                                <span class="font-bold text-primary" data-cart-subtotal>Rp 0</span>
                            </div>
                            <div class="flex items-center justify-between text-secondary/60 font-medium">
                                <span>Total Amount</span>
                                <span class="text-xl sm:text-2xl font-black text-primary" data-cart-total>Rp 0</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 sm:gap-3 pt-2">
                            <button type="button" id="split-bill" class="inline-flex items-center justify-center rounded-2xl border border-primary bg-white px-4 py-3 text-xs sm:text-sm font-black text-primary hover:bg-slate-100">
                                Split Bill
                            </button>
                            <button type="button" id="process-order" class="inline-flex items-center justify-center rounded-2xl bg-primary px-4 py-3 text-xs sm:text-sm font-black text-white shadow-md shadow-primary/20 hover:bg-secondary">
                                Checkout
                            </button>
                        </div>
                    </div>
                </aside>
            </div>
        </main>
    </div>

    <!-- Toast -->
    <div id="cart-toast" class="fixed top-6 right-6 z-50 hidden min-w-[240px] sm:min-w-[280px] rounded-2xl bg-slate-950 px-4 py-3 text-white shadow-2xl shadow-slate-950/30">
        <p class="text-xs sm:text-sm font-semibold">Produk ditambahkan ke keranjang</p>
        <p class="text-[10px] sm:text-xs text-white/60 mt-1" data-toast-text></p>
    </div>

    <!-- Split modal -->
    <div id="split-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" data-modal-backdrop></div>
        <div class="relative w-full max-w-md mx-4">
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h3 class="text-lg font-black text-primary">Bagi Tagihan</h3>
                    <p class="text-xs text-secondary/60 mt-1">Pilih berapa bagian tagihan akan dibagi.</p>
                </div>
                <div class="p-5 space-y-4">
                    <div class="flex items-center gap-3">
                        <button type="button" id="split-decrease" class="h-9 w-9 rounded-lg bg-white border text-primary">-</button>
                        <input id="split-count" type="number" min="2" max="20" value="2" class="w-20 text-center text-xl font-black border-0 bg-transparent focus:ring-0">
                        <button type="button" id="split-increase" class="h-9 w-9 rounded-lg bg-primary text-white">+</button>
                        <div class="ml-auto text-sm text-secondary/60">Maks 20</div>
                    </div>
                    <div class="text-xs text-secondary/70">Total saat ini: <span id="split-total-preview">Rp 0</span></div>
                </div>
                <div class="px-5 py-4 bg-slate-50 flex items-center justify-end gap-2">
                    <button type="button" id="split-cancel" class="inline-flex items-center px-4 py-2 rounded-xl border bg-white text-sm font-bold text-primary">Batal</button>
                    <button type="button" id="split-confirm" class="inline-flex items-center px-4 py-2 rounded-xl bg-primary text-sm font-black text-white">Lanjut</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Live Clock
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

        // Cart Logic
        document.addEventListener('DOMContentLoaded', function() {
            const cart = new Map();
            const cartItemsContainer = document.querySelector('[data-cart-items]');
            const cartTotalEl = document.querySelector('[data-cart-total]');
            const cartSubtotalEl = document.querySelector('[data-cart-subtotal]');
            const toast = document.getElementById('cart-toast');
            const toastText = document.querySelector('[data-toast-text]');

            const formatCurrency = (value) => new Intl.NumberFormat('id-ID').format(value);

            const showToast = (message) => {
                if (!toast || !toastText) {
                    console.warn('Toast not available:', message);
                    return;
                }
                toastText.textContent = message;
                toast.classList.remove('hidden');
                setTimeout(() => toast.classList.add('hidden'), 2200);
            };

            const updateTotals = () => {
                let total = 0;
                cart.forEach(item => total += item.price * item.quantity);
                if (cartSubtotalEl) cartSubtotalEl.textContent = `Rp ${formatCurrency(total)}`;
                if (cartTotalEl) cartTotalEl.textContent = `Rp ${formatCurrency(total)}`;
            };

            const renderCart = () => {
                if (cart.size === 0) {
                    cartItemsContainer.innerHTML = `
                        <div class="flex flex-col items-center justify-center text-secondary/40 space-y-3 py-12">
                            <i class="fa-solid fa-cart-shopping text-5xl"></i>
                            <p class="font-bold text-xs sm:text-sm text-center">Belum ada produk di keranjang</p>
                        </div>
                    `;
                    updateTotals();
                    return;
                }

                let html = '';
                cart.forEach(item => {
                    html += `
                        <div class="flex gap-3 bg-slate-50 rounded-2xl p-3">
                            <div class="w-9 h-9 bg-white rounded-xl flex items-center justify-center text-xs font-bold text-primary ring-1 ring-slate-200">
                                ${item.name.substring(0,2).toUpperCase()}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-primary">${item.name}</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <button data-cart-action="decrease" data-product-id="${item.id}" class="w-5 h-5 rounded bg-white border text-xs flex items-center justify-center">-</button>
                                    <span class="font-bold text-xs px-2">${item.quantity}</span>
                                    <button data-cart-action="increase" data-product-id="${item.id}" class="w-5 h-5 rounded bg-primary text-white text-xs flex items-center justify-center">+</button>
                                </div>
                            </div>
                            <div class="text-right text-xs">
                                <p class="font-bold">Rp ${formatCurrency(item.price * item.quantity)}</p>
                                <button data-cart-action="remove" data-product-id="${item.id}" class="text-red-500 mt-1">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });
                cartItemsContainer.innerHTML = html;
                updateTotals();
            };

            document.querySelectorAll('[data-add-to-cart]').forEach(card => {
                card.addEventListener('click', function() {
                    const id = this.dataset.productId;
                    const name = this.dataset.productName;
                    const price = Number(this.dataset.productPrice);
                    const stock = Number(this.dataset.productStock || 0);

                    if (stock <= 0) {
                        return showToast(`${name} stok habis`);
                    }

                    if (cart.has(id)) {
                        const item = cart.get(id);
                        if (item.quantity >= item.stock) {
                            return showToast(`Maksimal ${item.stock} untuk ${name}`);
                        }
                        item.quantity++;
                    } else {
                        cart.set(id, { id, name, price, stock, quantity: 1 });
                    }

                    renderCart();
                    showToast(name + ' masuk keranjang');
                });
            });

            document.addEventListener('click', e => {
                const btn = e.target.closest('[data-cart-action]');
                if (!btn) return;
                const id = btn.dataset.productId;
                const action = btn.dataset.cartAction;
                const item = cart.get(id);
                if (!item) return;

                if (action === 'increase') {
                    if (item.quantity >= item.stock) {
                        return showToast(`Maksimal ${item.stock} untuk ${item.name}`);
                    }
                    item.quantity++;
                }
                if (action === 'decrease') {
                    item.quantity--;
                    if (item.quantity <= 0) cart.delete(id);
                }
                if (action === 'remove') cart.delete(id);

                renderCart();
            });

            document.getElementById('clear-cart').addEventListener('click', () => { cart.clear(); renderCart(); });
            document.getElementById('process-order').addEventListener('click', () => {
                if (cart.size === 0) return showToast('Keranjang kosong');

                const items = Array.from(cart.values()).map(i => ({
                    id: i.id,
                    product_id: i.id,
                    name: i.name,
                    product_name: i.name,
                    price: Number(i.price || 0),
                    quantity: Number(i.quantity || 0),
                    subtotal: Number(i.price || 0) * Number(i.quantity || 0),
                }));

                const totalItems = items.reduce((s, it) => s + Number(it.quantity || 0), 0);
                const totalPrice = items.reduce((s, it) => s + Number(it.subtotal || 0), 0);

                const payload = {
                    id: `order-${Date.now()}`,
                    created_at: new Date().toISOString(),
                    items,
                    totalItems,
                    totalPrice,
                    totalPriceDisplay: `Rp ${new Intl.NumberFormat('id-ID').format(totalPrice)}`,
                };

                localStorage.setItem('kasir-active-checkout', JSON.stringify(payload));
                window.location.href = "{{ route('kasir.payment') }}";
            });

            // Split Bill: open modal to choose split count, then compute and redirect
            (function() {
                const splitBtn = document.getElementById('split-bill');
                const modal = document.getElementById('split-modal');
                const backdrop = modal?.querySelector('[data-modal-backdrop]');
                const input = document.getElementById('split-count');
                const inc = document.getElementById('split-increase');
                const dec = document.getElementById('split-decrease');
                const cancel = document.getElementById('split-cancel');
                const confirm = document.getElementById('split-confirm');
                const preview = document.getElementById('split-total-preview');

                const openModal = () => {
                    if (!modal) return;
                    // ensure cart not empty
                    if (cart.size === 0) return showToast('Keranjang kosong');
                    // set default
                    input.value = 2;
                    updatePreviewTotal();
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                };

                const closeModal = () => {
                    if (!modal) return;
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                };

                const clamp = (v) => Math.min(20, Math.max(2, Number(v) || 2));

                const updatePreviewTotal = () => {
                    let total = 0;
                    cart.forEach(item => total += item.price * item.quantity);
                    if (preview) preview.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(total)}`;
                };

                if (inc) inc.addEventListener('click', () => { input.value = clamp(Number(input.value) + 1); });
                if (dec) dec.addEventListener('click', () => { input.value = clamp(Number(input.value) - 1); });
                if (input) input.addEventListener('input', () => { input.value = clamp(input.value); });
                if (backdrop) backdrop.addEventListener('click', closeModal);
                if (cancel) cancel.addEventListener('click', closeModal);

                if (confirm) confirm.addEventListener('click', () => {
                    const parts = clamp(Number(input.value));
                    let total = 0;
                    cart.forEach(item => total += item.price * item.quantity);

                    const base = Math.floor(total / parts);
                    let remainder = total - base * parts;
                    const splits = [];
                    for (let i = 0; i < parts; i++) {
                        let amt = base + (remainder > 0 ? 1 : 0);
                        if (remainder > 0) remainder--;
                        splits.push({ index: i + 1, amount: amt });
                    }

                    const items = Array.from(cart.values()).map(i => ({
                        id: i.id,
                        product_id: i.id,
                        name: i.name,
                        product_name: i.name,
                        price: Number(i.price || 0),
                        quantity: Number(i.quantity || 0),
                        subtotal: Number(i.price || 0) * Number(i.quantity || 0),
                    }));
                    const totalItems = items.reduce((s, it) => s + Number(it.quantity || 0), 0);
                    const totalPrice = items.reduce((s, it) => s + Number(it.subtotal || 0), 0);

                    localStorage.setItem('kasir-split-checkout', JSON.stringify({ items, totalItems, totalPrice: totalPrice, total, splits }));
                    closeModal();
                    window.location.href = "{{ route('kasir.split-bill') }}";
                });

                if (splitBtn) splitBtn.addEventListener('click', openModal);
            })();

            renderCart();
        });
    </script>
</x-app-layout>