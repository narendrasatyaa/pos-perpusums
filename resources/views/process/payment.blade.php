<x-app-layout :title="'Payment'">
	<div class="min-h-screen bg-gradient-to-b from-primary/20 via-white to-primary/10 font-sans text-primary selection:bg-accent selection:text-primary">
		<div class="w-full px-4 py-6 sm:px-6 lg:px-8">
			<header class="mb-6 rounded-xl bg-gradient-to-r from-primary to-secondary px-6 py-4 text-white shadow-lg shadow-primary/20 sm:px-8">
				<div class="flex flex-wrap items-center justify-between gap-4">
					<div class="flex items-center gap-4">
						<img src="{{ asset('img/logo-perpus-putih.webp') }}" alt="Logo Perpus" class="h-10 w-auto p-1">
				</div>
				   <button
					   class="w-10 h-10 rounded-full bg-white text-secondary hover:text-primary flex items-center justify-center transition-colors relative">
                        <i class="fa-solid fa-bell"></i>
                        <span
                            class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
			</header>

            <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">
				<section class="rounded-xl border border-primary/10 bg-white p-6">
                    <div class="mb-5 flex items-center justify-between">
                        <div>
                            <h2 class="mt-1 text-xl font-bold text-primary">Pilih metode pembayaran</h2>
                        </div>
                        {{-- <span class="rounded-full bg-accent/10 px-4 py-1.5 text-xs font-bold text-accent" data-status-badge>Menunggu</span> --}}
                    </div>

					<div id="checkout-empty" class="hidden rounded-lg border border-dashed border-primary/10 bg-white p-10 text-center text-secondary/50">
                        <i class="fa-solid fa-bag-shopping text-5xl"></i>
                        <p class="mt-4 text-lg font-bold text-primary">Belum ada order aktif</p>
                        <p class="mt-2 text-sm leading-6">Balik ke halaman order dulu untuk pilih produk, lalu lanjut ke payment.</p>
                        <a href="{{ route('kasir.order') }}" class="mt-6 inline-flex rounded-xl bg-accent px-5 py-3 text-sm font-bold text-white transition hover:bg-info">
                            Ke Order
                        </a>
                    </div>

                    <div id="checkout-content" class="space-y-5">
						<div class="inline-flex rounded-lg border border-primary/10 bg-primary/5 p-1">
	                            <button type="button" data-method="cash" class="method-card rounded-md px-4 py-2 text-sm font-bold text-primary transition">Cash</button>
	                            <button type="button" data-method="qris" class="method-card rounded-md px-4 py-2 text-sm font-bold text-primary transition">QRIS</button>
                        </div>

						<div id="cash-panel" class="space-y-4 rounded-lg bg-primary/5 p-4">
                            <div class="grid gap-4 sm:grid-cols-2">
                                <label class="block">
                                    <span class="mb-2 block text-xs font-bold ">Total Tagihan</span>
									<input type="text" readonly data-total-field class="w-full rounded-lg border border-primary/10 bg-white px-4 py-3 text-lg font-bold text-primary">
                                </label>
                                <label class="block">
                                    <span class="mb-2 block text-xs font-bold">Uang Diterima</span>
									<input type="number" min="0" data-cash-input placeholder="Masukkan nominal"
	                                        class="w-full rounded-lg border border-primary/10 bg-white px-4 py-3 text-lg font-bold text-primary focus:border-accent focus:ring-accent">
                                </label>
                            </div>

                            <div class="flex flex-wrap gap-2">
								<button type="button" data-cash-quick="10000" class="rounded-md border border-primary/10 bg-white px-3 py-1.5 text-xs font-bold text-primary transition hover:bg-primary/10">10.000</button>
								<button type="button" data-cash-quick="20000" class="rounded-md border border-primary/10 bg-white px-3 py-1.5 text-xs font-bold text-primary transition hover:bg-primary/10">20.000</button>
								<button type="button" data-cash-quick="50000" class="rounded-md border border-primary/10 bg-white px-3 py-1.5 text-xs font-bold text-primary transition hover:bg-primary/10">50.000</button>
								<button type="button" data-cash-quick="100000" class="rounded-md border border-primary/10 bg-white px-3 py-1.5 text-xs font-bold text-primary transition hover:bg-primary/10">100.000</button>
                            </div>

							<div class="flex items-center justify-between rounded-lg border border-primary/10 bg-white px-4 py-3 text-sm font-semibold text-secondary/60">
                                <span>Kembalian</span>
                                <span class="text-lg font-extrabold text-primary" data-change-field>Rp 0</span>
                            </div>
                        </div>

						<div id="qris-panel" class="hidden p-4">
							<div class="mx-auto w-full max-w-xl rounded-lg bg-white p-3 sm:p-4">
								<img src="{{ asset('img/sample-qris-img.png') }}" alt="gambar qris" class="mx-auto h-auto w-full object-contain rounded-xl shadow-xl">
							</div>
						</div>

                        <div class="flex flex-wrap gap-3 pt-1">
							<button type="button" id="confirm-payment" class="rounded-lg bg-primary px-6 py-3 text-sm font-bold text-white transition hover:bg-secondary">
                                Konfirmasi Payment
                            </button>
							<button type="button" id="cancel-payment" class="rounded-lg border border-primary/10 bg-white px-6 py-3 text-sm font-bold text-primary transition hover:bg-primary/10">
                                Back to Order
                            </button>
                        </div>
                    </div>
                </section>

				<aside class="rounded-xl border border-primary/10 bg-white p-6">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-primary">Ringkasan Order</h2>
                        <span class="px-3 py-1 text-xs font-bold text-secondary/60" data-item-count>0 item</span>
                    </div>

					<div class="space-y-2" data-summary-items>
						<div class="rounded-lg border border-dashed border-primary/10 bg-primary/5 p-5 text-center text-sm text-secondary/50">
                            Data order belum ditemukan.
                        </div>
                    </div>

					<div class="mt-5 space-y-2 border-t border-primary/10 pt-4 text-sm font-semibold text-secondary/60">
                        <div class="flex items-center justify-between">
                            <span>Total</span>
                            <span class="text-base font-extrabold text-primary" data-summary-total>Rp 0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Metode</span>
                            <span class="font-bold text-primary" data-summary-method>-</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Kembalian</span>
                            <span class="font-bold text-primary" data-summary-change>Rp 0</span>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const checkout = JSON.parse(localStorage.getItem('kasir-active-checkout') || 'null');
			const emptyState = document.getElementById('checkout-empty');
			const contentState = document.getElementById('checkout-content');
			const totalField = document.querySelector('[data-total-field]');
			const cashInput = document.querySelector('[data-cash-input]');
			const changeField = document.querySelector('[data-change-field]');
			const summaryItems = document.querySelector('[data-summary-items]');
			const summaryTotal = document.querySelector('[data-summary-total]');
			const summaryMethod = document.querySelector('[data-summary-method]');
			const summaryChange = document.querySelector('[data-summary-change]');
			const itemCount = document.querySelector('[data-item-count]');
			const statusBadge = document.querySelector('[data-status-badge]');
			const cashPanel = document.getElementById('cash-panel');
			const qrisPanel = document.getElementById('qris-panel');
			const methodButtons = document.querySelectorAll('[data-method]');
			const confirmButton = document.getElementById('confirm-payment');
			const cancelButton = document.getElementById('cancel-payment');
			const quickCashButtons = document.querySelectorAll('[data-cash-quick]');

			const formatCurrency = (value) => `Rp ${new Intl.NumberFormat('id-ID').format(value)}`;

			if (!checkout || !checkout.items || checkout.items.length === 0) {
				emptyState.classList.remove('hidden');
				contentState.classList.add('hidden');
				return;
			}

			const renderSummary = () => {
				if (summaryItems) {
						summaryItems.innerHTML = checkout.items.map((item) => `
						<div class="flex items-center justify-between rounded-2xl border border-primary/10 bg-white p-4">
							<div class="min-w-0 pr-4">
								<p class="truncate font-bold text-primary">${item.name}</p>
								<p class="text-xs text-secondary/50">${item.quantity} x ${formatCurrency(item.price)}</p>
							</div>
							<p class="shrink-0 font-extrabold text-accent">${formatCurrency(item.subtotal)}</p>
						</div>
					`).join('');
				}

				if (summaryTotal) {
					summaryTotal.textContent = formatCurrency(checkout.totalPrice || 0);
				}

				if (itemCount) {
					itemCount.textContent = `${checkout.totalItems || 0} item`;
				}

				if (totalField) {
					totalField.value = formatCurrency(checkout.totalPrice || 0);
				}
			};

			let selectedMethod = 'cash';

			const updateMethodUI = () => {
				methodButtons.forEach((button) => {
					const method = button.dataset.method;
					const active = method === selectedMethod;
					button.classList.toggle('bg-white', active);
					button.classList.toggle('text-accent', active);
					button.classList.toggle('shadow-sm', active);
					button.classList.toggle('bg-transparent', !active);
					button.classList.toggle('text-primary', !active);
				});

				cashPanel.classList.toggle('hidden', selectedMethod !== 'cash');
				qrisPanel.classList.toggle('hidden', selectedMethod !== 'qris');

				if (summaryMethod) {
					summaryMethod.textContent = selectedMethod === 'cash' ? 'Cash' : 'QRIS';
				}
			};

			const updateChange = () => {
				const paid = Number(cashInput?.value || 0);
				const total = Number(checkout.totalPrice || 0);
				const change = selectedMethod === 'cash' ? Math.max(paid - total, 0) : 0;

				if (changeField) {
					changeField.textContent = formatCurrency(change);
				}

				if (summaryChange) {
					summaryChange.textContent = formatCurrency(change);
				}

				return change;
			};

			methodButtons.forEach((button) => {
				button.addEventListener('click', function() {
					selectedMethod = this.dataset.method;
					updateMethodUI();
					updateChange();
				});
			});

			cashInput?.addEventListener('input', updateChange);

			quickCashButtons.forEach((button) => {
				button.addEventListener('click', function() {
					if (!cashInput) {
						return;
					}

					cashInput.value = this.dataset.cashQuick || 0;
					updateChange();
				});
			});

			cancelButton?.addEventListener('click', function() {
				window.location.href = "{{ route('kasir.order') }}";
			});

			confirmButton?.addEventListener('click', function() {
				const total = Number(checkout.totalPrice || 0);
				const paid = Number(cashInput?.value || 0);
				const change = updateChange();

				if (selectedMethod === 'cash' && paid < total) {
					alert('Uang cash belum cukup.');
					return;
				}

				const receiptNumber = `RCPT-${Date.now()}`;
				const receiptPayload = {
					id: receiptNumber,
					status: 'paid',
					created_at: new Date().toISOString(),
					payment_method: selectedMethod,
					paid_amount: selectedMethod === 'cash' ? paid : total,
					change_amount: change,
					totalItems: checkout.totalItems || 0,
					totalPrice: total,
					items: checkout.items,
				};

				const history = JSON.parse(localStorage.getItem('kasir-order-history') || '[]');
				history.unshift(receiptPayload);
				localStorage.setItem('kasir-order-history', JSON.stringify(history.slice(0, 20)));
				localStorage.setItem('kasir-last-receipt', JSON.stringify(receiptPayload));
				localStorage.removeItem('kasir-active-checkout');

				window.location.href = "{{ route('kasir.receipt') }}";
			});

			renderSummary();
			updateMethodUI();
			updateChange();
			if (statusBadge) {
				statusBadge.textContent = 'Ready';
			}
		});
	</script>
</x-app-layout>