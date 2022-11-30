@extends('layout')

@section('content')
    <h1>Der Wert von ?name lautet: {{$request->getData()['name']}}</h1>
@endsection