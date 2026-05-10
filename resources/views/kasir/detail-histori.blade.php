<x-app-layout :title="'Detail Histori Order'">
	<div class="flex h-screen bg-[#f4f7fe] font-sans selection:bg-accent selection:text-primary">
		<x-sidebar />

		<main class="flex-1 flex flex-col h-screen overflow-hidden">
			<header
				class="bg-white/80 backdrop-blur-md h-[72px] px-8 flex items-center justify-between shadow-sm z-20 border-b border-slate-100 flex-shrink-0 sticky top-0">
				<a href="{{ route('kasir.histori') }}"
					class="inline-flex items-center gap-2 text-sm font-bold text-primary hover:text-secondary transition-colors">
					<i class="fa-solid fa-arrow-left text-xs"></i>
					Kembali ke Histori
				</a>

				<div class="text-right leading-tight">
					<p class="text-sm font-bold text-primary">{{ now()->translatedFormat('l, d F Y') }}</p>
					<p class="text-primary font-bold"><span class="clock-display">{{ date('H:i:s') }}</span> WIB</p>
				</div>
			</header>

			<div class="flex-1 overflow-y-auto p-8 lg:p-10 space-y-6 pb-12 custom-scrollbar">
				<div id="order-not-found"
					class="hidden bg-white border border-[#eef2f9] rounded-3xl shadow-sm p-12 text-center text-secondary/60">
					<div class="w-14 h-14 mx-auto rounded-2xl bg-[#f8faff] border border-[#eef2f9] flex items-center justify-center mb-3">
						<i class="fa-solid fa-receipt text-xl"></i>
					</div>
					<h2 class="text-xl font-bold text-primary">Order tidak ditemukan</h2>
					<p class="text-sm mt-2">Data histori mungkin sudah terhapus dari browser ini.</p>
					<a href="{{ route('kasir.histori') }}"
						class="inline-flex items-center gap-2 mt-4 px-4 py-2 rounded-xl bg-primary text-white font-bold text-sm hover:bg-secondary transition-colors">
						<i class="fa-solid fa-clock-rotate-left"></i>
						Kembali ke Histori
					</a>
				</div>

				<div id="order-detail-content" class="space-y-6">
					<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
						<section class="xl:col-span-2 bg-white rounded-3xl border border-[#eef2f9] shadow-sm p-6">
							<div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
								<div>
									<p class="text-xs font-bold  tracking-wider text-secondary/50">Order ID</p>
									<h1 id="order-id" class="text-2xl font-bold text-primary mt-1">-</h1>
									<p id="order-date" class="text-sm text-secondary/70 mt-1">-</p>
								</div>

								<div id="order-status-badge"></div>
							</div>

							<div class="overflow-x-auto">
								<table class="w-full min-w-[620px]">
									<thead>
										<tr class="text-left text-xs font-bold  tracking-wider text-secondary/50 border-b border-[#eef2f9]">
											<th class="pb-3 pr-3">Item</th>
											<th class="pb-3 px-3">Harga</th>
											<th class="pb-3 px-3">Qty</th>
											<th class="pb-3 pl-3 text-right">Subtotal</th>
										</tr>
									</thead>
									<tbody id="order-items-body"></tbody>
								</table>
							</div>
						</section>

						<aside class="bg-white rounded-3xl border border-[#eef2f9] shadow-sm p-6 h-fit space-y-6">
							<div>
								<p class="text-xs font-bold tracking-wider text-secondary/50">Ringkasan Pembayaran</p>

								<div class="mt-4 space-y-3 text-sm">
									<div class="flex items-center justify-between text-secondary/70 font-semibold">
										<span>Total Item</span>
										<span id="summary-total-items" class="text-primary font-bold">0</span>
									</div>
									<div class="flex items-center justify-between text-secondary/70 font-semibold">
										<span>Subtotal</span>
										<span id="summary-subtotal" class="text-primary font-bold">Rp 0</span>
									</div>
									<div class="flex items-center justify-between text-secondary/70 font-semibold">
										<span>Metode Bayar</span>
										<span id="summary-method" class="text-primary font-bold">-</span>
									</div>
									<div class="flex items-center justify-between text-secondary/70 font-semibold">
										<span>Nominal Bayar</span>
										<span id="summary-paid" class="text-primary font-bold">Rp 0</span>
									</div>
									<div id="summary-discount-row" class="hidden items-center justify-between text-secondary/70 font-semibold">
										<span>Discount</span>
										<span id="summary-discount" class="text-primary font-bold">Rp 0</span>
									</div>
									<div class="flex items-center justify-between text-secondary/70 font-semibold">
										<span>Kembalian</span>
										<span id="summary-change" class="text-primary font-bold">Rp 0</span>
									</div>
								</div>

								<div class="border-t border-[#eef2f9] mt-4 pt-4 flex items-center justify-between">
									<span class="text-base font-bold text-secondary">Total</span>
									<span id="summary-total" class="text-2xl font-bold text-primary">Rp 0</span>
								</div>
							</div>

							<div class="space-y-3">
								<button type="button" id="reprint-receipt"
									class="w-full bg-primary hover:bg-secondary text-white py-3.5 rounded-xl font-bold text-sm transition-colors">
									<i class="fa-solid fa-print mr-2"></i>
									Cetak Ulang Struk
								</button>

								<a href="{{ route('kasir.order') }}"
									class="w-full inline-flex justify-center items-center bg-[#f8faff] hover:bg-[#eef4ff] text-primary py-3.5 rounded-xl font-bold text-sm transition-colors border border-[#eef2f9]">
									<i class="fa-solid fa-cart-shopping mr-2"></i>
									Buat Order Baru
								</a>
							</div>
						</aside>
					</div>
				</div>
			</div>
		</main>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const clockEl = document.querySelector('.clock-display');
			const notFound = document.getElementById('order-not-found');
			const content = document.getElementById('order-detail-content');
			const orderIdEl = document.getElementById('order-id');
			const orderDateEl = document.getElementById('order-date');
			const orderStatusBadge = document.getElementById('order-status-badge');
			const itemsBody = document.getElementById('order-items-body');
			const reprintButton = document.getElementById('reprint-receipt');
			const discountRow = document.getElementById('summary-discount-row');
			const discountValueEl = document.getElementById('summary-discount');
			const routeOrderId = @json($orderId ?? '');
			const detailUrlTemplate = "{{ route('kasir.histori.show', ['id' => '__ID__']) }}";

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

			const fetchOrder = async () => {
				try {
					const url = detailUrlTemplate.replace('__ID__', encodeURIComponent(routeOrderId));
					const response = await fetch(url, {
						headers: { 'Accept': 'application/json' },
					});
					const result = await response.json();

					if (!response.ok || !result.success) {
						throw new Error(result.message || 'Order tidak ditemukan');
					}

					const order = result.data;
					const status = String(order.status || '').toLowerCase();
					const isPaid = status === 'paid';
					const items = Array.isArray(order.items) ? order.items : [];
					const totalItems = items.reduce((acc, item) => acc + Number(item.quantity || 0), 0);
					const subtotal = items.reduce((acc, item) => acc + Number(item.subtotal || 0), 0);
					const total = Number(order.total || 0);
					const paidAmount = Number(order.paid_amount || 0);
					const changeAmount = Number(order.change_amount || 0);
					const discountAmount = Math.max(subtotal - total, 0);

					orderIdEl.textContent = order.order_code || '-';
					orderDateEl.textContent = order.paid_at
						? new Date(order.paid_at).toLocaleString('id-ID', {
							day: '2-digit',
							month: 'long',
							year: 'numeric',
							hour: '2-digit',
							minute: '2-digit'
						})
						: (order.created_at ? new Date(order.created_at).toLocaleString('id-ID', {
							day: '2-digit',
							month: 'long',
							year: 'numeric',
							hour: '2-digit',
							minute: '2-digit'
						}) : '-');

					orderStatusBadge.innerHTML = isPaid
						? '<span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-tertiary/10 text-tertiary">LUNAS</span>'
						: '<span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-accent/10 text-accent">DRAFT</span>';

					itemsBody.innerHTML = items.map((item) => `
						<tr class="border-b border-[#f3f6fc]">
							<td class="py-4 pr-3">
								<p class="text-sm font-bold text-primary">${escapeHtml(item?.product_name || 'Item')}</p>
							</td>
							<td class="py-4 px-3 text-sm font-semibold text-secondary/70">${formatCurrency(item?.price || 0)}</td>
							<td class="py-4 px-3 text-sm font-semibold text-secondary/70">${Number(item?.quantity || 0)}</td>
							<td class="py-4 pl-3 text-right text-sm font-bold text-primary">${formatCurrency(item?.subtotal || 0)}</td>
						</tr>
					`).join('');

					document.getElementById('summary-total-items').textContent = String(totalItems);
					document.getElementById('summary-subtotal').textContent = formatCurrency(subtotal);
					document.getElementById('summary-method').textContent = isPaid ? 'Cash' : 'Belum dibayar';
					document.getElementById('summary-paid').textContent = formatCurrency(paidAmount);
					document.getElementById('summary-change').textContent = formatCurrency(changeAmount);
					document.getElementById('summary-total').textContent = formatCurrency(total);

					if (discountRow && discountValueEl) {
						if (discountAmount > 0) {
							discountRow.classList.remove('hidden');
							discountRow.classList.add('flex');
							discountValueEl.textContent = formatCurrency(discountAmount);
						} else {
							discountRow.classList.add('hidden');
							discountRow.classList.remove('flex');
						}
					}

					if (!isPaid) {
						reprintButton.disabled = true;
						reprintButton.classList.remove('bg-primary', 'hover:bg-secondary', 'text-white');
						reprintButton.classList.add('bg-slate-100', 'text-slate-400', 'cursor-not-allowed');
						reprintButton.innerHTML = '<i class="fa-solid fa-ban mr-2"></i> Draft belum bisa dicetak';
					}

					if (reprintButton) {
						reprintButton.addEventListener('click', function() {
							if (!isPaid) {
								return;
							}

							const receipt = {
								id: order.order_code,
								status: order.status,
								created_at: order.paid_at || order.created_at,
								payment_method: 'cash',
								paid_amount: order.paid_amount,
								change_amount: order.change_amount,
								totalItems,
								totalPrice: total,
								items: items.map((item) => ({
									id: item.product_id,
									name: item.product_name,
									price: item.price,
									quantity: item.quantity,
									subtotal: item.subtotal,
								})),
							};

							window.location.href = "{{ route('kasir.receipt') }}?id=" + encodeURIComponent(order.order_code);
						});
					}
				} catch (error) {
					content.classList.add('hidden');
					notFound.classList.remove('hidden');
					notFound.querySelector('h2').textContent = 'Order tidak ditemukan';
					notFound.querySelector('p.text-sm').textContent = error.message || 'Data histori mungkin sudah terhapus dari browser ini.';
				}
			};

			fetchOrder();
		});
	</script>
</x-app-layout>
