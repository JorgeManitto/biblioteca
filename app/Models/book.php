<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book extends Model
{
    use HasFactory;

    protected $fillable = [
        'portada',
        'titulo',
        'descripcion',
        'url',
        'estado',
        'fecha_publicacion',
        'deleted_at',
        'user_id',
    ];

    public function categories()
    {
    return $this->belongsToMany(Category::class, 'book_category','books_id',);
    }
}
