<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/kategorie.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/gericht.php');
// Aufgabe c includdieren

class ExampleController
{
    public function m4_6a_queryparameter(RequestData $rd) {
        /*
           Wenn Sie hier landen:
           bearbeiten Sie diese Action,
           so dass Sie die Aufgabe löst
        */

        return view('notimplemented', [
            'request'=>$rd,
            'url' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"
        ]);
    }

    public function m4_7a_queryparameter(RequestData $rd) {

        return view('examples.m4_7a_queryparameter', [
            'request'=>$rd,
            'url' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"
        ]);
    }

    public function m4_7b_kategorie(RequestData $rd) {

        $category = db_kategorie_select_sorted_categories();
        return view('examples.m4_7b_kategorie', [
            'data' => $category
        ]);
    }

    public function m4_7c_gerichte(RequestData $rd) {

        $meal = db_kategorie_select_sorted_gerichte();
        return view('examples.m4_7c_gerichte', [
            'data' => $meal
        ]);
    }

    public function m4_7d_layout(RequestData $rd) {
        $requestData = $rd->getData();
        if(!isset($requestData['no']))
            $requestData['no'] = '1';
        $viewName = $requestData['no'] == 1 ? 'examples.pages.m4_7d_page_1' : 'examples.pages.m4_7d_page_2';
        $gerichtData = $requestData['no'] == 1 ? db_gericht_select_all() : db_kategorie_select_all();

        return view($viewName, [
            'request' => $requestData,
            'titel' => $requestData['titel'] ?? 'Titel',
            'data' => $gerichtData,
            'url' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"
        ]);

    }
}