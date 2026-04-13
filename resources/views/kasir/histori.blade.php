<x-app-layout :title="'Histori Transaksi'">
    <div class="flex h-screen bg-[#f4f7fe] font-sans selection:bg-accent selection:text-primary">
        <x-sidebar />
        <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <header
                class="bg-white h-24 px-10 flex items-center justify-between shadow-sm z-10 rounded-b-3xl mx-4 mt-4 border border-[#eef2f9] flex-shrink-0">
                <div class="flex items-center space-x-12">
                    <h1 class="font-bold text-lg" style="padding-right: 1rem;">History Order</h1>
                    @foreach ($headerLinks ?? [] as $link)
                        <a href="{{ $link->url ?? '#' }}"
                            class="text-secondary/60 hover:text-primary font-bold text-sm transition-colors">
                            {{ $link->name ?? 'Link' }}
                        </a>
                    @endforeach
                </div>

                <div class="flex items-center space-x-6">
                    <button
                        class="w-10 h-10 rounded-full bg-[#f4f7fe] text-secondary hover:text-primary flex items-center justify-center transition-colors relative">
                        <i class="fa-solid fa-bell"></i>
                        <span
                            class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    {{-- <div class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden border-2 border-white shadow-sm">
                        <img src="{{ auth()->user()->avatar_url ?? asset('img/avatar-default.png') }}"
                            onerror="this.src='https://ui-avatars.com/api/?name=User&background=ecc25c&color=fff'"
                            alt="User" class="w-full h-full object-cover">
                    </div> --}}
                </div>
            </header>
</x-app-layout>
