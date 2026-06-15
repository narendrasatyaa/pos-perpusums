<x-app-layout :title="'Split Bill'">
	<div class="flex flex-col h-screen bg-slate-50 font-sans selection:bg-accent selection:text-primary">
		<x-sidebar />

		<main class="flex-1 flex flex-col overflow-hidden">
				<section class="flex-1 overflow-y-auto p-6 custom-scrollbar">
					<div class="flex items-center justify-between gap-4 mb-6">
						<h1 class="text-2xl font-black text-primary">Split Bill</h1>
						<a href="{{ route('kasir.order') }}"
							class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-primary hover:bg-slate-100 transition-colors">
							<i class="fa-solid fa-arrow-left"></i>
							Kembali ke Order
						</a>
					</div>
					<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
						<div class="xl:col-span-2 space-y-4">
							<div class="border-b border-slate-200 bg-white px-5 py-4">
								<div class="flex flex-wrap items-end gap-4">
								<div>
									<label for="split-people" class="block text-sm font-bold text-primary">Jumlah Orang</label>
									<p class="text-xs text-secondary/60 mt-1">Atur jumlah orang untuk membagi item.</p>
								</div>

								<div class="inline-flex items-center border border-slate-200 bg-slate-50 px-2 py-2">
									<button type="button" id="decrease-people"
										class="h-8 w-8 bg-white text-primary hover:bg-slate-100 transition-colors">
										<i class="fa-solid fa-minus text-xs"></i>
									</button>
									<input id="split-people" type="number" min="2" max="10" value="2"
										class="w-16 border-0 bg-transparent text-center text-lg font-black text-primary focus:ring-0">
									<button type="button" id="increase-people"
										class="h-8 w-8 bg-primary text-white hover:bg-secondary transition-colors">
										<i class="fa-solid fa-plus text-xs"></i>
									</button>
								</div>
								</div>
							</div>

							<div class="border border-slate-200 bg-white">
								<div class="flex items-center justify-between gap-4 border-b border-slate-200 px-5 py-4">
								<div>
									<h2 class="text-lg font-black text-primary">Pembagian Item</h2>
									<p class="text-xs text-secondary/60 mt-1">Total qty per baris harus sama dengan qty item.</p>
								</div>
								<button type="button" id="reset-allocation"
									class="inline-flex items-center border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-primary hover:bg-slate-100 transition-colors">
									Reset Otomatis
								</button>
								</div>

								<div class="px-5 py-4">
									<div id="split-table-wrap" class="overflow-x-auto custom-scrollbar"></div>
									<p id="split-warning" class="mt-3 text-xs font-semibold text-red-500 hidden"></p>
								</div>
						</div>
					</div>

					<aside class="space-y-4">
						<div class="border border-slate-200 bg-white">
							<div class="border-b border-slate-200 px-5 py-4">
								<h2 class="text-lg font-black text-primary">Ringkasan per Orang</h2>
							</div>
							<div id="summary-cards" class="divide-y divide-slate-200"></div>
						</div>

						<div class="border border-slate-200 bg-white px-5 py-4 space-y-4">
							<div class="flex items-center justify-between text-sm">
								<span class="font-semibold text-secondary/70">Total Bill</span>
								<span id="grand-total" class="text-xl font-black text-primary">Rp 0</span>
							</div>
							<div class="grid grid-cols-1 gap-3">
								<button id="proceed-payment" type="button"
									class="inline-flex items-center justify-center bg-primary px-4 py-3 text-sm font-black text-white transition-colors hover:bg-secondary">
									Lanjut ke Pembayaran
								</button>
							</div>
						</div>
					</aside>
				</div>
			</section>
		</main>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const splitKey = 'kasir-split-checkout';
			const fallbackKey = 'kasir-active-checkout';
			const splitTableWrap = document.getElementById('split-table-wrap');
			const summaryCards = document.getElementById('summary-cards');
			const grandTotalEl = document.getElementById('grand-total');
			const splitWarning = document.getElementById('split-warning');
			const peopleInput = document.getElementById('split-people');
			const decreasePeople = document.getElementById('decrease-people');
			const increasePeople = document.getElementById('increase-people');
			const resetAllocationBtn = document.getElementById('reset-allocation');
			const proceedPaymentBtn = document.getElementById('proceed-payment');

			const checkout = JSON.parse(localStorage.getItem(splitKey) || localStorage.getItem(fallbackKey) || 'null');
			const items = Array.isArray(checkout?.items) ? checkout.items : [];
			let peopleCount = 2;
			let allocation = {};

			const clampPeople = (value) => Math.min(10, Math.max(2, Number(value) || 2));
			const formatCurrency = (value) => `Rp ${new Intl.NumberFormat('id-ID').format(value || 0)}`;

			const buildEqualAllocation = () => {
				allocation = {};

				items.forEach((item) => {
					const qty = Number(item.quantity || 0);
					const base = Math.floor(qty / peopleCount);
					let rem = qty % peopleCount;

					allocation[item.id] = Array.from({
						length: peopleCount
					}, () => {
						const value = base + (rem > 0 ? 1 : 0);
						if (rem > 0) {
							rem -= 1;
						}
						return value;
					});
				});
			};

			const getItemSum = (itemId) => {
				return (allocation[itemId] || []).reduce((sum, qty) => sum + Number(qty || 0), 0);
			};

			const isAllocationValid = () => {
				return items.every((item) => getItemSum(item.id) === Number(item.quantity || 0));
			};

			const renderSummary = () => {
				const personTotals = Array.from({
					length: peopleCount
				}, () => 0);

				items.forEach((item) => {
					const prices = Number(item.price || 0);
					(allocation[item.id] || []).forEach((qty, idx) => {
						personTotals[idx] += Number(qty || 0) * prices;
					});
				});

				summaryCards.innerHTML = personTotals.map((total, idx) => `
					<div class="flex items-center justify-between gap-3 px-5 py-4">
						<p class="text-sm font-bold text-primary">Orang ${idx + 1}</p>
						<p class="text-base font-black text-primary">${formatCurrency(total)}</p>
					</div>
				`).join('');

				grandTotalEl.textContent = formatCurrency(personTotals.reduce((sum, value) => sum + value, 0));
			};

			const renderTable = () => {
				if (items.length === 0) {
					splitTableWrap.innerHTML = `
						<div class="h-44 flex flex-col items-center justify-center border border-dashed border-slate-200 bg-slate-50 text-secondary/40">
							<i class="fa-solid fa-cart-shopping text-3xl"></i>
							<p class="mt-3 text-sm font-semibold">Belum ada item untuk split bill</p>
						</div>
					`;
					summaryCards.innerHTML = '';
					grandTotalEl.textContent = formatCurrency(0);
					if (proceedPaymentBtn) {
						proceedPaymentBtn.disabled = true;
						proceedPaymentBtn.classList.add('opacity-50', 'cursor-not-allowed');
					}
					return;
				}

				const headCols = Array.from({
					length: peopleCount
				}, (_, idx) => `<th class="px-3 py-2 text-right font-bold text-primary whitespace-nowrap">Orang ${idx + 1}</th>`).join('');

				const rows = items.map((item) => {
					const assigned = getItemSum(item.id);
					const expected = Number(item.quantity || 0);
					const mismatchClass = assigned === expected ? 'text-secondary/50' : 'text-red-500';

					const qtyInputs = Array.from({
						length: peopleCount
					}, (_, idx) => {
						const val = allocation[item.id]?.[idx] ?? 0;
						return `
							<td class="px-2 py-2 text-right">
								<input
									type="number"
									min="0"
									max="${expected}"
									value="${val}"
									data-item-id="${item.id}"
									data-person-index="${idx}"
										class="split-qty-input w-16 border border-slate-200 bg-white px-2 py-1 text-right text-sm font-bold text-primary focus:border-accent focus:ring-accent"
								>
							</td>
						`;
					}).join('');

					return `
							<tr class="border-t border-slate-100">
							<td class="px-3 py-3 min-w-[220px]">
								<p class="text-sm font-black text-primary">${item.name}</p>
								<p class="text-xs text-secondary/60 mt-1">${formatCurrency(item.price)} x ${expected}</p>
								<p class="text-xs ${mismatchClass} mt-1">Assigned: ${assigned}/${expected}</p>
							</td>
							${qtyInputs}
						</tr>
					`;
				}).join('');

						splitTableWrap.innerHTML = `
						<table class="w-full border border-slate-200 overflow-hidden">
						<thead class="bg-slate-50">
							<tr>
								<th class="px-3 py-2 text-left text-xs font-black uppercase tracking-wide text-secondary/60">Item</th>
								${headCols}
							</tr>
						</thead>
						<tbody>
							${rows}
						</tbody>
					</table>
				`;

				renderSummary();

				const valid = isAllocationValid();
				if (valid) {
					splitWarning.textContent = '';
					splitWarning.classList.add('hidden');
				} else {
					splitWarning.textContent = 'Masih ada item yang total pembagiannya belum sama dengan qty item.';
					splitWarning.classList.remove('hidden');
				}
			};

			const updatePeopleCount = (nextValue) => {
				peopleCount = clampPeople(nextValue);
				peopleInput.value = peopleCount;
				buildEqualAllocation();
				renderTable();
			};

			if (items.length === 0) {
				renderTable();
				return;
			}

			peopleInput.addEventListener('change', function() {
				updatePeopleCount(this.value);
			});

			decreasePeople.addEventListener('click', function() {
				updatePeopleCount(peopleCount - 1);
			});

			increasePeople.addEventListener('click', function() {
				updatePeopleCount(peopleCount + 1);
			});

			resetAllocationBtn.addEventListener('click', function() {
				buildEqualAllocation();
				renderTable();
			});

			splitTableWrap.addEventListener('input', function(event) {
				const target = event.target;
				if (!target.classList.contains('split-qty-input')) {
					return;
				}

				const itemId = target.dataset.itemId;
				const personIndex = Number(target.dataset.personIndex || 0);
				const item = items.find((row) => String(row.id) === String(itemId));

				if (!item || !allocation[itemId]) {
					return;
				}

				const parsed = Math.max(0, Number(target.value || 0));
				const nextValue = Math.min(Number(item.quantity || 0), Math.floor(parsed));
				allocation[itemId][personIndex] = nextValue;
				renderTable();
			});

			proceedPaymentBtn.addEventListener('click', function() {
				if (!isAllocationValid()) {
					splitWarning.textContent = 'Perbaiki pembagian item dulu sebelum lanjut pembayaran.';
					splitWarning.classList.remove('hidden');
					return;
				}

				const splitPeople = Array.from({
					length: peopleCount
				}, (_, idx) => ({
					personLabel: `Orang ${idx + 1}`,
					items: items
					.map((item) => {
						const qty = Number(allocation[item.id]?.[idx] || 0);
						if (qty <= 0) {
							return null;
						}
						const price = Number(item.price || 0);
						return {
							id: item.id,
							name: item.name,
							quantity: qty,
							price,
							subtotal: qty * price,
						};
					})
					.filter(Boolean),
				})).map((person) => ({
					...person,
					total: person.items.reduce((sum, item) => sum + Number(item.subtotal || 0), 0),
				}));

				const payload = {
					id: checkout?.id || `order-${Date.now()}`,
					status: 'pending_payment',
					created_at: checkout?.created_at || new Date().toISOString(),
					items,
					totalItems: items.reduce((sum, item) => sum + Number(item.quantity || 0), 0),
					totalPrice: items.reduce((sum, item) => sum + (Number(item.quantity || 0) * Number(item.price || 0)), 0),
					splitBill: {
						peopleCount,
						people: splitPeople,
					},
				};

				localStorage.setItem('kasir-active-checkout', JSON.stringify(payload));
				localStorage.removeItem(splitKey);
				window.location.href = "{{ route('kasir.payment') }}";
			});

			buildEqualAllocation();
			renderTable();
		});
	</script>
</x-app-layout>
