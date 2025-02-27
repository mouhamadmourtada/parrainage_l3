<?php

namespace App\Filament\Resources\ParrainResource\Pages;

use App\Filament\Resources\ParrainResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParrains extends ListRecords
{
    protected static string $resource = ParrainResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
