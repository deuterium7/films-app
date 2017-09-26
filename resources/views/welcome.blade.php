@extends('layouts.app')

@section('content')
    <div class="container">
        @for($i = 0; $i < count($movies['title']); $i++)
            <div class="col-md-4" style="margin-bottom: 10px; text-align: center">
                <h5>{{ $movies['title'][$i] }}</h5>
                {!! $movies['image'][$i] !!}
            </div>
        @endfor
    </div>
@stop