<x-app-layout :title="'Receipt Kasir'">
	{{-- nota template --}}
	<div id="print-area" class="hidden print:block">
		<div class="font-mono text-black bg-white text-[11px] leading-snug" style="width: 80mm; margin: 0 auto; padding: 4mm;">

			{{-- HEADER --}}
			<div style="text-align: center; margin-bottom: 6px;">
				<img src="{{ asset('/img/logo-perpus.webp') }}" alt="logo" class="mx-auto w-12">
				<div style="font-weight: 700; font-size: 13px; letter-spacing: 1px; text-transform: uppercase;">Library Cafe UMS</div>
				<div style="font-size: 10px; margin-top: 2px;">UPT Perpustakaan dan Layanan Digital</div>
				<div style="font-size: 10px;">Jl. A. Yani Tromol Pos I, Pabelan</div>
				<div style="font-size: 10px;">Surakarta 57102</div>
			</div>

			<div style="border-top: 1px dashed #000; margin: 6px 0;"></div>

			{{-- INFO TRANSAKSI --}}
			<div style="font-size: 10px;">
				<div style="display: flex; justify-content: space-between;">
					<span>Kasir</span>
					<span style="font-weight: 600;">{{ auth()->user()->name ?? 'Kasir' }}</span>
				</div>
				<div style="display: flex; justify-content: space-between;">
					<span>No Nota</span>
					<span data-print-number>-</span>
				</div>
				<div style="display: flex; justify-content: space-between;">
					<span>Waktu</span>
					<span data-print-date>-</span>
				</div>
				<div style="display: flex; justify-content: space-between;">
					<span>Metode</span>
					<span data-print-method>-</span>
				</div>
			</div>

			<div style="border-top: 1px dashed #000; margin: 6px 0;"></div>

			{{-- item --}}
			<div style="font-size: 10px;" data-print-items>
				{{-- diisi via JS --}}
			</div>

			<div style="border-top: 1px dashed #000; margin: 6px 0;"></div>

			{{-- RINGKASAN HARGA --}}
			<div style="font-size: 10px;">
				<div style="display: flex; justify-content: space-between;">
					<span>Subtotal (<span data-print-itemcount>0</span> Produk)</span>
					<span data-print-subtotal>0</span>
				</div>
				<div style="display: flex; justify-content: space-between; font-weight: 700; border-top: 1px dashed #000; margin-top: 4px; padding-top: 4px;">
					<span>Total</span>
					<span data-print-total>0</span>
				</div>
				<div style="display: flex; justify-content: space-between; margin-top: 2px;">
					<span data-print-method-label>Tunai</span>
					<span data-print-paid>0</span>
				</div>
				<div style="display: flex; justify-content: space-between;">
					<span>Total Bayar</span>
					<span data-print-paid2>0</span>
				</div>
				<div style="display: flex; justify-content: space-between;">
					<span>Kembalian</span>
					<span data-print-change>0</span>
				</div>
			</div>

			<div style="border-top: 1px dashed #000; margin: 6px 0;"></div>

			{{-- FOOTER --}}
			<div style="text-align: center; font-size: 10px; line-height: 1.6;">
				<div>instagram: perpusums</div>
				<div>Terbayar <span data-print-footer-date>-</span></div>
			</div>

		</div>
	</div>
	{{-- web ui --}}
	<div class="min-h-screen bg-gradient-to-b from-primary/20 via-white to-primary/10 font-sans text-primary selection:bg-accent selection:text-primary print:hidden">
		<div class="w-full px-4 py-6 sm:px-6 lg:px-8">
			<header class="mb-6 rounded-xl bg-gradient-to-r from-primary to-secondary px-6 py-4 text-white shadow-lg shadow-primary/20 sm:px-8">
				<div class="flex flex-wrap items-center justify-between gap-4">
					<div class="flex items-center gap-4">
						<img src="{{ asset('img/logo-perpus-putih.webp') }}" alt="Logo Perpus" class="h-10 w-auto p-1">
					</div>
					<button class="h-10 w-10 rounded-full bg-white text-secondary transition-colors hover:text-primary flex items-center justify-center relative">
						<i class="fa-solid fa-bell"></i>
						<span class="absolute right-2.5 top-2 h-2 w-2 rounded-full border-2 border-white bg-red-500"></span>
					</button>
				</div>
			</header>

			<div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
				<section class="rounded-xl border border-primary/10 bg-white p-6">
					<div id="receipt-empty" class="hidden rounded-lg border border-dashed border-primary/10 bg-white p-10 text-center text-secondary/50">
						<i class="fa-solid fa-receipt text-5xl"></i>
						<p class="mt-4 text-lg font-bold text-primary">Belum ada receipt terbaru</p>
						<p class="mt-2 text-sm leading-6">Selesaikan payment dulu untuk membuat receipt.</p>
						<a href="{{ route('kasir.order') }}" class="mt-6 inline-flex rounded-xl bg-accent px-5 py-3 text-sm font-bold text-white transition hover:bg-info">
							Mulai Order
						</a>
					</div>

					<div id="receipt-content" class="space-y-6">
						<div class="flex items-right justify-end border-b border-dashed border-primary/10 pb-5">
							<span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-bold text-accent" data-receipt-status>PAID</span>
						</div>

						<div class="grid gap-4 sm:grid-cols-2">
							<div class="rounded-lg border border-primary/10 bg-white p-4">
								<p class="text-xs font-semibold text-secondary/40">Receipt Number</p>
								<p class="mt-1 text-lg font-bold text-primary" data-receipt-number>-</p>
							</div>
							<div class="rounded-lg border border-primary/10 bg-white p-4">
								<p class="text-xs font-semibold text-secondary/40">Tanggal</p>
								<p class="mt-1 text-lg font-bold text-primary" data-receipt-date>-</p>
							</div>
							<div class="rounded-lg border border-primary/10 bg-white p-4">
								<p class="text-xs font-semibold text-secondary/40">Metode</p>
								<p class="mt-1 text-lg font-bold text-primary" data-receipt-method>-</p>
							</div>
							<div class="rounded-lg border border-primary/10 bg-white p-4">
								<p class="text-xs font-semibold text-secondary/40">Status</p>
								<p class="mt-1 text-lg font-bold text-primary" data-receipt-payment-status>-</p>
							</div>
						</div>

						<div class="rounded-xl border border-primary/10 bg-white p-4">
							<div class="mb-4 flex items-center justify-between">
								<h3 class="text-lg font-bold text-primary">Detail Item</h3>
								<span class="text-sm font-semibold text-secondary/50" data-receipt-itemcount>0 item</span>
							</div>
							<div class="space-y-3" data-receipt-items></div>
						</div>
					</div>
				</section>

				<aside class="rounded-xl border border-primary/10 bg-white p-6">
					<div class="mb-4 flex items-center justify-between">
						<h2 class="text-lg font-bold text-primary">Ringkasan Receipt</h2>
						<span class="px-3 py-1 text-xs font-bold text-secondary/60" data-receipt-itemcount-side>0 item</span>
					</div>

					<div class="mt-5 space-y-4">
						<div class="rounded-lg border border-primary/10 bg-white p-4">
							<div class="flex items-center justify-between text-sm font-semibold text-secondary/60">
								<span>Total</span>
								<span class="text-lg font-extrabold text-primary" data-receipt-total>Rp 0</span>
							</div>
							<div class="mt-2 flex items-center justify-between text-sm font-semibold text-secondary/60">
								<span>Dibayar</span>
								<span class="font-bold text-primary" data-receipt-paid>Rp 0</span>
							</div>
							<div class="mt-2 flex items-center justify-between text-sm font-semibold text-secondary/60">
								<span>Kembalian</span>
								<span class="font-bold text-primary" data-receipt-change>Rp 0</span>
							</div>
						</div>

						<div class="flex flex-wrap gap-3 pt-1">
							<button type="button" id="print-receipt" class="rounded-lg bg-primary px-6 py-3 text-sm font-bold text-white transition hover:bg-secondary">
								Cetak Receipt
							</button>
							<a href="{{ route('kasir.order') }}" class="rounded-lg border border-primary/10 bg-white px-6 py-3 text-sm font-bold text-primary transition hover:bg-primary/10">
								Back to Order
							</a>
						</div>
					</div>
				</aside>
			</div>
		</div>
	</div>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const receipt = JSON.parse(localStorage.getItem('kasir-last-receipt') || 'null');
			const emptyState    = document.getElementById('receipt-empty');
			const contentState  = document.getElementById('receipt-content');
			const printButton   = document.getElementById('print-receipt');

			// Web UI elements
			const receiptNumber        = document.querySelector('[data-receipt-number]');
			const receiptDate          = document.querySelector('[data-receipt-date]');
			const receiptMethod        = document.querySelector('[data-receipt-method]');
			const receiptPaymentStatus = document.querySelector('[data-receipt-payment-status]');
			const receiptItemCount     = document.querySelector('[data-receipt-itemcount]');
			const receiptItemCountSide = document.querySelector('[data-receipt-itemcount-side]');
			const receiptTotal         = document.querySelector('[data-receipt-total]');
			const receiptPaid          = document.querySelector('[data-receipt-paid]');
			const receiptChange        = document.querySelector('[data-receipt-change]');
			const receiptItems         = document.querySelector('[data-receipt-items]');

			// Print area elements
			const printNumber      = document.querySelector('[data-print-number]');
			const printDate        = document.querySelector('[data-print-date]');
			const printFooterDate  = document.querySelector('[data-print-footer-date]');
			const printMethod      = document.querySelector('[data-print-method]');
			const printMethodLabel = document.querySelector('[data-print-method-label]');
			const printItems       = document.querySelector('[data-print-items]');
			const printItemCount   = document.querySelector('[data-print-itemcount]');
			const printSubtotal    = document.querySelector('[data-print-subtotal]');
			const printTotal       = document.querySelector('[data-print-total]');
			const printPaid        = document.querySelector('[data-print-paid]');
			const printPaid2       = document.querySelector('[data-print-paid2]');
			const printChange      = document.querySelector('[data-print-change]');

			const formatCurrency = (v) => `Rp ${new Intl.NumberFormat('id-ID').format(v)}`;
			const formatNumber   = (v) => new Intl.NumberFormat('id-ID').format(v);

			// Kosong
			if (!receipt || !receipt.items || receipt.items.length === 0) {
				emptyState.classList.remove('hidden');
				contentState.classList.add('hidden');
				return;
			}

			// Receipt Number
			receiptNumber.textContent = receipt.id || '-';
			if (printNumber) printNumber.textContent = receipt.id || '-';

			// Tanggal
			const dateObj   = new Date(receipt.created_at || Date.now());
			const dateShort = dateObj.toLocaleString('id-ID', { dateStyle: 'short', timeStyle: 'short' });
			const dateMedium = dateObj.toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' });
			receiptDate.textContent = dateMedium;
			if (printDate)       printDate.textContent      = dateShort;
			if (printFooterDate) printFooterDate.textContent = dateShort;

			// Metode
			const isCash    = receipt.payment_method === 'cash';
			const methodStr = isCash ? 'Cash' : 'QRIS';
			receiptMethod.textContent = methodStr;
			if (printMethod)      printMethod.textContent      = methodStr;
			if (printMethodLabel) printMethodLabel.textContent = isCash ? 'Tunai' : 'QRIS';

			// Status
			receiptPaymentStatus.textContent = 'Paid';

			// Item count
			const totalItems = receipt.totalItems || 0;
			receiptItemCount.textContent     = `${totalItems} item`;
			if (receiptItemCountSide) receiptItemCountSide.textContent = `${totalItems} item`;
			if (printItemCount)       printItemCount.textContent        = totalItems;

			// Harga
			const total  = receipt.totalPrice   || 0;
			const paid   = receipt.paid_amount  || 0;
			const change = receipt.change_amount || 0;

			receiptTotal.textContent  = formatCurrency(total);
			receiptPaid.textContent   = formatCurrency(paid);
			receiptChange.textContent = formatCurrency(change);

			if (printSubtotal) printSubtotal.textContent = formatNumber(total);
			if (printTotal)    printTotal.textContent    = formatNumber(total);
			if (printPaid)     printPaid.textContent     = formatNumber(paid);
			if (printPaid2)    printPaid2.textContent    = formatNumber(paid);
			if (printChange)   printChange.textContent   = formatNumber(change);

			// Item list — Web UI
			receiptItems.innerHTML = receipt.items.map((item) => `
				<div class="flex items-center justify-between rounded-2xl border border-primary/10 bg-white p-4">
					<div class="min-w-0 pr-4">
						<p class="truncate font-bold text-primary">${item.name}</p>
						<p class="text-xs text-secondary/50">${item.quantity} x ${formatCurrency(item.price)}</p>
					</div>
					<p class="shrink-0 font-extrabold text-accent">${formatCurrency(item.subtotal)}</p>
				</div>
			`).join('');

			// Item list — Print Area
			if (printItems) {
				printItems.innerHTML = receipt.items.map((item) => `
					<div style="margin-bottom: 4px;">
						<div style="font-weight: 600;">${item.quantity} ${item.name}</div>
						<div style="display: flex; justify-content: space-between;">
							<span style="margin-left: 8px;">${formatNumber(item.price)}</span>
							<span>${formatNumber(item.subtotal)}</span>
						</div>
					</div>
				`).join('');
			}

			// Tombol cetak
			printButton?.addEventListener('click', function () {
				window.print();
			});
		});
	</script>

	{{-- ============================================================ --}}
	{{-- STYLE PRINT                                                  --}}
	{{-- ============================================================ --}}
	<style>
		@media print {
			@page {
				size: 80mm auto;   /* lebar thermal 80mm, tinggi otomatis */
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
		}
	</style>

</x-app-layout>