@extends('layouts.app')

@section('content')
    <div class="row container-404">
        <div class="col-md-6 mb-4 mb-md-0">
            <img src="{{ asset('images/404.png') }}" class="img-fluid d-block mx-auto" />
        </div>

        <div class="col-md-6">
            <div class="jumbotron jumbotron-fluid shadow border rounded text-center">
                <div class="container">
                    <h1 class="display-5">Pokémon no encontrado</h1>
                    <p class="lead">
                        Al parecer no contamos con los registros de ese pokémon. Para regresar
                        a donde estabas da click en el link de abajo:
                    </p>
                    <a class="lead text-decoration-none text-pokemon-red" href="{{ url()->previous() }}">
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
