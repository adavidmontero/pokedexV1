@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
        </div>

        <div class="col-md-8">
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

                <div class="card-body">
                    <div class="text-center">
                        @foreach ($pokemon['types'] as $p)
                            <span class="badge {{ $p['type']['name'] }} px-2 py-1 text-capitalize">
                                {{ $p['type']['name'] }}
                            </span>
                        @endforeach
                    </div>

                    <hr>

                    <div class="d-flex justify-content-around align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="https://img.icons8.com/ios-glyphs/30/000000/height.png"/>
                            <p class="card-text ml-2">
                                {{ $pokemon['height'] }}
                            </p>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="https://img.icons8.com/ios/30/000000/weight.png"/>
                            <p class="card-text ml-2">
                                {{ $pokemon['weight'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="d-md-none">
        </div>
        <div class="col-md-8">
            <h5 class="text-capitalize text-center text-white bg-dark rounded py-2">
                sprites
            </h5>
            <div class="card bg-light rounded shadow">
                <div class="row row-cols-2 row-cols-lg-4 font-weight-bold text-pokemon-blue">
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

            <hr>

            <h5 class="text-capitalize text-center text-white bg-dark rounded py-2">
                estadísticas
            </h5>

            <div class="card bg-light rounded shadow py-2">
                {{-- $stat['stat']['name'] --}}
                <div class="car-body px-4 pt-2">
                    @foreach ($pokemon['stats'] as $key => $stat)
                        <div class="progress font-weight-bold text-capitalize mb-2" style="height: 20px;">
                            <div class="progress-bar bg-pokemon-red" role="progressbar" style="width: {{ $stat['percentage'] }}%"
                                aria-valuenow="{{ $stat['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $key }}  {{ $stat['value'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
