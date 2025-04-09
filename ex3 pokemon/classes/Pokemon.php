<?php
include_once 'AttackPokemon.php';

class Pokemon {
    protected $name;
    protected $url;
    protected $hp;
    protected $attackPokemon;

    public function __construct($name, $url, $hp, $attackPokemon) {
        $this->name = $name;
        $this->url = $url;
        $this->hp = $hp;
        $this->attackPokemon = $attackPokemon;
    }

    public function getHp() {
        return $this->hp;
    }

    public function isDead() {
        return $this->hp <= 0;
    }

    public function whoAmI() {
        return [
            'name' => $this->name,
            'img' => $this->url,
            'hp' => $this->hp,
            'min_attack' => $this->attackPokemon->attackMinimal,
            'max_attack' => $this->attackPokemon->attackMaximal,
            'special_attack' => $this->attackPokemon->specialAttack,
            'special_prob' => $this->attackPokemon->probabilitySpecialAttack
        ];
    }

    protected function getEffectiveness(Pokemon $enemy) {
        return 1;
    }

    public function attack(Pokemon $enemy) {
        $isSpecial = rand(1, 100) <= $this->attackPokemon->probabilitySpecialAttack;
        $baseAttack = $this->attackPokemon->getRandomAttack();
        $damage = $isSpecial ? $baseAttack * $this->attackPokemon->specialAttack : $baseAttack;
        $damage *= $this->getEffectiveness($enemy);

        $enemy->hp -= $damage;
        return (int) $damage;
    }
}