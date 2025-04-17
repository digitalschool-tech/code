<?php

namespace App\Filament\Resources\LevelResource\Pages;

use App\Filament\Resources\LevelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Infolists\Infolist;

class EditLevel extends EditRecord
{
    protected static string $resource = LevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function hasInfolist(): bool
    {
        return true;
    }

    public function getInfolist(string $name = null): ?Infolist
    {
        return $this->getResource()::infolist($this->infolist);
    }
} 