<?php
include_once 'classes/Pokemon.php';

class PokemonEau extends Pokemon {
    protected function getEffectiveness(Pokemon $enemy) {
        if ($enemy instanceof PokemonFeu) return 2;
        if ($enemy instanceof PokemonPlante || $enemy instanceof PokemonEau) return 0.5;
        return 1;
    }
}
