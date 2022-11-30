<?php

$gericht = $beschreibung = $date = $mail = "";
$name = "anonym";

if (isset($_POST['submit'])) {
    $date = date("Y-m-d");
    if (!empty($_POST['gericht'])) {
        $gericht = $_POST['gericht'];
    }
    if (!empty($_POST['beschreibung'])) {
        $beschreibung = $_POST['beschreibung'];
    }
    if (!empty($_POST['email'])) {
        $mail = $_POST['email'];
    }
    if (!empty($_POST['vorname'])) {
        $name = $_POST['vorname'];
    }

    $link = mysqli_connect(
        "localhost",
        "root",
        "root",
        "emensawerbeseite"
    );

    if (!$link) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }

    $statement = mysqli_stmt_init($link);
    mysqli_stmt_prepare($statement,
        "INSERT INTO wunschgericht (name, beschreibung, datum) VALUES (?, ?, ?);");

    mysqli_stmt_bind_param($statement, 'sss',
        $_POST['gericht'], $_POST['beschreibung'], $date);
    mysqli_stmt_execute($statement);

    $statement = mysqli_stmt_init($link);
    mysqli_stmt_prepare($statement,
        "INSERT INTO ersteller (name, mail, besitzt_wg) VALUES (?, ?, (SELECT id FROM wunschgericht WHERE name = ?));");

    mysqli_stmt_bind_param($statement, 'sss', $name, $mail, $gericht);
    mysqli_stmt_execute($statement);

    echo "Wunschgericht erfolgreich gespeichert!";

}
?>

<!DOCTYPE html>
<!--
- Praktikum DBWT. Autoren:
- Nodirjon, Tadjiev, 3527449
- Daniel, Winata, 3525700
-->
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Wunschgericht</title>
</head>
<body>
<form method="post">
    <fieldset style="width:400px">
        <legend>Wunschgericht</legend>
        <label for="gericht">Gericht:<sup>*</sup></label><br>
        <input type="text" id="gericht" name="gericht" placeholder="Bitte geben Sie den Gerichtnamen ein." size="35"
               required><br>
        <label for="beschreibung">Beschreibung:<sup>*</sup></label><br>
        <input type="text" id="beschreibung" name="beschreibung"
               placeholder="Bitte geben Sie die Beschreibung des Gerichts ein." size="70"
               required><br>
        <label for="vorname">Vorname:</label><br>
        <input type="text" id="vorname" name="vorname" placeholder="Bitte geben Sie Ihren Vornamen ein." size="35"><br>
        <label for="email">Email:<sup>*</sup></label><br>
        <input type="email" id="email" name="email" placeholder="Bitte geben Sie Ihre E-Mail ein." size="35"
               required><br><br>

        <input type="reset" value="Zur&uuml;cksetzen">
        <input type="submit" name="submit" value="Wunsch abschicken">
        <br><br>
        <div><small>*) Eingaben sind Pflicht</small></div>
    </fieldset>
</form>
<table>
    <tr>
        <td>Name</td>
        <td>Beschreibung</td>
        <td>Datum</td>
    </tr>
    <?php
    $link = mysqli_connect(
        "localhost",
        "root",
        "root",
        "emensawerbeseite"
    );

    if (!$link) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }
    $statement = mysqli_stmt_init($link);
    mysqli_stmt_prepare($statement,
        "SELECT * FROM wunschgericht ORDER BY datum DESC LIMIT 5;");
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    while ($data = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td>' . $data['name'] . '</td>';
        echo '<td>' . $data['beschreibung'] . '</td>';
        echo '<td>' . $data['datum'] . '</td>';
        echo '</tr>';
    }
    ?>
</table>
</body>
</html>
