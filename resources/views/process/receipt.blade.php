<x-app-layout :title="'Receipt'">
    {{-- template nota --}}
    <div class="hidden print:block"
        style="width: 80mm; font-family: 'Courier New', Courier, monospace; font-size: 11px; color: #000; padding: 2px;">

        {{-- header --}}
        <div style="text-align: center; margin-bottom: 8px;">
            <img src="{{ asset('img/logo-perpus.webp') }}" alt="" style="max-height: 45px; margin: 0 auto 5px; display: block;">
            <div style="font-weight: 900; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Library Cafe</div>
            <div style="font-size: 9px; margin-top: 2px; line-height: 1.3;">
                UPT Perpustakaan dan Layanan Digital<br>
                Jl. A. Yani Tromol Pos I, Pabelan, Surakarta 57102
            </div>
        </div>

        {{-- info transaksi (langsung di bawah header tanpa divider, persis di gambar) --}}
        <div style="font-size: 9px; line-height: 1.4; color: #000; margin-bottom: 5px;">
            <div>Order Date: <span data-print-date>-</span></div>
            <div>Order ID  : <span data-print-number>-</span></div>
            <div>Kasir     : {{ auth()->user()->name ?? 'Kasir' }}</div>
        </div>

        <div style="border-top: 1px dashed #000; margin: 5px 0;"></div>

        {{-- item --}}
        <div style="font-size: 10px; margin-bottom: 5px;" data-print-items>
            {{-- diisi via JS --}}
        </div>

        <div style="border-top: 1px dashed #000; margin: 5px 0;"></div>

        {{-- ringkasan harga --}}
        <div style="font-size: 10px; line-height: 1.4;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 2px;">
                <span>Subtotal (<span data-print-itemcount>0</span> item)</span>
                <span data-print-subtotal>0</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-weight: 700; font-size: 11px; margin-top: 3px; border-top: 1px dashed #000; padding-top: 3px;">
                <span>Total</span>
                <span data-print-total>0</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-top: 3px;">
                <span data-print-method-label>Tunai</span>
                <span data-print-paid>0</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span>Kembalian</span>
                <span data-print-change>0</span>
            </div>
        </div>

        <div style="border-top: 1px dashed #000; margin: 8px 0;"></div>

        {{-- footer --}}
        <div style="text-align: center; font-size: 9px; line-height: 1.4;">
            <div style="margin-bottom: 4px; font-style: italic;">"Makan, Minum, Baca, Santai"</div>
            <div>Instagram: @perpusums</div>
            <div>Wifi: UMS Wifi | Password: ums.wifi</div>
            <div style="margin-top: 6px; font-weight: bold;">-- Terima Kasih --</div>
        </div>

    </div>

    {{-- web ui --}}
    <div
        class="min-h-screen bg-slate-50 font-sans selection:bg-accent selection:text-primary print:hidden flex flex-col">

        <!-- Main Content -->
        <main class="flex-1 flex flex-col items-center py-12 px-4 relative">

            <!-- Receipt Card -->
            <div
                class="bg-white w-full max-w-[400px] rounded-[32px] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden relative p-8 sm:p-10">
                <!-- Decorative cutouts on sides (optional, for receipt look) -->
                <div class="absolute -left-3 top-[60%] w-6 h-6 rounded-full bg-slate-50 shadow-inner"></div>
                <div class="absolute -right-3 top-[60%] w-6 h-6 rounded-full bg-slate-50 shadow-inner"></div>

                <!-- Header -->
                <div class="text-center mb-6">
                    <img src="{{ asset('img/logo-perpus.webp') }}" alt="" class="h-16 mx-auto mb-4 grayscale opacity-90">
                    <h2 class="text-xl font-black text-slate-800 uppercase tracking-tighter">Library Cafe</h2>
                    <p class="text-[11px] text-slate-500 leading-relaxed mt-1 font-medium">
                        UPT Perpustakaan dan Layanan Digital<br>
                        Jl. A. Yani Tromol Pos I, Pabelan<br>
                        Surakarta 57102
                    </p>
                </div>

                <!-- Meta (Langsung di bawah, persis di foto) -->
                <div class="space-y-1.5 text-[11px] text-slate-600 font-medium mb-4">
                    <div>Order Date: <span class="font-bold text-slate-800" data-receipt-date>-</span></div>
                    <div>Order ID  : <span class="font-bold text-slate-800" data-receipt-number>-</span></div>
                    <div>Kasir     : <span class="font-bold text-slate-800">{{ auth()->user()->name ?? 'Kasir' }}</span></div>
                </div>

                <div class="border-t-[1.5px] border-dashed border-slate-200 my-4"></div>

                <!-- Items -->
                <div class="space-y-3" data-receipt-items>
                    <!-- JS will populate this -->
                </div>

                <div class="border-t-[1.5px] border-dashed border-slate-200 my-4"></div>

                <!-- Totals (Gada tax) -->
                <div class="space-y-2 mb-4 text-xs font-semibold text-slate-600">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span data-receipt-subtotal>Rp 0</span>
                    </div>
                    <div id="receipt-discount-row" class="hidden justify-between text-red-500">
                        <span>Discount</span>
                        <span data-receipt-discount>- Rp 0</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-dashed border-slate-200 text-sm font-black text-slate-800 uppercase">
                        <span>Total</span>
                        <span class="text-lg font-black text-slate-900 tracking-tighter" data-receipt-total>Rp 0</span>
                    </div>
                    <div class="flex justify-between pt-2">
                        <span data-receipt-method-label>Tunai</span>
                        <span data-receipt-paid>Rp 0</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Kembalian</span>
                        <span data-receipt-change>Rp 0</span>
                    </div>
                </div>

                <div class="border-t-[1.5px] border-dashed border-slate-200 my-5"></div>

                <!-- Footer -->
                <div class="text-center font-medium">
                    <p class="text-[11px] text-slate-500 italic mb-4">"Makan, Minum, Baca, Santai"</p>
                    <div class="space-y-1 text-[10px] text-slate-400 tracking-widest">
                        <p>Instagram: @perpusums</p>
                        <p>Wifi: UMS Wifi | Password: ums.wifi</p>
                    </div>
                    <div class="mt-6 text-[12px] font-black text-slate-800 tracking-[0.3em] opacity-30 uppercase">
                        -- Terima Kasih --
                    </div>
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
            const receiptPaid = document.querySelector('[data-receipt-paid]');
            const receiptChange = document.querySelector('[data-receipt-change]');
            const receiptMethodLabel = document.querySelector('[data-receipt-method-label]');

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

                const items = (receipt.items || []).map(item => {
                    let formattedOpts = item.formatted_options || '';
                    if (!formattedOpts && item.selected_options) {
                        try {
                            const opts = typeof item.selected_options === 'string' 
                                ? JSON.parse(item.selected_options) 
                                : item.selected_options;
                            formattedOpts = Object.entries(opts).map(([key, val]) => `${key} - ${val}`).join(', ');
                        } catch(e) {
                            formattedOpts = '';
                        }
                    }
                    return {
                        ...item,
                        formatted_options: formattedOpts
                    };
                });
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
                if (receiptMethodLabel) receiptMethodLabel.textContent = isCash ? 'Tunai' : methodStr;
                if (receiptPaid) receiptPaid.textContent = formatCurrency(paid);
                if (receiptChange) receiptChange.textContent = formatCurrency(change);
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
                            const personItemsHtml = person.items.map((item) => {
                                let formattedOpts = item.formatted_options || '';
                                if (!formattedOpts && item.selected_options) {
                                    try {
                                        const opts = typeof item.selected_options === 'string' 
                                            ? JSON.parse(item.selected_options) 
                                            : item.selected_options;
                                        formattedOpts = Object.entries(opts).map(([key, val]) => `${key} - ${val}`).join(', ');
                                    } catch(e) {
                                        formattedOpts = '';
                                    }
                                }
                                return `
                                    <div class="flex justify-between items-start text-xs pl-2 mb-2">
                                        <div class="max-w-[80%]">
                                            <p class="font-semibold text-primary/80 leading-tight">
                                                ${Number(item.quantity || 0)}x ${item.name || item.product_name || 'Item'}
                                            </p>
                                            ${formattedOpts ? `<p class="text-[9px] text-slate-400 font-semibold mt-0.5">${formattedOpts}</p>` : ''}
                                        </div>
                                        <p class="font-semibold text-primary/80">${formatNumber(Number(item.subtotal || 0))}</p>
                                    </div>
                                `;
                            }).join('');
                            
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
                            const personItemsHtml = person.items.map((item) => {
                                let formattedOpts = item.formatted_options || '';
                                if (!formattedOpts && item.selected_options) {
                                    try {
                                        const opts = typeof item.selected_options === 'string' 
                                            ? JSON.parse(item.selected_options) 
                                            : item.selected_options;
                                        formattedOpts = Object.entries(opts).map(([key, val]) => `${key} - ${val}`).join(', ');
                                    } catch(e) {
                                        formattedOpts = '';
                                    }
                                }
                                return `
                                     <div style="padding-left: 8px; line-height: 1.4; margin-bottom: 4px;">
                                         <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                             <span style="max-width: 75%; word-break: break-word; font-weight: 600;">
                                                 ${Number(item.quantity || 0)} ${item.name || item.product_name || 'Item'}
                                             </span>
                                             <span style="font-weight: 600;">${formatNumber(Number(item.subtotal || 0))}</span>
                                         </div>
                                         ${formattedOpts ? `<div style="font-size: 8px; color: #555; padding-left: 10px;">${formattedOpts}</div>` : ''}
                                     </div>
                                `;
                            }).join('');
                            
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
                        <div class="flex justify-between items-start text-sm mb-3">
                            <div class="max-w-[80%]">
                                <p class="font-bold text-primary leading-tight">
                                    ${Number(item.quantity || 0)}x ${item.name || item.product_name || 'Item'}
                                </p>
                                ${item.formatted_options ? `<p class="text-[10px] text-slate-400 font-semibold mt-0.5">${item.formatted_options}</p>` : ''}
                            </div>
                            <p class="font-bold text-primary">${formatNumber(Number(item.subtotal || 0))}</p>
                        </div>
                    `).join('');
                    }

                    if (printItems) {
                        printItems.innerHTML = items.map((item) => `
                          <div style="margin-bottom: 5px; line-height: 1.4;">
                              <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                  <span style="font-weight: 600; max-width: 75%; word-break: break-word;">
                                      ${Number(item.quantity || 0)} ${item.name || item.product_name || 'Item'}
                                  </span>
                                  <span style="font-weight: 600;">${formatNumber(Number(item.subtotal || 0))}</span>
                              </div>
                              ${item.formatted_options ? `<div style="font-size: 8px; color: #555; padding-left: 10px;">${item.formatted_options}</div>` : ''}
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
                        selected_options: item.selected_options || null,
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
