<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/werbeseite.php');

class WerbeseiteController
{
    public function werbeseite (RequestData $rd) {
        $res_gericht_allergen_pair = db_gericht_allergen_pair();
        $res_allergen = db_allergen();
        $res_anzahl_gerichte = db_anzahl_gerichte();
        $res_anzahl_besucher = db_anzahl_besucher();
        $recension = good_recension();
        if(isset($_SESSION['user_email'])) {
            $log = logger();
            $log->info("Abgemeldet vom Profil " . $_SESSION['user_email']);
            unset($_SESSION['user_email']);
            unset($_SESSION['login_ok']);
            unset($_SESSION['username']);
            unset($_SESSION['user_id']);
            unset($_SESSION['admin']);
        } else {
            $log = logger();
            $log->info("Jemand hat die Werbeseite aufgerufen");
        }
        return view('werbeseite.werbeseite', [
            'request'=>$rd,
            'res_gericht_allergen_pair' => $res_gericht_allergen_pair,
            'res_allergen' => $res_allergen,
            'res_anzahl_gerichte' => $res_anzahl_gerichte,
            'res_anzahl_besucher' => $res_anzahl_besucher,
            'recension' => $recension,
            'url' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"
        ]);
    }

    public function anmelden () {
        $log = logger();
        $log->info("Anmeldeseite wird gezeigt");
        return view('werbeseite.login');
    }

    public function verify (RequestData $rd) {
        $verified_user = verifyUser();
        if ($verified_user) {

//            incrementLoginAmount();
//            lastLoginDate(true);
            incrementAndLastLogin(true);
            $res_gericht_allergen_pair = db_gericht_allergen_pair();
            $res_allergen = db_allergen();
            $res_anzahl_gerichte = db_anzahl_gerichte();
            $res_anzahl_besucher = db_anzahl_besucher();
            $recension = good_recension();
            $userName = loginName();
            $log = logger();
            $log->info("Angemeldet als " . $userName[0]);
            return view('werbeseite.werbeseite', [
                'request'=>$rd,
                'res_gericht_allergen_pair' => $res_gericht_allergen_pair,
                'res_allergen' => $res_allergen,
                'res_anzahl_gerichte' => $res_anzahl_gerichte,
                'res_anzahl_besucher' => $res_anzahl_besucher,
                'username' => $userName,
                'recension' => $recension,
                'log' => "Abmelden",
                'logged' => "Angemeldet als " . $userName[0]
            ]);
        } else {
//            lastLoginDate(false);
            incrementAndLastLogin(false);
            $log = logger();
            $log->warning("Anmeldung fuer den Profil " . $_SESSION['user_email'] . " fehlgeschlagen");
            unset($_SESSION['user_email']);
            unset($_SESSION['login_ok']);
            unset($_SESSION['username']);
            unset($_SESSION['user_id']);
            unset($_SESSION['admin']);
            return view('werbeseite.login', [
                'request'=>$rd,
                'meldung' => "Benutzer nicht gefunden"
            ]);
        }
    }

    public function bewertung(RequestData $rd) {
        if (isset($_SESSION['login_ok']) && $_SESSION['login_ok']) {
            $evaluation_mealInfo = bewertung_mealInfo();
            $gerichtid = $_GET['gerichtid'];

            return view('werbeseite.bewertung', [
                'meal_id' => $gerichtid,
                'evaluation_mealInfo' => $evaluation_mealInfo
            ]);
        } else {
            unset($_SESSION['user_email']);
            unset($_SESSION['login_ok']);
            unset($_SESSION['username']);
            unset($_SESSION['user_id']);
            unset($_SESSION['admin']);
            return view('werbeseite.login', [
                'request'=>$rd,
                'meldung' => "Benutzer nicht gefunden"
            ]);
        }
    }

    public function verify_evaluation(RequestData $rd) {
        $check_evaluation = check_evaluation();
        if ($check_evaluation) {
            $res_gericht_allergen_pair = db_gericht_allergen_pair();
            $res_allergen = db_allergen();
            $res_anzahl_gerichte = db_anzahl_gerichte();
            $res_anzahl_besucher = db_anzahl_besucher();
            $recension = good_recension();
            $userName = $_SESSION['username'];
            return view('werbeseite.werbeseite', [
                'request'=>$rd,
                'res_gericht_allergen_pair' => $res_gericht_allergen_pair,
                'res_allergen' => $res_allergen,
                'res_anzahl_gerichte' => $res_anzahl_gerichte,
                'res_anzahl_besucher' => $res_anzahl_besucher,
                'username' => $userName,
                'recension' => $recension,
                'log' => "Abmelden",
                'logged' => "Angemeldet als " . $userName
            ]);
        } else {
            $evaluation_mealInfo = bewertung_mealInfo();
            $gerichtid = $_GET['gerichtid'];

            return view('werbeseite.bewertung', [
                'meal_id' => $gerichtid,
                'evaluation_mealInfo' => $evaluation_mealInfo,
                'fehlermeldung' => "Fehler beim Speichern der Bewertung"
            ]);
        }
    }

    public function bewertungen(RequestData $rd) {
        $asses_table = assesment_table();
        return view('werbeseite.bewertungen', [
            'stars_table' => $asses_table
        ]);
    }

    public function meine_bewertungen(RequestData $rd) {
        if (isset($_SESSION['login_ok'])) {
            $my_evaluations = my_assesment_table();
            return view('werbeseite.meine_bewertungen', [
                'my_stars_table' => $my_evaluations
            ]);
        } else {
            unset($_SESSION['user_email']);
            unset($_SESSION['login_ok']);
            unset($_SESSION['username']);
            unset($_SESSION['user_id']);
            unset($_SESSION['admin']);
            return view('werbeseite.login', [
                'request'=>$rd,
                'meldung' => "Benutzer und seine Bewertungen sind nicht gefunden"
            ]);
        }
    }

    public function delete_bewertungen(RequestData $rd) {
        delete_evaluation();
        header("Location: /meinebewertungen");
    }

    public function hervorheben(RequestData $rd) {
        hervorheben();
        header("Location: /bewertungen");
    }

    public function hervorheben_cancel(RequestData $rd) {
        hervorheben_abwaehlen();
        header("Location: /bewertungen");
    }
}