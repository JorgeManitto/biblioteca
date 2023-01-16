<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Book;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MultiSelect;
use Filament\Tables\Columns\ImageColumn;
use Closure;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Support\Str;


use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $recordTitleAttribute = 'titulo';
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationLabel = 'Libros';
    protected static ?string $navigationGroup = 'Administración de sitio';

    protected static ?string $title = 'Libros';
    protected static ?string $slug = 'libros';

    protected static ?string $modelLabel = 'Libros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('portada')->image()
                ->disk('local')
                ->directory('public/portada')
                ->label('Imagen de portada'),
                TextInput::make('titulo')->required(),
                TextInput::make('descripcion')->label('Descripción'),
                FileUpload::make('url')
                ->disk('local')
                ->directory('public/libros')
                ->acceptedFileTypes(['application/pdf'])
                ->label('Subir libro (*pdf)'),
                DatePicker::make('fecha_publicacion')->label('Fecha de Publicación')->displayFormat('d/m/Y'),
                Hidden::make('user_id')->default(auth()->id()),
                Select::make('estado')
                    ->options([
                        '1' => 'Pendiente',
                        '2' => 'Publicado',
                    ])->required(),
                MultiSelect::make('category')
                ->label('Categorias')
                ->relationship('categories', 'titulo')
                ->createOptionForm([
                TextInput::make('titulo')->required(),
                Select::make('estado')
                    ->options([
                        '1' => 'Pendiente',
                        '2' => 'Publicado',
                    ])->required()
                ])
                ->searchable()
                ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('portada')->disk('local')->width(200)->height(300),
                Tables\Columns\TextColumn::make('titulo')->searchable(),
                BadgeColumn::make('estado')
                ->enum([
                    "1" => 'Pendiente',
                    "2" => 'Publicado',
                ]),
            ])
            ->defaultSort('id','desc')
            ->filters([
                Filter::make('created_at')
                ->form([
                    Forms\Components\DatePicker::make("created_from")->label('Fecha inicial') ->format('Y-m-d G:i:s')
                    ->displayFormat('Y-m-d G:i:s'),
                    Forms\Components\DatePicker::make("created_until")->label('Fecha final')->default(now()) ->format('Y-m-d G:i:s')
                    ->displayFormat('Y-m-d G:i:s'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                })
                ,
                SelectFilter::make('estado')
                ->options([
                    "1" => 'Pendiente',
                    "2" => 'Publicado',
                ]),
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
            'index' => Pages\ManageBooks::route('/'),
        ];
    }
}
