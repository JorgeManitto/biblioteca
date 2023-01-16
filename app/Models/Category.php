<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'titulo',
        'estado'
    ];


    public function books(){
        // return $this->belongsTo(book::class,'book_category');
        // return $this->belongsToMany('App\Models\Category', 'book_category', 'books_id', 'category_id');
        return $this->belongsToMany('App\Models\book', 'book_category', 'category_id', 'books_id');
    }
}
