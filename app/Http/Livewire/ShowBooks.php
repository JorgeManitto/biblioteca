<?php

namespace App\Http\Livewire;

use App\Models\book;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class ShowBooks extends Component
{
    use WithPagination;
    public $tituloFilter;
    public $categoriaFilter;
    public $yearFilter;
    public $formFilter;
    public $ordenFilter = 'desc';

    public function updatingTituloFilter()
    {
        $this->resetPage();
    }

    public function updatingCategoriaFilter()
    {
        $this->resetPage();
    }

    public function updatingYearFilter()
    {
        $this->resetPage();
    }

    public function updatingFormFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::where('estado',2)->orderBy('id', 'desc')->get();

        $books = book::query()
        ->when($this->tituloFilter,function($query){
            $query->where('titulo','like','%'.$this->tituloFilter.'%');
        })
        ->when($this->categoriaFilter, function ($query)
        {
           $query->join('book_category', 'books.id', '=', 'book_category.books_id')
           ->where('book_category.category_id',$this->categoriaFilter)
            ->select('books.*', 'book_category.category_id')->distinct();
        })
        ->when($this->ordenFilter,function($query)
        {
            $query ->orderBy('id', $this->ordenFilter);
        })
        ->paginate(12);


        return view('livewire.show-books',compact('books', 'categories'));
    }
}
