<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\ViewModels\PokemonViewModel;
use Illuminate\Support\Facades\Http;
use App\ViewModels\PokemonsViewModel;

class PageController extends Controller
{
    public function index($offset = 1)
    {
        if ($offset === 1) {
            $offset = 0;
        } else {
            $offset -= 1;
            $offset *= 8;
        }

        $pokemons = Http::get('https://pokeapi.co/api/v2/pokemon?offset=' . $offset . '&limit=8')->json()['results'];

        $client = new Client(['base_uri' => 'https://pokeapi.co/']);

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

        $viewModel = new PokemonsViewModel($offset, $pokemons, $responses);

        return view('pages.index', $viewModel);
    }

    public function show($name)
    {
        $pokemon = Http::get('https://pokeapi.co/api/v2/pokemon/' . $name)->json();

        if (!$pokemon) {
            return view('404');
        }

        $viewModel = new PokemonViewModel($pokemon);

        return view('pages.show', $viewModel);
    }

    public function search(Request $request)
    {
        $name = Str::lower($request->get('name'));

        return $this->show($name);
    }
}
