@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
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
        <div class="clearfix"></div>
        @if(count($comments) > 0)
            <div style="margin-top: 20px;">
                <h4>Comments</h4>
                <div style="background-color: #c9e2b3; padding: 4px 16px;">
                    <?php $i = 0; ?>
                    @foreach($comments as $comment)
                        <h5>#{{ $i + 1 }}</h5>
                        <h5>От: {{ $userNames[$i] }}</h5>
                        <p>{{ $comment->body }}</p>
                        <?php $i++; ?>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@stop