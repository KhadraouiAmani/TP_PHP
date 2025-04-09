<?php
class AttackPokemon {
    public $attackMinimal;
    public $attackMaximal;
    public $specialAttack;
    public $probabilitySpecialAttack;

    public function __construct($min, $max, $special, $probability) {
        $this->attackMinimal = $min;
        $this->attackMaximal = $max;
        $this->specialAttack = $special;
        $this->probabilitySpecialAttack = $probability;
    }

    public function getRandomAttack() {
        return rand($this->attackMinimal, $this->attackMaximal);
    }
}