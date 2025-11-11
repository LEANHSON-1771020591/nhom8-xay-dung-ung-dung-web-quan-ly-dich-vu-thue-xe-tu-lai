<ul>
    @foreach ($cars as $car)
        <li><a href="/car/{{ $car["slug"] }}">{{ $car["model"] }}</a></li>
    @endforeach
</ul>


<a href="/filter/ho-chi-minh">Ho Chi Minh</a>
<a href="/filter/ha-noi">Ha Noi</a>
<a href="/filter/da-nang">Da Nang</a>
<a href="/filter/thanh-hoa">Thanh Hoa</a>