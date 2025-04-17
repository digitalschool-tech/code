<?php

namespace App\Filament\Widgets;

use App\Models\Level;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LevelsStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Levels', Level::count())
                ->description('All available levels')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('warning'),
        ];
    }
} 