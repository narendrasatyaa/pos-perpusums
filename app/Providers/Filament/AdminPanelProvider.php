<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\ProductsByCategoryChart;
use App\Filament\Widgets\ProductAvailabilityChart;
// use App\Filament\Widgets\StockAvailability;
use App\Filament\Widgets\SalesOverview;
use App\Filament\Widgets\SalesChart;
use App\Filament\Widgets\TopProducts;
use App\Filament\Widgets\LowStockProducts;
use App\Filament\Widgets\HppSummary;
use App\Filament\Pages\Dashboard;
use App\Filament\Widgets\PaymentMethodChart;
// use App\Filament\Widgets\ProductPriceRangeChart;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ->default()
            ->id('admin')
            ->path('admin')
            ->brandName('POS Library Cafe')
            ->globalSearch(false)
            ->sidebarCollapsibleOnDesktop()
            ->brandLogo(asset('img/logo-perpus-putih.webp'))
            ->brandLogoHeight('2.5rem')
            ->favicon(asset('img/logo-perpus.webp'))
            ->login(
                fn() => view('auth.login', [
                    'loginAction' => route('admin.login.store'),
                ]),
            )
            ->colors([
                'primary' => Color::hex('#323986'),
            ])
            ->navigationGroups([
                NavigationGroup::make('Manajemen Produk')
                    ->label('Manajemen Produk')
                    ->collapsible(),
                NavigationGroup::make('Manajemen Stok')
                    ->label('Manajemen Stok')
                    ->collapsible(),
                NavigationGroup::make('Laporan Penjualan')
                    ->label('Laporan Penjualan')
                    ->collapsible(),
                NavigationGroup::make('Keuangan & Kas')
                    ->label('Keuangan & Kas')
                    ->collapsible(),
                NavigationGroup::make('Log Aktivitas')
                    ->label('Log Aktivitas')
                    ->collapsible(),
                NavigationGroup::make('Manajemen Akses')
                    ->label('Manajemen Akses')
                    ->collapsible(),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([Dashboard::class])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                SalesOverview::class,
                StatsOverview::class,
                HppSummary::class,
                SalesChart::class,
                TopProducts::class,
                LowStockProducts::class,
                ProductAvailabilityChart::class,
                ProductsByCategoryChart::class,
                PaymentMethodChart::class,
            ])
            ->middleware([EncryptCookies::class, AddQueuedCookiesToResponse::class, StartSession::class, AuthenticateSession::class, ShareErrorsFromSession::class, PreventRequestForgery::class, SubstituteBindings::class, DisableBladeIconComponents::class, DispatchServingFilamentEvent::class])
            ->authMiddleware([Authenticate::class]);
    }
}
