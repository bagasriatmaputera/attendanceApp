<?php

namespace App\Filament\Resources\Attendances\Schemas;

use App\Models\attendance;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('employee_id')
                    ->label('Employee')
                    ->relationship('employee', 'name')
                    ->required(),
                TextInput::make('attendance_id')
                    ->label('ID')
                    ->default(function () {
                        $lastCode = attendance::orderBy('attendance_id', 'desc')->first()?->attendance_id ?? 'PC000';
                        $number = intval(substr($lastCode, 1)) + 1;
                        return 'PC' . str_pad($number, 2, '0', STR_PAD_LEFT);
                    })
                    ->disabled() // agar user tidak ubah
                    ->dehydrated(true), // <-- tambahkan ini agar tetap dikirim ke database!,
                TimePicker::make('clock_in')
                    ->required()
                    ->label('Clock in'),
                TimePicker::make('clock_out')
                    ->required()
                    ->label('Clock Out'),

            ]);
    }
}
