<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LevelResource\Pages;
use App\Models\Level;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class LevelResource extends Resource
{
    protected static ?string $model = Level::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    
    protected static ?string $navigationGroup = 'Content Management';
    
    protected static ?string $navigationLabel = 'Levels';
    
    protected static ?int $navigationSort = 3;

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Level Hierarchy')
                    ->description('This level belongs to the following course structure')
                    ->icon('heroicon-m-rectangle-stack')
                    ->schema([
                        Infolists\Components\TextEntry::make('hierarchy')
                            ->label('')
                            ->html()
                            ->columnSpanFull()
                            ->state(function ($record) {
                                $lesson = $record?->lesson;
                                $course = $lesson?->course;
                                
                                if (!$lesson) {
                                    return '<div class="text-gray-500">No lesson assigned yet</div>';
                                }

                                // Get sibling levels
                                $siblingLevels = $lesson->levels()
                                    ->orderBy('index')
                                    ->pluck('index')
                                    ->toArray();
                                
                                $currentIndex = array_search($record->index, $siblingLevels);
                                $previousLevel = $currentIndex > 0 ? $siblingLevels[$currentIndex - 1] : null;
                                $nextLevel = isset($siblingLevels[$currentIndex + 1]) ? $siblingLevels[$currentIndex + 1] : null;

                                // Get previous and next lessons
                                $siblingLessons = $course->lessons()
                                    ->orderBy('name')
                                    ->get();
                                
                                $currentLessonIndex = $siblingLessons->search(function($item) use ($lesson) {
                                    return $item->id === $lesson->id;
                                });
                                
                                $previousLesson = $currentLessonIndex > 0 ? $siblingLessons[$currentLessonIndex - 1] : null;
                                $nextLesson = isset($siblingLessons[$currentLessonIndex + 1]) ? $siblingLessons[$currentLessonIndex + 1] : null;
                                
                                return view('filament.components.hierarchy-badge', [
                                    'course' => $course?->name ?? 'No Course',
                                    'lesson' => $lesson?->name ?? 'No Lesson',
                                    'record' => $record,
                                    'previousLevel' => $previousLevel,
                                    'nextLevel' => $nextLevel,
                                    'previousLesson' => $previousLesson,
                                    'nextLesson' => $nextLesson,
                                ])->render();
                            }),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Relationships')
                    ->description('This level belongs to the following hierarchy')
                    ->icon('heroicon-m-rectangle-stack')
                    ->schema([
                        Forms\Components\Select::make('lesson_id')
                            ->relationship('lesson', 'name')
                            ->required()
                            ->label('Lesson')
                            ->searchable()
                            ->preload()
                            ->prefixIcon('heroicon-m-book-open')
                            ->afterStateUpdated(function ($state, Forms\Get $get, Forms\Set $set) {
                                if ($state) {
                                    $lesson = \App\Models\Lesson::find($state);
                                    if ($lesson) {
                                        $set('course_info', $lesson->course->name ?? 'No Course');
                                    }
                                }
                            }),
                        Forms\Components\Placeholder::make('hierarchy_info')
                            ->content(function ($record) {
                                $lesson = $record?->lesson;
                                $course = $lesson?->course;
                                
                                if (!$lesson) {
                                    return 'Select a lesson to see the hierarchy';
                                }

                                // Get sibling levels
                                $siblingLevels = $lesson->levels()
                                    ->orderBy('index')
                                    ->pluck('index')
                                    ->toArray();
                                
                                $currentIndex = array_search($record->index, $siblingLevels);
                                $previousLevel = $currentIndex > 0 ? $siblingLevels[$currentIndex - 1] : null;
                                $nextLevel = isset($siblingLevels[$currentIndex + 1]) ? $siblingLevels[$currentIndex + 1] : null;

                                // Get previous and next lessons
                                $siblingLessons = $course->lessons()
                                    ->orderBy('name')
                                    ->get();
                                
                                $currentLessonIndex = $siblingLessons->search(function($item) use ($lesson) {
                                    return $item->id === $lesson->id;
                                });
                                
                                $previousLesson = $currentLessonIndex > 0 ? $siblingLessons[$currentLessonIndex - 1] : null;
                                $nextLesson = isset($siblingLessons[$currentLessonIndex + 1]) ? $siblingLessons[$currentLessonIndex + 1] : null;
                                
                                return view('filament.components.hierarchy-badge', [
                                    'course' => $course?->name ?? 'No Course',
                                    'lesson' => $lesson?->name ?? 'No Lesson',
                                    'record' => $record,
                                    'previousLevel' => $previousLevel,
                                    'nextLevel' => $nextLevel,
                                    'previousLesson' => $previousLesson,
                                    'nextLesson' => $nextLesson,
                                ]);
                            }),
                    ])
                    ->collapsible(),
                Forms\Components\Section::make('Level Information')
                    ->description('Basic information about the level')
                    ->icon('heroicon-m-puzzle-piece')
                    ->schema([
                        Forms\Components\TextInput::make('index')
                            ->required()
                            ->label('Index'),
                        Forms\Components\TextInput::make('description')
                            ->required()
                            ->label('Description'),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Level Editor')
                    ->description('Visual editor for level layout')
                    ->icon('heroicon-m-squares-2x2')
                    ->schema([
                        \App\Filament\Forms\Components\LevelEditor::make('level_data')
                            ->columnSpanFull()
                            ->afterStateHydrated(function ($component, $state, Forms\Set $set) {
                                // Get the actual field values from the record
                                $record = $component->getRecord();
                                
                                if (!$record) {
                                    return;
                                }
                                
                                $player = [];
                                if (!empty($record->player)) {
                                    $player = json_decode($record->player, true) ?: [];
                                }
                                
                                $goal = [];
                                if (!empty($record->goal)) {
                                    $goal = json_decode($record->goal, true) ?: [];
                                }
                                
                                $route = [];
                                if (!empty($record->route)) {
                                    $route = json_decode($record->route, true) ?: [];
                                }
                                
                                $blocks = [];
                                if (!empty($record->blocks)) {
                                    $blocks = json_decode($record->blocks, true) ?: [];
                                }
                                
                                // Set the data for the level editor
                                $set('level_data', [
                                    'player' => $player,
                                    'goal' => $goal,
                                    'route' => $route,
                                    'blocks' => $blocks,
                                ]);
                            })
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if (!$state) {
                                    return;
                                }

                                // Ensure we're storing valid JSON data
                                $player = is_array($state['player']) ? $state['player'] : [];
                                $goal = is_array($state['goal']) ? $state['goal'] : [];
                                $route = is_array($state['route']) ? $state['route'] : [];
                                $blocks = is_array($state['blocks']) ? $state['blocks'] : [];

                                $set('player', json_encode($player));
                                $set('goal', json_encode($goal));
                                $set('route', json_encode($route));
                                $set('blocks', json_encode($blocks));
                            }),
                        Forms\Components\Hidden::make('player')
                            ->default('[]')
                            ->required(),
                        Forms\Components\Hidden::make('goal')
                            ->default('[]')
                            ->required(),
                        Forms\Components\Hidden::make('route')
                            ->default('[]')
                            ->required(),
                        Forms\Components\Hidden::make('blocks')
                            ->default('[]')
                            ->required(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('Level')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('player')
                    ->label('Player')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('goal')
                    ->label('Goal')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('route')
                    ->label('Route')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('blocks')
                    ->label('Blocks')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('lesson.course.name')
                    ->label('Course')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('lesson.name')
                    ->label('Lesson')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->groups([
                Tables\Grouping\Group::make('lesson.course.name')
                    ->label('Course')
                    ->collapsible(),
                Tables\Grouping\Group::make('lesson.name')
                    ->label('Lesson')
                    ->collapsible(),
            ])
            ->defaultGroup('lesson.name')
            ->defaultSort(column: 'id', direction: 'asc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->striped();
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListLevels::route('/'),
            'create' => Pages\CreateLevel::route('/create'),
            'edit'   => Pages\EditLevel::route('/{record}/edit'),
        ];
    }
}
