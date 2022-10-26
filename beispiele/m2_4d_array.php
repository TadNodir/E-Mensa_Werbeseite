/**
* Praktikum DBWT. Autoren:
* Daniel, Winata, 3525700
* Nodirjon, Tadjiev, 3527449
*/
<?php
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

function noWinner($arr): array
{
    $years = [];
    foreach ($arr as $item) {
        if (is_array($item['winner'])) {
            foreach ($item['winner'] as $year) {
                $years[] = $year;
            }
        } else {
            $years[] = $item['winner'];
        }
    }
    $allYears = range(2000, 2022);

    return array_diff($allYears, $years);
}

?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Mensa</title>

    <style>
        li {
            margin-top: 10px;
            padding-left: 5px;
        }
    </style>
</head>

<form method="get">
    <ol>
        <?php
        foreach ($famousMeals as $meal) {
            echo "<li>" . $meal['name'] . "</li>";
            if (is_array($meal['winner'])) {
                rsort($meal['winner']);
                foreach ($meal['winner'] as $oneMeal) {
                    if (end($meal['winner']) == $oneMeal) {
                        echo $oneMeal;
                        continue;
                    }
                    echo $oneMeal . ", ";
                }
            } else {
                echo $meal['winner'];
            }
        }
        ?>
    </ol>
    <p> Keine Gewinner zwischen Jahren 2000 und 2022 gab es in Jahren:
        <?php
        $noWinnerYears = noWinner($famousMeals);
        foreach ($noWinnerYears as $value) {
            echo "<br>" . $value;
        }
        ?>
    </p>
</form>
