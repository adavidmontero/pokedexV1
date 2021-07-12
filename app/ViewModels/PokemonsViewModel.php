<?php

namespace App\ViewModels;

use Illuminate\Support\Str;
use Spatie\ViewModels\ViewModel;

class PokemonsViewModel extends ViewModel
{
    public function __construct($page, $pokemons, $responses)
    {
        $this->page = $page;
        $this->pokemons = $pokemons;
        $this->responses = $responses;
    }

    public function previous()
    {
        return $this->page > 0 ? $this->page - 1 : null;
    }

    public function next()
    {
        return $this->page < 139 ? $this->page + 1 : null;
    }

    public function collectionPokemons()
    {
        $collectionPokemon = collect([]);

        foreach ($this->pokemons as $pokemon) {
            $jsonObject = json_decode($this->responses[$pokemon['name']]['value']->getBody()->getContents());

            $collectionPokemon->prepend(
                collect(), $pokemon['name']
            );

            $collectionPokemon[$pokemon['name']] = $collectionPokemon[$pokemon['name']]->merge([
                'image' => $jsonObject->sprites->other->{'official-artwork'}->front_default,
                'height' => ($jsonObject->height / 10) . ' m',
                'types' => $jsonObject->types,
                'weight' => ($jsonObject->weight / 10) . ' kg',
                'name_f' => Str::replace('-', ' ', $pokemon['name'])
            ]);
        }

        return $collectionPokemon;
    }

    public function pokemons()
    {
        return $this->pokemons;
    }
}
