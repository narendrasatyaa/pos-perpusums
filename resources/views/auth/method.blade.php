<x-app-layout :title="'Pilih Metode Login'">
    <x-navbar />
    <div class="min-h-screen flex flex-col items-center justify-center bg-slate-50 px-6 py-20 relative overflow-hidden font-sans">
            <img src="{{ asset('img/bg-hero-1.webp') }}" alt="Library Background"
                    class="absolute inset-0 h-full w-full object-cover object-bottom z-0">
                <div class="absolute inset-0 bg-secondary/100 mix-blend-multiply z-0"></div>

        <div class="relative z-10 w-full max-w-4xl mx-auto">
            <div class="text-center mb-16">
                {{-- <a href="{{ route('home') }}" class="text-accent hover:text-primary">balik home</a> --}}
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 tracking-tight">
                    Pilih Peran Anda
                </h1>
                <p class="text-white text-lg">Silakan tentukan peran login Anda untuk mengakses sistem Library Cafe.</p>
            </div>

            {{-- role --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl mx-auto">
                
                {{-- kasir --}}
                <a href="{{ route('login') }}"
                    class="group relative bg-white border-2 border-slate-100 hover:border-primary p-8 md:p-10 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full overflow-hidden">
                    
                    <div class="absolute -right-6 -top-6 text-slate-50 group-hover:text-primary/5 transition-colors duration-500">
                        <i class="fa-solid fa-cash-register text-9xl"></i>
                    </div>

                    <div class="relative z-10">
                        <div class="w-16 h-16 flex items-center justify-center rounded-xl bg-primary text-white mb-6 transition-transform duration-300">
                            <i class="fa-solid fa-cash-register text-2xl"></i>
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-2xl font-bold text-primary mb-2">Kasir</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">Akses antarmuka Point of Sale untuk memproses transaksi pesanan mahasiswa dengan cepat.</p>
                        </div>
                        <div class="mt-8 flex items-center text-sm font-bold text-accent group-hover:text-primary transition-colors">
                            Masuk sebagai Kasir <i class="fa-solid fa-arrow-right ml-2"></i>
                        </div>
                    </div>
                </a>

                {{-- admin/financea --}}
                <a href="{{ url('/admin/login') }}"
                    class="group relative bg-white border-2 border-slate-100 hover:border-secondary p-8 md:p-10 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full overflow-hidden">
                    
                    <div class="absolute -right-6 -top-6 text-slate-50 group-hover:text-secondary/5 transition-colors duration-500">
                        <i class="fa-solid fa-user-shield text-9xl"></i>
                    </div>

                    <div class="relative z-10">
                        <div class="w-16 h-16 flex items-center justify-center rounded-xl bg-secondary text-white mb-6 transition-transform duration-300">
                            <i class="fa-solid fa-user-shield text-2xl"></i>
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-2xl font-bold text-primary mb-2">Administrator/Finance</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">Kelola sistem inventaris, rekap laporan keuangan/transaksi harian dari kasir Library Cafe.</p>
                        </div>
                        <div class="mt-8 flex items-center text-sm font-bold text-info group-hover:text-secondary transition-colors">
                            Masuk sebagai Admin <i class="fa-solid fa-arrow-right ml-2"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="mt-8 flex items-center justify-center gap-4">
                <a href="{{ route('doc') }}" class="inline-flex items-center justify-center rounded-full bg-white px-6 py-3 font-bold text-primary hover:text-info transition">
                    <i class="fa-solid fa-book-open mr-2"></i> Baca Dokumentasi & Fitur
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
