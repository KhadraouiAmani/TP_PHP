<?php
include_once 'classes/AttackPokemon.php';
include_once 'classes/Pokemon.php';
include_once 'classes/PokemonFeu.php';
include_once 'classes/PokemonEau.php';
include_once 'classes/PokemonPlante.php';
include_once 'battle.php';

$p1 = new PokemonFeu("Dracaufeu Gigamax", "images/charizard.png", 200, new AttackPokemon(10, 100, 2, 20));
$p2 = new PokemonPlante("Florizarre", "images/venusaur.png", 200, new AttackPokemon(30, 80, 4, 20));

$result = simulateBattle($p1, $p2);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pokémon Battle</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Les combattants</h1>
    
    <!-- Initial fighters display -->
    <div class="fighters-display">
        <div class="fighter">
            <img src="<?= $result['initial']['p1']['img'] ?>" class="pokemon-img">
            <h2><?= $result['initial']['p1']['name'] ?></h2>
            <p>Points : <?= $result['initial']['p1']['hp'] ?></p>
            <p>Min Attack Points : <?= $result['initial']['p1']['min_attack'] ?></p>
            <p>Max Attack Points : <?= $result['initial']['p1']['max_attack'] ?></p>
            <p>Special Attack : <?= $result['initial']['p1']['special_attack'] ?></p>
            <p>Probability Special Attack : <?= $result['initial']['p1']['special_prob'] ?></p>
        </div>

        <div class="fighter">
            <img src="<?= $result['initial']['p2']['img'] ?>" class="pokemon-img">
            <h2><?= $result['initial']['p2']['name'] ?></h2>
            <p>Points : <?= $result['initial']['p2']['hp'] ?></p>
            <p>Min Attack Points : <?= $result['initial']['p2']['min_attack'] ?></p>
            <p>Max Attack Points : <?= $result['initial']['p2']['max_attack'] ?></p>
            <p>Special Attack : <?= $result['initial']['p2']['special_attack'] ?></p>
            <p>Probability Special Attack : <?= $result['initial']['p2']['special_prob'] ?></p>
        </div>
    </div>

    <!-- Rounds display -->
    <?php foreach ($result['rounds'] as $round): ?>
    <div class="round">
        <h2>Round <?= $round['number'] ?></h2>
        <table class="damage-table">
            <tr>
                <td><?= $round['damage1'] ?></td>
                <td><?= $round['damage2'] ?></td>
            </tr>
        </table>
        
        <div class="fighters-display">
            <div class="fighter">
                <img src="<?= $round['p1']['img'] ?>" class="pokemon-img">
                <h2><?= $round['p1']['name'] ?></h2>
                <p>Points : <?= $round['p1']['hp'] ?></p>
                <p>Min Attack Points : <?= $round['p1']['min_attack'] ?></p>
                <p>Max Attack Points : <?= $round['p1']['max_attack'] ?></p>
                <p>Special Attack : <?= $round['p1']['special_attack'] ?></p>
                <p>Probability Special Attack : <?= $round['p1']['special_prob'] ?></p>
            </div>

            <div class="fighter">
                <img src="<?= $round['p2']['img'] ?>" class="pokemon-img">
                <h2><?= $round['p2']['name'] ?></h2>
                <p>Points : <?= $round['p2']['hp'] ?></p>
                <p>Min Attack Points : <?= $round['p2']['min_attack'] ?></p>
                <p>Max Attack Points : <?= $round['p2']['max_attack'] ?></p>
                <p>Special Attack : <?= $round['p2']['special_attack'] ?></p>
                <p>Probability Special Attack : <?= $round['p2']['special_prob'] ?></p>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <div class="winner">
        Le vainqueur est : <?= $result['winner']['name'] ?> !
    </div>
</body>
</html>