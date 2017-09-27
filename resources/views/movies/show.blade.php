@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 style="text-align: center;">{{ $movie->getTitle() }}</h2>
        <div style="float: left; margin-right: 30px;">
            @inject('image', 'Tmdb\Helper\ImageHelper')
            {!! $image->getHtml($movie->getPosterImage(), 'w154', 300, 450) !!}
        </div>
        <p style="font-size: 16px;">{{ $movie->getOverview() }}</p>
        <h4>Genres</h4>
        <ul>
            <?php $genres = $movie->getGenres(); ?>
            @foreach($genres as $genre)
                <li>{{ $genre->getName() }}</li>
            @endforeach
        </ul>
        <h4>Facts</h4>
        <ul>
            <li>Status - {{ $movie->getStatus() }}</li>
            <li>Original Language - {{ $movie->getOriginalLanguage() }}</li>
            <li>Budget - {{ $movie->getBudget() }}$</li>
            <li>Revenue - {{ $movie->getRevenue() }}$</li>
        </ul>
        <h4><a href="{{ $movie->getHomepage() }}">Homepage</a></h4>
    </div>
@stop