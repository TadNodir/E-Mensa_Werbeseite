@extends('werbeseite.layouts.bewertungen_layout')

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
            </tr>
            @foreach($stars_table as $stars => $star)
            <tr>
                <td>{{$star['gericht']}}</td>
                <td>{{$star['bemerkung']}}</td>
                <td>{{$star['sterne_bewertung']}}</td>
                @if($star['hervorgehoben'])
                    <td style="background: darkorange">{{$star['hervorgehoben']}}</td>
                @else
                    <td>{{$star['hervorgehoben']}}</td>
                @endif
                <td>{{$star['bewertungszeitpunkt']}}</td>
                <td>{{$star['benutzer']}}</td>
                @if(isset($_SESSION['admin']))
                    @if($_SESSION['admin'])
                        @if($star['hervorgehoben'])
                            <td><a href="/hervorheben_cancel?bewertung_id={{$star['bewertung_id']}}">Hervorhebung abwählen</a></td>
                        @else
                            <td><a href="/hervorheben?bewertung_id={{$star['bewertung_id']}}">Hervorheben</a></td>
                        @endif

                    @endif
                @endif
            </tr>
            @endforeach
        </table>
    </div>
@endsection