<?php
/**
 * Praktikum DBWT. Autoren:
 * Daniel, Winata, 3525700
 * Nodirjon, Tadjiev, 3527449
 */
const GET_PARAM_MIN_STARS = 'search_min_stars';
const GET_PARAM_SEARCH_TEXT = 'search_text';
const GET_PARAM_SHOW_DESCRIPTION = 'show_description';
const GET_MIN_MAX = "show_top_flop";

/**
 * List of all allergens.
 */
$allergens = [
    11 => 'Gluten',
    12 => 'Krebstiere',
    13 => 'Eier',
    14 => 'Fisch',
    17 => 'Milch'
];

$meal = [
    'name' => 'Süßkartoffeltaschen mit Frischkäse und Kräutern gefüllt',
    'description' => 'Die Süßkartoffeln werden vorsichtig aufgeschnitten und der Frischkäse eingefüllt.',
    'price_intern' => 2.90,
    'price_extern' => 3.90,
    'allergens' => [11, 13],
        'amount' => 42            // Number of available meals
    ];

$ratings = [
    [   'text' => 'Die Kartoffel ist einfach klasse. Nur die Fischstäbchen schmecken nach Käse. ',
        'author' => 'Ute U.',
        'stars' => 2 ],
    [   'text' => 'Sehr gut. Immer wieder gerne',
        'author' => 'Gustav G.',
        'stars' => 4 ],
    [   'text' => 'Der Klassiker für den Wochenstart. Frisch wie immer',
        'author' => 'Renate R.',
        'stars' => 4 ],
    [   'text' => 'Kartoffel ist gut. Das Grüne ist mir suspekt.',
        'author' => 'Marta M.',
        'stars' => 3 ]
];

$en = [
        'reveal' => 'Reveal the description',
        'meal' => 'Meal',
        'name' => 'Sweet potato filled with fresh cheese and herbs',
        'description' => 'Gently cut sweet potato filled with fresh cheese.',
        'review' => 'Reviews',
        'overall' => 'Overall',
        'search' => 'Search',
        'stars' => 'Stars',
        'allergies' => 'Allergens',
        'eggs' => 'Eggs',
        'language' => 'Language',
        'lang_en' => 'en',
        'prices' => "Prices",
        'price_intern' => 'Price for internals',
        'price_extern' => 'Price for externals'
];

$de = [
    'reveal' => 'Beschreibung ausblenden',
    'meal' => 'Gericht',
    'name' => 'Süßkartoffeltaschen mit Frischkäse und Kräutern gefüllt',
    'description' => 'Die Süßkartoffeln werden vorsichtig aufgeschnitten und der Frischkäse eingefüllt.',
    'review' => 'Bewertungen',
    'overall' => 'Insgesamt',
    'search' => 'Suchen',
    'stars' => 'Sterne',
    'allergies' => 'Allergene',
    'eggs' => 'Eier',
    'language' => 'Sprache',
    'lang_de' => 'de',
    'prices' => 'Preise',
    'price_intern' => 'Preis intern',
    'price_extern' => 'Preis extern'
];

$translate = [];
if (!isset($_GET['lang'])) {
    $_GET['lang'] = "de";
    $translate = $de;
} else if (!empty($_GET['lang'])) {
    if ($_GET['lang'] == "de") {
        $translate = $de;
    } else if ($_GET['lang'] == "en") {
        $translate = $en;
    }
}

$show_desc = NULL;
if (!isset($_GET[GET_PARAM_SHOW_DESCRIPTION])) {
    $show_desc = $translate['description'];
} else {
    if (($_GET[GET_PARAM_SHOW_DESCRIPTION]) == 0) {
        $show_desc = NULL;
    } else {
        $show_desc = $translate['description'];
    }
}


function allStars(array $meals) : array {
    $stars = [];
    foreach ($meals as $meal) {
        $stars[] = $meal['stars'];
    }
    return $stars;
}


