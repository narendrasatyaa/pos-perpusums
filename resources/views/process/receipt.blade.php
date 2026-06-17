<x-app-layout :title="'Receipt'">
    {{-- template nota --}}
    <div class="hidden print:block"
        style="width: 80mm; font-family: 'Courier New', Courier, monospace; font-size: 12px; color: #000; padding: 2px;">

        {{-- header --}}
        <div style="text-align: center; margin-bottom: 10px;">
            <img src="{{ asset('img/logo-perpus.webp') }}" alt="">
            <div style="font-weight: 900; font-size: 14px; letter-spacing: 1px; text-transform: uppercase;">
            </div>
            <div style="font-size: 10px; margin-top: 4px;">UPT Perpustakaan dan Layanan Digital</div>
            <div style="font-size: 10px;">Jl. A. Yani Tromol Pos I, Pabelan</div>
            <div style="font-size: 10px;">Surakarta 57102</div>
        </div>

        <div style="border-top: 1px dashed #000; margin: 6px 0;"></div>

        {{-- info transaksi --}}
        <div style="font-size: 11px; margin-bottom: 8px;">
            <div style="display: flex; justify-content: space-between;">
                <span>Penjualan</span>
                <span>: <span data-print-number>-</span></span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span>Tanggal</span>
                <span>: <span data-print-date>-</span></span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span>Kasir</span>
                <span>: {{ auth()->user()->name ?? 'Kasir' }}</span>
            </div>
        </div>

        <div style="border-top: 1px dashed #000; margin: 6px 0;"></div>

        {{-- item --}}
        <div style="font-size: 11px; margin-bottom: 8px;" data-print-items>
            {{-- diisi via JS --}}
        </div>

        <div style="border-top: 1px dashed #000; margin: 6px 0;"></div>

        {{-- ringkasan harga --}}
        <div style="font-size: 11px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 2px;">
                <span>Subtotal (<span data-print-itemcount>0</span> item)</span>
                <span data-print-subtotal>0</span>
            </div>
            <div
                style="display: flex; justify-content: space-between; font-weight: 700; font-size: 13px; margin-top: 4px; border-top: 1px dashed #000; padding-top: 4px;">
                <span>Total</span>
                <span data-print-total>0</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-top: 4px;">
                <span data-print-method-label>Tunai</span>
                <span data-print-paid>0</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span>Kembalian</span>
                <span data-print-change>0</span>
            </div>
        </div>

        <div style="border-top: 1px dashed #000; margin: 10px 0;"></div>

        {{-- footer --}}
        <div style="text-align: center; font-size: 10px; line-height: 1.4;">
            <div style="margin-bottom: 4px; font-style: italic;">"Makan, Minum, Baca, Santai"</div>
            <div>Instagram: @perpusums</div>
            <div style="margin-top: 8px;">Wifi : UMS Wifi</div>
            <div>Password : ums.wifi</div>
            <div style="margin-top: 8px;">-- Terima Kasih --</div>
        </div>

    </div>

    {{-- web ui --}}
    <div
        class="min-h-screen bg-slate-50 font-sans selection:bg-accent selection:text-primary print:hidden flex flex-col">
        {{-- <!-- Top Nav -->
    <header class="bg-white border-b border-slate-200 px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3 font-bold text-primary text-lg">
            <i class="fa-solid fa-mug-hot"></i>
            <span>Library Cafe POS</span>
        </div>
        <div class="flex items-center gap-6 text-sm text-slate-500 font-medium">
            <button class="flex items-center gap-2 hover:text-primary transition-colors">
                <i class="fa-regular fa-circle-question"></i>
                Support
            </button>
            <div class="flex items-center gap-3 border-l border-slate-200 pl-6">
                <div class="text-right leading-tight">
                    <p class="text-[10px] uppercase tracking-wider">Operator</p>
                    <p class="text-primary font-bold">{{ explode(' ', auth()->user()->name ?? 'Admin')[0] }}</p>
                </div>
                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                    <i class="fa-regular fa-user"></i>
                </div>
            </div>
        </div>
    </header> --}}

        <!-- Main Content -->
        <main class="flex-1 flex flex-col items-center py-12 px-4 relative">
            <!-- Success Header -->
            {{-- <div class="text-center mb-8">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center text-white text-xl mx-auto mb-4 shadow-lg shadow-tertiary/30">
                <i class="fa-solid fa-check"></i>
            </div>
            <h1 class="text-[28px] font-bold text-primary mb-2">Payment Successful</h1>
            <p class="text-slate-500 text-sm">The digital receipt has been generated.</p>
        </div> --}}

            <!-- Receipt Card -->
            <div
                class="bg-white w-full max-w-[420px] rounded-[24px] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 p-8 relative z-10 overflow-hidden">
                <!-- Decorative cutouts on sides (optional, for receipt look) -->
                <div class="absolute -left-3 top-[55%] w-6 h-6 rounded-full bg-slate-50 shadow-inner"></div>
                <div class="absolute -right-3 top-[55%] w-6 h-6 rounded-full bg-slate-50 shadow-inner"></div>

                <!-- Header -->
                <div class="text-center mb-6">
                    <img src="{{ asset('img/logo-perpus.webp') }}" alt="" class="h-14 mx-auto mb-3">
                    <h2 class="text-xl font-bold text-primary mb-1">Library Cafe</h2>
                    <p class="text-[11px] text-slate-500 leading-relaxed">
                        UPT Perpustakaan dan Layanan Digital<br>
                        Jl. A. Yani Tromol Pos I, Pabelan<br>
                        Surakarta 57102
                    </p>
                </div>

                <div class="border-t-[1.5px] border-dashed border-slate-200 my-5"></div>

                <!-- Meta -->
                <div class="flex justify-between text-[10px] text-slate-500 uppercase tracking-wider mb-2">
                    <div>
                        <p class="mb-1 font-semibold">Date Time</p>
                        <p class="text-primary font-bold normal-case" data-receipt-date>-</p>
                    </div>
                    <div class="text-right">
                        <p class="mb-1 font-semibold">Transaction ID</p>
                        <p class="text-primary font-bold normal-case" data-receipt-number>-</p>
                    </div>
                </div>

                <div class="border-t-[1.5px] border-dashed border-slate-200 my-5"></div>

                <!-- Items -->
                <div class="space-y-3" data-receipt-items>
                    <!-- JS will populate this -->
                </div>

                <div class="border-t-[1.5px] border-dashed border-slate-200 mt-4 mb-5"></div>

                <!-- Totals -->
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm text-slate-500 font-medium">
                        <span>Subtotal</span>
                        <span data-receipt-subtotal>Rp 0</span>
                    </div>
                    <div id="receipt-discount-row" class="hidden justify-between text-sm text-slate-500 font-medium">
                        <span>Discount</span>
                        <span data-receipt-discount>- Rp 0</span>
                    </div>
                </div>

                <div class="flex justify-between items-end mb-8">
                    <span class="text-lg font-bold text-primary">Total</span>
                    <span class="text-[26px] font-bold text-primary tracking-tight" data-receipt-total>Rp 0</span>
                </div>

                <!-- Payment Method -->
                <div
                    class="bg-slate-50 rounded-xl p-3.5 flex items-center justify-between border border-slate-100 mb-6">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-600">
                            <i class="fa-solid fa-credit-card" id="method-icon"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Payment Method</p>
                            <p class="text-sm font-bold text-primary" data-receipt-method>-</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-circle-check text-tertiary text-lg"></i>
                </div>

                <!-- Footer -->
                <div class="text-center">
                    <p class="text-xs text-slate-500 mb-4">Thank you for your visit!<br>Enjoy your reading time with us.
                    </p>
                    {{-- <div class="flex justify-center text-slate-300 text-[40px] leading-none opacity-50">
                    <i class="fa-solid fa-barcode"></i>
                    <i class="fa-solid fa-barcode"></i>
                </div> --}}
                </div>
            </div>
            {{--  --}}

            <!-- Action Buttons -->
            {{-- <div class="mt-8 flex gap-4 w-full max-w-[420px]">
            <button type="button" id="print-receipt" class="flex-1 bg-primary hover:bg-primary/90 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2 text-sm">
                <i class="fa-solid fa-print"></i>
                Cetak Struk
            </button>
            <a href="{{ route('kasir.receipt-qr', ['id' => request()->get('id')]) }}"
               class="w-full flex items-center justify-center gap-2 bg-primary hover:bg-primary/90 text-white font-bold py-3.5 rounded-xl transition-all">
                <i class="fa-solid fa-qrcode"></i> Tampilkan QR Nota
            </a>
        </div> --}}
            <div class="mt-8 flex flex-col sm:flex-row gap-4 w-full max-w-[420px]">
                <button type="button" id="print-receipt"
                    class="flex-1 inline-flex items-center justify-center gap-2 bg-primary hover:bg-secondary text-white text-sm font-black py-4 rounded-2xl shadow-lg shadow-primary/20 transition-all duration-200">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Struk</span>
                </button>

                <a href="{{ route('kasir.receipt-qr', ['id' => request()->get('id')]) }}"
                    class="flex-1 inline-flex items-center justify-center gap-2 bg-white border-2 border-primary text-primary text-sm font-black py-4 rounded-2xl hover:bg-slate-50 transition-all duration-200">
                    <i class="fa-solid fa-qrcode"></i>
                    <span>QR Nota</span>
                </a>
            </div>


            <!-- Links -->
            <div class="mt-8 flex gap-8 text-sm font-bold text-slate-400">
                <a href="{{ route('kasir.dashboard') }}"
                    class="hover:text-primary transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Back to Dashboard
                </a>
                <a href="{{ route('kasir.order') }}"
                    class="hover:text-primary transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i>
                    New Sale
                </a>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const printButton = document.getElementById('print-receipt');
            const receiptQueryId = new URLSearchParams(window.location.search).get('id');
            const historyDetailRoute = "{{ route('kasir.histori.show', ['id' => '__ID__']) }}";

            // Web UI elements
            const receiptNumber = document.querySelector('[data-receipt-number]');
            const receiptDate = document.querySelector('[data-receipt-date]');
            const receiptMethod = document.querySelector('[data-receipt-method]');
            const receiptTotal = document.querySelector('[data-receipt-total]');
            const receiptSubtotal = document.querySelector('[data-receipt-subtotal]');
            const receiptDiscount = document.querySelector('[data-receipt-discount]');
            const receiptItems = document.querySelector('[data-receipt-items]');
            const methodIcon = document.getElementById('method-icon');
            const receiptDiscountRow = document.getElementById('receipt-discount-row');

            // Print area elements
            const printNumber = document.querySelector('[data-print-number]');
            const printDate = document.querySelector('[data-print-date]');
            const printFooterDate = document.querySelector('[data-print-footer-date]');
            const printMethodLabel = document.querySelector('[data-print-method-label]');
            const printItems = document.querySelector('[data-print-items]');
            const printItemCount = document.querySelector('[data-print-itemcount]');
            const printSubtotal = document.querySelector('[data-print-subtotal]');
            const printTotal = document.querySelector('[data-print-total]');
            const printPaid = document.querySelector('[data-print-paid]');
            const printChange = document.querySelector('[data-print-change]');

            const formatCurrency = (v) => `Rp ${new Intl.NumberFormat('id-ID').format(v)}`;
            const formatNumber = (v) => new Intl.NumberFormat('id-ID').format(v);

            const setNotFound = () => {
                window.location.href = "{{ route('kasir.order') }}";
            };

            const renderReceipt = (receipt) => {
                if (!receipt || !receipt.items || receipt.items.length === 0) {
                    setNotFound();
                    return;
                }

                const items = receipt.items || [];
                const totalItems = Number(receipt.totalItems || items.reduce((acc, item) => acc + Number(item
                    .quantity || 0), 0));
                const total = Number(receipt.totalPrice || receipt.total || 0);
                const paid = Number(receipt.paid_amount || 0);
                const change = Number(receipt.change_amount || 0);
                const subtotalVal = items.reduce((acc, item) => acc + Number(item.subtotal || 0), 0);
                const discountVal = Math.max(subtotalVal - total, 0);
                const dateObj = new Date(receipt.created_at || Date.now());
                const dateShort = dateObj.toLocaleString('id-ID', {
                    dateStyle: 'short',
                    timeStyle: 'short'
                });
                const dateMedium = dateObj.toLocaleString('en-GB', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                const paymentMethod = receipt.payment_method || 'cash';
                const isCash = paymentMethod === 'cash';
                const methodStr = isCash ? 'Cash' : (paymentMethod === 'transfer' ? 'Bank Transfer' : 'QRIS');

                receiptNumber.textContent = receipt.id || receipt.order_code || '-';
                if (printNumber) printNumber.textContent = receipt.id || receipt.order_code || '-';

                receiptDate.textContent = dateMedium;
                if (printDate) printDate.textContent = dateShort;
                if (printFooterDate) printFooterDate.textContent = dateShort;

                if (receiptMethod) receiptMethod.textContent = methodStr;
                if (printMethodLabel) printMethodLabel.textContent = isCash ? 'Tunai' : methodStr;

                if (methodIcon) {
                    methodIcon.className = isCash ?
                        'fa-solid fa-money-bill-wave' :
                        (paymentMethod === 'transfer' ? 'fa-solid fa-building-columns' : 'fa-solid fa-qrcode');
                }

                if (printItemCount) printItemCount.textContent = totalItems;
                receiptTotal.textContent = formatCurrency(total);
                if (receiptSubtotal) receiptSubtotal.textContent = formatCurrency(subtotalVal);
                if (receiptDiscount) receiptDiscount.textContent = `- ${formatCurrency(discountVal)}`;
                if (receiptDiscountRow) {
                    if (discountVal > 0) {
                        receiptDiscountRow.classList.remove('hidden');
                        receiptDiscountRow.classList.add('flex');
                    } else {
                        receiptDiscountRow.classList.add('hidden');
                        receiptDiscountRow.classList.remove('flex');
                    }
                }
                if (printSubtotal) printSubtotal.textContent = formatNumber(subtotalVal);
                if (printTotal) printTotal.textContent = formatNumber(total);
                if (printPaid) printPaid.textContent = formatNumber(paid);
                if (printChange) printChange.textContent = formatNumber(change);

                const splitData = receipt.split_data || receipt.splitBill || null;
                
                if (splitData && splitData.people && splitData.people.length > 0) {
                    if (receiptItems) {
                        receiptItems.innerHTML = splitData.people.map((person) => {
                            const personItemsHtml = person.items.map((item) => `
                                <div class="flex justify-between items-start text-xs pl-2">
                                    <div>
                                        <p class="font-semibold text-primary/80">${item.name || item.product_name || 'Item'}</p>
                                        <p class="text-[10px] text-slate-500">${Number(item.quantity || 0)} x ${formatCurrency(Number(item.price || 0))}</p>
                                    </div>
                                    <p class="font-semibold text-primary/80">${formatCurrency(Number(item.subtotal || 0))}</p>
                                </div>
                            `).join('');
                            
                            return `
                                <div class="space-y-2 border border-slate-100 rounded-xl p-3 bg-slate-50/50">
                                    <div class="flex justify-between items-center border-b border-dashed border-slate-200 pb-1">
                                        <span class="text-xs font-bold text-primary">${person.personLabel}</span>
                                        <span class="text-xs font-bold text-primary">${formatCurrency(person.total)}</span>
                                    </div>
                                    <div class="space-y-2">
                                        ${personItemsHtml}
                                    </div>
                                </div>
                            `;
                        }).join('<div class="border-t-[1.5px] border-dashed border-slate-200 my-4"></div>');
                    }
                    
                    if (printItems) {
                        printItems.innerHTML = splitData.people.map((person) => {
                            const personItemsHtml = person.items.map((item) => `
                                 <div style="display: flex; justify-content: space-between; padding-left: 8px;">
                                     <span>${Number(item.quantity || 0)} ${item.name || item.product_name || 'Item'}</span>
                                     <span>${formatNumber(Number(item.subtotal || 0))}</span>
                                 </div>
                            `).join('');
                            
                            return `
                                <div>
                                    <div style="display: flex; justify-content: space-between; font-weight: bold; border-b: 1px dashed #000; padding-bottom: 2px; margin-bottom: 4px;">
                                        <span>${person.personLabel}</span>
                                        <span>${formatNumber(person.total)}</span>
                                    </div>
                                    ${personItemsHtml}
                                </div>
                            `;
                        }).join('<div style="border-top: 1px dashed #000; margin: 8px 0;"></div>');
                    }
                } else {
                    if (receiptItems) {
                        receiptItems.innerHTML = items.map((item) => `
                        <div class="flex justify-between items-start text-sm">
                            <div>
                                <p class="font-bold text-primary">${item.name || item.product_name || 'Item'}</p>
                                <p class="text-[11px] text-slate-500">${Number(item.quantity || 0)} x ${formatCurrency(Number(item.price || 0))}</p>
                            </div>
                            <p class="font-bold text-primary">${formatCurrency(Number(item.subtotal || 0))}</p>
                        </div>
                    `).join('');
                    }

                    if (printItems) {
                        printItems.innerHTML = items.map((item) => `
                         <div style="margin-bottom: 2px;">
                             <div style="display: flex; justify-content: space-between;">
                                 <span style="font-weight: 600;">${Number(item.quantity || 0)} ${item.name || item.product_name || 'Item'}</span>
                                 <span>${formatNumber(Number(item.subtotal || 0))}</span>
                             </div>
                         </div>
                    `).join('');
                    }
                }

                printButton?.addEventListener('click', function() {
                    window.print();
                });
            };

            const loadFromLocalStorage = () => {
                try {
                    return JSON.parse(localStorage.getItem('kasir-last-receipt') || 'null');
                } catch (error) {
                    return null;
                }
            };

            const loadFromServer = async (id) => {
                const url = historyDetailRoute.replace('__ID__', encodeURIComponent(id));
                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                    },
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || 'Transaksi tidak ditemukan');
                }

                const order = result.data;

                return {
                    id: order.order_code,
                    order_code: order.order_code,
                    created_at: order.paid_at || order.created_at,
                    payment_method: order.payment_method || 'cash',
                    paid_amount: order.paid_amount,
                    change_amount: order.change_amount,
                    totalItems: (order.items || []).reduce((acc, item) => acc + Number(item.quantity || 0),
                        0),
                    totalPrice: Number(order.total || 0),
                    items: (order.items || []).map((item) => ({
                        id: item.product_id,
                        name: item.product_name,
                        price: Number(item.price || 0),
                        quantity: Number(item.quantity || 0),
                        subtotal: Number(item.subtotal || 0),
                    })),
                    split_data: order.split_data || null,
                };
            };

            (async () => {
                try {
                    if (receiptQueryId) {
                        const receipt = await loadFromServer(receiptQueryId);
                        renderReceipt(receipt);
                        return;
                    }

                    const receipt = loadFromLocalStorage();

                    if (!receipt) {
                        setNotFound();
                        return;
                    }

                    renderReceipt(receipt);
                } catch (error) {
                    const receipt = loadFromLocalStorage();

                    if (!receipt) {
                        setNotFound();
                        return;
                    }

                    renderReceipt(receipt);
                }
            })();
        });
    </script>

    {{-- ============================================================ --}}
    {{-- STYLE PRINT                                                  --}}
    {{-- ============================================================ --}}
    <style>
        @media print {
            @page {
                size: 80mm auto;
                /* lebar thermal 80mm, tinggi otomatis */
                margin: 0;
            }

            body {
                margin: 0;
                padding: 0;
                background: white !important;
                color: black !important;
            }

            .print\:hidden,
            .no-print {
                display: none !important;
            }

            /* Pastikan font di print area menggunakan monospace agar sejajar */
            [data-print-items]>div,
            [style*="text-align: center"] {
                font-family: 'Courier New', Courier, monospace;
            }
        }
    </style>
</x-app-layout>
