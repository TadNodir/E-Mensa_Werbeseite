@extends('examples.layout.m4_7d_layout')

@section('title')
    PAGE 2
@endsection

@section('main')
    <table>
        <thead>
        <th>Name</th>
        </thead>
        <tbody>
        @foreach($data as $d)
            <tr>
                <td>{{$d['name']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('footer')
    FOOTER 2
@endsection