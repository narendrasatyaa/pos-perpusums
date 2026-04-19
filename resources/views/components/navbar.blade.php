 <header id="main-navbar"
     class="fixed inset-x-0 top-0 z-30 border-b border-transparent bg-transparent text-accent transition-all duration-300">
     <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-5 sm:px-8 lg:px-12">
         <a href="{{ route('home') }}" class="flex items-center gap-3">
             <img src="{{ asset('img/logo-perpus-putih.webp') }}" alt="Logo UMS Library" class="h-11 w-auto">
         </a>

         <nav class="hidden items-center gap-8 text-sm font-semibold lg:flex">
             <a href="{{ route('home') }}" class="text-accent transition hover:text-white">Home</a>
             <a href="{{ route('home') }}#fitur" class="transition hover:text-white">Features</a>
             <a href="{{ route('doc') }}" class="transition hover:text-white">Documentation</a>
         </nav>

         {{-- <div class="flex items-center gap-3">
                    <a href="{{ route('access') }}"
                        class="inline-flex items-center rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        <i class="fa-solid fa-arrow-right-to-bracket mr-2 text-xs"></i>
                        Login
                    </a>
                    <a href="{{ route('access') }}"
                        class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-blue-700">
                        Get Started
                    </a>
                </div> --}}
     </div>
 </header>
