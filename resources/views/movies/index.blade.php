@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 style="text-align: center;">Top popular films</h1>
        @for($i = 0; $i < count($movies['title']); $i++)
            <div class="col-md-4" style="margin-bottom: 16px; text-align: center">
                <a href="{{ route('movie', ['id' => $movies['id'][$i]]) }}" title="{{ $movies['title'][$i] }}">{!! $movies['image'][$i] !!}</a>
                <?= link_to_route('movie', 'More info', ['id' => $movies['id'][$i]], ['title' => $movies['title'][$i],'style'=>'display:block; margin-top: 4px;']) ?>
            </div>
        @endfor
    </div>
@stop