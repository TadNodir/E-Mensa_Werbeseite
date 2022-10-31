<?php
/**
 * Praktikum DBWT. Autoren:
 * Daniel, Winata, 3525700
 * Nodirjon, Tadjiev, 3527449
 */
$file = fopen('./en.txt', 'r');
if (!$file) {
    die('Öffnen fehlgeschlagen');
}
$fileList = [];
while (!feof($file)) {
    $line = fgets($file, 1024);
    $fileList[] = $line;
}
fclose($file);

$translationList = [];
foreach ($fileList as $word) {
    $translationList[] = explode(";", $word);
}

$translation = NULL;
if (isset($_GET['suche'])) {
    if (!empty($_GET['suche'])) {
        foreach ($translationList as $words) {
            if ($words[0] == $_GET['suche']) {
                $translation = $words[1];
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Translator</title>
</head>
<body>
<h3>Translator</h3>
<form method="get">
    <input type="text" name="suche">
    <button type="submit" name="submit">Suchen</button>
    <p><?php if (isset($_GET['suche']) && !empty($translation)) {
            echo $translation;
        } else if (isset($_GET['suche']) && empty($translation)) {
            echo "Das gesuchte Wort " . $_GET['suche'] . " ist nicht enthalten";
        } else {
            echo "";
        }
        ?></p>
</form>
</body>
</html>
