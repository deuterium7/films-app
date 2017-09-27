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
                    @foreach($comments as $comment)
                        <h5>От: {{ $comment->user_id }}</h5>
                        <p>{{ $comment->body }}</p>
                        <hr>
                    @endforeach
                </div>
            </div>
        @endif
        <div style="margin-top: 20px;">
            <h4 style="text-align: center;">Add comment</h4>
            {!! Form::open(['route' => 'comment-add']) !!}
            {!! Form::hidden('theme_id', $movie->getId()) !!}
            {!! Form::hidden('user_id', $authUserId) !!}
            <div class="form-group">
                {!! Form::label('body') !!}
                {!! Form::textarea('body', null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Add', ['class'=>'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop