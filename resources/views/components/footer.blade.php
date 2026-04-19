
        <footer class="bg-accent text-primary">
            <div class="mx-auto max-w-7xl px-5 py-14 sm:px-8 lg:px-12">
                <div class="grid gap-10 text-left sm:grid-cols-2 lg:grid-cols-3">
                    <div class="lg:col-span-1">
                        <img src="{{ asset('img/logo-perpus-putih.webp') }}" alt="Logo Library Cafe" class="w-full h-auto">
                        <p class="mt-4 max-w-xs text-sm leading-7 text-primary">
                            Sistem POS internal yang mendukung operasional kafe perpustakaan secara cepat, terorganisir, dan transparan.
                        </p>
                    </div>

                    {{-- <div>
                        <h4 class="text-sm font-bold uppercase tracking-[0.18em] text-white">Navigasi</h4>
                        <ul class="mt-4 space-y-3 text-sm">
                            <li><a href="{{ route('home') }}" class="transition hover:text-accent">Beranda</a></li>
                            <li><a href="#fitur" class="transition hover:text-accent">Fitur</a></li>
                            <li><a href="{{ route('access') }}" class="transition hover:text-accent">Akses Sistem</a>
                            </li>
                        </ul>
                    </div> --}}

                    {{-- <div>
                        <h4 class="text-sm font-bold uppercase tracking-[0.18em] text-white">Produk</h4>
                        <ul class="mt-4 space-y-3 text-sm">
                            <li><span class="text-white/70">POS Kasir</span></li>
                            <li><span class="text-white/70">Laporan Harian</span></li>
                            <li><span class="text-white/70">Manajemen Inventori</span></li>
                        </ul>
                    </div> --}}

                    <div>
                        <h4 class="text-sm font-bold uppercase tracking-[0.18em] text-primary">Jam Buka</h4>
                        <ul class="mt-4 space-y-3 text-sm">
                            <li><span class="text-primary"> Senin - Jumat: 08:00 - 20:00</span></li>
                            <li><span class="text-primary">Sabtu: 08:00 - 16:00</span></li>
                            <li><span class="text-primary">Tutup Sholat & Istirahat (12.00 - 13.00 WIB)</span></li>
                         <li><span class="text-primary">Jumat (11.00 - 13.00 WIB)</span></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-sm font-bold uppercase tracking-[0.18em] text-primary">Kontak</h4>
                        <ul class="mt-4 space-y-3 text-sm">
                            <li class="flex items-center gap-2">
                                <i class="fa-regular fa-envelope text-primary"></i>
                                {{-- <span>librarycafe@ums.ac.id</span> --}}
                                <a href="mailto:perpus@ums.ac.id" class="transition hover:text-primary">perpus@ums.ac.id</a>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fa-solid fa-phone text-primary"></i>
                                {{-- <span>+62 851-9005-2577</span> --}}
                                <a href="wa.me/+6285190052577" class="transition hover:text-primary">+62 851-9005-2577</a>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fa-solid fa-location-dot text-primary"></i>
                                <span>Jl. A. Yani Tromol Pos I Pabelan Surakarta 57102.
                                    Telepon 0271-717417 est. 3206 & 3249</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-12 bg-tertiary border-t border-white/30 pt-6 text-center text-sm text-secondary">
                    {{-- ©{{ date('Y') }} Library Cafe UPT Perpustakaan & Layanan Digital UM Surakarta. All rights reserved. --}}
                    ©{{ date('Y') }}  All rights reserved by UMS Library and Digital Services Center
                </div>
            </div>
        </footer>
