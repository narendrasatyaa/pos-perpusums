<x-filament-panels::page>
    <style>
        /* Container styling */
        .abcxyz-matrix-wrapper {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 8px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03);
        }
        .dark .abcxyz-matrix-wrapper {
            background-color: #18181b;
            border-color: #27272a;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3);
        }

        /* Grid layout */
        .abcxyz-grid {
            display: grid;
            grid-template-columns: 100px repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-top: 16px;
        }

        /* Header & Label cells */
        .abcxyz-header-cell {
            text-align: center;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #71717a;
            padding: 8px 4px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .dark .abcxyz-header-cell {
            color: #a1a1aa;
        }
        .abcxyz-header-sub {
            font-size: 9px;
            font-weight: 400;
            text-transform: none;
            color: #a1a1aa;
            margin-top: 2px;
            line-height: 1.25;
        }
        .dark .abcxyz-header-sub {
            color: #52525b;
        }

        .abcxyz-row-label {
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: right;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            color: #71717a;
            padding-right: 16px;
        }
        .dark .abcxyz-row-label {
            color: #a1a1aa;
        }
        .abcxyz-row-sub {
            font-size: 9px;
            font-weight: 400;
            text-transform: none;
            color: #a1a1aa;
            margin-top: 2px;
            line-height: 1.25;
        }
        .dark .abcxyz-row-sub {
            color: #52525b;
        }

        /* Matrix interactive cells */
        .abcxyz-cell {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 16px;
            border-radius: 12px;
            border: 1px solid;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            height: 108px;
            text-align: center;
        }
        .abcxyz-cell:focus {
            outline: none;
        }

        /* Cell selection states */
        .abcxyz-cell.is-selected {
            outline: 3px solid #6366f1;
            outline-offset: 2px;
            border-color: #6366f1;
            transform: scale(1.02);
            font-weight: bold;
        }
        .dark .abcxyz-cell.is-selected {
            outline-color: #818cf8;
            border-color: #818cf8;
        }

        /* Color palettes for categories (light / dark) */
        /* AX, AY, BX: Emerald/Green */
        .cell-ax, .cell-ay, .cell-bx {
            background-color: #f0fdf4;
            border-color: #bbf7d0;
            color: #166534;
        }
        .cell-ax:hover, .cell-ay:hover, .cell-bx:hover {
            background-color: #dcfce7;
        }
        .dark .cell-ax, .dark .cell-ay, .dark .cell-bx {
            background-color: rgba(6, 95, 70, 0.15);
            border-color: rgba(16, 185, 129, 0.3);
            color: #a7f3d0;
        }
        .dark .cell-ax:hover, .dark .cell-ay:hover, .dark .cell-bx:hover {
            background-color: rgba(6, 95, 70, 0.25);
        }

        /* AZ, BY: Amber/Yellow */
        .cell-az, .cell-by {
            background-color: #fffbeb;
            border-color: #fde68a;
            color: #92400e;
        }
        .cell-az:hover, .cell-by:hover {
            background-color: #fef3c7;
        }
        .dark .cell-az, .dark .cell-by {
            background-color: rgba(146, 64, 14, 0.15);
            border-color: rgba(245, 158, 11, 0.3);
            color: #fde68a;
        }
        .dark .cell-az:hover, .dark .cell-by:hover {
            background-color: rgba(146, 64, 14, 0.25);
        }

        /* CX, CY: Blue */
        .cell-cx, .cell-cy {
            background-color: #eff6ff;
            border-color: #bfdbfe;
            color: #1e40af;
        }
        .cell-cx:hover, .cell-cy:hover {
            background-color: #dbeafe;
        }
        .dark .cell-cx, .dark .cell-cy {
            background-color: rgba(30, 64, 175, 0.15);
            border-color: rgba(59, 130, 246, 0.3);
            color: #bfdbfe;
        }
        .dark .cell-cx:hover, .dark .cell-cy:hover {
            background-color: rgba(30, 64, 175, 0.25);
        }

        /* BZ: Rose/Red */
        .cell-bz {
            background-color: #fff5f5;
            border-color: #fed7d7;
            color: #c53030;
        }
        .cell-bz:hover {
            background-color: #fee2e2;
        }
        .dark .cell-bz {
            background-color: rgba(197, 48, 48, 0.15);
            border-color: rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }
        .dark .cell-bz:hover {
            background-color: rgba(197, 48, 48, 0.25);
        }

        /* CZ: Slate/Gray */
        .cell-cz {
            background-color: #f8fafc;
            border-color: #e2e8f0;
            color: #334155;
        }
        .cell-cz:hover {
            background-color: #f1f5f9;
        }
        .dark .cell-cz {
            background-color: rgba(39, 39, 42, 0.4);
            border-color: rgba(63, 63, 70, 0.6);
            color: #d4d4d8;
        }
        .dark .cell-cz:hover {
            background-color: rgba(63, 63, 70, 0.4);
        }

        /* Inner elements */
        .cell-title {
            font-size: 16px;
            font-weight: 800;
            display: block;
        }
        .cell-value {
            font-size: 13px;
            font-weight: 700;
            margin-top: 3px;
            display: block;
        }
        .cell-value-sub {
            font-size: 10px;
            font-weight: 400;
            opacity: 0.8;
        }
        .cell-desc {
            font-size: 9px;
            line-height: 1.25;
            margin-top: 5px;
            opacity: 0.75;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Notification bar */
        .abcxyz-alert-bar {
            margin-top: 16px;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #eef2ff;
            border: 1px solid #e0e7ff;
            color: #3730a3;
        }
        .dark .abcxyz-alert-bar {
            background-color: rgba(55, 48, 163, 0.15);
            border-color: rgba(67, 56, 202, 0.3);
            color: #c7d2fe;
        }
    </style>

    <!-- Filter Section -->
    <x-filament::section heading="Filter Periode Analisis" description="Pilih rentang waktu transaksi penjualan untuk analisis ABC-XYZ">
        <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 20px; margin-top: 10px;">
            <div style="display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
                <span style="font-size: 12px; font-weight: 600; color: #888; text-transform: uppercase; tracking-wider: 0.05em; width: 100px;">Timeframe</span>
                <x-filament::input.wrapper style="width: 200px;">
                    <x-filament::input.select wire:model.live="timeframe" style="font-size: 13px; padding-top: 6px; padding-bottom: 6px;">
                        <option value="30">30 Hari Terakhir</option>
                        <option value="60">60 Hari Terakhir</option>
                        <option value="90">90 Hari Terakhir</option>
                        <option value="custom">Custom Tanggal</option>
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>

            @if ($timeframe === 'custom')
                <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
                        <span style="font-size: 12px; font-weight: 600; color: #888; text-transform: uppercase; tracking-wider: 0.05em; width: 40px; text-align: right;">Dari</span>
                        <x-filament::input.wrapper style="width: 160px;">
                            <x-filament::input 
                                type="date" 
                                wire:model.live="startDate" 
                                style="font-size: 13px; padding-top: 6px; padding-bottom: 6px;"
                            />
                        </x-filament::input.wrapper>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
                        <span style="font-size: 12px; font-weight: 600; color: #888; text-transform: uppercase; tracking-wider: 0.05em; width: 50px; text-align: right;">Sampai</span>
                        <x-filament::input.wrapper style="width: 160px;">
                            <x-filament::input 
                                type="date" 
                                wire:model.live="endDate" 
                                style="font-size: 13px; padding-top: 6px; padding-bottom: 6px;"
                            />
                        </x-filament::input.wrapper>
                    </div>
                </div>
            @endif
        </div>
    </x-filament::section>

    <!-- 3x3 Matrix Grid -->
    <div class="abcxyz-matrix-wrapper">
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Matriks Klasifikasi ABC-XYZ</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400">Pilih salah satu kotak di bawah ini untuk memfilter daftar produk di tabel.</p>

        @php
            $counts = $this->getMatrixCounts();
            
            // Define styling and description for each cell
            $cellMeta = [
                'AX' => ['class' => 'cell-ax', 'desc' => 'Superstar (Omzet Tinggi, Stabil)'],
                'AY' => ['class' => 'cell-ay', 'desc' => 'Musiman (Omzet Tinggi, Fluktuatif)'],
                'AZ' => ['class' => 'cell-az', 'desc' => 'Bernilai Tinggi, Jarang (Omzet Tinggi, Sporadis)'],
                'BX' => ['class' => 'cell-bx', 'desc' => 'Omzet Sedang, Permintaan Stabil'],
                'BY' => ['class' => 'cell-by', 'desc' => 'Omzet Sedang, Permintaan Fluktuatif'],
                'BZ' => ['class' => 'cell-bz', 'desc' => 'Omzet Sedang, Permintaan Sporadis'],
                'CX' => ['class' => 'cell-cx', 'desc' => 'Murah/Pelengkap, Permintaan Stabil'],
                'CY' => ['class' => 'cell-cy', 'desc' => 'Murah/Pelengkap, Permintaan Fluktuatif'],
                'CZ' => ['class' => 'cell-cz', 'desc' => 'Deadweight (Omzet Kecil, Jarang)'],
            ];
        @endphp

        <!-- The Matrix Wrapper -->
        <div class="abcxyz-grid">
            <!-- Col Header Corner (Empty) -->
            <div></div>
            <!-- Column Headers -->
            <div class="abcxyz-header-cell">
                X
                <span class="abcxyz-header-sub">Stabil<br>(CV &le; 20%)</span>
            </div>
            <div class="abcxyz-header-cell">
                Y
                <span class="abcxyz-header-sub">Fluktuatif<br>(20% - 50%)</span>
            </div>
            <div class="abcxyz-header-cell">
                Z
                <span class="abcxyz-header-sub">Sporadis<br>(CV &gt; 50%)</span>
            </div>

            <!-- Row A -->
            <div class="abcxyz-row-label">
                A
                <span class="abcxyz-row-sub">Omzet Tinggi<br>(80% Teratas)</span>
            </div>
            @foreach(['AX', 'AY', 'AZ'] as $cell)
                <button 
                    wire:click="selectGridClass('{{ $cell }}')"
                    class="abcxyz-cell {{ $cellMeta[$cell]['class'] }} {{ $selectedClass === $cell ? 'is-selected' : '' }}"
                >
                    <span class="cell-title">{{ $cell }}</span>
                    <span class="cell-value">{{ $counts[$cell] }} <span class="cell-value-sub">Prod</span></span>
                    <span class="cell-desc">{{ $cellMeta[$cell]['desc'] }}</span>
                </button>
            @endforeach

            <!-- Row B -->
            <div class="abcxyz-row-label">
                B
                <span class="abcxyz-row-sub">Omzet Sedang<br>(15% Berikutnya)</span>
            </div>
            @foreach(['BX', 'BY', 'BZ'] as $cell)
                <button 
                    wire:click="selectGridClass('{{ $cell }}')"
                    class="abcxyz-cell {{ $cellMeta[$cell]['class'] }} {{ $selectedClass === $cell ? 'is-selected' : '' }}"
                >
                    <span class="cell-title">{{ $cell }}</span>
                    <span class="cell-value">{{ $counts[$cell] }} <span class="cell-value-sub">Prod</span></span>
                    <span class="cell-desc">{{ $cellMeta[$cell]['desc'] }}</span>
                </button>
            @endforeach

            <!-- Row C -->
            <div class="abcxyz-row-label">
                C
                <span class="abcxyz-row-sub">Omzet Rendah<br>(5% Terakhir)</span>
            </div>
            @foreach(['CX', 'CY', 'CZ'] as $cell)
                <button 
                    wire:click="selectGridClass('{{ $cell }}')"
                    class="abcxyz-cell {{ $cellMeta[$cell]['class'] }} {{ $selectedClass === $cell ? 'is-selected' : '' }}"
                >
                    <span class="cell-title">{{ $cell }}</span>
                    <span class="cell-value">{{ $counts[$cell] }} <span class="cell-value-sub">Prod</span></span>
                    <span class="cell-desc">{{ $cellMeta[$cell]['desc'] }}</span>
                </button>
            @endforeach
        </div>

        @if ($selectedClass)
            <div class="abcxyz-alert-bar">
                <div>
                    Menampilkan filter kelas: <strong style="font-size: 13px; text-transform: uppercase;">{{ $selectedClass }}</strong> — {{ $cellMeta[$selectedClass]['desc'] }}
                </div>
                <button wire:click="selectGridClass('{{ $selectedClass }}')" style="font-weight: 700; text-decoration: underline; background: none; border: none; cursor: pointer;">
                    Hapus Filter
                </button>
            </div>
        @endif
    </div>

    <!-- Table -->
    <div class="flex flex-col gap-4">
        {{ $this->table }}
    </div>
</x-filament-panels::page>
