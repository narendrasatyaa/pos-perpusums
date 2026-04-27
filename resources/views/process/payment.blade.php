<x-app-layout :title="'Payment'">
    <div class="min-h-screen bg-secondary/80 flex items-center justify-center p-4 font-sans">
        <div
            class="bg-white rounded-[24px] w-full max-w-6xl xl:max-w-[1200px] flex flex-col md:flex-row overflow-hidden shadow-2xl min-h-[75vh]">

            {{-- LEFT PANEL: Order Summary --}}
            <div class="w-full md:w-[38%] border-r border-slate-100 flex flex-col">
                <div class="p-8 flex-1">
                    <div class="flex items-start justify-between mb-8">
                        <h2 class="text-[28px] font-bold text-primary leading-tight">Order Summary</h2>
                        <span class="bg-slate-100 text-primary text-xs font-bold px-3 py-1.5 rounded-full"
                            id="order-id">#ORD-0000</span>
                    </div>

                    <div class="space-y-5" id="order-items">
                        {{-- Injected via JS --}}
                        <div class="text-slate-400 text-sm text-center py-4">No items</div>
                    </div>
                </div>

                {{-- Discount --}}
                <div class="px-8 pb-5">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-[10px] font-bold text-slate-500 tracking-wider">DISCOUNTS & PROMOS</span>
                    </div>
                    <div
                        class="border border-dashed border-[#242b6a]/30 rounded-xl p-3.5 flex justify-between items-center bg-[#fdfdfd]">
                        <div class="w-full">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-[13px] font-bold text-[#242b6a]">Discount Type</p>
                                <div class="bg-slate-100 p-1 rounded-lg flex text-[11px] font-bold relative">
                                    <button type="button" id="btn-type-pct"
                                        class="px-3 py-1.5 rounded-md relative z-10 transition-all text-[#242b6a] bg-white shadow-sm">Persen
                                        (%)</button>
                                    <button type="button" id="btn-type-rp"
                                        class="px-3 py-1.5 rounded-md relative z-10 transition-all text-slate-400">Nominal
                                        (Rp)</button>
                                </div>
                            </div>

                            <div class="relative" id="discount-input-container">
                                <!-- Input Persen -->
                                <div id="container-pct" class="relative block">
                                    <input type="number" id="discount-percent" placeholder="0"
                                        class="w-full rounded-lg border border-slate-200 py-2.5 pl-4 pr-8 text-sm font-bold text-[#242b6a] focus:border-[#242b6a] focus:ring-0 transition-colors"
                                        value="" min="0" max="100">
                                    <span
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 font-bold">%</span>
                                </div>

                                <!-- Input Nominal -->
                                <div id="container-rp" class="relative hidden">
                                    <span
                                        class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-bold">Rp</span>
                                    <input type="number" id="discount-input" placeholder="0"
                                        class="w-full rounded-lg border border-slate-200 py-2.5 pl-10 pr-4 text-sm font-bold text-primary focus:border-primary focus:ring-0 transition-colors"
                                        value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Totals --}}
                <div class="bg-primary text-white p-8">
                    <div class="flex justify-between text-[13px] text-white/70 mb-2">
                        <span>Subtotal</span>
                        <span id="subtotal-display">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-[13px] text-white/70 mb-6">
                        <span>Discount Total</span>
                        <span id="discount-display">- Rp 0</span>
                    </div>
                    <div class="flex justify-between items-end">
                        <span class="text-base text-white/90">Total Due</span>
                        <span class="text-[28px] font-bold leading-none tracking-tight" id="total-due">Rp 0</span>
                    </div>
                </div>
            </div>

            {{-- RIGHT PANEL: Process Payment --}}
            <div class="w-full md:w-[62%] p-8 flex flex-col bg-white">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h2 class="text-[22px] font-bold text-slate-800">Process Payment</h2>
                        <p class="text-slate-500 text-sm mt-1">Choose payment method and enter amount</p>
                    </div>
                    <a href="{{ route('kasir.order') }}"
                        class="text-slate-400 hover:text-slate-600 transition-colors w-8 h-8 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                </div>

                <div class="flex gap-8 flex-1">
                    {{-- Methods & Change --}}
                    <div class="w-1/2 flex flex-col justify-between">
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 tracking-wider mb-3">METHOD</p>
                            <div class="space-y-3">
                                {{-- Cash --}}
                                <button type="button"
                                    class="method-btn w-full flex items-center gap-4 p-3.5 rounded-xl border-2 border-primary bg-primary/5 text-left"
                                    data-method="cash">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center text-lg flex-shrink-0">
                                        <i class="fa-solid fa-money-bill-wave"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">Cash</p>
                                    </div>
                                </button>
                                {{-- QRIS --}}
                                <button type="button"
                                    class="method-btn w-full flex items-center gap-4 p-3.5 rounded-xl border border-slate-200 hover:border-slate-300 text-left opacity-50 cursor-not-allowed"
                                    data-method="qris" disabled>
                                    <div
                                        class="w-10 h-10 rounded-lg bg-slate-100 text-primary flex items-center justify-center text-lg flex-shrink-0">
                                        <i class="fa-solid fa-qrcode"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">QRIS</p>
                                        <p class="text-[10px] font-bold text-slate-400">Soon</p>
                                    </div>
                                </button>
                                {{-- Bank Transfer --}}
                                <button type="button"
                                    class="method-btn w-full flex items-center gap-4 p-3.5 rounded-xl border border-slate-200 hover:border-slate-300 text-left opacity-50 cursor-not-allowed"
                                    data-method="transfer" disabled>
                                    <div
                                        class="w-10 h-10 rounded-lg bg-slate-100 text-primary flex items-center justify-center text-lg flex-shrink-0">
                                        <i class="fa-solid fa-building-columns"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">Bank Transfer</p>
                                        <p class="text-[10px] font-bold text-slate-400">Soon</p>
                                    </div>
                                </button>
                            </div>
                        </div>

                        {{-- Change --}}
                        <div class="bg-slate-100 rounded-xl p-5 text-center mt-6">
                            <p class="text-[11px] font-bold text-slate-600 mb-1.5">Change to Return</p>
                            <p class="text-[26px] font-bold text-tertiary tracking-tight" id="change-display">Rp 0</p>
                        </div>
                    </div>

                    {{-- Numpad & Submit --}}
                    <div class="w-1/2 flex flex-col justify-between">
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 tracking-wider mb-3">NOMINAL BAYAR</p>
                            <div class="relative mb-5">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-lg">Rp</span>
                                <input type="text" id="nominal-input"
                                    class="w-full rounded-xl border-2 border-primary py-3.5 pr-4 pl-12 text-right text-[26px] font-bold text-primary focus:outline-none"
                                    value="" placeholder="0">
                            </div>

                            <div class="grid grid-cols-4 gap-2.5 mb-3">
                                <button type="button"
                                    class="w-full py-2 rounded-xl bg-slate-100 hover:bg-slate-200 font-bold text-primary text-[15px] transition-colors quick-btn"
                                    data-val="10000">10.000</button>
                                <button type="button"
                                    class="w-full py-2 rounded-xl bg-slate-100 hover:bg-slate-200 font-bold text-primary text-[15px] transition-colors quick-btn"
                                    data-val="20000">20.000</button>
                                <button type="button"
                                    class="w-full py-2 rounded-xl bg-slate-100 hover:bg-slate-200 font-bold text-primary text-[15px] transition-colors quick-btn"
                                    data-val="50000">50.000</button>
                                <button type="button"
                                    class="w-full py-2 rounded-xl bg-slate-100 hover:bg-slate-200 font-bold text-primary text-[15px] transition-colors quick-btn"
                                    data-val="100000">100.000</button>
                            </div>

                            <div class="grid grid-cols-3 gap-2.5">
                                <button type="button"
                                    class="py-3 rounded-xl bg-slate-100 hover:bg-slate-200 font-bold text-primary text-lg transition-colors numpad-btn"
                                    data-val="1">1</button>
                                <button type="button"
                                    class="py-3 rounded-xl bg-slate-100 hover:bg-slate-200 font-bold text-primary text-lg transition-colors numpad-btn"
                                    data-val="2">2</button>
                                <button type="button"
                                    class="py-3 rounded-xl bg-slate-100 hover:bg-slate-200 font-bold text-primary text-lg transition-colors numpad-btn"
                                    data-val="3">3</button>

                                <button type="button"
                                    class="py-3 rounded-xl bg-slate-100 hover:bg-slate-200 font-bold text-primary text-lg transition-colors numpad-btn"
                                    data-val="4">4</button>
                                <button type="button"
                                    class="py-3 rounded-xl bg-slate-100 hover:bg-slate-200 font-bold text-primary text-lg transition-colors numpad-btn"
                                    data-val="5">5</button>
                                <button type="button"
                                    class="py-3 rounded-xl bg-slate-100 hover:bg-slate-200 font-bold text-primary text-lg transition-colors numpad-btn"
                                    data-val="6">6</button>

                                <button type="button"
                                    class="py-3 rounded-xl bg-slate-100 hover:bg-slate-200 font-bold text-primary text-lg transition-colors numpad-btn"
                                    data-val="7">7</button>
                                <button type="button"
                                    class="py-3 rounded-xl bg-slate-100 hover:bg-slate-200 font-bold text-primary text-lg transition-colors numpad-btn"
                                    data-val="8">8</button>
                                <button type="button"
                                    class="py-3 rounded-xl bg-slate-100 hover:bg-slate-200 font-bold text-primary text-lg transition-colors numpad-btn"
                                    data-val="9">9</button>

                                <button type="button"
                                    class="py-3 rounded-xl bg-slate-100 hover:bg-slate-200 font-bold text-primary text-lg transition-colors numpad-btn"
                                    data-val="0">0</button>
                                <button type="button"
                                    class="py-3 rounded-xl bg-slate-100 hover:bg-slate-200 font-bold text-primary text-[15px] transition-colors numpad-btn"
                                    data-val="000">000</button>
                                <button type="button"
                                    class="py-3 rounded-xl bg-red-100 hover:bg-red-200 text-red-600 text-base transition-colors numpad-btn"
                                    data-action="backspace"><i class="fa-solid fa-delete-left"></i></button>
                            </div>
                        </div>

                        <button type="button" id="process-payment-btn"
                            class="w-full py-4 mt-6 rounded-xl bg-primary hover:bg-primary/90 transition-colors text-white font-bold text-sm flex justify-center items-center gap-2.5 shadow-sm">
                            <i class="fa-regular fa-circle-check text-lg"></i>
                            Process Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Data checkout
            const checkout = JSON.parse(localStorage.getItem('kasir-active-checkout') || 'null');
            if (!checkout || !checkout.items || checkout.items.length === 0) {
                alert('Order kosong! Kembali ke halaman order.');
                window.location.href = "{{ route('kasir.order') }}";
                return;
            }

            // Order code final dibuat di backend saat transaksi tersimpan.
            document.getElementById('order-id').textContent = '#AUTO';

            const formatCurrency = (val) => new Intl.NumberFormat('id-ID').format(val);

            // Subtotal
            let subtotal = checkout.totalPrice || 0;
            let discount = 0;
            let totalDue = subtotal - discount;

            // Render Items
            const itemsContainer = document.getElementById('order-items');
            itemsContainer.innerHTML = checkout.items.map(item => `
                <div class="flex items-start justify-between gap-3">
                    <div class="flex gap-3">
                        <span class="text-primary font-bold text-sm">${item.quantity}x</span>
                        <div>
                            <p class="font-bold text-slate-800 text-sm leading-tight">${item.name}</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">${item.category_id == 1 ? 'Standard, Less Ice' : 'Regular'}</p>
                        </div>
                    </div>
                    <p class="font-bold text-slate-800 text-sm whitespace-nowrap">Rp ${formatCurrency(item.subtotal)}</p>
                </div>
            `).join('');

            // Numpad & Totals logic
            let nominalStr = ""; // Don't prefill
            const nominalInput = document.getElementById('nominal-input');
            const changeDisplay = document.getElementById('change-display');

            const updateTotals = () => {
                totalDue = subtotal - discount;
                if (totalDue < 0) totalDue = 0;
                document.getElementById('subtotal-display').textContent = `Rp ${formatCurrency(subtotal)}`;
                document.getElementById('discount-display').textContent = `- Rp ${formatCurrency(discount)}`;
                document.getElementById('total-due').textContent = `Rp ${formatCurrency(totalDue)}`;
                updateChange();
            };

            const discountInput = document.getElementById('discount-input');
            const discountPercent = document.getElementById('discount-percent');
            const btnPct = document.getElementById('btn-type-pct');
            const btnRp = document.getElementById('btn-type-rp');
            const containerPct = document.getElementById('container-pct');
            const containerRp = document.getElementById('container-rp');

            let discountType = 'pct'; // default

            const switchDiscountType = (type) => {
                discountType = type;
                if (type === 'pct') {
                    btnPct.classList.add('bg-white', 'shadow-sm', 'text-primary');
                    btnPct.classList.remove('text-slate-400');
                    btnRp.classList.add('text-slate-400');
                    btnRp.classList.remove('bg-white', 'shadow-sm', 'text-primary');

                    containerPct.classList.remove('hidden');
                    containerPct.classList.add('block');
                    containerRp.classList.add('hidden');
                    containerRp.classList.remove('block');
                } else {
                    btnRp.classList.add('bg-white', 'shadow-sm', 'text-primary');
                    btnRp.classList.remove('text-slate-400');
                    btnPct.classList.add('text-slate-400');
                    btnPct.classList.remove('bg-white', 'shadow-sm', 'text-primary');

                    containerRp.classList.remove('hidden');
                    containerRp.classList.add('block');
                    containerPct.classList.add('hidden');
                    containerPct.classList.remove('block');
                }

                // Reset values on switch
                discountPercent.value = "";
                discountInput.value = "";
                discount = 0;
                updateTotals();
            };

            if (btnPct && btnRp) {
                btnPct.addEventListener('click', () => switchDiscountType('pct'));
                btnRp.addEventListener('click', () => switchDiscountType('rp'));

                // Input Nominal (Rp)
                discountInput.addEventListener('input', (e) => {
                    if (discountType !== 'rp') return;
                    discount = parseInt(e.target.value, 10) || 0;
                    if (discount < 0) discount = 0;
                    if (discount > subtotal) discount = subtotal;
                    updateTotals();
                });

                // Input Percent (%)
                discountPercent.addEventListener('input', (e) => {
                    if (discountType !== 'pct') return;
                    let pct = parseFloat(e.target.value) || 0;
                    if (pct < 0) pct = 0;
                    if (pct > 100) pct = 100;

                    discount = Math.round(subtotal * (pct / 100));
                    updateTotals();
                });
            }

            const updateNominal = () => {
                let nominalVal = parseInt(nominalStr, 10);
                if (isNaN(nominalVal)) nominalVal = 0;

                nominalStr = nominalVal > 0 ? nominalVal.toString() : "";
                nominalInput.value = nominalVal > 0 ? formatCurrency(nominalVal) : "";
                updateChange();
            };

            const updateChange = () => {
                let nominalVal = parseInt(nominalStr, 10) || 0;
                let change = nominalVal - totalDue;
                if (change < 0) change = 0;
                changeDisplay.textContent = `Rp ${formatCurrency(change)}`;
            };

            updateTotals(); // Initial render
            updateNominal();

            nominalInput.addEventListener('input', (e) => {
                nominalStr = e.target.value.replace(/\\D/g, '');
                updateNominal();
            });

            document.querySelectorAll('.quick-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const val = parseInt(btn.getAttribute('data-val'), 10);
                    if (val) {
                        let current = parseInt(nominalStr, 10) || 0;
                        current += val;
                        nominalStr = current.toString();
                        updateNominal();
                    }
                });
            });

            document.querySelectorAll('.numpad-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const val = btn.getAttribute('data-val');
                    const action = btn.getAttribute('data-action');

                    if (val) {
                        if (nominalStr === "0") nominalStr = val;
                        else nominalStr += val;
                    } else if (action === 'backspace') {
                        nominalStr = nominalStr.slice(0, -1);
                    }
                    updateNominal();
                });
            });

            // Method selection
            let selectedMethod = 'cash';
            const methodBtns = document.querySelectorAll('.method-btn');

            methodBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    selectedMethod = btn.getAttribute('data-method');

                    methodBtns.forEach(b => {
                        b.classList.remove('border-2', 'border-primary', 'bg-primary/5');
                        b.classList.add('border', 'border-slate-200');
                        // reset icon bg
                        const iconBox = b.querySelector('div');
                        iconBox.classList.remove('bg-primary/10');
                        iconBox.classList.add('bg-slate-100');
                    });

                    btn.classList.add('border-2', 'border-primary', 'bg-primary/5');
                    btn.classList.remove('border', 'border-slate-200');
                    const iconBox = btn.querySelector('div');
                    iconBox.classList.add('bg-primary/10');
                    iconBox.classList.remove('bg-slate-100');
                });
            });

            // Process Payment
            const processPaymentButton = document.getElementById('process-payment-btn');
            let isSubmitting = false;

            processPaymentButton.addEventListener('click', async () => {
                if (isSubmitting) {
                    return;
                }

                const paid = parseInt(nominalStr, 10);

                if (paid < totalDue) {
                    alert('Nominal bayar kurang dari total tagihan!');
                    return;
                }

                isSubmitting = true;
                processPaymentButton.disabled = true;
                processPaymentButton.classList.add('opacity-70', 'cursor-not-allowed');

                const itemsPayload = (checkout.items || []).map((item) => ({
                    product_id: item.id ?? null,
                    name: item.name ?? 'Item',
                    price: Number(item.price || 0),
                    quantity: Number(item.quantity || 0),
                }));

                try {
                    const response = await fetch("{{ route('kasir.orders.paid') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({
                            subtotal: Number(subtotal || 0),
                            total: Number(totalDue || 0),
                            paid_amount: Number(paid || 0),
                            change_amount: Number((paid - totalDue) || 0),
                            items: itemsPayload,
                        }),
                    });

                    const result = await response.json();

                    if (!response.ok || !result.success) {
                        throw new Error(result.message || 'Gagal menyimpan transaksi');
                    }

                    const trx = result.data;
                    const receiptFromDb = {
                        id: trx.order_code,
                        status: trx.status,
                        created_at: trx.paid_at || trx.created_at,
                        payment_method: selectedMethod,
                        paid_amount: trx.paid_amount,
                        change_amount: trx.change_amount,
                        totalItems: (trx.items || []).reduce((acc, row) => acc + Number(row
                            .quantity || 0), 0),
                        totalPrice: trx.total,
                        items: (trx.items || []).map((row) => ({
                            id: row.product_id,
                            name: row.product_name,
                            price: row.price,
                            quantity: row.quantity,
                            subtotal: row.subtotal,
                        })),
                    };

                    localStorage.setItem('kasir-last-receipt', JSON.stringify(receiptFromDb));
                    localStorage.removeItem('kasir-active-checkout');

                    window.location.href = "{{ route('kasir.payment-success') }}";
                } catch (error) {
                    alert(error.message || 'Terjadi kesalahan saat simpan transaksi');
                    isSubmitting = false;
                    processPaymentButton.disabled = false;
                    processPaymentButton.classList.remove('opacity-70', 'cursor-not-allowed');
                }
            });
        });
    </script>
</x-app-layout>
