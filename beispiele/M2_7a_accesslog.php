<?php
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