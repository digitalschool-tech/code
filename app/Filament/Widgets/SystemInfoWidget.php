<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class SystemInfoWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $memoryUsage = $this->getMemoryUsage();
        $diskUsage = $this->getDiskUsage();
        $phpVersion = PHP_VERSION;
        $laravelVersion = app()->version();

        return [
            Stat::make('Memory Usage', $memoryUsage)
                ->description('Current memory consumption')
                ->color('success'),
            Stat::make('Disk Usage', $diskUsage)
                ->description('Storage space used')
                ->color('warning'),
            Stat::make('PHP Version', $phpVersion)
                ->description('Running PHP version')
                ->color('info'),
            Stat::make('Laravel Version', $laravelVersion)
                ->description('Framework version')
                ->color('primary'),
        ];
    }

    protected function getMemoryUsage(): string
    {
        $memory = memory_get_usage(true);
        return $this->formatBytes($memory);
    }

    protected function getDiskUsage(): string
    {
        $disk = disk_free_space('/');
        $total = disk_total_space('/');
        $used = $total - $disk;
        return $this->formatBytes($used) . ' / ' . $this->formatBytes($total);
    }

    protected function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
} 