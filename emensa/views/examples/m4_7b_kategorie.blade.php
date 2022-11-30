@extends('layout')

@section('content')
    <ul>
        @foreach ($data as $category)
            @if ($loop->odd)
                <li><b>{{$category['name']}}</b></li>
            @else
                <li> {{$category[0]}} </li>
            @endif
        @endforeach
    </ul>
@endsection