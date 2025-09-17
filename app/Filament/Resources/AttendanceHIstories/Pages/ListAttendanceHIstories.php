<?php

namespace App\Filament\Resources\AttendanceHIstories\Pages;

use App\Filament\Resources\AttendanceHIstories\AttendanceHIstoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAttendanceHIstories extends ListRecords
{
    protected static string $resource = AttendanceHIstoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
