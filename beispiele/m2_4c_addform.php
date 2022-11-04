<?php

if (isset($_GET['a'])) {
    $a = $_GET['a'];
}
if (isset($_GET['b'])) {
    $b = $_GET['b'];
}

include('m2_4a_standardparameter.php');

function multiplizieren($a = 0, $b = 0) : float {
    return $a * $b;
}

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <style>
        .fset {
            width: 590px;
        }
    </style>
</head>
<body>
<form>
    <fieldset class="fset">
        <legend> ADDIEREN / MULTIPLIZIEREN </legend>
        <label for="a">a</label>
        <input id="a" type="input" name="a">
        <label for="b">b</label>
        <input id="b" type="input" name="b">
        <button type="submit" name="addieren" value="1">addieren</button>
        <button type="submit" name="multiplizieren" value="1">multiplizieren</button>
        <br>
        <div>
            Summe :
            <?php
            if (isset($_GET['addieren']) && $_GET['addieren'] == 1) {
                echo addieren($a, $b);
            }
            ?>
        </div>
        <div>
            Multiplikation :
            <?php
            if (isset($_GET['multiplizieren']) && $_GET['multiplizieren'] == 1) {
                echo multiplizieren($a, $b);
            }
            ?>
        </div>
    </fieldset>
</form>
</body>
</html>