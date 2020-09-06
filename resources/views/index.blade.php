@extends('rookie::layout')

@section('content')
    @livewire('rookie-index', ['name' => $rookieName])
@endsection
