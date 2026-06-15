<x-app-layout :title="'Histori Transaksi'">
    <div class="flex flex-col h-screen bg-slate-50 font-sans selection:bg-accent selection:text-primary">
        <x-sidebar />

        <main class="flex-1 flex flex-col overflow-hidden">

            <div class="flex-1 overflow-y-auto p-8 lg:p-10 space-y-6 pb-12 custom-scrollbar">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-primary">Histori Order</h1>
                        <p class="text-sm text-secondary/60 mt-1">Lihat transaksi sebelumnya, buka detail order, dan
                            cetak ulang struk kapan saja.</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" data-filter="all"
                            class="history-filter-btn px-4 py-2 rounded-xl text-sm font-bold bg-primary text-white shadow-sm">Semua</button>
                        <button type="button" data-filter="cash"
                            class="history-filter-btn px-4 py-2 rounded-xl text-sm font-bold bg-white text-secondary/70 border border-slate-200">Tunai</button>
                        <button type="button" data-filter="qris_static"
                            class="history-filter-btn px-4 py-2 rounded-xl text-sm font-bold bg-white text-secondary/70 border border-slate-200">QRIS</button>
                    </div>

                </div>

                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-5 space-y-5">
                    <div class="flex flex-col md:flex-row gap-3 md:items-center md:justify-between">
                        <div class="relative w-full md:max-w-sm">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-secondary/40">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </span>
                            <input type="text" id="history-search"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-4 py-2.5 text-sm font-medium text-primary placeholder:text-secondary/40 focus:border-accent focus:ring-accent"
                                placeholder="Cari ID order atau nama item...">
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-secondary/60 uppercase tracking-wider">Total
                                Data:</span>
                            <span id="history-count" class="text-sm font-bold text-primary">0</span>
                        </div>
                    </div>

                    <div id="history-empty"
                        class="hidden rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-10 text-center text-secondary/50">
                        <div
                            class="w-14 h-14 mx-auto rounded-2xl bg-white border border-slate-200 flex items-center justify-center mb-3">
                            <i class="fa-solid fa-clock-rotate-left text-xl"></i>
                        </div>
                        <p class="font-bold text-primary">Belum ada histori order</p>
                        <p class="text-sm mt-1">Mulai transaksi dari halaman Order, lalu histori akan muncul di sini.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[850px]">
                            <thead>
                                <tr
                                    class="text-left text-xs font-bold uppercase tracking-wider text-secondary/50 border-b border-slate-100">
                                    <th class="pb-3 pr-3">Order ID</th>
                                    <th class="pb-3 px-3">Waktu</th>
                                    <th class="pb-3 px-3">Ringkasan</th>
                                    <th class="pb-3 px-3">Total</th>
                                    <th class="pb-3 px-3">Metode</th>
                                    <th class="pb-3 pl-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="history-table-body"></tbody>
                        </table>
                    </div>
                    <div class="pagination" id="history-pagination">

                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Debounce Utility Function
        function debounce(func, delay) {
            let timeoutId;
            return function(...args) {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(() => {
                    func.apply(this, args);
                }, delay);
            };
        }

        document.addEventListener('DOMContentLoaded', function() {
            const clockEl = document.querySelector('.clock-display');
            const searchInput = document.getElementById('history-search');
            const tableBody = document.getElementById('history-table-body');
            const emptyState = document.getElementById('history-empty');
            const historyCount = document.getElementById('history-count');
            const filterButtons = document.querySelectorAll('.history-filter-btn');
            const historyDataUrl = "{{ route('kasir.histori.data') }}";
            let activeFilter = 'all';
            let allHistory = [];

            if (clockEl) {
                setInterval(() => {
                    const now = new Date();
                    clockEl.textContent = now.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    });
                }, 1000);
            }

            const formatCurrency = (value) => `Rp ${new Intl.NumberFormat('id-ID').format(Number(value || 0))}`;
            const escapeHtml = (value) => String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/\"/g, '&quot;')
                .replace(/'/g, '&#39;');

            const getPaymentMethodBadge = (method) => {
                if (method === 'cash') {
                    return '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-tertiary/10 text-tertiary">TUNAI</span>';
                }

                return '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-accent/10 text-accent">QRIS</span>';
            };


            const normalizeOrder = (order) => {
                const items = Array.isArray(order.items) ? order.items : [];
                const totalItems = items.reduce((acc, item) => acc + Number(item.quantity || 0), 0);

                return {
                    id: order.order_code || order.id || '-',
                    status: order.status || 'draft',
                    payment_method: order.payment_method || 'cash',
                    created_at: order.paid_at || order.created_at || order.updated_at || null,
                    totalItems,
                    totalPrice: Number(order.total || 0),
                    items: items.map((item) => ({
                        name: item.product_name || item.name || 'Item',
                        price: Number(item.price || 0),
                        quantity: Number(item.quantity || 0),
                        subtotal: Number(item.subtotal || 0),
                    })),
                };
            };

            const renderRows = () => {
                const keyword = (searchInput?.value || '').trim().toLowerCase();
                const filtered = allHistory.filter((order) => {
                    const methodMatch = activeFilter === 'all' ? true : (order.payment_method || '')
                        .toLowerCase() === activeFilter;

                    if (!methodMatch) {
                        return false;
                    }


                    if (!keyword) {
                        return true;
                    }

                    const id = (order.id || '').toLowerCase();
                    const itemNames = Array.isArray(order.items) ?
                        order.items.map((item) => (item?.name || '').toLowerCase()).join(' ') :
                        '';

                    return id.includes(keyword) || itemNames.includes(keyword);
                });

                historyCount.textContent = String(filtered.length);

                if (filtered.length === 0) {
                    tableBody.innerHTML = '';
                    emptyState.classList.remove('hidden');
                    return;
                }

                emptyState.classList.add('hidden');

                tableBody.innerHTML = filtered.map((order) => {
                    const createdAt = order.created_at ? new Date(order.created_at) : null;
                    const dateText = createdAt ?
                        createdAt.toLocaleString('id-ID', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        }) :
                        '-';

                    const totalItems = Number(order.totalItems || 0);
                    const firstItems = Array.isArray(order.items) ?
                        order.items.slice(0, 2).map((item) => item?.name || 'Item') : [];

                    const summary = firstItems.length ?
                        `${firstItems.join(', ')}${totalItems > 2 ? ' +' + (totalItems - 2) + ' item' : ''}` :
                        'Tanpa item';

                    const printable = (order.status || '').toLowerCase() === 'paid';

                    return `
                        <tr class="border-b border-slate-100 transition-colors">
                            <td class="py-4 pr-3 align-top">
                                <p class="text-sm font-bold text-primary">${escapeHtml(order.id || '-')}</p>
                            </td>
                            <td class="py-4 px-3 align-top text-sm text-secondary/70 font-semibold">${escapeHtml(dateText)}</td>
                            <td class="py-4 px-3 align-top text-sm text-secondary/80">${escapeHtml(summary)}</td>
                            <td class="py-4 px-3 align-top text-sm font-bold text-primary">${formatCurrency(order.totalPrice || 0)}</td>
                            <td class="py-4 px-3 align-top">${getPaymentMethodBadge((order.payment_method || '').toLowerCase())}</td>
                            <td class="py-4 pl-3 align-top">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="/kasir/histori/${encodeURIComponent(order.id || '')}" class="px-3 py-2 rounded-xl text-xs font-bold border border-slate-200 text-primary bg-white">
                                        Detail
                                    </a>
                                    <button type="button"
                                        class="reprint-btn px-3 py-2 rounded-xl text-xs font-bold ${printable ? 'bg-primary text-white' : 'bg-slate-100 text-slate-400 cursor-not-allowed'}"
                                        data-order-id="${escapeHtml(order.id || '')}"
                                        ${printable ? '' : 'disabled'}>
                                        Cetak Ulang
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                }).join('');
            };

            filterButtons.forEach((button) => {
                button.addEventListener('click', function() {
                    activeFilter = this.dataset.filter || 'all';

                    filterButtons.forEach((btn) => {
                        btn.classList.remove('bg-primary', 'text-white', 'shadow-sm');
                        btn.classList.add('bg-white', 'text-secondary/70', 'border',
                            'border-slate-200');
                    });

                    this.classList.remove('bg-white', 'text-secondary/70', 'border',
                        'border-slate-200');
                    this.classList.add('bg-primary', 'text-white', 'shadow-sm');

                    renderRows();
                });
            });

            if (searchInput) {
                searchInput.addEventListener('input', debounce(renderRows, 300));
            }

            const loadHistory = async () => {
                try {
                    const response = await fetch(historyDataUrl, {
                        headers: {
                            'Accept': 'application/json',
                        },
                    });

                    const result = await response.json();

                    if (!response.ok || !result.success) {
                        throw new Error(result.message || 'Gagal mengambil histori');
                    }

                    allHistory = (result.data?.data || []).map(normalizeOrder);
                    renderRows();
                } catch (error) {
                    tableBody.innerHTML = '';
                    emptyState.classList.remove('hidden');
                    emptyState.querySelector('p.font-bold').textContent = 'Gagal memuat histori';
                    emptyState.querySelector('p.text-sm').textContent = error.message ||
                        'Coba muat ulang halaman ini.';
                }
            };

            document.addEventListener('click', function(event) {
                const reprintButton = event.target.closest('.reprint-btn');

                if (!reprintButton) {
                    return;
                }

                const orderId = reprintButton.dataset.orderId || '';
                const order = allHistory.find((item) => String(item?.id) === String(orderId));

                if (!order || String(order.status || '').toLowerCase() !== 'paid') {
                    return;
                }

                window.location.href = "{{ route('kasir.receipt') }}?id=" + encodeURIComponent(order.id);
            });

            loadHistory();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const clockEl = document.querySelector('.clock-display');
            const updateTime = () => {
                const now = new Date();
                const formattedTime = now.toLocaleTimeString('id-ID');
                if (clockEl) clockEl.textContent = `${formattedTime} WIB`;
            };
            updateTime();
            setInterval(updateTime, 1000);
        });
    </script>
</x-app-layout>
