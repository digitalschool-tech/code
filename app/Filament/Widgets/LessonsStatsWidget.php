<?php

namespace App\Filament\Widgets;

use App\Models\Lesson;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LessonsStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Lessons', Lesson::count())
                ->description('All available lessons')
                ->descriptionIcon('heroicon-o-book-open')
                ->color('info'),
        ];
    }
} 