<?php
function simulateBattle($p1, $p2) {
    $rounds = [];
    $roundNumber = 1;

    // Store initial state
    $initial = [
        'p1' => $p1->whoAmI(),
        'p2' => $p2->whoAmI()
    ];

    while (!$p1->isDead() && !$p2->isDead()) {
        $damage1 = $p1->attack($p2);
        $damage2 = $p2->attack($p1);

        $rounds[] = [
            'number' => $roundNumber,
            'damage1' => $damage1,
            'damage2' => $damage2,
            'p1' => $p1->whoAmI(),
            'p2' => $p2->whoAmI()
        ];
        $roundNumber++;
    }

    $winner = $p1->isDead() ? $p2 : $p1;

    return [
        'initial' => $initial,
        'rounds' => $rounds,
        'winner' => $winner->whoAmI()
    ];
}