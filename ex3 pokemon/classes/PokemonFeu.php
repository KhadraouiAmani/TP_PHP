<?php
include_once 'classes/Pokemon.php';

class PokemonFeu extends Pokemon {
    protected function getEffectiveness(Pokemon $enemy) {
        if ($enemy instanceof PokemonPlante) return 2;
        if ($enemy instanceof PokemonFeu || $enemy instanceof PokemonEau) return 0.5;
        return 1;
    }
}
