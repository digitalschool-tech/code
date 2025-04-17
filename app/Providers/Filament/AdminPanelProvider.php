<?php

namespace App\Providers\Filament;

use App\Filament\Resources\CourseResource;
use App\Filament\Resources\LevelResource;
use App\Filament\Resources\LessonResource;
use App\Filament\Widgets\CoursesStatsWidget;
use App\Filament\Widgets\LessonsStatsWidget;
use App\Filament\Widgets\LevelsStatsWidget;
use App\Filament\Widgets\RecentLessonsWidget;
use App\Filament\Widgets\SystemInfoWidget;
use App\Filament\Widgets\UserActivityWidget;
use Filament\Http\Middleware\Authenticate;
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
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('Course Management')
            ->colors([
                'danger' => Color::Red,
                'gray' => Color::Zinc,
                'info' => Color::Blue,
                'primary' => Color::Pink,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->font('Nunito')
            ->favicon(asset('images/favicon.png'))
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('250px')
            ->maxContentWidth('full')
            ->resources([
                CourseResource::class,
                LevelResource::class,
                LessonResource::class,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                SystemInfoWidget::class,
                CoursesStatsWidget::class,
                LessonsStatsWidget::class,
                LevelsStatsWidget::class,
                RecentLessonsWidget::class,
                UserActivityWidget::class,
            ])
            ->navigationGroups([
                'Content Management',
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
            ]);
    }
}
