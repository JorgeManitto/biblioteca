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
            if($this->categoriaFilter[0] != 0){
                $query->join('book_category', 'books.id', '=', 'book_category.books_id')
                ->whereRaw('FIND_IN_SET('.$this->categoriaFilter.',book_category.category_id)')
                ->select('books.*', 'book_category.category_id')->distinct();
            }
        })
        ->when($this->ordenFilter,function($query)
        {
            $query ->orderBy('id', $this->ordenFilter);
        })
        ->where('estado',2)
        ->paginate(12);


        return view('livewire.show-books',compact('books', 'categories'));
    }
}
