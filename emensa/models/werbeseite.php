<?php
function db_kategorie_select_all()
{
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

function db_gericht_allergen_pair()
{
    $link = connectdb();


    $sql = "SELECT id, name, bildname, GROUP_CONCAT(code) as allergen_codes, preis_intern, preis_extern
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


function db_allergen()
{
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


function db_anzahl_gerichte()
{
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
function db_anzahl_besucher()
{
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


function verifyUser()
{
    if (isset($_POST['email']) && isset($_POST['password'])) {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $_SESSION['user_email'] = $_POST['email'];
            $hashKeyPassword = sha1('saltbae' . $password);

            $link = connectdb();
            $sql = "SELECT * FROM benutzer WHERE email = '$email' AND passwort = '$hashKeyPassword'";

            $userData = mysqli_query($link, $sql);

            if (!$userData) {
                echo "Fehler während der Abfrage:  ", mysqli_error($link);
                exit();
            }
            $userInfoRow = mysqli_fetch_row($userData);

            $_SESSION['admin'] = $userInfoRow[4];

            if (!is_null($userInfoRow)) {
                $_SESSION['user_id'] = $userInfoRow[0];
            }

            mysqli_close($link);
            return !is_null($userInfoRow);
        }
    }
}

function incrementLoginAmount(): void
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

function lastLoginDate(bool $success)
{
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

function incrementAndLastLogin(bool $success)
{
    $link = connectdb();
    try {
        $link->begin_transaction();
        if (isset($_SESSION['user_email'])) {
            $userEmail = $_SESSION['user_email'];
            $containsEmail = "SELECT * FROM benutzer WHERE email = '$userEmail'";
            $emailIsThere = mysqli_query($link, $containsEmail);
            $row = mysqli_fetch_row($emailIsThere);
            if ($success) {
                $_SESSION['login_ok'] = true;
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                mysqli_query($link, "CALL incrementLogin({$row[0]})");
//                $sql = "UPDATE benutzer SET anzahlanmeldungen = anzahlanmeldungen + 1";
//                mysqli_query($link, $sql);
                $sql = "UPDATE benutzer SET letzteanmeldung = NOW() WHERE email = '$userEmail'";
                mysqli_query($link, $sql);
            } else {
                $_SESSION['login_ok'] = false;
                if (!empty($row)) {
                    $sql = "UPDATE benutzer SET letzterfehler = NOW() WHERE email = '$userEmail'";
                    mysqli_query($link, $sql);
                }
            }

        }
        $link->commit();
    } catch (mysqli_sql_exception $exception) {
        $link->rollback();
        throw $exception;
    }

    mysqli_close($link);
}

function loginName()
{

    if (verifyUser()) {

        $link = connectdb();

        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $hashKeyPassword = sha1('saltbae' . $password);

        $sql = "SELECT name, id FROM benutzer WHERE email = '$email' AND passwort = '$hashKeyPassword'";

        $nameStatement = mysqli_query($link, $sql);

        $name = mysqli_fetch_row($nameStatement);

        if (!$name) {
            echo "Fehler während der Abfrage:  ", mysqli_error($link);
            exit();
        }

        mysqli_close($link);

        $_SESSION['username'] = $name[0];
        return $name;
    }
}

function bewertung_mealInfo()
{

    if (isset($_GET['gerichtid'])) {
        $id = $_GET['gerichtid'];
        $_SESSION['gerichtid'] = $id;
        $link = connectdb();


        $sql = "SELECT name, bildname FROM gericht WHERE id='$id'";

        $evaluation = mysqli_query($link, $sql);

        $evaluationInfo = mysqli_fetch_row($evaluation);

        if (!$evaluationInfo) {
            echo "Fehler während der Abfrage:  ", mysqli_error($link);
            exit();
        };

        mysqli_close($link);
        return $evaluationInfo;
    }
}

function check_evaluation()
{
    if (isset($_POST['bemerkung']) && isset($_POST['stars'])) {
        if (!empty($_POST['bemerkung']) && !empty($_POST['stars'])) {
            $allowed_stars = ['sehr schlecht', 'schlecht', 'gut', 'sehr gut'];
            $gericht_id = $_SESSION['gerichtid'];
            $user_id = $_SESSION['user_id'];
            $caption = htmlspecialchars($_POST['bemerkung']);
            $star = $_POST['stars'];
            if (($pos = array_search($star, $allowed_stars)) !== false) {
                $star = $allowed_stars[$pos];
            }

            $link = connectdb();
            $sql = "INSERT INTO bewertungen (bemerkung, sterne_bewertung, bewertungszeitpunkt, benutzer_id, gericht_id) VALUES ('$caption', '$star', NOW(), '$user_id', '$gericht_id')";

            $mealData = mysqli_query($link, $sql);

            if (!$mealData) {
                echo "Fehler während der Abfrage:  ", mysqli_error($link);
                return false;
            }

            mysqli_close($link);
            return true;
        }
        return false;
    }
    return false;
}

function assesment_table()
{
    $link = connectdb();

    $sql = "SELECT b.id AS benutzer_id, bemerkung, sterne_bewertung, bewertungszeitpunkt, hervorgehoben, 
       b.name AS benutzer, g.name AS gericht, bewe.id AS bewertung_id FROM bewertungen bewe 
           LEFT JOIN benutzer b ON bewe.benutzer_id = b.id 
           LEFT JOIN gericht g ON g.id = bewe.gericht_id 
                         ORDER BY bewertungszeitpunkt DESC LIMIT 30;";

    $bewertungen = mysqli_query($link, $sql);

    if (!$bewertungen) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }

    mysqli_close($link);
    mysqli_fetch_row($bewertungen);
    return $bewertungen;
}

function my_assesment_table()
{

    $link = connectdb();
    $benutzerID = $_SESSION['user_id'];

    $sql = "SELECT bewe.id AS bewertung_id, bemerkung, sterne_bewertung, bewertungszeitpunkt, hervorgehoben, 
       b.name AS benutzer, g.name AS gericht FROM bewertungen bewe 
           LEFT JOIN benutzer b ON bewe.benutzer_id = b.id 
           LEFT JOIN gericht g ON g.id = bewe.gericht_id WHERE benutzer_id = '$benutzerID'
                         ORDER BY bewertungszeitpunkt DESC LIMIT 30;";

    $bewertungen = mysqli_query($link, $sql);

    if (!$bewertungen) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }

    mysqli_close($link);
    return $bewertungen;
}

function delete_evaluation()
{
    if (isset($_GET['bewertung_id'])) {

        $link = connectdb();
        $benutzerID = $_SESSION['user_id'];
        $bew_id = $_GET['bewertung_id'];

        $sql = "DELETE FROM bewertungen WHERE id = '$bew_id' AND benutzer_id = '$benutzerID'";

        $bewertungen = mysqli_query($link, $sql);

        if (!$bewertungen) {
            echo "Fehler während der Abfrage:  ", mysqli_error($link);
            exit();
        }

        mysqli_close($link);
        return $bewertungen;
    }
}

function hervorheben() {

        $link = connectdb();
        $bew_id = $_GET['bewertung_id'];

        $sql = "UPDATE bewertungen SET hervorgehoben = true WHERE id='$bew_id'";

        $show = mysqli_query($link, $sql);

        if (!$show) {
            echo "Fehler während der Abfrage:  ", mysqli_error($link);
            exit();
        }

        mysqli_close($link);
        return $show;
}

function hervorheben_abwaehlen() {

    $link = connectdb();
    $bew_id = $_GET['bewertung_id'];

    $sql = "UPDATE bewertungen SET hervorgehoben = false WHERE id='$bew_id'";

    $show = mysqli_query($link, $sql);

    if (!$show) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }

    mysqli_close($link);
    return $show;
}

function good_recension() {
    $link = connectdb();

    $sql = "SELECT g.name AS gericht, bemerkung, sterne_bewertung FROM bewertungen bewe 
    LEFT JOIN gericht g ON g.id = bewe.gericht_id WHERE bewe.hervorgehoben = true";

    $show = mysqli_query($link, $sql);

    if (!$show) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }

    mysqli_close($link);
    return $show;
}