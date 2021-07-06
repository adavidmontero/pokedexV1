<?php

namespace App\Http\Controllers;

use App\ViewModels\PokemonsViewModel;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    public function index($offset = 0)
    {
        $offset *= 8;
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
}
