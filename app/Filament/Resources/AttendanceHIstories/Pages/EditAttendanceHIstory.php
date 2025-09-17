<?php

namespace App\Filament\Resources\AttendanceHIstories\Pages;

use App\Filament\Resources\AttendanceHIstories\AttendanceHIstoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAttendanceHIstory extends EditRecord
{
    protected static string $resource = AttendanceHIstoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
