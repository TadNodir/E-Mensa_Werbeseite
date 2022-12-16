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
    return $res_anzahl_besucher;
}


function verifyUser () {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $hashKeyPassword = sha1('saltbae' . $password);

            $link = connectdb();
            $sql = "SELECT * FROM benutzer WHERE email = '$email' AND passwort = '$hashKeyPassword'";

            $userData = mysqli_query($link, $sql);

            if (!$userData) {
                echo "Fehler während der Abfrage:  ", mysqli_error($link);
                exit();
            }
            $userInfoRow = mysqli_fetch_row($userData);

            mysqli_close($link);
            return !is_null($userInfoRow);
        }
    }
}

function incrementLoginAmount (): void
{
    $link = connectdb();

    $sql = "UPDATE benutzer SET anzahlanmeldungen = anzahlanmeldungen + 1";

    $increment = mysqli_query($link, $sql);

    if (!$increment) {
        echo "Fehler während der Abfrage: ", mysqli_error($link);
        exit();
    }

    mysqli_close($link);
}

function lastLoginDate (bool $success) {
    $link = connectdb();
    $name = loginName();
    if ($success) {
        $sql = "UPDATE benutzer SET letzteanmeldung = NOW() WHERE name = '$name'";
    } else {
        $sql = "UPDATE benutzer SET letzterfehler = NOW() WHERE name = '$name'";
    }

    $login = mysqli_query($link, $sql);

    if (!$login) {
        echo "Fehler während der Abfrage: ", mysqli_error($link);
        exit();
    }

    mysqli_close($link);
}

function incrementAndLastLogin (bool $success) {
    $link = connectdb();
    $name = loginName();

    $link->begin_transaction();
    try {

        if ($success) {
            $sql = "UPDATE benutzer SET anzahlanmeldungen = anzahlanmeldungen + 1";
            mysqli_query($link, $sql);
            $sql = "UPDATE benutzer SET letzteanmeldung = NOW() WHERE name = '$name[0]'";
        } else {
            $sql = "UPDATE benutzer SET letzterfehler = NOW()";
        }
        mysqli_query($link, $sql);
        $link->commit();

    } catch (mysqli_sql_exception $exception) {
        $link->rollback();
        throw $exception;
    }

    mysqli_close($link);
}

function loginName () {

    if(verifyUser()) {

        $link = connectdb();

        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $hashKeyPassword = sha1('saltbae' . $password);

        $sql = "SELECT name FROM benutzer WHERE email = '$email' AND passwort = '$hashKeyPassword'";

        $nameStatement = mysqli_query($link, $sql);

        $name = mysqli_fetch_row($nameStatement);

        if (!$name) {
            echo "Fehler während der Abfrage:  ", mysqli_error($link);
            exit();
        }

        mysqli_close($link);

        return $name;
    }
}