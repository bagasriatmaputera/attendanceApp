<?php

namespace App\Filament\Resources\AttendanceHIstories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AttendanceHIstoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')
                ->label('Employee'),
                TextColumn::make('attendance.attendance_id')
                ->label('ID Attendance'),
                TextColumn::make('date_attendance')
                ->label('Date Attendance'),
                TextColumn::make('description')
                ->label('Description'),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
