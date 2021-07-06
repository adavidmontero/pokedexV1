<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;

class PokemonsViewModel extends ViewModel
{
    public function __construct($offset, $pokemons, $responses)
    {
        $this->offset = $offset;
        $this->pokemons = $pokemons;
        $this->responses = $responses;
    }

    public function previous()
    {
        return $this->offset > 0 ? $this->offset - 1 : null;
    }

    public function next()
    {
        return $this->offset < 139 ? $this->offset + 1 : null;
    }

    public function collectionPokemons()
    {
        $collectionPokemon = collect([]);

        foreach ($this->pokemons as $pokemon) {
            $jsonObject = json_decode($this->responses[$pokemon['name']]['value']->getBody()->getContents());

            //dd($jsonObject);

            $collectionPokemon->prepend(
                collect(), $pokemon['name']
            );

            $collectionPokemon[$pokemon['name']] = $collectionPokemon[$pokemon['name']]->merge([
                'image' => $jsonObject->sprites->other->{'official-artwork'}->front_default,
                'height' => ($jsonObject->height / 10) . ' m',
                'types' => $jsonObject->types,
                'weight' => ($jsonObject->weight / 10) . ' kg',
            ]);
        }

        //dd($collectionPokemon);
        return $collectionPokemon;
    }

    public function pokemons()
    {
        return $this->pokemons;
    }

    /* public function formatType($types)
    {
        foreach ($types as $t) {
            $t->type->class = $t->type->name;
        }

        return $types;
    } */
}
