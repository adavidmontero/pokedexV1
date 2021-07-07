<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;

class PokemonViewModel extends ViewModel
{
    public function __construct($pokemon)
    {
        $this->pokemon = $pokemon;
    }

    public function pokemon()
    {
        $pokemon = collect($this->pokemon)->merge([
            'height' => ($this->pokemon['height'] / 10) . ' m',
            'image' => $this->pokemon['sprites']['other']['official-artwork']['front_default'],
            'types' => $this->pokemon['types'],
            'weight' => ($this->pokemon['weight'] / 10) . ' kg',
            'stats' => $this->calculateStats($this->pokemon['stats']),
        ]);

        //dd($pokemon);

        return $pokemon;
    }

    public function calculateStats($stats)
    {
        $statsFormatted = [];

        foreach ($stats as $stat) {
            $statsFormatted[$stat['stat']['name']]['percentage'] = ($stat['base_stat'] * 100) / 150;
            $statsFormatted[$stat['stat']['name']]['value'] = $stat['base_stat'];
        }

        return $statsFormatted;
    }
}
