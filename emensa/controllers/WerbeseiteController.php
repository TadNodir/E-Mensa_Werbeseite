<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/werbeseite.php');

class WerbeseiteController
{
    public function werbeseite (RequestData $rd) {
        $res_gericht_allergen_pair = db_gericht_allergen_pair();
        $res_allergen = db_allergen();
        $res_anzahl_gerichte = db_anzahl_gerichte();
        $res_anzahl_besucher = db_anzahl_besucher();

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
            return view('werbeseite.login', [
                'request'=>$rd,
                'meldung' => "Benutzer nicht gefunden"
            ]);
        }
    }
}