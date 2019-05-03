@extends('layouts.master')

@section('title','Welcome')

@section('content')

    <h2>Welcome to my first laravel site</h2>
    <a href="{{route('login')}}" class="btn btn-x btn-success">Entrar na aplicação</a>
@endsection