<?php
/**
 * Praktikum DBWT. Autoren:
 * Daniel, Winata, 3525700
 * Nodirjon, Tadjiev, 3527449
 */

$info = [
    'date' => date('d.m.Y'),
    'time' => date("h:i:sa"),
    'browser' => $_SERVER['HTTP_USER_AGENT'],
    'ip' => $_SERVER['REMOTE_ADDR']
];

$file = fopen('./accesslog.txt', 'w');
if (!$file) {
    die('Öffnen fehlgeschlagen');
}
foreach ($info as $key => $txt) {
    $line = "$key: $txt, ";
    fwrite($file, $line);
}
fclose($file);