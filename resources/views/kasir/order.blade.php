<x-app-layout :title="'Order Kasir'">
    <div class="flex h-screen bg-slate-50 font-sans selection:bg-accent selection:text-primary overflow-hidden">
        <x-sidebar />

        <main class="flex-1 flex flex-col h-screen overflow-y-auto lg:overflow-hidden">
            <header
                class="bg-white/80 backdrop-blur-md min-h-[72px] py-4 px-4 sm:px-8 flex flex-col sm:flex-row items-center justify-between sm:justify-end shadow-sm z-20 border-b border-slate-100 flex-shrink-0 sticky top-0 gap-4">
                
                <!-- Hamburger menu placeholder if needed for mobile sidebar later -->
                <div class="w-full sm:hidden flex justify-between items-center mb-2">
                    <h1 class="font-black text-xl text-primary">Library Cafe</h1>
                    <div class="text-right leading-tight">
                        <p class="text-primary font-bold">{{ date('H:i:s') }} WIB</p>
                    </div>
                </div>

                <div class="flex items-center gap-5 w-full sm:w-auto">
                    <form method="GET" action="{{ route('kasir.order') }}" class="relative w-full sm:w-64 flex-shrink-0">
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <div class="absolute inset-y-0 left-0 flex items-center pl-1">
                            <button type="submit"
                                class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center hover:bg-info transition-colors">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </button>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="bg-white border text-primary text-sm rounded-full focus:ring-accent focus:border-accent border-secondary/10 block w-full pl-12 pr-4 py-2 font-medium placeholder:text-secondary/40"
                            placeholder="Cari menu...">
                    </form>
                    <div class="text-right leading-tight hidden sm:block">
                        <p class="text-sm font-bold text-primary">{{ now()->translatedFormat('l, d F Y') }}</p>
                        <p class="text-primary font-bold">{{ date('H:i:s') }} WIB</p>
                    </div>
                </div>
            </header>
            
            <div class="flex-1 flex flex-col lg:flex-row p-4 sm:p-6 gap-6 lg:overflow-hidden">
                <section class="flex-1 flex flex-col gap-5 lg:overflow-hidden">
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

                    <div class="flex-1 bg-white rounded-[28px] p-4 sm:p-6 shadow-sm border border-slate-200 lg:overflow-y-auto custom-scrollbar">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
                            <div>
                                <h2 class="text-xl sm:text-2xl font-black text-primary">Daftar Menu</h2>
                                <p class="text-sm text-secondary/60 mt-1">Pilih produk dari daftar berikut</p>
                            </div>
                            <div class="inline-flex items-center self-start sm:self-center rounded-2xl bg-slate-100 px-4 py-2 text-xs font-black text-primary border border-slate-200">
                                {{ count($products ?? []) }} Items
                            </div>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4">
                            @forelse($products ?? [] as $product)
                                @php
                                    $words = explode(' ', $product->name);
                                    if (count($words) >= 2) {
                                        $productInitials = strtoupper(
                                            substr($words[0], 0, 1) . substr($words[1], 0, 1),
                                        );
                                    } else {
                                        $productInitials = strtoupper(substr($product->name, 0, 2));
                                    }
                                @endphp
                                <button type="button"
                                    class="group text-left flex flex-col aspect-square w-full rounded-2xl border border-[#eef2f9] bg-white p-3 sm:p-3.5 shadow-sm transition-all duration-200 hover:shadow-lg {{ $product->stock == 0 ? 'opacity-60 cursor-not-allowed grayscale-[50%]' : 'cursor-pointer' }}"
                                    @if($product->stock > 0) data-add-to-cart @else disabled @endif 
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name }}"
                                    data-product-price="{{ $product->price }}">

                                    <div class="relative flex-1 w-full flex items-center justify-center overflow-hidden rounded-xl bg-[#f4f7fe] border border-[#eef2f9]">
                                        @if($product->stock == 0)
                                            <div class="absolute top-2 right-2 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-lg z-10 shadow-sm">
                                                Habis
                                            </div>
                                            {{-- low stok --}}
                                        @elseif($product->stock <= 10)
                                            <div class="absolute top-2 right-2 bg-amber-500 text-white text-[10px] font-bold px-2 py-1 rounded-lg z-10 shadow-sm">
                                                Sisa {{ $product->stock }}
                                            </div>
                                        @endif
                                        <div class="flex aspect-square items-center justify-center text-6xl sm:text-8xl tracking-tighter text-primary">
                                            {{ $productInitials }}
                                        </div>
                                    </div>

                                    <div class="mt-2 w-full">
                                        <h3 class="truncate text-xs sm:text-[0.9rem] font-bold leading-tight text-primary">
                                            {{ $product->name }}
                                        </h3>
                                        <p class="mt-0.5 text-sm sm:text-[1.1rem] font-black leading-none tracking-tight text-accent">
                                            Rp{{ number_format($product->price, 0, ',', '.') }}
                                        </p>
                                        <p class="mt-1 text-[10px] sm:text-xs font-semibold {{ $product->stock == 0 ? 'text-red-500' : ($product->stock <= 5 ? 'text-amber-500' : 'text-secondary/60') }}">
                                            Stok: {{ $product->stock }}
                                        </p>
                                    </div>
                                </button>
                            @empty
                                <div class="col-span-full h-48 flex flex-col items-center justify-center text-secondary/40 space-y-4 bg-slate-100 rounded-2xl border border-dashed border-slate-200">
                                    <i class="fa-solid fa-utensils text-3xl sm:text-4xl"></i>
                                    <p class="font-semibold text-xs sm:text-sm text-center px-4">Belum ada menu yang tersedia</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </section>

                <aside
                    class="w-full lg:max-w-[360px] bg-white rounded-[28px] shadow-sm border border-slate-200 flex flex-col overflow-hidden shrink-0 h-[500px] lg:h-auto mt-4 lg:mt-0">
                    <div class="p-4 sm:p-6 border-b border-secondary/10 flex items-center justify-between gap-4">
                        <div>
                            <h2 class="font-black text-xl sm:text-2xl text-primary">Current Order</h2>
                        </div>

                        <button type="button" id="clear-cart"
                            class="text-xs sm:text-sm font-bold text-red-500 hover:text-red-600 transition-colors">
                            Clear All
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto p-4 sm:p-6 custom-scrollbar space-y-3 sm:space-y-4" data-cart-items>
                        <div class="flex flex-col items-center justify-center text-secondary/40 space-y-3 py-12">
                            <i class="fa-solid fa-cart-shopping text-5xl sm:text-7xl"></i>
                            <p class="font-bold text-xs sm:text-sm text-center px-4">Belum ada produk di keranjang</p>
                        </div>
                    </div>

                    <div class="border-t border-slate-200 p-4 sm:p-6 space-y-4 bg-white">
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
                            <button type="button" id="split-bill"
                                class="inline-flex items-center justify-center rounded-2xl border border-primary bg-white px-2 sm:px-4 py-2.5 sm:py-3.5 text-xs sm:text-sm font-black text-primary transition-colors hover:bg-slate-100"
                                title="Fitur split bill segera hadir">
                                Split Bill
                            </button>
                            <button type="button" id="process-order"
                                class="inline-flex items-center justify-center rounded-2xl bg-primary px-2 sm:px-4 py-2.5 sm:py-3.5 text-xs sm:text-sm font-black text-white shadow-md shadow-primary/20 transition-colors hover:bg-secondary">
                                Checkout
                            </button>
                        </div>
                    </div>
                </aside>
            </div>
        </main>
    </div>

    {{-- pop up tambah ke order kerangjang --}}
    <div id="cart-toast"
        class="fixed top-6 right-6 z-50 hidden min-w-[240px] sm:min-w-[280px] rounded-2xl bg-slate-950 px-4 py-3 text-white shadow-2xl shadow-slate-950/30">
        <p class="text-xs sm:text-sm font-semibold">Produk ditambahkan ke keranjang</p>
        <p class="text-[10px] sm:text-xs text-white/60 mt-1" data-toast-text></p>
    </div>

    <script>
        // script jam
        document.addEventListener('DOMContentLoaded', function() {
            const clockEl = document.querySelector('.clock-display');
            if (clockEl) {
                setInterval(() => {
                    const now = new Date();
                    clockEl.textContent = now.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    }) + ' WIB';
                }, 1000);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const cart = new Map();
            const cartItems = document.querySelector('[data-cart-items]');
            const cartTotal = document.querySelector('[data-cart-total]');
            const cartSubtotal = document.querySelector('[data-cart-subtotal]');
            const toast = document.getElementById('cart-toast');
            const toastText = document.querySelector('[data-toast-text]');
            const processButton = document.getElementById('process-order');
            const clearButton = document.getElementById('clear-cart');
            const splitBillButton = document.getElementById('split-bill');
            let toastTimer = null;

            const activeCheckout = JSON.parse(localStorage.getItem('kasir-active-checkout') || 'null');

            if (activeCheckout?.items?.length) {
                activeCheckout.items.forEach((item) => {
                    cart.set(String(item.id), {
                        id: String(item.id),
                        name: item.name,
                        price: Number(item.price || 0),
                        quantity: Number(item.quantity || 1),
                    });
                });
            }

            const formatCurrency = (value) => new Intl.NumberFormat('id-ID').format(value);

            const showToast = (message) => {
                if (!toast || !toastText) {
                    return;
                }

                toastText.textContent = message;
                toast.classList.remove('hidden');

                if (toastTimer) {
                    clearTimeout(toastTimer);
                }

                toastTimer = setTimeout(() => {
                    toast.classList.add('hidden');
                }, 2200);
            };

            const getCartSnapshot = () => {
                return Array.from(cart.values()).map((item) => ({
                    id: item.id,
                    name: item.name,
                    price: item.price,
                    quantity: item.quantity,
                    subtotal: item.quantity * item.price,
                }));
            };

            const updateTotals = () => {
                let totalItems = 0;
                let totalPrice = 0;

                cart.forEach((item) => {
                    totalItems += item.quantity;
                    totalPrice += item.quantity * item.price;
                });

                if (cartSubtotal) {
                    cartSubtotal.textContent = `Rp ${formatCurrency(totalPrice)}`;
                }

                if (cartTotal) {
                    cartTotal.textContent = `Rp ${formatCurrency(totalPrice)}`;
                }

                return {
                    totalItems,
                    totalPrice
                };
            };

            const renderCart = () => {
                if (!cartItems) {
                    return;
                }

                if (cart.size === 0) {
                    cartItems.innerHTML = `
                        <div class="flex flex-col items-center justify-center text-secondary/40 space-y-3 py-12">
                            <i class="fa-solid fa-cart-shopping text-5xl"></i>
                            <p class="font-bold text-sm text-center">Belum ada produk di keranjang</p>
                        </div>
                    `;
                    updateTotals();
                    return;
                }

                cartItems.innerHTML = Array.from(cart.values()).map((item) => `
                    <div class="flex items-center gap-4 rounded-[22px] border border-slate-200 bg-slate-100 p-3.5">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white text-sm font-black text-primary ring-1 ring-slate-200">
                            ${String(item.name || 'P')
                                .trim()
                                .split(/\s+/)
                                .filter(Boolean)
                                .slice(0, 2)
                                .map((part) => part.charAt(0))
                                .join('')
                                .toUpperCase()}
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="truncate text-sm font-black text-primary">${item.name}</h3>
                            <p class="mt-0.5 text-xs font-semibold text-secondary/55">Single item</p>

                            <div class="mt-2 inline-flex items-center rounded-2xl bg-white px-2 py-1 shadow-sm ring-1 ring-slate-200">
                                <button type="button" class="h-7 w-7 rounded-xl bg-slate-100 text-secondary hover:text-primary transition-colors" data-cart-action="decrease" data-product-id="${item.id}">
                                    <i class="fa-solid fa-minus text-[10px]"></i>
                                </button>
                                <span class="min-w-10 px-2 text-center text-xs font-black text-primary">${item.quantity}</span>
                                <button type="button" class="h-7 w-7 rounded-xl bg-primary/10 text-primary hover:bg-primary hover:text-white transition-colors" data-cart-action="increase" data-product-id="${item.id}">
                                    <i class="fa-solid fa-plus text-[10px]"></i>
                                </button>
                            </div>
                        </div>

                        <div class="text-right">
                            <p class="text-sm font-black text-primary">Rp ${formatCurrency(item.price * item.quantity)}</p>
                            <button type="button" class="mt-2 text-xs font-bold text-secondary/55 hover:text-red-500 transition-colors" data-cart-action="remove" data-product-id="${item.id}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `).join('');

                updateTotals();
            };

            document.querySelectorAll('[data-add-to-cart]').forEach((card) => {
                card.addEventListener('click', function() {
                    const id = String(this.dataset.productId);
                    const name = this.dataset.productName;
                    const price = Number(this.dataset.productPrice || 0);

                    if (cart.has(id)) {
                        cart.get(id).quantity += 1;
                    } else {
                        cart.set(id, {
                            id,
                            name,
                            price,
                            quantity: 1
                        });
                    }

                    renderCart();
                    showToast(`${name} masuk keranjang`);
                });
            });

            document.addEventListener('click', function(event) {
                const actionButton = event.target.closest('[data-cart-action]');

                if (!actionButton) {
                    return;
                }

                const id = String(actionButton.dataset.productId);
                const action = actionButton.dataset.cartAction;
                const item = cart.get(id);

                if (!item) {
                    return;
                }

                if (action === 'increase') {
                    item.quantity += 1;
                }

                if (action === 'decrease') {
                    item.quantity -= 1;
                    if (item.quantity <= 0) {
                        cart.delete(id);
                    }
                }

                if (action === 'remove') {
                    cart.delete(id);
                }

                renderCart();
            });

            if (clearButton) {
                clearButton.addEventListener('click', function() {
                    cart.clear();
                    localStorage.removeItem('kasir-active-checkout');
                    renderCart();
                });
            }

            if (processButton) {
                processButton.addEventListener('click', function() {
                    if (cart.size === 0) {
                        showToast('Keranjang masih kosong');
                        return;
                    }

                    const snapshot = getCartSnapshot();
                    const totals = updateTotals();

                    localStorage.setItem('kasir-active-checkout', JSON.stringify({
                        id: `order-${Date.now()}`,
                        status: 'pending_payment',
                        created_at: new Date().toISOString(),
                        items: snapshot,
                        totalItems: totals.totalItems,
                        totalPrice: totals.totalPrice,
                    }));

                    window.location.href = "{{ route('kasir.payment') }}";
                });
            }

            if (splitBillButton) {
                splitBillButton.addEventListener('click', function() {
                    if (cart.size === 0) {
                        showToast('Keranjang masih kosong');
                        return;
                    }

                    const snapshot = getCartSnapshot();
                    const totals = updateTotals();

                    localStorage.setItem('kasir-split-checkout', JSON.stringify({
                        id: `split-${Date.now()}`,
                        status: 'pending_split',
                        created_at: new Date().toISOString(),
                        items: snapshot,
                        totalItems: totals.totalItems,
                        totalPrice: totals.totalPrice,
                    }));

                    window.location.href = "{{ route('kasir.split-bill') }}";
                });
            }

            renderCart();
        });
    </script>
</x-app-layout>
