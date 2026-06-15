<x-filament-panels::page>
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-gray-200 dark:border-gray-700 pb-4">
        <x-filament::tabs class="border-none shadow-none">
            <x-filament::tabs.item
                :active="$activeTab === 'all'"
                wire:click="$set('activeTab', 'all')"
                icon="heroicon-m-squares-2x2"
            >
                Semua Produk
            </x-filament::tabs.item>

            <x-filament::tabs.item
                :active="$activeTab === 'low_stock'"
                wire:click="$set('activeTab', 'low_stock')"
                icon="heroicon-m-exclamation-triangle"
                badge="{{ $this->getLowStockCount() }}"
                badge-color="warning"
            >
                Stok Rendah
            </x-filament::tabs.item>

            <x-filament::tabs.item
                :active="$activeTab === 'slow_moving'"
                wire:click="$set('activeTab', 'slow_moving')"
                icon="heroicon-m-arrow-trending-down"
                badge="{{ $this->getSlowMovingCount() }}"
                badge-color="danger"
            >
                Slow Moving
            </x-filament::tabs.item>

            <x-filament::tabs.item
                :active="$activeTab === 'dead_stock'"
                wire:click="$set('activeTab', 'dead_stock')"
                icon="heroicon-m-clock"
                badge="{{ $this->getDeadStockCount() }}"
                badge-color="gray"
            >
                Dead Stock
            </x-filament::tabs.item>
                <x-filament::button 
                wire:click="export"
                icon="heroicon-m-arrow-down-tray"
                color="success"
            >
                Ekspor Excel
            </x-filament::button>
        </x-filament::tabs>
    </div>

    {{ $this->table }}
</x-filament-panels::page>
