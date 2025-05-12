<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\SpatieLaravelMediaLibrary\SpatieLaravelMediaLibraryPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel = $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->darkMode(true)
            ->colors([
                'primary' => Color::Amber,
                'danger' => Color::Rose,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->brandName('Cloud Restaurant')
            ->favicon(asset('images/favicon.png'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigationGroups([
                'Restaurant Management',
                'Order Management',
                'User Management',
            ])
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth('full');

        // Only enable database notifications if the notifications table exists
        if (Schema::hasTable('notifications')) {
            $panel->databaseNotifications();
        }

        // Add plugins
        $plugins = [];

        // Add Spatie Media Library Plugin if it exists
        if (class_exists(\Filament\SpatieLaravelMediaLibrary\SpatieLaravelMediaLibraryPlugin::class)) {
            $plugins[] = \Filament\SpatieLaravelMediaLibrary\SpatieLaravelMediaLibraryPlugin::make();
        }

        // Add Filament Shield Plugin if it exists
        if (class_exists(\BezhanSalleh\FilamentShield\FilamentShieldPlugin::class)) {
            $plugins[] = \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make();
        }

        if (!empty($plugins)) {
            $panel->plugins($plugins);
        }

        return $panel;
    }
}
