<?php

namespace App\Filament\Widgets;

use App\Models\Message;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getCards(): array
    {
        return [
            Card::make('Total Users', User::where('status', '=', 1)->count()),
            Card::make('Total Messages', Message::count()),
        ];
    }
}
