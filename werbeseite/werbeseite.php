<?php
/**
 * Praktikum DBWT. Autoren:
 * Daniel, Winata, 3525700
 * Nodirjon, Tadjiev, 3527449
 */
include 'foodList.php';

echo "Test";

$nameErr = $emailErr = $langErr = $agbErr = "";
$name = $email = "";
$successName = $successEmail = $successLang = $successAgb = false;
$userData = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["vorname"])) {
        $nameErr = "Bitte den Namen eingeben";
    } else {
        $name = legit_input($_POST["vorname"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^([a-zA-Z' ]+)$/", $name)) {
            $nameErr = "Falsche Namenseingabe";
        } else {
            $userData[0] = $name;
            $successName = true;
        }
    }
    if (empty($_POST["email"])) {
        $emailErr = "Bitte Email Addresse eingeben";
    } else {
        $email = legit_input($_POST["email"]);

        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strpos($email, "rcpt.at") ||
            strpos($email, "damnthespam.at") || strpos($email, "wegwerfmail.de") ||
            strpos($email, "trashmail.at") || strpos($email, "trashmail.com")) {
            $emailErr = "Falsche Email Eingabe";
        } else {
            $userData[1] = $email;
            $successEmail = true;
        }
    }
    if (empty($_POST["language"])) {
        $langErr = "Bitte Sprache eingeben";
    } else {
        if ($_POST['language'] == "Deutsch" || $_POST['language'] == "Englisch" || $_POST['language'] ==
            "Spanisch") {
            $userData[2] = $_POST['language'];
            $successLang = true;
        } else {
            $langErr = "Falsche Spracheingabe";
        }
    }
    if (empty($_POST["agb"])) {
        $agbErr = "Bitte Datenschutzbedingungen zustimmen";
    } else {
        if ($_POST['agb']) {
            $userData[3] = $_POST['agb'];
            $successAgb = true;
        } else {
            $agbErr = "Falsche Eingabe der Datenschutzbedingungen";
        }
    }
}

function legit_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


$file = fopen('./newsletterData.txt', 'a');
if (!$file) {
    die('Öffnen fehlgeschlagen');
}
foreach ($userData as $info) {
    if ($info == end($userData)) {
        $line = "$info\n";
    } else {
        $line = "$info:";
    }
    fwrite($file, $line);
}
fclose($file);

?>

<!DOCTYPE html>
<!--
- Praktikum DBWT. Autoren:
- Nodirjon, Tadjiev, 3527449
- Daniel, Winata, 3525700
-->
<html lang="de">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Mensa</title>

    <style>
        /*
        All children of main tag have to have these characteristics
        we want to center here all the elements in main and use they in full wide
         */
        main > * {
            width: 100%;
            justify-content: center;
            text-align: center;
        }

        /*
        Removing margin from the body, in order not to have the margin between header and sides
         */
        body {
            margin: 0;
        }

        /*
        Header
        The header container is designed with help of grid, where we assign each word in menu as a column
        'sticky' places the header according to the normal flow of the document
        Here and further we used vw as a unit of measurement to do the website more responsive and depending
        on the page size
         */
        .header-container {
            display: grid;
            grid-template-columns: 1fr 3fr;
            position: sticky;
            padding: 0.8vw;
            border-bottom: teal solid;
            background-color: teal;
        }

        /*
        Logo of the Mensa
        Radius is 50%, to make the logo round
        Placing it in center as it is a child item of a grid
        Not allowing to get bigger/smaller restricting the max/min sizes
         */
        .header-item1 {
            border-radius: 50%;
            place-self: center;
            max-width: 25%;
            min-width: 20%;
        }

        /*
        List of menu containing
        placing the menu words as they are a grid children and stretching them
         */
        .header-item2 {
            padding: 0.7vw;
            place-self: center stretch;
            margin: 1vw;
        }

        /*
        Each word of the menu
        Displaying inline, as otherwise they are displayed as a list
         */
        .header-item2 > li {
            list-style: none;
            display: inline;
            margin: 0.7vw;
            color: white;
            font-size: 2.2vw;
        }

        /*
        Headers for each menu section
        Setting one font size for all menu headers
         */
        h2 {
            font-size: 2.5vw;
        }

        /*
        If not pressed the link, be dark grey
         */
        a:link {
            color: darkgrey;
        }

        /*
        If already visited the link, be black
         */
        a:visited {
            color: black;
        }

        /*
        Designing the main content of the page as a grid
         */
        .main-container {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
        }

        /*
        Central column
        the distance between the header and main content
         */
        .centerCol {
            padding-top: 4vw;
        }

        /*
        Rectangle picture of the food table
         */
        .top-picture {
            width: 50vw;
            height: 30vw;
        }

        /*
        Lorem ipsum text in the middle
         */
        p {
            border: solid 2px black;
            padding: 1em;
            font-size: 1vw;
        }

        /*
        Table with prices made relative to column full width
        Aligning text to the center
         */
        table, th, td {
            width: 100%;
            border: 1px solid;
            padding: 0.5em;
            text-align: center;
            font-size: 1vw;
        }

        /*
        Mensa in numbers
        List displayed inline and aligned to the center
         */
        .inNumbers ul li {
            display: inline;
            font-size: 1.7vw;
            text-align: center;
        }

        /*
        first and second words have a margin between each other
         */
        .inNumbers ul li:nth-of-type(1), .inNumbers ul li:nth-of-type(2) {
            margin-right: 7%;
        }

        /*
        Two input tags and one select tag designed as flex rows and leaving between them space evenly
         */
        .inputContainer {
            display: flex;
            flex-direction: row;
            justify-content: space-evenly;
        }

        /*
        All children of form, input and select tag have to have the font size depending of page size
         */
        form > *, input, select {
            font-size: 1vw;
        }

        /*
        All elements of the form
         */
        .info {
            margin: 3px;
            align-self: center;
        }

        /*
        List of important things aligned left
         */
        .wichtig-list > ul > li {
            text-align: left;
            font-size: 1vw;
        }

        /*
        The footer text is aligned to the center and has a distance to the List of important things
         */
        footer {
            text-align: center;
            margin-top: 4vw;
            border-top: 1px solid black;
            font-size: 1vw;
        }

        /*
        Each word of the footer list displayed inlined
         */
        footer li {
            display: inline;
            margin-right: 5em;
        }

        /*
        First and second words have a distance between each other and border
         */
        footer ul li:nth-of-type(1), footer ul li:nth-of-type(2) {
            border-right: 2px solid black;
            padding-right: 5vw;
        }

        /*
        Input tags with these name values have to have relative width of 80%
         */
        [name="language"], [name="benutzer"] {
            width: 80%;
        }

        .error {
            color: #FF0000;
        }

        .successMessage {
            color: green;
            font-weight: bold;
        }

    </style>
</head>
<body>
<header class="header-container">
    <img src="logo.png" alt="E-Mensa Logo" class="header-item1">
    <ul class="header-item2">
        <li><a href="#ankündigung">Ankündigung</a></li>
        <li><a href="#speisen">Speisen</a></li>
        <li><a href="#zahlen">Zahlen</a></li>
        <li><a href="#kontakt">Kontakt</a></li>
        <li><a href="#wichtig">Wichtig für uns</a></li>
    </ul>
</header>

<main class="main-container">
    <div></div>
    <div class="centerCol">
        <img class="top-picture" src="food.jpg" alt="food picture">
        <br>
        <h2 id="ankündigung">Bald gibt es Essen auch online ;)</h2>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Egestas fringilla phasellus faucibus scelerisque eleifend. Amet cursus sit amet dictum
            sit
            amet justo donec. Pretium aenean pharetra magna ac placerat vestibulum lectus mauris ultrices. Et ligula
            ullamcorper malesuada proin libero nunc consequat interdum varius. Vitae congue mauris rhoncus aenean vel
            elit.
            Eu turpis egestas pretium aenean pharetra. Bibendum est ultricies integer quis auctor elit sed vulputate.
            Orci
            dapibus ultrices in iaculis. Blandit volutpat maecenas volutpat blandit aliquam etiam erat velit. Aenean
            pharetra magna ac placerat vestibulum. Commodo ullamcorper a lacus vestibulum.<br>
            Semper quis lectus nulla at volutpat diam. Id diam maecenas ultricies mi eget mauris pharetra.
            Montes nascetur ridiculus mus mauris vitae ultricies leo integer malesuada. In arcu cursus euismod
            quis viverra. Ultricies tristique nulla aliquet enim tortor. Tincidunt nunc pulvinar sapien et ligula
            ullamcorper malesuada. Metus aliquam eleifend mi in nulla posuere. Eget lorem dolor sed viverra ipsum
            nunc aliquet. Elementum sagittis vitae et leo duis ut diam quam. Massa tincidunt nunc pulvinar sapien et
            ligula ullamcorper malesuada proin. Leo a diam sollicitudin tempor id eu nisl nunc mi. Tempus urna et
            pharetra pharetra massa massa. Duis ut diam quam nulla porttitor massa id. Hac habitasse platea dictumst
            quisque sagittis purus sit. A lacus vestibulum sed arcu. At auctor urna nunc id cursus. Faucibus scelerisque
            eleifend donec pretium. In ornare quam viverra orci. In ornare quam viverra orci sagittis eu. Sed nisi lacus
            sed viverra.
        </p>

        <h2 id="speisen">Köstlichkeiten, die Sie erwarten</h2>
        <table>
            <tr>
                <td></td>
                <td>Preis intern</td>
                <td>Preis extern</td>
                <td>Bilder</td>
            </tr>
            <?php
            $foodList = include "foodList.php";

            foreach ($foodList as $food) {
                echo "<tr><td>{$food['name']}</td>
                     <td>{$food['price_intern']} &euro;</td>
                     <td>{$food['price_extern']} &euro;</td>
                     <td><img src={$food['image']} width='100px' height='70px'></td>
                 </tr>";
            }
            ?>
        </table>

        <h2>E-Mensa in Zahlen</h2>

        <div id="zahlen" class="inNumbers">
            <ul>
                <li>X Besuche</li>
                <li>Y Anmeldungen zum Newsletter</li>
                <li>Z Speisen</li>
            </ul>
        </div>

        <h2 id="kontakt">Interesse geweckt? Wir informieren Sie!</h2>
        <form action="" method="POST">
            <fieldset>
                <div class="inputContainer">
                    <div class="info">
                        <label for="vorname">Vorname:<sup>*</sup></label><br>
                        <input type="text" id="vorname" name="vorname"
                               placeholder="Max"
                               size="35" required><br>
                        <span class="error"><?php echo $nameErr; ?></span>
                    </div>
                    <div class="info">
                        <label for="email">E-Mail:<sup>*</sup></label><br>
                        <input type="email" id="email" name="email" placeholder="name@example.com"
                               size="35" required><br>
                        <span class="error"><?php echo $emailErr; ?></span>
                    </div>
                    <div class="info">
                        <label for="lang">Newsletter bitte in:</label><br>
                        <select id="lang" name="language">
                            <option value="Deutsch">Deutsch</option>
                            <option value="Englisch">Englisch</option>
                            <option value="Spanisch">Spanisch</option>
                        </select>
                        <span class="error"><?php echo $langErr; ?></span>
                    </div>
                </div>
                <div class="info">
                    <input type="checkbox" id="scales" name="agb" required>
                    <label for="scales">Den Datenschutzbestimmungen stimme ich zu<sup>*</sup></label>
                    <span class="error"><?php echo $agbErr; ?></span>
                </div>
                <br>
                <div class="info">
                    <input type="submit" name="submit" value="Zum Newsletter anmelden">
                </div>
                <div class="info">
                    <br>
                    *) Eingaben sind Pflicht
                </div>
            </fieldset>
        </form>
        <span class="successMessage"><?php if ($successName && $successEmail) {
                echo "Daten erfolgreich gespeichert.";
            } ?></span>
        <h2 id="wichtig">Das ist uns wichtig!</h2>
        <div class="wichtig-list">
            <ul>
                <li>Beste frische saisonale Zutaten</li>
                <li>Ausgewogene abwechslungsreiche Gerichte</li>
                <li>Sauberkeit</li>
            </ul>
        </div>
        <h2>Wir freuen uns auf Ihren Besuch!</h2>
    </div>
    <div></div>
</main>
<footer>
    <ul>
        <li>(c) E-Mensa GmbH</li>
        <li>Nodirjon Tadjiev, Daniel Winata</li>
        <li><a href="https://www.fh-aachen.de/" target="_blank">Impressum</a></li>
    </ul>
</footer>


</body>
</html>
