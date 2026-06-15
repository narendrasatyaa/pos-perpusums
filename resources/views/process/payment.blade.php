<x-app-layout :title="'Payment'">
    <div class="min-h-screen bg-secondary/80 flex items-center justify-center p-4 font-sans">
        <div
            class="bg-white rounded-[24px] w-full max-w-6xl xl:max-w-[1200px] flex flex-col md:flex-row overflow-hidden shadow-2xl min-h-[75vh]">

            {{-- Order Summary --}}
            <div class="w-full md:w-[38%] border-r border-slate-100 flex flex-col">
                <div class="p-8 flex-1">
                    <div class="flex items-start justify-between mb-8">
                        <h2 class="text-[28px] font-bold text-primary leading-tight">Order Summary</h2>
                        <span class="bg-slate-100 text-primary text-xs font-bold px-3 py-1.5 rounded-full"
                            id="order-id">#ORD-0000</span>
                    </div>

                    <div class="space-y-5" id="order-items">
                        <div class="text-slate-400 text-sm text-center py-4">No items</div>
                    </div>
                </div>

                {{-- Discount Section --}}
                <div class="px-8 pb-5">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-[10px] font-bold text-slate-500 tracking-wider">DISCOUNTS & PROMO</span>
                    </div>
                    <div class="border border-dashed border-[#242b6a]/30 rounded-xl p-3.5 bg-[#fdfdfd]">
                        <div class="w-full">
                            <div class="mb-3">
                                <p class="text-[13px] font-bold text-primary whitespace-nowrap">Kode Voucher</p>
                            </div>

                            {{-- Input Container --}}
                            <div class="relative w-full overflow-hidden" id="discount-input-container">
                                <div id="container-voucher" class="relative w-full">
                                    <input type="text" id="voucher-input" placeholder="Masukkan kode voucher"
                                        class="w-full rounded-lg border border-slate-200 py-2.5 px-4 text-[8px] sm:text-sm font-bold text-primary focus:border-primary focus:ring-0 transition-colors tracking-wider placeholder:text-slate-300"
                                        autocomplete="off">
                                </div>
                                <button type="button" id="apply-voucher-btn"
                                    class="mt-2 w-full rounded-lg bg-primary/10 py-2 text-[11px] font-bold text-primary hover:bg-primary/15 transition-colors">
                                    Terapkan Voucher
                                </button>
                                <p id="voucher-feedback" class="mt-2 text-[11px] font-medium text-slate-400 hidden"></p>
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

            {{-- Process Payment --}}
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

                <div class="flex flex-col lg:flex-row gap-8 flex-1">
                    {{-- Methods --}}
                    <div class="w-full lg:w-1/2 flex flex-col justify-between">
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 tracking-wider mb-3">METHOD</p>
                            <div class="space-y-3">
                                <button type="button"
                                    class="method-btn w-full flex items-center gap-4 p-3.5 rounded-xl border-2 border-primary bg-primary/5 text-left"
                                    data-method="cash">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center text-lg flex-shrink-0">
                                        <i class="fa-solid fa-money-bill-wave"></i>
                                    </div>
                                    <p class="font-bold text-slate-800 text-sm">Cash</p>
                                </button>
                                <button type="button"
                                    class="method-btn w-full flex items-center gap-4 p-3.5 rounded-xl border border-slate-200 text-left"
                                    data-method="qris_static">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-slate-100 text-primary flex items-center justify-center text-lg flex-shrink-0">
                                        <i class="fa-solid fa-qrcode"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm"> QRIS Statis</p>
                                        <p class="text-[10px] font-bold text-slate-400">Upload bukti transfer</p>
                                    </div>
                                </button>
                            </div>

                            <div id="qris-static-panel" class="mt-4 hidden rounded-xl border border-slate-200 bg-slate-50 p-3.5">
                                <p class="text-[11px] font-bold text-slate-600 mb-2">Upload Bukti Transfer</p>
                                <div class="flex flex-col">
                                    <label for="transfer-proof-input" class="text-[11px] font-medium text-slate-500 mb-1.5">Silakan upload bukti transfer Anda di sini.</label>
                                    <input type="file" id="transfer-proof-input" accept="image/*,.pdf"
                                        class="block w-full text-[11px] text-slate-600 file:mr-2 file:rounded-md file:border-0 file:bg-primary/10 file:px-3 file:py-1.5 file:text-[11px] file:font-bold file:text-primary hover:file:bg-primary/15">
                                    <p id="transfer-proof-feedback" class="mt-1 text-[11px] font-medium text-red-600 hidden"></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-100 rounded-xl p-5 text-center mt-6">
                            <p class="text-[11px] font-bold text-slate-600 mb-1.5">Change to Return</p>
                            <p class="text-[26px] font-bold text-tertiary tracking-tight" id="change-display">Rp 0</p>
                        </div>
                    </div>

                    {{-- Numpad --}}
                    <div class="w-full lg:w-1/2 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-[10px] font-bold text-slate-500 tracking-wider" id="payment-amount-label">NOMINAL BAYAR</p>
                                <div id="qris-transfer-summary" class="hidden items-center text-[24px] font-bold text-primary tracking-tight">
                                    <span id="qris-large-total">Rp 0</span>
                                </div>
                            </div>

                            <div id="cash-input-panel">
                                <div class="relative mb-5">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-lg font-bold">Rp</span>
                                    <input type="text" id="nominal-input"
                                        class="w-full rounded-xl border-2 border-primary py-3.5 pr-4 pl-12 text-right text-[26px] font-bold text-primary focus:outline-none"
                                        placeholder="0">
                                </div>

                                <div class="grid grid-cols-4 gap-2 mb-3">
                                    <button type="button"
                                        class="py-2 rounded-xl bg-slate-100 font-bold text-primary text-[13px] quick-btn"
                                        data-val="10000">10.000</button>
                                    <button type="button"
                                        class="py-2 rounded-xl bg-slate-100 font-bold text-primary text-[13px] quick-btn"
                                        data-val="20000">20.000</button>
                                    <button type="button"
                                        class="py-2 rounded-xl bg-slate-100 font-bold text-primary text-[13px] quick-btn"
                                        data-val="50000">50.000</button>
                                    <button type="button"
                                        class="py-2 rounded-xl bg-slate-100 font-bold text-primary text-[13px] quick-btn"
                                        data-val="100000">100.000</button>
                                </div>

                                <div class="grid grid-cols-3 gap-2">
                                    @for ($i = 1; $i <= 9; $i++)
                                        <button type="button"
                                            class="py-3 rounded-xl bg-slate-100 font-bold text-primary text-lg numpad-btn"
                                            data-val="{{ $i }}">{{ $i }}</button>
                                    @endfor
                                    <button type="button"
                                        class="py-3 rounded-xl bg-slate-100 font-bold text-primary text-lg numpad-btn"
                                        data-val="0">0</button>
                                    <button type="button"
                                        class="py-3 rounded-xl bg-slate-100 font-bold text-primary text-lg numpad-btn"
                                        data-val="000">000</button>
                                    <button type="button" class="py-3 rounded-xl bg-red-100 text-red-600 numpad-btn"
                                        data-action="backspace"><i class="fa-solid fa-delete-left"></i></button>
                                </div>
                            </div>
                            
                            <div id="qris-image-panel" class="hidden flex-col items-center justify-center py-6 px-4 border-2 border-dashed border-slate-200 rounded-2xl bg-[#fdfdfd] mb-4">
                                <div class="bg-white p-3 rounded-xl border border-slate-200 shadow-sm mb-4">
                                    <img src="{{ asset('img/sample-qris-img.png') }}" alt="QRIS Statis" class="w-full max-w-[300px] aspect-square object-contain">
                                </div>
                                <p class="text-[11px] font-medium text-slate-400 text-center">Scan QR Code dengan aplikasi pembayaran Anda</p>
                            </div>
                        </div>

                        <button type="button" id="process-payment-btn"
                            class="w-full py-4 mt-6 rounded-xl bg-primary hover:bg-primary/90 text-white font-bold text-sm flex justify-center items-center gap-2.5">
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
            const checkout = JSON.parse(localStorage.getItem('kasir-active-checkout') || 'null');
            if (!checkout || !checkout.items) {
                window.location.href = "{{ route('kasir.order') }}";
                return;
            }

            const generateOrderId = () => {
                const now = new Date();
                const y = String(now.getFullYear()).slice(-2);
                const m = String(now.getMonth() + 1).padStart(2, '0');
                const d = String(now.getDate()).padStart(2, '0');
                const random = String(Math.floor(1000 + Math.random() * 9000));

                return `#ORD-${y}${m}${d}-${random}`;
            };

            if (!checkout.order_id) {
                checkout.order_id = generateOrderId();
                localStorage.setItem('kasir-active-checkout', JSON.stringify(checkout));
            }

            document.getElementById('order-id').textContent = checkout.order_id;

            const formatCurrency = (val) => new Intl.NumberFormat('id-ID').format(val);
            let subtotal = checkout.totalPrice || 0;
            let discount = 0;
            let totalDue = subtotal;
            let nominalStr = "";
            let appliedVoucher = null;
            let activePaymentMethod = 'cash';

            const itemsContainer = document.getElementById('order-items');
            itemsContainer.innerHTML = checkout.items.map(item => `
                <div class="flex justify-between gap-3">
                    <div class="flex gap-3">
                        <span class="text-primary font-bold text-sm">${item.quantity}x</span>
                        <p class="font-bold text-slate-800 text-sm leading-tight">${item.name}</p>
                    </div>
                    <p class="font-bold text-slate-800 text-sm">Rp ${formatCurrency(item.subtotal)}</p>
                </div>
            `).join('');

            const updateTotals = () => {
                totalDue = Math.max(0, subtotal - discount);
                document.getElementById('subtotal-display').textContent = `Rp ${formatCurrency(subtotal)}`;
                document.getElementById('discount-display').textContent = `- Rp ${formatCurrency(discount)}`;
                document.getElementById('total-due').textContent = `Rp ${formatCurrency(totalDue)}`;

                if (activePaymentMethod === 'qris_static') {
                    nominalStr = String(totalDue);
                }
                
                document.getElementById('qris-large-total').textContent = `Rp ${formatCurrency(totalDue)}`;
                updateChange();
            };

            const updateChange = () => {
                let paid = parseInt(nominalStr, 10) || 0;
                let change = Math.max(0, paid - totalDue);
                document.getElementById('change-display').textContent = `Rp ${formatCurrency(change)}`;
            };

            const qrisPanel = document.getElementById('qris-static-panel');
            const qrisImagePanel = document.getElementById('qris-image-panel');
            const qrisTransferSummary = document.getElementById('qris-transfer-summary');
            const cashPanel = document.getElementById('cash-input-panel');
            const paymentAmountLabel = document.getElementById('payment-amount-label');
            const transferProofInput = document.getElementById('transfer-proof-input');
            const transferProofFeedback = document.getElementById('transfer-proof-feedback');

            const showTransferProofFeedback = (message = '') => {
                transferProofFeedback.textContent = message;
                transferProofFeedback.classList.toggle('hidden', !message);
            };

            const setPaymentMethod = (method) => {
                activePaymentMethod = method;

                document.querySelectorAll('.method-btn').forEach((button) => {
                    const isActive = button.dataset.method === method;
                    button.classList.toggle('border-2', isActive);
                    button.classList.toggle('border-primary', isActive);
                    button.classList.toggle('bg-primary/5', isActive);
                    button.classList.toggle('border', !isActive);
                    button.classList.toggle('border-slate-200', !isActive);
                });

                const isQris = method === 'qris_static';
                qrisPanel.classList.toggle('hidden', !isQris);
                qrisImagePanel.classList.toggle('hidden', !isQris);
                qrisImagePanel.classList.toggle('flex', isQris);
                qrisTransferSummary.classList.toggle('hidden', !isQris);
                qrisTransferSummary.classList.toggle('flex', isQris);
                cashPanel.classList.toggle('hidden', isQris);
                paymentAmountLabel.textContent = isQris ? 'TOTAL TRANSFER' : 'NOMINAL BAYAR';

                if (isQris) {
                    nominalStr = String(totalDue);
                    showTransferProofFeedback('');
                    updateNominal();
                    return;
                }

                if (nominalStr === String(totalDue)) {
                    nominalStr = '';
                    updateNominal();
                }
            };

            // Discount Logic
            const voucherInput = document.getElementById('voucher-input');
            const voucherFeedback = document.getElementById('voucher-feedback');
            const applyVoucherBtn = document.getElementById('apply-voucher-btn');

            const showVoucherFeedback = (message, status = 'info') => {
                voucherFeedback.textContent = message;
                voucherFeedback.classList.remove('hidden', 'text-slate-400', 'text-tertiary', 'text-red-600');

                if (status === 'success') {
                    voucherFeedback.classList.add('text-tertiary');
                } else if (status === 'error') {
                    voucherFeedback.classList.add('text-red-600');
                } else {
                    voucherFeedback.classList.add('text-slate-400');
                }
            };

            const resetVoucherState = (shouldClearInput = false) => {
                appliedVoucher = null;

                if (shouldClearInput) {
                    voucherInput.value = '';
                }

                voucherFeedback.textContent = '';
                voucherFeedback.classList.add('hidden');
            };

            applyVoucherBtn.onclick = async () => {
                const code = voucherInput.value.trim();

                if (!code) {
                    discount = 0;
                    resetVoucherState();
                    showVoucherFeedback('Masukkan kode voucher terlebih dahulu.', 'error');
                    updateTotals();
                    return;
                }

                applyVoucherBtn.disabled = true;
                applyVoucherBtn.textContent = 'Memproses...';

                try {
                    const response = await fetch("{{ route('kasir.vouchers.validate') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            code,
                            subtotal
                        })
                    });

                    const result = await response.json();

                    if (!response.ok || !result.success) {
                        throw new Error(result.message || 'Voucher tidak bisa digunakan.');
                    }

                    appliedVoucher = result.data;
                    voucherInput.value = code;
                    discount = parseInt(appliedVoucher.discount_amount, 10) || 0;
                    showVoucherFeedback(`Voucher ${appliedVoucher.code} aktif. Diskon Rp ${formatCurrency(discount)}.`, 'success');
                    updateTotals();
                } catch (error) {
                    discount = 0;
                    resetVoucherState();
                    showVoucherFeedback(error.message || 'Gagal memvalidasi voucher.', 'error');
                    updateTotals();
                } finally {
                    applyVoucherBtn.disabled = false;
                    applyVoucherBtn.textContent = 'Terapkan Voucher';
                }
            };

            voucherInput.addEventListener('input', () => {
                discount = 0;
                appliedVoucher = null;
                voucherFeedback.classList.add('hidden');
                updateTotals();

                if (activePaymentMethod === 'qris_static') {
                    nominalStr = String(totalDue);
                    updateNominal();
                }
            });

            // Numpad & Payment
            const nominalInput = document.getElementById('nominal-input');
            const updateNominal = () => {
                let val = parseInt(nominalStr, 10) || 0;
                nominalInput.value = val > 0 ? formatCurrency(val) : "";
                updateChange();
            };

            transferProofInput.addEventListener('change', () => {
                showTransferProofFeedback('');
            });

            document.querySelectorAll('.method-btn').forEach(btn => {
                btn.onclick = () => setPaymentMethod(btn.dataset.method);
            });

            document.querySelectorAll('.numpad-btn').forEach(btn => {
                btn.onclick = () => {
                    const val = btn.dataset.val;
                    const action = btn.dataset.action;
                    if (val) nominalStr += val;
                    else if (action === 'backspace') nominalStr = nominalStr.slice(0, -1);
                    updateNominal();
                };
            });

            document.querySelectorAll('.quick-btn').forEach(btn => {
                btn.onclick = () => {
                    nominalStr = ((parseInt(nominalStr, 10) || 0) + parseInt(btn.dataset.val))
                    .toString();
                    updateNominal();
                };
            });

            document.getElementById('process-payment-btn').onclick = async function() {
                if (voucherInput.value.trim() && !appliedVoucher) {
                    alert('Voucher belum diterapkan.');
                    return;
                }

                if (activePaymentMethod === 'qris_static' && !transferProofInput.files.length) {
                    showTransferProofFeedback('Upload bukti transfer terlebih dahulu.');
                    return;
                }

                const paid = activePaymentMethod === 'qris_static'
                    ? totalDue
                    : (parseInt(nominalStr, 10) || 0);
                if (paid < totalDue) return alert('Uang kurang!');

                this.disabled = true;
                this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';

                // kode id order, subtotal, total, paid_amount, change_amount, items
                try {
                    const payload = new FormData();
                    payload.append('order_id', checkout.order_id);
                    payload.append('subtotal', String(subtotal));
                    payload.append('total', String(totalDue));
                    payload.append('paid_amount', String(paid));
                    payload.append('change_amount', String(Math.max(0, paid - totalDue)));
                    payload.append('payment_method', activePaymentMethod);
                    payload.append('voucher_code', appliedVoucher?.code || '');
                    payload.append('discount_type', appliedVoucher ? `voucher_${appliedVoucher.discount_type}` : 'none');
                    payload.append('discount_value', String(discount));
                    payload.append('items', JSON.stringify(checkout.items));

                    if (activePaymentMethod === 'qris_static' && transferProofInput.files.length) {
                        payload.append('transfer_proof', transferProofInput.files[0]);
                    }

                    const response = await fetch("{{ route('kasir.orders.paid') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: payload
                    });

                    const result = await response.json();

                    if (!response.ok) {
                        throw new Error(result.message || 'Gagal menyimpan transaksi');
                    }

                    const trx = result.data || {};
                    const lastReceipt = {
                        id: trx.order_code || checkout.order_id,
                        order_code: trx.order_code || checkout.order_id,
                        created_at: trx.paid_at || trx.created_at || new Date().toISOString(),
                        payment_method: trx.payment_method || activePaymentMethod,
                        paid_amount: Number(trx.paid_amount ?? paid),
                        change_amount: Number(trx.change_amount ?? Math.max(0, paid - totalDue)),
                        totalItems: (trx.items || checkout.items || []).reduce((acc, item) => acc + Number(item.quantity || 0), 0),
                        totalPrice: Number(trx.total ?? totalDue),
                        items: (trx.items || checkout.items || []).map((item) => ({
                            id: item.product_id || item.id || null,
                            name: item.product_name || item.name || 'Item',
                            price: Number(item.price || 0),
                            quantity: Number(item.quantity || 0),
                            subtotal: Number(item.subtotal || (Number(item.price || 0) * Number(item.quantity || 0))),
                        })),
                    };

                    localStorage.setItem('kasir-last-receipt', JSON.stringify(lastReceipt));
                    localStorage.removeItem('kasir-active-checkout');
                    window.location.href = "{{ route('kasir.payment-success') }}";
                } catch (e) {
                    alert(e.message || 'Error saving transaction');
                    this.disabled = false;
                    this.innerHTML = '<i class="fa-regular fa-circle-check text-lg"></i> Process Payment';
                }
            };

            updateTotals();
            setPaymentMethod('cash');
        });
    </script>
</x-app-layout>
