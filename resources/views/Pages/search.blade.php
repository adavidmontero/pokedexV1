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
                <x-pokemon-card :pokemon="$pokemon" :collectionPokemons="$collectionPokemons" />
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
