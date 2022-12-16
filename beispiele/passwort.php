<?php
$password = "";

if (isset($_POST["password"])) {
    if (!empty($_POST["password"])) {
        $password = sha1("saltbae" . $_POST["password"]);
    }
}

?>

<!DOCTYPE html>
<hmtl>
<form method="POST">
    <fieldset>
        <legend>Gib dein Passwort ein:</legend>
        <label for="password">Passwort:</label>
        <input type="password" id="password" name="password" placeholder="********" size="35"
               required><br>
        <label for="check">Passwort anzeigen</label>
        <input type="checkbox" id="check" onclick="makeInvisible()"><br>
        <input type="submit" name="submit" value="Submit">
        <script>
            function makeInvisible() {
                var x = document.getElementById("password");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }
        </script>
    </fieldset>
</form>

<?php
if ($password != "") {
    echo "<p>" . "Dein Hash key ist:" . "</p>";
    echo $password;
}
?>
</hmtl>
