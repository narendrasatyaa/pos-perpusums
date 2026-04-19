<x-app-layout :title="'Histori Transaksi'">
    <div class="flex h-screen bg-[#f4f7fe] font-sans selection:bg-accent selection:text-primary">
        <x-sidebar />
        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            <header
                class="bg-white/80 backdrop-blur-md h-20 px-10 flex items-center justify-between shadow-sm z-20 border-b border-slate-100 flex-shrink-0 sticky top-0">

                <div class="flex items-center gap-4 justify-end w-full">
                    <div class="text-right mr-4 border-slate-200 pr-4 hidden md:block">
                        <p class="text-sm font-bold text-primary">{{ now()->translatedFormat('l, d F Y') }}</p>
                        <p class="text-xs text-secondary/60 font-medium clock-display">00:00:00 WIB</p>
                    </div>
                </div>
            </header>

            {{-- script jam --}}
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const clockEl = document.querySelector('.clock-display');
                    if (clockEl) {
                        setInterval(() => {
                            const now = new Date();
                            clockEl.textContent = now.toLocaleTimeString('id-ID', {
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit'
                            }) + ' WIB';
                        }, 1000);
                    }
                });
            </script>
        </div>
    </div>


</x-app-layout>
