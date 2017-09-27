@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 style="text-align: center;">Search films</h2>
        {!! Form::open(['route' => 'search-films']) !!}
        <div class="form-group">
            {!! Form::text('search', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Search', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@stop