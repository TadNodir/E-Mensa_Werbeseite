@extends('werbeseite.layouts.meine_bewertungen_layout')

@section('table')
    <div class="table">
        <table>
            <tr>
                <th>Gericht</th>
                <th>Bemerkung</th>
                <th>Bewertung</th>
                <th>Hervorgehoben</th>
                <th>Bewertungszeitpunkt</th>
                <th>Bewerter</th>
                <th>Löschen</th>
            </tr>
            @foreach($my_stars_table as $stars => $star)
                <tr>
                    <td>{{$star['gericht']}}</td>
                    <td>{{$star['bemerkung']}}</td>
                    <td>{{$star['sterne_bewertung']}}</td>
                    <td>{{$star['hervorgehoben']}}</td>
                    <td>{{$star['bewertungszeitpunkt']}}</td>
                    <td>Ich: {{$star['benutzer']}}</td>
                    <td><a href="/deleteBewertung?bewertung_id={{$star['bewertung_id']}}">Löschen</a></td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection