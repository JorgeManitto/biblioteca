<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'Usuarios';
    protected static ?string $navigationGroup = 'Administración de sitio';

    protected static ?string $title = 'Usuarios';
    protected static ?string $slug = 'usuarios';

    protected static ?string $modelLabel = 'Usuario';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required()
                ->label("Nombre")
                ->maxLength(255),
                TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
                Select::make('rol')
                ->options([
                    "1" => 'Admin',
                    "2" => 'Profesor',
                    "3" => 'Alumno'
                ]),
                Select::make('estado')
                ->options([
                    "1" => 'Inactivo',
                    "2" => 'Activo',
                ]),
                TextInput::make('password')
                ->password()
                ->maxLength(255)
                ->dehydrateStateUsing(static fn(null|string $state):null|string => filled($state)? Hash::make($state):null)
                ->required(static fn(Page $livewire):bool =>
                $livewire instanceof CreateUser)
                ->dehydrated(static fn(null|string $state):bool => filled($state))
                ->label(static fn(Page $livewire):string =>
                ($livewire instanceof EditUser) ? 'Cambiar contraseña' : 'Contraseña'
            ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label("#")->sortable(),
                TextColumn::make('name')->label("Nombre")->searchable()->sortable(),
                TextColumn::make('email')->searchable()
            ])->defaultSort('id','desc')
            ->filters([
                SelectFilter::make('estado')
                ->options([
                    "1" => 'Inactivo',
                    "2" => 'Activo',
                ]),
                SelectFilter::make('rol')
                ->options([
                    "1" => 'Admin',
                    "2" => 'Profesor',
                    "3" => 'Estudiante',
                ])
                ->label("Rol")
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
