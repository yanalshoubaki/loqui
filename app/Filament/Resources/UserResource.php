<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\UserResource\Pages;
use App\Models\MediaObject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal information') ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required(),
                    Forms\Components\TextInput::make('username')
                        ->required()
                        ->unique(User::class, 'username', ignoreRecord: true),
                    Forms\Components\TextInput::make('email')
                        ->required()
                        ->email()
                        ->unique(User::class, 'email', ignoreRecord: true),
                        Forms\Components\TextInput::make('password')
                        ->required()
                        ->password(),
                        Forms\Components\Select::make('roles')->multiple()->relationship('roles', 'name')->required(),
                        Forms\Components\Toggle::make('status')
                        ->onColor(1)
                        ->required()
                        ->offColor(0),
                    Forms\Components\FileUpload::make('mediaObjects.media_path')->required()
                ])
                    ->collapsible(),
            ]);
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\ImageColumn::make('mediaObject.media_path')->label('Profile image')->rounded(),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('username')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\BooleanColumn::make('status')->sortable()
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueIcon('heroicon-s-check-circle'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->action(function () {
                        Notification::make()
                            ->title('Now, now, don\'t be cheeky, leave some records for others to play with!')
                            ->warning()
                            ->send();
                    }),
            ]);

    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
