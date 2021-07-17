@extends('layouts.app')

@section('content')
    <div class="text-center" id="spinner">
        <div class="spinner-border text-pokemon-red" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="d-none" id="main-content">
        <div class="jumbotron jumbotron-fluid">
            <div class="container text-center">
                <form action="{{ route('page.search') }}">
                    <h1 class="display-4">Bienvenido(a) a la Laravel Pokédex</h1>
                    <p class="lead">En esta aplicación podrás visualizar la información de cualquier pokémon. Lets do it!</p>
                    <input type="search" name="name" id="name" placeholder="Nombre del Pokémon. Ej: bulbasaur"
                        class="form-control w-50 mx-auto @error('name') is-invalid @enderror">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </form>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
            @foreach ($pokemons as $pokemon)
                <x-pokemon-card :pokemon="$pokemon" :collectionPokemons="$collectionPokemons" />
            @endforeach
        </div>
        <div class="page-load-status my-8">
            <div class="d-flex justify-content-center">
                {{-- <p class="infinite-scroll-request spinner my-8 text-4xl">&nbsp;</p> --}}
                <div class="infinite-scroll-request spinner-border text-pokemon-red" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                {{-- <p class="infinite-scroll-last">Fin del contenido</p> --}}
                <div class="infinite-scroll-last">
                    <img src="{{ asset('images/pikachu.jpg') }}" class="d-block mx-auto rounded rounded-3 shadow border border-light"
                        width="200" height="200" alt="pikachu llorando">
                    <div class="alert alert-dark shadow mt-4" role="alert">
                        ¡Ooops...! Parece que Nintendo no ha sacado más generaciones.
                    </div>
                </div>
                <div class="infinite-scroll-error">
                    <img src="{{ asset('images/rocket.png') }}" class="d-block mx-auto rounded rounded-3 shadow border border-light"
                        width="200" height="200" alt="equipo rocket">
                    <div class="infinite-scroll-error alert alert-danger mt-4" role="alert">
                        ¡Houston tenemos un problema!
                    </div>
                </div>
                {{-- <p class="infinite-scroll-error">Error</p> --}}
            </div>
        </div>
        <!-- Paginación -->
        {{-- <div class="d-flex justify-content-between">
            <a href="/offset/{{ $previous }}" class="p-2 border text-decoration-none bg-light">Anterior</a>
            <a href="/offset/{{ $next }}" class="py-2 px-4 border text-decoration-none bg-light">Siguiente</a>
        </div> --}}
    </div>

@endsection

@section('scripts')
    <script src="https://unpkg.com/infinite-scroll@4/dist/infinite-scroll.pkgd.min.js"></script>
    <script>
        window.addEventListener('load', () => {

            //setTimeout(loading, 1000);

            loading();

            function loading() {
                document.querySelector('#spinner').className = 'd-none';
                document.querySelector('#main-content').className = 'd-block';
            }
        });

        let elem = document.querySelector('.row');
        let infScroll = new InfiniteScroll( elem, {
            // options
            path: '/page/@{{#}}',
            append: '.col',
            status: '.page-load-status'
            //history: false,
        });
    </script>
@endsection
