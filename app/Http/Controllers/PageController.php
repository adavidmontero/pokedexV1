<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\ViewModels\PokemonViewModel;
use App\ViewModels\PokemonsViewModel;

class PageController extends Controller
{
    public function index($page = 1)
    {
        //Establecemos el número de pokemons por página, por ahora de manera estática
        //Se podría pedir al usuario el número de pokemons por página
        $limit = 9;

        //Controlamos las páginas de acuerdo a como esta compuesta la API
        if ($page === 1) {
            $page = 0;
            $count = 1;
        } else {
            $page -= 1;
            $page *= $limit;
            $count = $page + 1;
        }

        //Creamos una instancia de la clase Client con dirección url base de la API
        $client = new Client(['base_uri' => 'https://pokeapi.co/']);

        //Creamos un array que contendrá todas las peticiones que haremos de manera asíncrona
        //El primer elemento es una petición de todos los pokemons
        $promises = [
            0 => $client->getAsync('/api/v2/pokemon?offset=' . $page . '&limit=' . $limit)
        ];

        //Agregamos las peticiones individuales de cada pokemon mediante un for
        for ($i = $count; $i < $count + $limit; $i++) {
            $promises[$i] = $client->getAsync('/api/v2/pokemon/' . $i);
        }

        //Espera que cada una de las peticiones sean completadas, arroja un excepción de conexión
        //si falla alguna de las solicitudes
        $responses = Promise\Utils::unwrap($promises);

        //Espera que cada una de las peticiones sean completadas, incluso si falla una
        $responses = Promise\Utils::settle($promises)->wait();

        //Obtiene los pokemons de la primera petición y las almacena en un array
        $arrayP = json_decode($responses[0]['value']->getBody()->getContents(), true)['results'];

        //Inicializamos el arreglo de pokemons
        $pokemons = [];

        //Utilizamos el for con dos variables inicializadas, para relaccionar la respuesta con el array
        //anterior de todos los pokemons
        for ($i = $count, $j = 0; $i < $count + $limit; $i++, $j++) {
            $pokemons[$i] = $arrayP[$j];
        }

        //Mandamos al viewmodel la variable para la paginación, el array general de pokemons,
        //la respuesta con los pokemons individualizados y el nombre del metodo para diferenciarlo
        $viewModel = new PokemonsViewModel($page, $pokemons, $responses, 'index');

        //Enviamos a la vista todo lo que se retorne en el viewModel
        return view('pages.index', $viewModel);
    }

    public function show($id)
    {
        //$pokemon = Http::get('https://pokeapi.co/api/v2/pokemon/' . $name)->json();

        $client = new Client();

        $request = new \GuzzleHttp\Psr7\Request('GET', 'https://pokeapi.co/api/v2/pokemon/' . $id);

        $promise = $client->sendAsync($request)->then(function ($response) {
            return $response->getBody()->getContents();
        });

        try {
            $pokemon = json_decode($promise->wait(), true);
            $viewModel = new PokemonViewModel($pokemon);

            return view('pages.show', $viewModel);
        } catch (Exception $e){
            if ($e->getCode() === 404) return view('errors.404');
        }
    }

    public function search(Request $request)
    {
        $request->validate([
            'name' => 'min:3'
        ]);

        $name = Str::lower($request->get('name'));

        $client = new Client(['base_uri' => 'https://pokeapi.co/']);

        $request = new \GuzzleHttp\Psr7\Request('GET', 'https://pokeapi.co/api/v2/pokemon/?offset=0&limit=1118');

        $promise = $client->sendAsync($request)->then(function ($response) {
            return $response->getBody()->getContents();
        });

        $pokemons = json_decode($promise->wait(), true)['results'];

        $results = collect($pokemons)->filter(function ($pokemon) use ($name) {
            return Str::contains($pokemon['name'], $name);
        });

        $promises = [];

        foreach ($results as $pokemon) {
            $promises[$pokemon['name']] = $client->getAsync('/api/v2/pokemon/' . $pokemon['name']);
        }

        $responses = Promise\Utils::unwrap($promises);

        $responses = Promise\Utils::settle($promises)->wait();

        $viewModel = new PokemonsViewModel(1, $results, $responses, 'search');

        return view('pages.search', $viewModel, compact('name'));
    }
}
