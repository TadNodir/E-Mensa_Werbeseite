<!doctype html>
<html class="no-js" lang="DE">
<head>
    <meta charset="utf-8">
    <title>E-Mensa Routing Script</title>
    <meta name="description" content="unused">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.2/css/bootstrap.min.css" integrity="sha512-CpIKUSyh9QX2+zSdfGP+eWLx23C8Dj9/XmHjZY2uDtfkdLGo0uY12jgcnkX9vXOgYajEKb/jiw67EYm+kBf+6g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @yield("cssextra")
    <meta name="theme-color" content="#dadada">
</head>
<body>
{{var_dump($request)}}
<div class="container">
    <div class="row">
        <header class="mt-5">
            @yield("title")
        </header>
        <nav>
            <strong> NAVIGATION </strong>
            <form class="page-selector" method="get">
                <strong> {{$request['no'] === 1 ? "Gericht: " : "Kategorie: "}} </strong>
                <button name="no" value="1"> Gericht </button>
                <button name="no" value="2"> Kategorie </button>
            </form>
        </nav>

        <main class="main">
            @yield("main")
        </main>
    </div>
</div>

<footer>
    <strong> Footer </strong>
    <ul>
        @yield("footer")
    </ul>
</footer>
@yield("jsextra")
</body>

</html>