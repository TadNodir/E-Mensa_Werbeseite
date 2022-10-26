/**
* Praktikum DBWT. Autoren:
* Daniel, Winata, 3525700
* Nodirjon, Tadjiev, 3527449
*/
<?php
include 'm2_4a_standardparameter.php';

$result = "No results yet";
if (isset($_GET['a']) && isset($_GET['b'])) {
    $a = $_GET['a'];
    $b = $_GET['b'];
    $result = addieren($a, $b);
}
?>

<form method="get">
    <input type="text" name="a">
    <input type="text" name="b">
    <button type="submit" name="addButton">Addieren</button>
    <br>
    <?php echo $result; ?>
</form>
