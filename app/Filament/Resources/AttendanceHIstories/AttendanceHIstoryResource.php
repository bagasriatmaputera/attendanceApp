<?php

namespace App\Filament\Resources\AttendanceHIstories;

use App\Filament\Resources\AttendanceHIstories\Pages\CreateAttendanceHIstory;
use App\Filament\Resources\AttendanceHIstories\Pages\EditAttendanceHIstory;
use App\Filament\Resources\AttendanceHIstories\Pages\ListAttendanceHIstories;
use App\Filament\Resources\AttendanceHIstories\Schemas\AttendanceHIstoryForm;
use App\Filament\Resources\AttendanceHIstories\Tables\AttendanceHIstoriesTable;
use App\Models\AttendanceHIstory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AttendanceHIstoryResource extends Resource
{
    protected static ?string $model = AttendanceHIstory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Document;

    protected static ?string $recordTitleAttribute = 'AttendanceHistory';

    // public static function form(Schema $schema): Schema
    // {
    //     return AttendanceHIstoryForm::configure($schema);
    // }

    public static function table(Table $table): Table
    {
        return AttendanceHIstoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAttendanceHIstories::route('/'),
            // 'create' => CreateAttendanceHIstory::route('/create'),
            'edit' => EditAttendanceHIstory::route('/{record}/edit'),
        ];
    }
}
