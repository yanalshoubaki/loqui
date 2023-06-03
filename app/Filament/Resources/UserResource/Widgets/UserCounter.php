<?php

namespace App\Filament\Resources\UserResource\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\Widget;

class UserCounter extends Widget
{
    protected static string $view = 'filament.resources.user-resource.widgets.user-counter';

    protected function getViewData(): array
    {
        return [
            StatsOverviewWidget::class,
        ];
    }
}
