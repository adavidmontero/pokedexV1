@extends('layouts.app')

@section('content')
    <div class="text-center" id="spinner">
        <div class="spinner-border text-pokemon-red" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="d-none" id="main-content">
        <div class="row pt-4">
            <div class="col-md-4">
                <a class="btn btn-sm bg-pokemon-blue text-white d-inline-flex align-items-center"
                    href="{{ url()->previous() }}" role="button">
                    <img src="https://img.icons8.com/office/30/000000/pokeball.png" class="mr-2"/>
                    Volver
                </a>
                <hr class="d-md-none">
            </div>
            <div class="col-md-8">
                <form action="{{ route('page.search') }}">
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">
                            <img src="https://img.icons8.com/material-outlined/24/000000/search--v1.png"/>
                          </span>
                        </div>
                        <input type="search" name="name" id="name" placeholder="Buscar pokémon. Ej: bulbasaur"
                            class="form-control shadow-sm @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
        </div>

        <hr>

        <h3>{{ $pokemons->count() }} resultados de la palabra
            <span class="text-pokemon-red">{{ $name }}</span>:
        </h3>

        <hr>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
            @foreach ($pokemons as $pokemon)
                <div class="col mb-4">
                    <div class="card shadow bg-light">
                        <img src="{{ $collectionPokemons[$pokemon['name']]['image'] }}"
                            class="card-img-top px-4" alt="{{ $pokemon['name'] }} image">

                        <div class="card-body">
                            <h5 class="card-title text-capitalize text-center bg-dark py-2">
                                <a href="{{ route('page.show', $pokemon['name']) }}" class="text-white text-decoration-none">
                                    {{ $collectionPokemons[$pokemon['name']]['name_f'] }}
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
    </div>

@endsection

@section('scripts')
    <script>
        window.addEventListener('load', () => {

            //setTimeout(loading, 2000);

            loading();

            function loading() {
                document.querySelector('#spinner').className = 'd-none';
                document.querySelector('#main-content').className = 'd-block';
            }
        });
    </script>
@endsection
