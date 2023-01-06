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

    <link rel="stylesheet" href="/css/werbeseite.css">
</head>

<body>
<header class="header-container">
@yield('header_navigation')
</header>

<main class="main-container">
    <div></div>
    <div class="centerCol">
        @yield('begrüßung')
        <h2 id="speisen">Köstlichkeiten, die Sie erwarten</h2>
        <table>
            <tr>
                <td>Name</td>
                <td>Preis intern</td>
                <td>Preis extern</td>
                <td>Bilder</td>
                <td>Allergen</td>
                @if(isset($log))
                    <td>Dieses Gericht bewerten</td>
                @endif
            </tr>
            @yield('gericht')
        </table>
        <div class="allerge-container">

            <h3>Die Allergen, die Sie berucksichtegen sollen</h3>
            <ol>
                @yield('allergene')
            </ol>
        </div>


        <h2 id="wichtig">Das ist uns wichtig!</h2>
        <div class="wichtig-list">
            @yield("wichtig")
        </div>
        <h2 id="wichtig">Meinungen unserer Gäste</h2>
        <div class="opinion">
            @yield('opinion')
        </div>
        <h2>Wir freuen uns auf Ihren Besuch!</h2>

    </div>
    <div></div>
</main>
<footer>
    @yield("footer")
</footer>
</body>
</html>