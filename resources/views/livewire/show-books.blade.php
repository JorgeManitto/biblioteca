<div >

    <div class="sm:flex">
        <nav class="sm:w-1/4  p-2">
            <form wire:submit.prevent ="formFilter">
                <div>
                    <label class="text-black font-bold mb-2 block" for="search">Titulo</label>
                    <input class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md py-2  shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="Busqueda por titulo..." wire:model="tituloFilter" type="text" id="search" name="search"/>
                </div>
              <div>
                <label class="text-black font-bold mb-2 block" for="categoria">Categorías</label>
                <select style="height: 16rem;" multiple wire:model="categoriaFilter" class="form-input w-full border border-slate-300 rounded-md" id="categoria">
                    <option value="">Todas</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->titulo}}</option>
                    @endforeach
                </select>
              </div>

              <div>
                <label class="text-black font-bold mb-2 block" for="orden">Orden</label>
                <select wire:model="ordenFilter" class="form-input w-full border border-slate-300 rounded-md" id="orden">
                    <option value="desc">Subidos recientemente</option>
                    <option value="asc">Anteriores</option>
                </select>
              </div>

                {{-- <div class="w-full">
                    <label class="text-black font-bold mb-2 block" for="fecha">Año</label>
                    <input class="form-input mb-4 w-full border border-slate-300 rounded-md " type="number" min="1900" max="2099" step="1" value="2016" />
                </div>

                <button class="bg-gray-800  hover:bg-gray-400 text-gray-200 font-bold py-2 px-4 rounded w-full items-center" type="submit">Buscar</button> --}}
            </form>
        </nav>

        <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 p-2 justify-items-center" style="grid-gap: 20px;">
            @foreach ($books as $book)
                @if (!$book)
                    No hay libros para mostrar.
                @endif
                @php
                $imagen = 'https://placehold.jp/3d4070/ffffff/300x200.png?text=Imagen%20no%20disponible';
                if($book->portada){
                    $imagen= str_replace('public/', '', $book->portada);
                    $imagen = asset('storage/'.$imagen);
                }
                @endphp
                <a href="{{ route('show', $book->id) }}">
                    <div class="w-full mb-2 rounded overflow-hidden shadow-lg">
                        <img style="height: 380px;object-fit: cover;" class="w-full" src="{{$imagen}}" alt="book">
                        <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2">{{$book->titulo}}</div>
                        <p style="display: -webkit-box;-webkit-line-clamp: 3;-webkit-box-orient: vertical;overflow: hidden;" class="text-gray-700 text-base">
                            {{$book->descripcion}}
                        </p>
                        </div>
                        <div class="px-6 pt-4 pb-2">
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{$book->fecha_publicacion}}</span>
                        </div>
                    </div>
                 </a>
            @endforeach
        </div>
    </div>
      <div class="p-2">
        {{$books->links()}}
      </div>


</div>
