<?php
include_once 'classes/Pokemon.php';

class PokemonPlante extends Pokemon {
    protected function getEffectiveness(Pokemon $enemy) {
        if ($enemy instanceof PokemonEau) return 2;
        if ($enemy instanceof PokemonFeu || $enemy instanceof PokemonPlante) return 0.5;
        return 1;
    }
}
