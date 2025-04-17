<?php

namespace App\Filament\Widgets;

use App\Models\Lesson;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentLessonsWidget extends BaseWidget
{
    protected static ?string $heading = 'Recent Lessons';
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Lesson::query()
                    ->with('course')
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course'),
                Tables\Columns\TextColumn::make('levels_count')
                    ->counts('levels')
                    ->label('Levels'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
} 