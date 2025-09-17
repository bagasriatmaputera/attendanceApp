<?php

namespace App\Filament\Resources\Employees\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EmployeesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee_id')
                ->label('Employee ID')
                ->searchable(),
                TextColumn::make('name')
                ->label('Employee Name')
                ->searchable(),
                TextColumn::make('email')
                ->label('Email')
                ->searchable(),
                TextColumn::make('address')
                ->label('Employee Address')
                ->searchable(),
                TextColumn::make('department.department_name')
                ->label('Department')

            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
