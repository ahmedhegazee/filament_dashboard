<?php

namespace App\Filament\Resources\EmployeeResource\Widgets;

use App\Models\Employee;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class EmployeesCountWidget extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('All Employees', Employee::count('id')),
            Card::make('US Employees', Employee::whereHas('country', fn ($query) => $query->where('country_code', 'USA'))->count('id')),
            Card::make('UK Employees', Employee::whereHas('country', fn ($query) => $query->where('country_code', 'UK'))->count('id')),
        ];
    }
}