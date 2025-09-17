<?php

namespace App\Filament\Widgets;

use App\Models\department;
use App\Models\Employee;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GeneralWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalPengguns = Employee::count();
        $totaldepartment = department::count();
        return [
            Stat::make('Total Employee', $totalPengguns . ' Employee'),
            Stat::make('Total Department', $totaldepartment . ' Department'),
        ];
    }
}
