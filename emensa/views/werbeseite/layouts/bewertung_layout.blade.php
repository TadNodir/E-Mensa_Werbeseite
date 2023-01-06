<!DOCTYPE html>
<!--
- Praktikum DBWT. Autoren:
- Nodirjon, Tadjiev, 3527449
- Daniel, Winata, 3525700
-->
<html lang="de">
<head>
    <!-- This line will set the viewport of your page, which will give the browser instructions on
    how to control the page's dimensions and scaling.-->
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bewertung</title>
    <!-- Link to the styling css file-->
    <link rel="stylesheet" href="css/bewertung.css" type="text/css" media="screen"/>
</head>
<body>
<div class="background">
    @yield('meal_info')
    @yield('formular')
    {{$fehlermeldung}}
</div>
</body>
</html>
