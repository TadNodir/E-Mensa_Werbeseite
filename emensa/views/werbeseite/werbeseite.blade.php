@extends('werbeseite.layouts.layout1')
@section('')
@endsection

@section('begrüßung')
    <img class="top-picture" src="/img/food.jpg" alt="food picture">
    <br>
    <h2 id="ankündigung">Bald gibt es Essen auch online ;)</h2>
    {{var_dump($_SESSION)}}
    <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
        dolore magna aliqua. Egestas fringilla phasellus faucibus scelerisque eleifend. Amet cursus sit amet dictum
        sit
        amet justo donec. Pretium aenean pharetra magna ac placerat vestibulum lectus mauris ultrices. Et ligula
        ullamcorper malesuada proin libero nunc consequat interdum varius. Vitae congue mauris rhoncus aenean vel
        elit.
        Eu turpis egestas pretium aenean pharetra. Bibendum est ultricies integer quis auctor elit sed vulputate.
        Orci
        dapibus ultrices in iaculis. Blandit volutpat maecenas volutpat blandit aliquam etiam erat velit. Aenean
        pharetra magna ac placerat vestibulum. Commodo ullamcorper a lacus vestibulum.<br>
        Semper quis lectus nulla at volutpat diam. Id diam maecenas ultricies mi eget mauris pharetra.
        Montes nascetur ridiculus mus mauris vitae ultricies leo integer malesuada. In arcu cursus euismod
        quis viverra. Ultricies tristique nulla aliquet enim tortor. Tincidunt nunc pulvinar sapien et ligula
        ullamcorper malesuada. Metus aliquam eleifend mi in nulla posuere. Eget lorem dolor sed viverra ipsum
        nunc aliquet. Elementum sagittis vitae et leo duis ut diam quam. Massa tincidunt nunc pulvinar sapien et
        ligula ullamcorper malesuada proin. Leo a diam sollicitudin tempor id eu nisl nunc mi. Tempus urna et
        pharetra pharetra massa massa. Duis ut diam quam nulla porttitor massa id. Hac habitasse platea dictumst
        quisque sagittis purus sit. A lacus vestibulum sed arcu. At auctor urna nunc id cursus. Faucibus scelerisque
        eleifend donec pretium. In ornare quam viverra orci. In ornare quam viverra orci sagittis eu. Sed nisi lacus
        sed viverra.
    </p>
@endsection

@section('header_navigation')
    <img src="/img/logo.png" alt="E-Mensa Logo" class="header-item1">
    <ul class="header-item2">
        <li><a href="#ankündigung">Ankündigung</a></li>
        <li><a href="#speisen">Speisen</a></li>
        <li><a href="#zahlen">Zahlen</a></li>
        <li><a href="#kontakt">Kontakt</a></li>
        <li><a href="#wichtig">Wichtig für uns</a></li>
    </ul>
@endsection

@section('gericht')

    @foreach($res_gericht_allergen_pair as $key => $dish)


        <tr>
            <td><img alt='' class='img-dishes' src=''>{{$dish['name']}}</td>
            <td>{{number_format($dish['preis_intern'], 2,',')}}&euro;</td>
            <td>{{number_format($dish['preis_extern'], 2,',')}}&euro;</td>
            <td></td>
            <td>{{$dish['allergen_codes']}}</td>
        </tr>
    @endforeach



@endsection

@section('allergene')

    @foreach($res_allergen as $allerge)
        <li style='text-align: left' >{{$allerge['code']}}: {{$allerge['name']}}</li>
    @endforeach

@endsection

@section('wichtig')
    <ul>
        <li>Beste frische saisonale Zutaten</li>
        <li>Ausgewogene abwechslungsreiche Gerichte</li>
        <li>Sauberkeit</li>
    </ul>
@endsection

@section('footer')
    <ul>
        <li>(c) E-Mensa GmbH</li>
        <li>Nodirjon Tadjiev, Daniel Winata</li>
        <li><a href="https://www.fh-aachen.de/" target="_blank">Impressum</a></li>
    </ul>
@endsection