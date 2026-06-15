<x-app-layout :title="'Profil Pengguna'">
    <div class="flex flex-col h-screen bg-slate-50 font-sans selection:bg-accent selection:text-primary">
        <x-sidebar />

        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white h-24 px-10 flex items-center justify-between shadow-sm z-10 rounded-b-3xl mx-4 mt-4 border border-slate-100 flex-shrink-0">
                <div class="flex flex-col space-y-1">
                    <h1 class="text-2xl font-extrabold text-primary">
                        Profil Pengguna
                    </h1>
                    <p class="text-sm text-secondary/60 font-medium">
                        Kelola informasi akun dan kata sandi Anda
                    </p>
                </div>
                <div class="flex items-center space-x-6">
                    <button class="w-10 h-10 rounded-full bg-slate-50 text-secondary hover:text-primary flex items-center justify-center transition-colors relative">
                        <i class="fa-solid fa-bell"></i>
                    </button>
                </div>
            </header>

            <div class="flex-1 overflow-auto p-8 space-y-8">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Left Column: User Info Card --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 flex flex-col items-center text-center">
                            <div class="w-32 h-32 rounded-full bg-slate-200 overflow-hidden border-4 border-white shadow-lg mb-6 relative group">
                                {{-- <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'User') . '&background=ecc25c&color=fff&size=200' }}"
                                    alt="User Avatar" class="w-full h-full object-cover"> --}}
                                    <img src="{{ asset('img/avatar-default.png') }}" alt="" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                                    <i class="fa-solid fa-camera text-white text-xl"></i>
                                </div>
                            </div>
                            
                            <h2 class="text-2xl font-extrabold text-primary mb-1">{{ auth()->user()->name ?? 'Nama Pengguna' }}</h2>
                            <p class="text-sm font-semibold text-secondary/60 mb-6">{{ auth()->user()->email ?? 'email@ums.ac.id' }}</p>
                            <div class="w-full space-y-4 border-t border-slate-100 pt-6">
                                {{-- <div class="flex justify-between items-center text-sm">
                                    <span class="text-secondary/60 font-semibold">Bergabung Pada</span>
                                    <span class="font-bold text-primary">{{ auth()->user()->created_at ? auth()->user()->created_at->format('d M Y') : '10 Sep 2025' }}</span>
                                </div> --}}
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-secondary/60 font-semibold">Status Akun</span>
                                    <span class="font-bold text-green-500">Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Detail Informasi --}}
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                            <h3 class="text-xl font-bold text-primary mb-6">Detail Informasi</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <p class="text-sm font-bold text-secondary">Nama Lengkap</p>
                                    <div class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-primary font-semibold">
                                        {{ auth()->user()->name ?? '-' }}
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-sm font-bold text-secondary">Alamat Email</p>
                                    <div class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-primary font-semibold">
                                        {{ auth()->user()->email ?? '-' }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-8 p-5 bg-blue-50 border border-blue-100 rounded-xl flex items-start gap-3">
                                <i class="fa-solid fa-circle-info text-blue-500 text-lg mt-0.5"></i>
                                <p class="text-sm text-blue-800 leading-relaxed font-medium">
                                    Informasi akun dan kata sandi dikelola secara terpusat oleh Administrator. Jika Anda perlu melakukan perubahan data, silakan hubungi Administrator sistem.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</x-app-layout>
