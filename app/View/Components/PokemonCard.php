<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PokemonCard extends Component
{
    public $pokemon;
    public $collectionPokemons;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($pokemon, $collectionPokemons)
    {
        $this->pokemon = $pokemon;
        $this->collectionPokemons = $collectionPokemons;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.pokemon-card');
    }
}
