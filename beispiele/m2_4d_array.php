<?php
/**
 * Praktikum DBWT. Autoren:
 * Daniel, Winata, 3525700
 * Nodirjon, Tadjiev, 3527449
 */

$famousMeals = [
    1 => ['name' => 'Currywurst mit Pommes',
        'winner' => [2001, 2003, 2007, 2010, 2020]],
    2 => ['name' => 'Hähnchencrossies mit Paprikareis',
        'winner' => [2002, 2004, 2008]],
    3 => ['name' => 'Spaghetti Bolognese',
        'winner' => [2011, 2012, 2017]],
    4 => ['name' => 'Jägerschnitzel mit Pommes',
        'winner' => 2019]
];

function reverseWinner(array $winner) : array {
    $newWinner = [];
    $len = count($winner);
    for($i= $len - 1; $i >= 0; $i--) {
        $newWinner[] = $winner[$i];
    }
    return $newWinner;
}

function findLoser(array $famousMeals) : array {
    $loser = [];
    for($i = 2000; $i < 2023; $i++) {
        $loser[$i] = $i;
    }
    foreach ($famousMeals as $meal) {
        if (is_array($meal['winner'])) {
            foreach ($meal['winner'] as $year) {
                if (in_array($year, $loser)) {
                    unset($loser[$year]);
                }
            }
        } else {
            if (in_array($meal['winner'], $loser)) {
                unset($loser[$meal['winner']]);
            }
        }
    }
    return $loser;
}

echo "<ol>";
foreach ($famousMeals as $meal) {
    echo "<li style='margin-top: 10px; padding-left: 5px;'>" . $meal['name'] ;
    if (is_array($meal['winner']) == 1) {
        //print_r($meal['winner']);
        $meal['winner'] = reverseWinner($meal['winner']);
        //print_r($meal['winner']);
        echo "<br>".implode(', ', $meal['winner']). "</li>";
    } else {
        echo "<br>".$meal['winner'] . "</li>";
    }
}
echo "</ol>";
echo "<div> Loser : ". implode(', ', findLoser($famousMeals)) ."</div>";
