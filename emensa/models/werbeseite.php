<?php
function db_kategorie_select_all() {
    $link = connectdb();

    $sql = "
            SELECT name, preis_intern, preis_extern FROM (
                SELECT * FROM gericht
                ORDER BY  RAND()
                LIMIT 5
            ) as gericht
            ORDER BY  name ASC
            LIMIT 5";

    $res_dishes = mysqli_query($link, $sql);

    if (!$res_dishes) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }

    mysqli_close($link);
    return $res_dishes;
}

function db_gericht_allergen_pair() {
    $link = connectdb();


    $sql = "SELECT name, GROUP_CONCAT(code) as allergen_codes, preis_intern, preis_extern
        FROM gericht_hat_allergen
        INNER JOIN gericht as gericht
        ON gericht_hat_allergen.gericht_id = gericht.id
        GROUP BY id
        LIMIT 5";

    $res_gericht_allergen_pair = mysqli_query($link, $sql);

    if (!$res_gericht_allergen_pair) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }

    mysqli_close($link);
    return $res_gericht_allergen_pair;
}
function db_allergen() {
    $link = connectdb();


    $sql = "SELECT DISTINCT code, name FROM allergen";

    $res_allergen = mysqli_query($link, $sql);

    if (!$res_allergen) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    };

    mysqli_close($link);
    return $res_allergen;
}


function db_anzahl_gerichte() {
    $link = connectdb();

    $sql = "SELECT DISTINCT COUNT(*) as anzahl FROM gericht";

    $res_anzahl_gerichte = mysqli_query($link, $sql);

    if (!$res_anzahl_gerichte) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    };;

    mysqli_close($link);
    return $res_anzahl_gerichte;
}
//function db_anzahl_newsletter() {
//    $link = connectdb();
//
//    $sql = "SELECT DISTINCT COUNT(*) as anzahl FROM newsletter";
//
//    $res_anzahl_newsletter = mysqli_query($link, $sql);
//
//    if (!$res_anzahl_newsletter) {
//        echo "Fehler während der Abfrage:  ", mysqli_error($link);
//        exit();
//    };
//
//    mysqli_close($link);
//    return $res_anzahl_newsletter ;
//}
function db_anzahl_besucher() {
    $link = connectdb();

    $sql = "SELECT DISTINCT COUNT(*) as anzahl FROM pages";

    $res_anzahl_besucher = mysqli_query($link, $sql);

    if (!$res_anzahl_besucher) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }

    mysqli_close($link);
    return $res_anzahl_besucher ;
}