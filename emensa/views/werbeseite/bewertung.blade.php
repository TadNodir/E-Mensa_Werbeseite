@extends('werbeseite.layouts.bewertung_layout')

@section('meal_info')
<div class="info">
    <img src="/img/gerichte/{{$evaluation_mealInfo[1]}}.jpg" alt="gerichtFoto"><br>
    <h1>{{$evaluation_mealInfo[0]}}</h1>
</div>
@endsection


@section('formular')
    <div class="formular">
        <form method="post" action="/verify_evaluation">
            <h3>Bewerten Sie das Gericht </h3>
            <label for="bemerkung">Bemerkungen</label>
            <textarea class="textarea" name="bemerkung" id="bemerkung" minlength="5"></textarea><br>
            <input type="radio" id="sehr_schlecht" name="stars" value="sehr schlecht">
            <label for="sehr_schlecht">Sehr schlecht</label><br>
            <input type="radio" id="schlecht" name="stars" value="schlecht">
            <label for="schlecht">Schlecht</label><br>
            <input type="radio" id="gut" name="stars" value="gut">
            <label for="gut">Gut</label><br>
            <input type="radio" id="sehr_gut" name="stars" value="sehr gut">
            <label for="sehr_gut">Sehr gut</label><br>
            <input type="submit" name="submit" value="Speichern" class="submit">
        </form>
    </div>
@endsection

