<x-filament-panels::page>
    @php
        $data = $this->getCashFlowData();
    @endphp

    {{-- Filter Periode - Native Filament Card with Inline Flex Layout --}}
    <x-filament::section heading="Filter Periode Laporan" description="Pilih rentang tanggal untuk memfilter grafik dan rincian arus kas">
        <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 20px; margin-top: 10px;">
            <div style="display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
                <span style="font-size: 12px; font-weight: 600; color: #888; text-transform: uppercase; tracking-wider: 0.05em; width: 40px;">Dari</span>
                <x-filament::input.wrapper style="width: 160px;">
                    <x-filament::input 
                        type="date" 
                        wire:model.live="from" 
                        style="font-size: 13px; padding-top: 6px; padding-bottom: 6px;"
                    />
                </x-filament::input.wrapper>
            </div>
            
            <div style="display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
                <span style="font-size: 12px; font-weight: 600; color: #888; text-transform: uppercase; tracking-wider: 0.05em; width: 40px;">Sampai</span>
                <x-filament::input.wrapper style="width: 160px;">
                    <x-filament::input 
                        type="date" 
                        wire:model.live="until" 
                        style="font-size: 13px; padding-top: 6px; padding-bottom: 6px;"
                    />
                </x-filament::input.wrapper>
            </div>
        </div>
    </x-filament::section>

    {{-- Detail Breakdown Visual (Progress Bars) using Inline CSS Grid --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px;">
        
        {{-- Progress Pengeluaran --}}
        <x-filament::section heading="Breakdown Pengeluaran" description="Distribusi pengeluaran kas kafe berdasarkan kategori">
            
            {{-- Summary Total Banner --}}
            <div style="display: flex; align-items: center; justify-content: space-between; background-color: rgba(244, 63, 94, 0.05); border: 1px solid rgba(244, 63, 94, 0.15); padding: 10px 14px; border-radius: 8px; margin-bottom: 20px; margin-top: 5px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 13px; font-weight: 600; color: #f43f5e;">Total Pengeluaran Kafe</span>
                </div>
                <span style="font-size: 15px; font-weight: 800; color: #f43f5e;">
                    Rp {{ number_format($data['total_expense'], 0, ',', '.') }}
                </span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 18px;">
                @php
                    $totalExp = $data['total_expense'] ?: 1;
                    $labelsOut = [
                        'bahan_baku' => ['label' => 'Bahan Baku', 'color' => '#f43f5e', 'icon' => 'heroicon-m-shopping-cart'],
                        'gaji' => ['label' => 'Gaji Karyawan', 'color' => '#f59e0b', 'icon' => 'heroicon-m-identification'],
                        'operasional' => ['label' => 'Operasional Kafe', 'color' => '#6366f1', 'icon' => 'heroicon-m-cog-6-tooth'],
                        'lain_lain' => ['label' => 'Lain-lain', 'color' => '#6b7280', 'icon' => 'heroicon-m-ellipsis-horizontal'],
                    ];
                @endphp
                @foreach ($data['expenses_by_category'] as $cat => $val)
                     @php
                        $percent = ($val / $totalExp) * 100;
                        $catMeta = $labelsOut[$cat] ?? ['label' => $cat, 'color' => '#f43f5e', 'icon' => 'heroicon-m-exclamation-triangle'];
                    @endphp
                    <div>
                        <div style="display: flex; align-items: center; justify-content: space-between; font-size: 13px; margin-bottom: 6px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <x-filament::icon icon="{{ $catMeta['icon'] }}" style="width: 14px; height: 14px; color: #888;" />
                                <span style="font-weight: 500; color: #4b5563;">{{ $catMeta['label'] }}</span>
                            </div>
                            <span style="font-weight: 700; color: #111827;">
                                Rp {{ number_format($val, 0, ',', '.') }} 
                                <span style="font-size: 11px; font-weight: 400; color: #6b7280; margin-left: 4px;">({{ number_format($percent, 1) }}%)</span>
                            </span>
                        </div>
                        <div style="height: 6px; width: 100%; background-color: rgba(107, 114, 128, 0.1); border-radius: 9999px; overflow: hidden;">
                            <div style="height: 100%; background-color: {{ $catMeta['color'] }}; border-radius: 9999px; width: {{ $percent }}%; transition: width 0.5s ease-in-out;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-filament::section>

        {{-- Progress Pemasukan --}}
        <x-filament::section heading="Sumber Pemasukan" description="Kontribusi pemasukan kas kafe berdasarkan kategori">
            
            {{-- Summary Total Banner --}}
            <div style="display: flex; align-items: center; justify-content: space-between; background-color: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.15); padding: 10px 14px; border-radius: 8px; margin-bottom: 20px; margin-top: 5px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 13px; font-weight: 600; color: #10b981;">Total Pemasukan Kafe</span>
                </div>
                <span style="font-size: 15px; font-weight: 800; color: #10b981;">
                    Rp {{ number_format($data['total_income'], 0, ',', '.') }}
                </span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 18px;">
                @php
                    $totalInc = $data['total_income'] ?: 1;
                    $posPercent = ($data['total_sales'] / $totalInc) * 100;
                    $labelsIn = [
                        'modal' => ['label' => 'Suntikan Modal', 'color' => '#06b6d4', 'icon' => 'heroicon-m-credit-card'],
                        'sewa' => ['label' => 'Sewa / Event Space', 'color' => '#8b5cf6', 'icon' => 'heroicon-m-home'],
                        'lain_lain' => ['label' => 'Pemasukan Lain-lain', 'color' => '#14b8a6', 'icon' => 'heroicon-m-plus-circle'],
                    ];
                @endphp
                
                {{-- POS Sales --}}
                <div>
                    <div style="display: flex; align-items: center; justify-content: space-between; font-size: 13px; margin-bottom: 6px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <x-filament::icon icon="heroicon-m-building-storefront" style="width: 14px; height: 14px; color: #10b981;" />
                            <span style="font-weight: 500; color: #4b5563;">Penjualan POS (Kasir)</span>
                        </div>
                        <span style="font-weight: 700; color: #111827;">
                            Rp {{ number_format($data['total_sales'], 0, ',', '.') }} 
                            <span style="font-size: 11px; font-weight: 400; color: #6b7280; margin-left: 4px;">({{ number_format($posPercent, 1) }}%)</span>
                        </span>
                    </div>
                    <div style="height: 6px; width: 100%; background-color: rgba(107, 114, 128, 0.1); border-radius: 9999px; overflow: hidden;">
                        <div style="height: 100%; background-color: #10b981; border-radius: 9999px; width: {{ $posPercent }}%; transition: width 0.5s ease-in-out;"></div>
                    </div>
                </div>

                {{-- Cash In categories --}}
                @foreach ($data['incomes_by_category'] as $cat => $val)
                     @php
                        $percent = ($val / $totalInc) * 100;
                        $catMeta = $labelsIn[$cat] ?? ['label' => $cat, 'color' => '#10b981', 'icon' => 'heroicon-m-exclamation-triangle'];
                    @endphp
                    <div>
                        <div style="display: flex; align-items: center; justify-content: space-between; font-size: 13px; margin-bottom: 6px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <x-filament::icon icon="{{ $catMeta['icon'] }}" style="width: 14px; height: 14px; color: #888;" />
                                <span style="font-weight: 500; color: #4b5563;">{{ $catMeta['label'] }}</span>
                            </div>
                            <span style="font-weight: 700; color: #111827;">
                                Rp {{ number_format($val, 0, ',', '.') }} 
                                <span style="font-size: 11px; font-weight: 400; color: #6b7280; margin-left: 4px;">({{ number_format($percent, 1) }}%)</span>
                            </span>
                        </div>
                        <div style="height: 6px; width: 100%; background-color: rgba(107, 114, 128, 0.1); border-radius: 9999px; overflow: hidden;">
                            <div style="height: 100%; background-color: {{ $catMeta['color'] }}; border-radius: 9999px; width: {{ $percent }}%; transition: width 0.5s ease-in-out;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-filament::section>

    </div>
</x-filament-panels::page>
