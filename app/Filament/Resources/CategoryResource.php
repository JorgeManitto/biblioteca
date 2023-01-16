<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $recordTitleAttribute = 'titulo';

    protected static ?string $navigationLabel = 'Categorías';
    protected static ?string $navigationGroup = 'Administración de sitio';

    protected static ?string $title = 'Categorías';
    protected static ?string $slug = 'categoria';

    protected static ?string $modelLabel = 'Categoría';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('titulo'),
                Select::make('estado')->options(
                    [
                        1 => 'Pendiente',
                        2 => 'Publicado',
                    ]
                )
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label("#")->sortable(),
                TextColumn::make('titulo')->searchable()->sortable(),
                BadgeColumn::make('estado')
                ->enum([
                    "1" => 'Pendiente',
                    "2" => 'Publicado',
                ]),
            ])->defaultSort('id','desc')
            ->filters([
                //
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
            'index' => Pages\ManageCategories::route('/'),
        ];
    }
}
