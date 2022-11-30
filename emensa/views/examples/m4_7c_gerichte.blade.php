@extends('layout')

@section('content')
    <p>Gerichte mit Namen und Preis ab 2 Euro absteigend nach Namen sortiert</p>
    <ul>
        @if (empty($data))
            Es sind keine Gerichte vorhanden
        @else
           @foreach ($data as $gericht)
                <li>Name: {{$gericht['name']}} , preis intern: {{$gericht['preis_intern']}} &euro; </li>
           @endforeach
        @endif
    </ul>
@endsection
