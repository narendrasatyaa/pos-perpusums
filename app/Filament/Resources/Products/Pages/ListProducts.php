<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadTemplate')
                ->label('Template Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->url(route('products.template')),
            Action::make('importExcel')
                ->label('Upload Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalSubmitActionLabel('Upload')
                ->modalCancelAction(false)
                ->closeModalByClickingAway(false)
                ->closeModalByEscaping(false)
                ->form([
                    FileUpload::make('file')
                        ->label('File Excel')
                        ->required()
                        ->storeFiles(false)
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                            'text/csv',
                        ])
                        ->helperText('Pakai template yang diunduh dari tombol di samping.'),
                ])
                ->action(function (array $data): void {
                    $import = new \App\Imports\ProductsImport();

                    $file = $data['file'] ?? null;

                    // FileUpload may return an array of files or a single TemporaryUploadedFile
                    if (is_array($file)) {
                        $file = reset($file) ?: null;
                    }

                    if (! $file instanceof TemporaryUploadedFile) {
                        Notification::make()
                            ->title('File Excel tidak terbaca')
                            ->danger()
                            ->send();

                        return;
                    }

                    $path = $file->getRealPath();

                    if (! $path) {
                        Notification::make()
                            ->title('File Excel gagal diproses')
                            ->danger()
                            ->send();

                        return;
                    }

                    try {
                        Excel::import($import, $path);

                        Notification::make()
                            ->title('Produk berhasil diimport')
                            ->success()
                            ->send();
                    } catch (\Throwable $e) {
                        Notification::make()
                            ->title('Import gagal: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
                ->color('primary'),
            CreateAction::make(),
        ];
    }
}
