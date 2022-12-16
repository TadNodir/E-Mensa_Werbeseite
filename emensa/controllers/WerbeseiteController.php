<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/werbeseite.php');

class WerbeseiteController
{
    public function werbeseite (RequestData $rd) {
        $res_gericht_allergen_pair = db_gericht_allergen_pair();
        $res_allergen = db_allergen();
        $res_anzahl_gerichte = db_anzahl_gerichte();
        $res_anzahl_besucher = db_anzahl_besucher();
        if(isset($_SESSION['user_email'])) {
            $log = logger();
            $log->info("Abgemeldet vom Profil " . $_SESSION['user_email']);
            unset($_SESSION['user_email']);
            unset($_SESSION['login_ok']);
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

            return view('werbeseite.login', [
                'request'=>$rd,
                'meldung' => "Benutzer nicht gefunden"
            ]);
        }
    }
}