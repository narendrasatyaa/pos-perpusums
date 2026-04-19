<x-app-layout :title="'Order Kasir'">
    <div class="flex h-screen bg-[#f4f7fe] font-sans selection:bg-accent selection:text-primary">
        <x-sidebar />

        <div class="flex-1 flex flex-col h-screen overflow-hidden">
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
                                <div
                                    class="bg-white rounded-2xl p-4 shadow-sm border border-[#eef2f9] flex flex-col transition-all hover:shadow-lg group cursor-pointer"
                                    data-add-to-cart
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name ?? 'Product Name' }}"
                                    data-product-price="{{ $product->price ?? 0 }}"
                                    data-product-image="{{ $product->image ? asset('storage/' . $product->image) : '' }}">
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
                    <div class="flex-1 overflow-y-auto p-6 space-y-4 custom-scrollbar" data-cart-items>
                        <div class="flex flex-col items-center justify-center text-secondary/40 space-y-3 py-12">
                            <i class="fa-solid fa-cart-shopping text-7xl"></i>
                            <p class="font-bold text-sm text-center">Belum ada produk di keranjang</p>
                        </div>
                    </div>
                    {{-- checkout --}}
                    <div class="p-6 bg-white border-t border-secondary/10 space-y-4">
                        <div class="flex items-center justify-between text-sm font-semibold text-secondary/60">
                            <span>Total</span>
                            <span class="text-lg font-extrabold text-primary" data-cart-total>Rp 0</span>
                        </div>
                        <div class="space-y-3">
                                    <button type="button" id="process-order"
                                class="w-full bg-primary hover:bg-secondary text-white py-4 rounded-2xl font-bold transition-all shadow-md shadow-accent/20">
                                Proses Order
                            </button>
                            <button type="button" id="save-history"
                                class="w-full bg-[#f4f7fe] hover:bg-[#e9effc] text-primary py-4 rounded-2xl font-bold transition-all">
                                Simpan ke History
                            </button>
                        </div>
                    </div>
                </aside>
            </main>
        </div>
    </div>

    {{-- notif tambah ke order kerangjang --}}
    {{-- <div id="cart-toast"
        class="fixed top-6 right-6 z-50 hidden min-w-[280px] rounded-2xl bg-slate-950 px-4 py-3 text-white shadow-2xl shadow-slate-950/30">
        <p class="text-sm font-semibold">Produk ditambahkan ke keranjang</p>
        <p class="text-xs text-white/60 mt-1" data-toast-text></p>
    </div> --}}

    <script>
        // script jam
        document.addEventListener('DOMContentLoaded', function() {
            const clockEl = document.querySelector('.clock-display');
            if(clockEl) {
                setInterval(() => {
                    const now = new Date();
                    clockEl.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }) + ' WIB';
                }, 1000);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const cart = new Map();
            const cartItems = document.querySelector('[data-cart-items]');
            const cartTotal = document.querySelector('[data-cart-total]');
            const cartCount = document.querySelector('[data-cart-count]');
            const toast = document.getElementById('cart-toast');
            const toastText = document.querySelector('[data-toast-text]');
            const processButton = document.getElementById('process-order');
            const saveHistoryButton = document.getElementById('save-history');
            let toastTimer = null;

            const activeCheckout = JSON.parse(localStorage.getItem('kasir-active-checkout') || 'null');

            if (activeCheckout?.items?.length) {
                activeCheckout.items.forEach((item) => {
                    cart.set(String(item.id), {
                        id: String(item.id),
                        name: item.name,
                        price: Number(item.price || 0),
                        image: item.image || '',
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
                    image: item.image,
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

                if (cartCount) {
                    cartCount.textContent = totalItems;
                }

                if (cartTotal) {
                    cartTotal.textContent = `Rp ${formatCurrency(totalPrice)}`;
                }

                return { totalItems, totalPrice };
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
                    <div class="flex items-center gap-4 rounded-2xl border border-[#eef2f9] bg-[#f4f7fe] p-3">
                        <div class="h-14 w-14 shrink-0 overflow-hidden rounded-xl bg-white flex items-center justify-center border border-[#eef2f9]">
                            ${item.image
                                ? `<img src="${item.image}" alt="${item.name}" class="h-full w-full object-cover">`
                                : `<i class="fa-solid fa-image text-xl text-secondary/20"></i>`}
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="truncate text-sm font-bold text-primary">${item.name}</h3>
                            <p class="text-xs font-semibold text-accent">Rp ${formatCurrency(item.price)}</p>

                            <div class="mt-2 flex items-center gap-2">
                                <button type="button" class="h-7 w-7 rounded-lg bg-white text-secondary hover:text-primary border border-[#eef2f9]" data-cart-action="decrease" data-product-id="${item.id}">
                                    <i class="fa-solid fa-minus text-[10px]"></i>
                                </button>
                                <span class="min-w-6 text-center text-xs font-bold text-primary">${item.quantity}</span>
                                <button type="button" class="h-7 w-7 rounded-lg bg-accent/10 text-accent hover:bg-accent hover:text-white" data-cart-action="increase" data-product-id="${item.id}">
                                    <i class="fa-solid fa-plus text-[10px]"></i>
                                </button>
                            </div>
                        </div>

                        <button type="button" class="h-8 w-8 rounded-lg bg-white text-secondary hover:text-red-500 border border-[#eef2f9]" data-cart-action="remove" data-product-id="${item.id}">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </div>
                `).join('');

                updateTotals();
            };

            document.querySelectorAll('[data-add-to-cart]').forEach((card) => {
                card.addEventListener('click', function() {
                    const id = String(this.dataset.productId);
                    const name = this.dataset.productName;
                    const price = Number(this.dataset.productPrice || 0);
                    const image = this.dataset.productImage || '';

                    if (cart.has(id)) {
                        cart.get(id).quantity += 1;
                    } else {
                        cart.set(id, { id, name, price, image, quantity: 1 });
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

            if (saveHistoryButton) {
                saveHistoryButton.addEventListener('click', function() {
                    if (cart.size === 0) {
                        showToast('Keranjang masih kosong');
                        return;
                    }

                    const history = JSON.parse(localStorage.getItem('kasir-order-history') || '[]');
                    const snapshot = getCartSnapshot();
                    const totals = updateTotals();

                    history.unshift({
                        id: `draft-${Date.now()}`,
                        status: 'draft',
                        created_at: new Date().toISOString(),
                        items: snapshot,
                        totalItems: totals.totalItems,
                        totalPrice: totals.totalPrice,
                    });

                    localStorage.setItem('kasir-order-history', JSON.stringify(history.slice(0, 20)));
                    showToast('Draft order disimpan ke history');
                });
            }

            renderCart();
        });
    </script>
</x-app-layout>
