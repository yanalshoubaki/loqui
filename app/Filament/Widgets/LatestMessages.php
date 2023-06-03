<?php

namespace App\Filament\Widgets;

use App\Models\Message;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestMessages extends BaseWidget
{
    protected static ?int $sort = 2;
    protected function getTableQuery(): Builder
    {
        return Message::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('user.name')->sortable(),
            Tables\Columns\TextColumn::make('sender.name')->sortable(),
            Tables\Columns\TextColumn::make('message')->sortable(),
        ];
    }
}
