@extends('werbeseite.layouts.login_layout')

@section('formular')
    <div class="formular">
        <form method="post" action="/anmeldung_verifizieren">
            <h3>Login</h3>
            <label for="email">E-Mail</label>
            <input type="email" placeholder="example@mail.com" name="email" id="email" required>
            <label for="password">Passwort</label>
            <input type="password" placeholder="********" name="password" id="password" required>
            <label for="check">Passwort anzeigen</label>
            <input type="checkbox" id="check" onclick="makeInvisible()"><br>
            <input type="submit" name="submit" value="Login" class="login">
            {{$meldung}}
        </form>
    </div>
@endsection

@section('show_password_script')
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
@endsection


