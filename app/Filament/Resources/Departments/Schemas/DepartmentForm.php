<?php

namespace App\Filament\Resources\Departments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('department_name')
                ->required()
                ->label('Department')
                ->placeholder('Department name'),
                TimePicker::make('max_clock_in_time')
                ->required()
                ->label('Max Clock in'),
                TimePicker::make('max_clock_out_time')
                ->required()
                ->label('Max Clock Out'),
            ]);
    }
}