function findMinStar(array $meals) : int {
    $stars = allStars($meals);
    return min($stars);
}

function findMaxStar(array $meals) : int {
    $stars = allStars($meals);
    return max($stars);
}


$showRatings = [];
if (!empty($_GET[GET_PARAM_SEARCH_TEXT])) {
    $searchTerm = $_GET[GET_PARAM_SEARCH_TEXT];
    foreach ($ratings as $rating) {
        if (stripos($rating['text'], $searchTerm) !== false) {
            $showRatings[] = $rating;
        }
    }
} else if (!empty($_GET[GET_PARAM_MIN_STARS])) {
    $minStars = $_GET[GET_PARAM_MIN_STARS];
    foreach ($ratings as $rating) {
        if ($rating['stars'] >= $minStars) {
            $showRatings[] = $rating;
        }
    }
} else if (!empty($_GET[GET_MIN_MAX])) {
    $min_max = $_GET[GET_MIN_MAX];
    if ($min_max === "TOP") {
        $maxStar = findMaxStar($ratings);
        foreach ($ratings as $rating) {
            if ($rating['stars'] === $maxStar) {
                $showRatings[] = $rating;
            }
        }
    } else if ($min_max === "FLOP") {
        $minStar = findMinStar($ratings);
        foreach ($ratings as $rating) {
            if ($rating['stars'] === $minStar) {
                $showRatings[] = $rating;
            }
        }
    }
}
else {
    $showRatings = $ratings;
}


function calcMeanStars(array $ratings) : float {
    $sum = 0;
    foreach ($ratings as $rating) {
        $sum += $rating['stars'];
    }
    return $sum / count($ratings);
}

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"/>
    <title>Gericht:
        <?php echo $meal['name']; ?>
    </title>
    <style>
        * {
            font-family: Arial, serif;
        }
        .rating {
            color: darkgray;
        }
    </style>
</head>
<body>
<form method="get">
    <label for="lang"><?php echo $translate['language']; ?></label><br>
    <a href="meal.php?lang=de"><?php echo $de['lang_de']; ?></a>
    <a href="meal.php?lang=en"><?php echo $en['lang_en']; ?></a><br>
    <button type="submit" value="<?php echo $show_desc ? 0 : 1; ?>" name="show_description"><?php echo $translate['reveal']; ?></button>
</form>
    <h1><?php echo $translate['meal'] . ": " . $translate['description']; ?></h1>
    <p><?php echo $show_desc; ?></p>
    <h1><?php echo $translate['review'] . " (" . $translate['overall'] . ": " . calcMeanStars($ratings) . ")"; ?></h1>


<form method="get">
    <label for="search_text">Filter:</label>
    <input id="search_text" type="text" name="search_text" value="<?php echo $_GET[GET_PARAM_SEARCH_TEXT] ?? '' ?>">
    <input type="submit" value="<?php echo $translate['search']; ?>">
</form>
<table class="rating">
    <thead>
    <tr>
        <td>Text</td>
        <td><?php echo $translate['stars']; ?></td>
        <td>Author</td>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($showRatings as $rating) {
        echo "<tr><td class='rating_text'>{$rating['text']}</td>
                      <td class='rating_stars'>{$rating['stars']}</td>
                      <td class='rating_author'>{$rating['author']}</td>
                  </tr>";
    }
    ?>
    </tbody>
</table>
<h4><?php echo $translate['allergies']; ?>:</h4>
<ul>
    <?php echo "<li>$allergens[11]</li>", "<li>$allergens[13]"; ?>
</ul>
<h4><?php echo $translate['prices']; ?>:</h4>
<ol>
    <?php
        echo "<li>" . $translate['price_intern'] . " : " . number_format($meal['price_intern'], 2, ',') . "&euro;</li>",
        "<li>" . $translate['price_extern'] . " : " . number_format($meal['price_extern'], 2, ',') . "&euro;</li>";
    ?>
</ol>
</body>
</html>