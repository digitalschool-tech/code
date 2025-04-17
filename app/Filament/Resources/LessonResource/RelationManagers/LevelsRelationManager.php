<?php

namespace App\Filament\Resources\LessonResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;

class LevelsRelationManager extends RelationManager
{
    protected static string $relationship = 'levels';
    protected static ?string $recordTitleAttribute = 'index';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('index')
                ->required()
                ->label('Index'),
            Forms\Components\TextInput::make('description')
                ->required()
                ->label('Description'),
            Forms\Components\TextInput::make('player')
                ->required()
                ->label('Player'),
            Forms\Components\TextInput::make('goal')
                ->required()
                ->label('Goal'),
            Forms\Components\TextInput::make('route')
                ->required()
                ->label('Route'),
            Forms\Components\TextInput::make('blocks')
                ->required()
                ->label('Blocks'),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('Index')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(30),
                Tables\Columns\TextColumn::make('player')
                    ->label('Player'),
                Tables\Columns\TextColumn::make('goal')
                    ->label('Goal'),
                Tables\Columns\TextColumn::make('route')
                    ->label('Route'),
                Tables\Columns\TextColumn::make('blocks')
                    ->label('Blocks'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
} 