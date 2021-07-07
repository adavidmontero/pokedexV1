@extends('layouts.app')

@section('content')
    <div class="text-center" id="spinner">
        <div class="spinner-border text-pokemon-red" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="d-none" id="main-content">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
            @foreach ($pokemons as $pokemon)
                <div class="col mb-4">
                    <div class="card shadow bg-light">
                        <img src="{{ $collectionPokemons[$pokemon['name']]['image'] }}"
                            class="card-img-top px-4" alt="{{ $pokemon['name'] }} image">

                        <div class="card-body">
                            <h5 class="card-title text-capitalize text-center bg-dark py-2">
                                <a href="{{ route('page.show', $pokemon['name']) }}" class="text-white text-decoration-none">
                                    {{ $pokemon['name'] }}
                                </a>
                            </h5>

                            <div class="text-center">
                                @foreach ($collectionPokemons[$pokemon['name']]['types'] as $p)
                                    <span class="badge {{ $p->type->name }} px-2 py-1 text-capitalize">
                                        {{ $p->type->name }}
                                    </span>
                                @endforeach
                            </div>

                            <hr>

                            <div class="d-flex justify-content-around align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="https://img.icons8.com/ios-glyphs/30/000000/height.png"/>
                                    <p class="card-text ml-2">
                                        {{ $collectionPokemons[$pokemon['name']]['height'] }}
                                    </p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <img src="https://img.icons8.com/ios/30/000000/weight.png"/>
                                    <p class="card-text ml-2">
                                        {{ $collectionPokemons[$pokemon['name']]['weight'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

            //setTimeout(loading, 2000);

            loading();

            function loading() {
                document.querySelector('#spinner').className = 'd-none';
                document.querySelector('#main-content').className = 'd-block';
            }
        });

        let elem = document.querySelector('.row');
        let infScroll = new InfiniteScroll( elem, {
            // options
            path: '/offset/@{{#}}',
            append: '.col',
            status: '.page-load-status'
            //history: false,
        });
    </script>
@endsection
