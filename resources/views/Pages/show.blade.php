@extends('layouts.app')

@section('content')
    <div class="text-center" id="spinner">
        <div class="spinner-border text-pokemon-red" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="d-none" id="main-content">
        <div class="row">
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
                    <div class="input-group shadow-sm">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">
                            <img src="https://img.icons8.com/material-outlined/24/000000/search--v1.png"/>
                          </span>
                        </div>
                        <input type="search" name="name" id="name" placeholder="Buscar pokémon. Ej: bulbasaur"
                            class="form-control">
                    </div>
                </form>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-4">
                <h5 class="text-capitalize text-center text-white bg-dark rounded py-2">
                    {{ $pokemon['name'] }}
                </h5>
                <div class="card shadow bg-light">
                    <img src="{{ $pokemon['image'] }}"
                        class="card-img-top px-4" alt="{{ $pokemon['name'] }} image">
                </div>

                <hr class="d-md-none">
            </div>

            <div class="col-md-8">
                <h5 class="text-capitalize text-center text-white bg-dark rounded py-2">
                    datos generales
                </h5>

                <div class="card bg-light rounded shadow pt-2">
                    <div class="card-body">
                        <div class="d-flex mb-3 mt-1">
                            <span class="text-dark font-weight-bold" style="width: 200px;">
                                Tipo(s)
                            </span>
                            <span>
                                @foreach ($pokemon['types'] as $p)
                                    <span class="badge {{ $p['type']['name'] }} px-2 py-1 text-capitalize">
                                        {{ $p['type']['name'] }}
                                    </span>
                                @endforeach
                            </span>
                        </div>

                        <div class="d-flex mb-3">
                            <span class="text-dark font-weight-bold" style="width: 200px;">
                                Altura
                            </span>
                            <span class="card-text">
                                {{ $pokemon['height'] }}
                            </span>
                        </div>

                        <div class="d-flex mb-3">
                            <span class="text-dark font-weight-bold" style="width: 200px;">
                                Peso
                            </span>
                            <span class="card-text">
                                {{ $pokemon['weight'] }}
                            </span>
                        </div>

                        <div class="d-flex mb-3">
                            <span class="text-dark font-weight-bold" style="width: 200px;">
                                Experiencia Base
                            </span>
                            <span class="card-text">
                                {{ $pokemon['base_experience'] }}
                            </span>
                        </div>

                        <div class="d-flex mb-3">
                            <span class="text-dark font-weight-bold" style="width: 200px;">
                                Habilidad(es)
                            </span>
                            <span class="card-text text-capitalize">
                                @foreach ($pokemon['abilities'] as $ability)
                                    {{ $ability }}
                                    @if (!$loop->last)
                                     |
                                    @endif
                                @endforeach
                            </span>
                        </div>
                        <div class="d-flex mb-3">
                            <span class="text-dark font-weight-bold" style="width: 200px;">
                                Item(s)
                            </span>
                            <span class="card-text text-capitalize">
                                @forelse ($pokemon['items'] as $item)
                                    {{ $item }}
                                    @if (!$loop->last)
                                     |
                                    @endif
                                @empty
                                    <span>Sin items</span>
                                @endforelse
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-4">
                <h5 class="text-capitalize text-center text-white bg-dark rounded py-2">
                    sprites
                </h5>

                <div class="card bg-light rounded shadow font-weight-bold py-1">
                    <div class="d-flex justify-content-around">
                        <div>
                            <img src="{{ $pokemon['sprites']['back_default'] }}" alt="{{ $pokemon['name']  }}'s sprite"
                                class="d-block mx-auto">
                            <p class="text-center">Back</p>
                        </div>
                        <div>
                            <img src="{{ $pokemon['sprites']['back_shiny'] }}" alt="{{ $pokemon['name']  }}'s sprite"
                                class="d-block mx-auto">
                            <p class="text-center">Back Shiny</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around">
                        <div>
                            <img src="{{ $pokemon['sprites']['front_default'] }}" alt="{{ $pokemon['name']  }}'s sprite"
                                class="d-block mx-auto">
                            <p class="text-center">Front</p>
                        </div>
                        <div>
                            <img src="{{ $pokemon['sprites']['front_shiny'] }}" alt="{{ $pokemon['name']  }}'s sprite"
                                class="d-block mx-auto">
                            <p class="text-center">Front Shiny</p>
                        </div>
                    </div>
                </div>

                <hr class="d-md-none">
            </div>

            <div class="col-md-8">
                <h5 class="text-capitalize text-center text-white bg-dark rounded py-2">
                    estadísticas
                </h5>

                <div class="card bg-light rounded shadow">
                    {{-- $stat['stat']['name'] --}}
                    <div class="card-body">
                        @foreach ($pokemon['stats'] as $stat)
                            <div class="d-flex">
                                <p class="text-dark text-capitalize font-weight-bold" style="width: 200px;">{{ $stat['name'] }}</p>
                                <div class="progress font-weight-bold text-capitalize" style="height: 20px; width:100%;">
                                    <div class="progress-bar bg-pokemon-red" role="progressbar" style="width: {{ $stat['percentage'] }}%"
                                        aria-valuenow="{{ $stat['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ $stat['value'] }} {{-- / 150 --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a class="btn btn-sm bg-pokemon-red text-white d-inline-flex align-items-center"
                href="/pokemon/{{ $pokemon['id'] - 1 }}" role="button">
                <img src="https://img.icons8.com/ios-glyphs/30/ffffff/long-arrow-left.png" class="mr-2" />
                Anterior
            </a>

            <a class="btn btn-sm bg-pokemon-red text-white d-inline-flex align-items-center"
                href="/pokemon/{{ $pokemon['id'] + 1 }}" role="button">
                Siguiente
                <img src="https://img.icons8.com/ios-glyphs/30/ffffff/long-arrow-right.png" class="ml-2" />
            </a>
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
