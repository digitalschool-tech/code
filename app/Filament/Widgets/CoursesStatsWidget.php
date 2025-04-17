<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CoursesStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Courses', Course::count())
                ->description('All available courses')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('success'),
        ];
    }
} 