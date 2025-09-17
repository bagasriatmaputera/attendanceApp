<?php

namespace App\Filament\Resources\Employees\Schemas;

use App\Models\Employee;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('employee_id')
                    ->label('Employee ID')
                    ->default(function () {
                        $lastCode = Employee::orderBy('employee_id', 'desc')->first()?->employee_id ?? 'KYW000';
                        $number = intval(substr($lastCode, 3)) + 1; // ambil mulai setelah 'KYW'
                        return'KYW' . str_pad($number, 3, '0', STR_PAD_LEFT);
                    })
                    ->disabled() // agar user tidak ubah
                    ->dehydrated(true),
                Select::make('department_id')
                    ->relationship('department', 'department_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->required(),
                Textarea::make('address')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
