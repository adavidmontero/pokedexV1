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
            'abilities' => $this->calculateAbilities($this->pokemon['abilities']),
            'items' => $this->calculateItems($this->pokemon['held_items'])
        ])->except(['game_indices', 'location_area_encounters', 'order', 'moves']);

        //dd($pokemon);

        return $pokemon;
    }

    public function calculateStats($stats)
    {
        $statsFormatted = [];

        foreach ($stats as $stat) {
            $statsFormatted[$stat['stat']['name']]['percentage'] = ($stat['base_stat'] * 100) / 150;
            $statsFormatted[$stat['stat']['name']]['value'] = $stat['base_stat'];
            $statsFormatted[$stat['stat']['name']]['name'] = str_replace('-', ' ', $stat['stat']['name']);
        }

        //dd($statsFormatted);

        return $statsFormatted;
    }

    public function calculateAbilities($abilities)
    {
        $abilitiesFormatted = [];

        foreach ($abilities as $ability) {
            array_push($abilitiesFormatted, str_replace('-', ' ', $ability['ability']['name']));
        }

        return $abilitiesFormatted;
    }

    public function calculateItems($items)
    {
        $itemsFormatted = [];

        foreach ($items as $item) {
            array_push($itemsFormatted, str_replace('-', ' ', $item['item']['name']));
        }

        return $itemsFormatted;
    }
}
