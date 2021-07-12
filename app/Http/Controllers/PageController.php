<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\ViewModels\PokemonViewModel;
use Illuminate\Support\Facades\Http;
use App\ViewModels\PokemonsViewModel;

class PageController extends Controller
{
    public function index($page = 1)
    {
        if ($page === 1) {
            $page = 0;
        } else {
            $page -= 1;
            $page *= 8;
        }

        $client = new Client(['base_uri' => 'https://pokeapi.co/']);

        //$pokemons = Http::get('https://pokeapi.co/api/v2/pokemon?offset=' . $offset . '&limit=8')->json()['results'];
        $request = new \GuzzleHttp\Psr7\Request('GET', 'https://pokeapi.co/api/v2/pokemon?offset=' . $page . '&limit=8');

        $promise = $client->sendAsync($request)->then(function ($response) {
            return $response->getBody()->getContents();
        });

        $pokemons = json_decode($promise->wait(), true)['results'];

        // Initiate each request but do not block
        $promises = [];

        foreach ($pokemons as $pokemon) {
            $promises[$pokemon['name']] = $client->getAsync('/api/v2/pokemon/' . $pokemon['name']);
        }

        // Wait for the requests to complete; throws a ConnectException
        // if any of the requests fail
        $responses = Promise\Utils::unwrap($promises);

        // You can access each response using the key of the promise
        /* echo $responses['image']->getHeader('Content-Length')[0];
        echo $responses['png']->getHeader('Content-Length')[0]; */

        // Wait for the requests to complete, even if some of them fail
        $responses = Promise\Utils::settle($promises)->wait();

        $viewModel = new PokemonsViewModel($page, $pokemons, $responses);

        return view('pages.index', $viewModel);
    }

    public function show($name)
    {
        //$pokemon = Http::get('https://pokeapi.co/api/v2/pokemon/' . $name)->json();

        $client = new Client();

        $request = new \GuzzleHttp\Psr7\Request('GET', 'https://pokeapi.co/api/v2/pokemon/' . $name);

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

        $viewModel = new PokemonsViewModel(1, $results, $responses);

        return view('pages.search', $viewModel, compact('name'));
    }
}
