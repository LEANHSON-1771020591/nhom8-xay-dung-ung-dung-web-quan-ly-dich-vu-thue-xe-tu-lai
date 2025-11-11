<h1>{{ $slug }}</h1>


<ul>
    @foreach ($cars as $car)
        <li>
            <a href="/car/{{ $car["slug"] }}">{{ $car["model"] }}</a>
        </li>
    @endforeach
</ul>