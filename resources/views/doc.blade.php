<x-app-layout :title="'Dokumentasi Library Cafe'">
	<div class="min-h-screen bg-primary font-sans text-white selection:bg-accent selection:text-primary">
        <x-navbar/>
		<main>
			<section class="relative overflow-hidden min-h-screen flex items-center justify-center py-20 lg:py-28">
				<img src="{{ asset('img/bg-hero-1.webp') }}" alt="Library Background"
					class="absolute inset-0 h-full w-full object-cover object-bottom z-0">
				<div class="absolute inset-0 bg-secondary/100 mix-blend-multiply z-0"></div>

				<div class="relative z-10 mx-auto max-w-7xl px-5 sm:px-8 lg:px-12 pt-20">
					<div class="grid items-center gap-20 lg:grid-cols-2 lg:gap-12 pl-2">
						<div class="max-w-2xl">
							<h1 class="mt-4 text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl lg:text-[3.5rem]">
								Panduan penggunaan Library Cafe POS untuk user dan pengelola.
							</h1>

							<p class="mt-6 text-lg font-medium text-white/90 sm:text-xl">
								Halaman ini menjelaskan cara masuk, cara memakai fitur utama, dan alur dasar penggunaan sistem agar mudah dipahami oleh pengguna baru.
							</p>
						</div>
					</div>
				</div>
			</section>

			{{-- <section class="relative py-24 bg-primary overflow-hidden">
				<div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-accent/10 blur-[120px]"></div>

				<div class="relative mx-auto max-w-7xl px-5 text-center">
					<h2 class="text-3xl font-extrabold sm:text-4xl text-white">
						Panduan inti untuk user baru
					</h2>
					<p class="mt-4 text-white/60 max-w-2xl mx-auto">
						Dokumentasi ini dibuat supaya user bisa memahami alur penggunaan tanpa harus melihat semua detail teknis di landing page.
					</p>

					<div class="mt-16 grid gap-8 lg:grid-cols-3">
						<div class="group rounded-2xl bg-white/5 backdrop-blur-md border border-white/10 p-6 text-left transition duration-300 hover:bg-white/10 hover:shadow-xl hover:-translate-y-1">
							<div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-accent/20 text-accent text-lg">
								<i class="fa-solid fa-circle-play"></i>
							</div>
							<h3 class="text-lg font-bold text-white">1. Cara Masuk</h3>
							<p class="mt-2 text-sm text-white/60 leading-7">
								Buka halaman akses, pilih metode login yang sesuai, lalu masukkan akun yang sudah didistribusikan oleh pengelola.
							</p>
						</div>

						<div class="group rounded-2xl bg-white/5 backdrop-blur-md border border-white/10 p-6 text-left transition duration-300 hover:bg-white/10 hover:shadow-xl hover:-translate-y-1">
							<div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-accent/20 text-accent text-lg">
								<i class="fa-solid fa-basket-shopping"></i>
							</div>
							<h3 class="text-lg font-bold text-white">2. Cara Pakai Harian</h3>
							<p class="mt-2 text-sm text-white/60 leading-7">
								Gunakan menu order/kasir untuk transaksi, cek stok saat input barang, lalu lihat histori untuk meninjau aktivitas sebelumnya.
							</p>
						</div>

						<div class="group rounded-2xl bg-white/5 backdrop-blur-md border border-white/10 p-6 text-left transition duration-300 hover:bg-white/10 hover:shadow-xl hover:-translate-y-1">
							<div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-accent/20 text-accent text-lg">
								<i class="fa-solid fa-shield-halved"></i>
							</div>
							<h3 class="text-lg font-bold text-white">3. Akses per Role</h3>
							<p class="mt-2 text-sm text-white/60 leading-7">
								Kasir fokus transaksi, admin mengelola data, dan pimpinan memantau laporan. Hak akses dibatasi agar data tetap aman.
							</p>
						</div>
					</div>
				</div>
			</section> --}}

			<section class="border-t border-white/10 bg-primary py-20">
				<div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">
					<div class="rounded-3xl border border-white/10 bg-white/5 px-6 py-10 text-center backdrop-blur-md sm:px-10 lg:px-14">
						<h2 class="mt-4 text-3xl font-extrabold sm:text-4xl text-white">
							Dokumentasi soon.
						</h2>
					</div>
				</div>
			</section>
		</main>
	</div>
    <x-footer/>
    

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const navbar = document.getElementById('main-navbar');
			if (!navbar) {
				return;
			}

			const updateNavbarState = () => {
				if (window.scrollY > 24) {
					navbar.classList.remove('bg-transparent', 'border-transparent');
					navbar.classList.add('bg-slate-900/70', 'border-white/10', 'backdrop-blur-md', 'shadow-lg');
				} else {
					navbar.classList.remove('bg-slate-900/70', 'border-white/10', 'backdrop-blur-md', 'shadow-lg');
					navbar.classList.add('bg-transparent', 'border-transparent');
				}
			};

			updateNavbarState();
			window.addEventListener('scroll', updateNavbarState, {
				passive: true
			});
		});
	</script>
</x-app-layout>