<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\Message;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\Widget;

class UserCounter extends Widget
{
    protected static string $view = 'filament.resources.user-resource.widgets.user-counter';

    protected function getViewData(): array
    {
        return [
            StatsOverviewWidget::class
        ];
    }
}
