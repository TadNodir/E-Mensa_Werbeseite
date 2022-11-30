@extends('examples.layout.m4_7d_layout')

@section('title')
    PAGE 1
@endsection

@section('main')
    <table>
        <thead>
        <th>Name</th>
        <th>Beschreibung</th>
        <th>Interne Preise</th>
        <th>Externe Preise</th>
        </thead>
        <tr>

        @foreach($data as $d)
            {{--var_dump($d)--}}
            <tr>
                <td>{{$d['name']}}</td>
                <td>{{$d['beschreibung']}}</td>
                <td>{{$d['preis_intern']}}</td>
                <td>{{$d['preis_extern']}}</td>
            </tr>
            @endforeach
            </tbody>
    </table>
@endsection

@section('footer')
    FOOTER 1
@endsection